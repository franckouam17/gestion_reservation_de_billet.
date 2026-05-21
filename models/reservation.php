<?php
class Reservation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function creer($user_id, $voyage_id, $sieges, $canal ) {

        // Vérifier que le voyage existe et est planifié
        $stmt = $this->pdo->prepare("SELECT id, statut, placerestante, prix FROM voyage WHERE id = ?");
        $stmt->execute([$voyage_id]);
        $voyage = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$voyage) {
            return ['succes' => false, 'message' => 'Voyage introuvable'];
        }

        if ($voyage['statut'] != 0) {
            return ['succes' => false, 'message' => 'Ce voyage n est plus disponible'];
        }

        if ($voyage['placerestante'] < count($sieges)) {
            return ['succes' => false, 'message' => 'Pas assez de places disponibles'];
        }

        // Vérifier que chaque siège est disponible
        foreach ($sieges as $siege_id) {
            $stmt = $this->pdo->prepare("SELECT statut FROM siege WHERE id = ? AND voyage_id = ?");
            $stmt->execute([$siege_id, $voyage_id]);
            $siege = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$siege || $siege['statut'] != 0) {
                return ['succes' => false, 'message' => 'Le siège ' . $siege_id . ' n est pas disponible'];
            }
        }

        // Calculer le montant total
        $montant_total = $voyage['prix'] * count($sieges);

        // Créer la réservation avec statut 0 (en attente de paiement)
        $stmt = $this->pdo->prepare("
            INSERT INTO reservation (user_id, voyage_id, date_reservation, statut, montant_total, canal)
            VALUES (?, ?, NOW(), 0, ?, ?)
        ");
        $stmt->execute([$user_id, $voyage_id, $montant_total, $canal]);

        $reservation_id = $this->pdo->lastInsertId();

        // Mettre les sièges en attente (statut = 2)
        foreach ($sieges as $siege_id) {
            $stmt = $this->pdo->prepare("
                INSERT INTO reservation_siege (reservation_id, siege_id)
                VALUES (?, ?)
            ");
            $stmt->execute([$reservation_id, $siege_id]);

            // ✅ Statut 2 = en attente de paiement
            $stmt = $this->pdo->prepare("UPDATE siege SET statut = 2 WHERE id = ?");
            $stmt->execute([$siege_id]);
        }

        // Mettre à jour les places restantes
        $stmt = $this->pdo->prepare("
            UPDATE voyage SET placerestante = placerestante - ? WHERE id = ?
        ");
        $stmt->execute([count($sieges), $voyage_id]);

        return [
            'succes'         => true,
            'message'        => 'Réservation créée avec succès',
            'reservation_id' => $reservation_id,
            'montant_total'  => $montant_total
        ];
    }

   public function annuler($id) {

    // Vérifier que la réservation existe
    $stmt = $this->pdo->prepare("
        SELECT r.id, r.statut, r.voyage_id, r.montant_total,
               v.dateheuredepart
        FROM reservation r
        JOIN voyage v ON v.id = r.voyage_id
        WHERE r.id = ?
    ");
    $stmt->execute([$id]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        return ['succes' => false, 'message' => 'Réservation introuvable'];
    }

    if ($reservation['statut'] == 2) {
        return ['succes' => false, 'message' => 'Cette réservation est déjà annulée'];
    }

    // Vérifier le délai de 5h
    $dateDepart      = new DateTime($reservation['dateheuredepart']);
    $maintenant      = new DateTime();
    $diff            = $maintenant->diff($dateDepart);
    $heuresRestantes = ($diff->days * 24) + $diff->h;

    if ($maintenant >= $dateDepart || $heuresRestantes < 5) {
        return [
            'succes'  => false,
            'message' => 'Annulation impossible — le départ est dans moins de 5 heures'
        ];
    }

    // Récupérer le paiement associé
    $stmt = $this->pdo->prepare("
        SELECT id, montant, methode, referencetransaction
        FROM paiement
        WHERE reservation_id = ? AND statut = 1
    ");
    $stmt->execute([$id]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calculer remboursement 75%
    $montant_rembourse = $reservation['montant_total'] * 0.75;

    // Libérer les sièges
    $stmt = $this->pdo->prepare("SELECT siege_id FROM reservation_siege WHERE reservation_id = ?");
    $stmt->execute([$id]);
    $sieges = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sieges as $siege) {
        $stmt = $this->pdo->prepare("UPDATE siege SET statut = 0 WHERE id = ?");
        $stmt->execute([$siege['siege_id']]);
    }

    // Remettre les places restantes
    $stmt = $this->pdo->prepare("
        UPDATE voyage SET placerestante = placerestante + ? WHERE id = ?
    ");
    $stmt->execute([count($sieges), $reservation['voyage_id']]);

    // Annuler la réservation
    $stmt = $this->pdo->prepare("UPDATE reservation SET statut = 2 WHERE id = ?");
    $stmt->execute([$id]);

    // Annuler le paiement
    $stmt = $this->pdo->prepare("UPDATE paiement SET statut = 2 WHERE reservation_id = ?");
    $stmt->execute([$id]);

    // Supprimer les billets
    $stmt = $this->pdo->prepare("DELETE FROM billet WHERE reservation_id = ?");
    $stmt->execute([$id]);

    // Générer référence remboursement
    $reference_remboursement = 'RMB-' . date('Ymd') . '-' . strtoupper(uniqid());

    // Enregistrer le remboursement
    $stmt = $this->pdo->prepare("
        INSERT INTO remboursement (
            reservation_id, paiement_id, montant_initial,
            montant_rembourse, methode, statut,
            referencetransaction, date_remboursement
        )
        VALUES (?, ?, ?, ?, ?, 1, ?, NOW())
    ");
    $stmt->execute([
        $id,
        $paiement ? $paiement['id'] : null,
        $reservation['montant_total'],
        $montant_rembourse,
        $paiement ? $paiement['methode'] : 'especes',
        $reference_remboursement
    ]);

    return [
        'succes'                  => true,
        'message'                 => 'Réservation annulée avec succès',
        'montant_rembourse'       => $montant_rembourse,
        'montant_total'           => $reservation['montant_total'],
        'methode'                 => $paiement ? $paiement['methode'] : 'especes',
        'reference_remboursement' => $reference_remboursement
    ];
}
    public function listerParClient($user_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                r.id,
                r.date_reservation,
                r.montant_total,
                r.statut,
                r.canal,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart,
                v.dateheurearrive,
                v.prix,
                al1.addresse AS agence_depart,
                al2.addresse AS agence_arrivee,
                GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
            FROM reservation r
            JOIN voyage v             ON v.id   = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
            JOIN trajet t             ON t.id   = tc.trajet_id
            JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
            JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
            JOIN reservation_siege rs ON rs.reservation_id = r.id
            JOIN siege s              ON s.id   = rs.siege_id
            WHERE r.user_id = ?
            GROUP BY r.id
            ORDER BY r.date_reservation DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listerToutes() {
        $stmt = $this->pdo->prepare("
            SELECT 
                r.id,
                r.date_reservation,
                r.montant_total,
                r.statut,
                r.canal,
                CONCAT(u.nom,' ',u.prenom) AS client,
                u.email,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart,
                al1.addresse AS agence_depart,
                al2.addresse AS agence_arrivee,
                GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
            FROM reservation r
            JOIN user u               ON u.id   = r.user_id
            JOIN voyage v             ON v.id   = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
            JOIN trajet t             ON t.id   = tc.trajet_id
            JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
            JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
            JOIN reservation_siege rs ON rs.reservation_id = r.id
            JOIN siege s              ON s.id   = rs.siege_id
            WHERE DATE(r.date_reservation) = CURDATE()
            GROUP BY r.id
          
            ORDER BY r.date_reservation DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     public function listerToute() {
        $stmt = $this->pdo->prepare("
            SELECT 
                r.id,
                r.date_reservation,
                r.montant_total,
                r.statut,
                r.canal,
                CONCAT(u.nom,' ',u.prenom) AS client,
                u.email,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart,
                al1.addresse AS agence_depart,
                al2.addresse AS agence_arrivee,
                GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
            FROM reservation r
            JOIN user u               ON u.id   = r.user_id
            JOIN voyage v             ON v.id   = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
            JOIN trajet t             ON t.id   = tc.trajet_id
            JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
            JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
            JOIN reservation_siege rs ON rs.reservation_id = r.id
            JOIN siege s              ON s.id   = rs.siege_id
            
            GROUP BY r.id
          
            ORDER BY r.date_reservation DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                r.id,
                r.date_reservation,
                r.montant_total,
                r.statut,
                r.canal,
                r.voyage_id,
                CONCAT(u.nom,' ',u.prenom) AS client,
                u.email,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart,
                v.dateheurearrive,
                v.prix,
                al1.addresse AS agence_depart,
                al2.addresse AS agence_arrivee,
                CONCAT(c.nom,' ',c.prenom) AS chauffeur,
                b.immatriculation          AS bus,
                GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
            FROM reservation r
            JOIN user u               ON u.id   = r.user_id
            JOIN voyage v             ON v.id   = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
            JOIN trajet t             ON t.id   = tc.trajet_id
            JOIN chauffeur c          ON c.id   = tc.chauffeur_id
            JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
            JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
            JOIN bus b                ON b.id   = v.bus_id
            JOIN reservation_siege rs ON rs.reservation_id = r.id
            JOIN siege s              ON s.id   = rs.siege_id
            WHERE r.id = ?
            GROUP BY r.id
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSiegesDisponibles($voyage_id) {
        $stmt = $this->pdo->prepare("
            SELECT id, numero, statut
            FROM siege
            WHERE voyage_id = ?
            ORDER BY numero ASC
        ");
        $stmt->execute([$voyage_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>