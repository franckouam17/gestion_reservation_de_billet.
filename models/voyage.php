<?php
class Voyage {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Créer un voyage
    public function creer($trajetchauffeur_id, $agencelocaledeapart_id, $agenceloacledarrive_id, $type_id, $bus_id, $dateheuredepart, $dateheurearrive, $prix) {

        // Vérifier que le bus est disponible
        $stmt = $this->pdo->prepare("SELECT estdisponible, nbre_place FROM bus WHERE id = ?");
        $stmt->execute([$bus_id]);
        $bus = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($bus['estdisponible'] != 1) {
            return [
                'succes'  => false,
                'message' => 'Ce bus nest pas disponible'
            ];
        }

        // Créer le voyage
        $stmt = $this->pdo->prepare("
            INSERT INTO voyage (
                trajetchauffeur_id, agencelocaledeapart_id, agenceloacledarrive_id,
                type_id, bus_id, dateheuredepart, dateheurearrive,
                prix, statut, placerestante
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?)
        ");

        $stmt->execute([
            $trajetchauffeur_id,
            $agencelocaledeapart_id,
            $agenceloacledarrive_id,
            $type_id,
            $bus_id,
            $dateheuredepart,
            $dateheurearrive,
            $prix,
            $bus['nbre_place']
        ]);

        $voyage_id = $this->pdo->lastInsertId();

        // Générer automatiquement les sièges (nbre_place - 3)


// Calculer les places réelles selon la taille du bus
$nbre_place = $bus['nbre_place'];

if ($nbre_place > 30) {
    // 2 portes → perd 3 places
    $places_disponibles = $nbre_place - 3;
} else {
    // 1 porte → perd 2 places
    $places_disponibles = $nbre_place - 2;
}


// Générer les sièges
for ($i = 1; $i <= $places_disponibles; $i++) {
    $stmt = $this->pdo->prepare("
        INSERT INTO siege (voyage_id, numero, statut)
        VALUES (?, ?, 0)
    ");
    $stmt->execute([$voyage_id, $i]);
}
// Après création du voyage
// Marquer le bus comme indisponible
$stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 0 WHERE id = ?");
$stmt->execute([$bus_id]);

// ✅ Marquer le trajet_chauffeur comme occupé
$stmt = $this->pdo->prepare("UPDATE trajet_chauffeur SET statut = 0 WHERE id = ?");
$stmt->execute([$trajetchauffeur_id]);

// Mettre à jour placerestante
$stmt = $this->pdo->prepare("UPDATE voyage SET placerestante = ? WHERE id = ?");
$stmt->execute([$places_disponibles, $voyage_id]);

// placerestante = nbre_place - 3

        // Marquer le bus comme indisponible
        $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 0 WHERE id = ?");
        $stmt->execute([$bus_id]);

        return [
            'succes'  => true,
            'message' => 'Voyage créé avec succès',
            'id'      => $voyage_id
        ];
    }

    // Lister tous les voyages
    public function lister() {
        $stmt = $this->pdo->prepare("
            SELECT 
                v.id,
                t.villedepart,
                t.villearrive,
                t.duree,
                v.dateheuredepart,
                v.dateheurearrive,
                v.prix,
                v.placerestante,
                v.statut,
                tv.libelle          AS type_voyage,
                b.immatriculation   AS bus,
                b.nbre_place,
                tb.libelle          AS type_bus,
                CONCAT(c.nom,' ',c.prenom) AS chauffeur,
                al1.addresse        AS agence_depart,
                al1.photo           AS photo_depart,
                al2.addresse        AS agence_arrivee,
                al2.photo           AS photo_arrivee
            FROM voyage v
            JOIN trajet_chauffeur tc ON tc.id   = v.trajetchauffeur_id
            JOIN trajet t            ON t.id    = tc.trajet_id
            JOIN chauffeur c         ON c.id    = tc.chauffeur_id
            JOIN typevoyage tv       ON tv.id   = v.type_id
            JOIN bus b               ON b.id    = v.bus_id
            JOIN typebus tb          ON tb.id   = b.typebus_id
            JOIN agence_locale al1   ON al1.id  = v.agencelocaledeapart_id
            JOIN agence_locale al2   ON al2.id  = v.agenceloacledarrive_id
            
            WHERE v.dateheuredepart >= NOW()
             ORDER BY v.dateheuredepart ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listertout() {
        $stmt = $this->pdo->prepare("
            SELECT 
                v.id,
                t.villedepart,
                t.villearrive,
                t.duree,
                v.dateheuredepart,
                v.dateheurearrive,
                v.prix,
                v.placerestante,
                v.statut,
                tv.libelle          AS type_voyage,
                b.immatriculation   AS bus,
                b.nbre_place,
                tb.libelle          AS type_bus,
                CONCAT(c.nom,' ',c.prenom) AS chauffeur,
                al1.addresse        AS agence_depart,
                al1.photo           AS photo_depart,
                al2.addresse        AS agence_arrivee,
                al2.photo           AS photo_arrivee
            FROM voyage v
            JOIN trajet_chauffeur tc ON tc.id   = v.trajetchauffeur_id
            JOIN trajet t            ON t.id    = tc.trajet_id
            JOIN chauffeur c         ON c.id    = tc.chauffeur_id
            JOIN typevoyage tv       ON tv.id   = v.type_id
            JOIN bus b               ON b.id    = v.bus_id
            JOIN typebus tb          ON tb.id   = b.typebus_id
            JOIN agence_locale al1   ON al1.id  = v.agencelocaledeapart_id
            JOIN agence_locale al2   ON al2.id  = v.agenceloacledarrive_id
            
        
             ORDER BY v.dateheuredepart ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rechercher un voyage
    public function rechercher($villedepart, $villearrive, $date) {
        $stmt = $this->pdo->prepare("
            SELECT 
                v.id,
                t.villedepart,
                t.villearrive,
                t.duree,
                v.dateheuredepart,
                v.dateheurearrive,
                v.prix,
                v.placerestante,
                tv.libelle          AS type_voyage,
                b.immatriculation   AS bus,
                b.nbre_place,
                CONCAT(c.nom,' ',c.prenom) AS chauffeur,
                al1.addresse        AS agence_depart,
                al1.photo           AS photo_depart,
                al2.addresse        AS agence_arrivee,
                al2.photo           AS photo_arrivee
            FROM voyage v
            JOIN trajet_chauffeur tc ON tc.id   = v.trajetchauffeur_id
            JOIN trajet t            ON t.id    = tc.trajet_id
            JOIN chauffeur c         ON c.id    = tc.chauffeur_id
            JOIN typevoyage tv       ON tv.id   = v.type_id
            JOIN bus b               ON b.id    = v.bus_id
            JOIN agence_locale al1   ON al1.id  = v.agencelocaledeapart_id
            JOIN agence_locale al2   ON al2.id  = v.agenceloacledarrive_id
            WHERE t.villedepart           = ?
            AND   t.villearrive           = ?
            AND   DATE(v.dateheuredepart) = ?
            AND   v.statut                = 0
            AND   v.placerestante         > 0
            ORDER BY v.dateheuredepart ASC
        ");
        $stmt->execute([$villedepart, $villearrive, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifier un voyage
    public function modifier($id, $trajetchauffeur_id, $agencelocaledeapart_id, $agenceloacledarrive_id, $type_id, $bus_id, $dateheuredepart, $dateheurearrive, $prix, $statut) {

        // Vérifier que le voyage existe
        $stmt = $this->pdo->prepare("SELECT id, statut, bus_id FROM voyage WHERE id = ?");
        $stmt->execute([$id]);
        $voyage = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$voyage) {
            return ['succes' => false, 'message' => 'Voyage introuvable'];
        }

        if ($voyage['statut'] == 2 || $voyage['statut'] == 3) {
            return ['succes' => false, 'message' => 'Impossible de modifier un voyage terminé ou annulé'];
        }

        // Si le bus a changé
        if ($bus_id != $voyage['bus_id']) {
            $stmt = $this->pdo->prepare("SELECT estdisponible, nbre_place FROM bus WHERE id = ?");
            $stmt->execute([$bus_id]);
            $nouveau_bus = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($nouveau_bus['estdisponible'] != 1) {
                return ['succes' => false, 'message' => 'Le nouveau bus nest pas disponible'];
            }

            // Libérer l'ancien bus
            $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 1 WHERE id = ?");
            $stmt->execute([$voyage['bus_id']]);

            // Occuper le nouveau bus
            $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 0 WHERE id = ?");
            $stmt->execute([$bus_id]);

            // Mettre à jour les places
            $stmt = $this->pdo->prepare("UPDATE voyage SET placerestante = ? WHERE id = ?");
            $stmt->execute([$nouveau_bus['nbre_place'], $id]);
        }

        $stmt = $this->pdo->prepare("
            UPDATE voyage
            SET trajetchauffeur_id      = ?,
                agencelocaledeapart_id  = ?,
                agenceloacledarrive_id  = ?,
                type_id                 = ?,
                bus_id                  = ?,
                dateheuredepart         = ?,
                dateheurearrive         = ?,
                prix                    = ?,
                statut                  = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $trajetchauffeur_id,
            $agencelocaledeapart_id,
            $agenceloacledarrive_id,
            $type_id,
            $bus_id,
            $dateheuredepart,
            $dateheurearrive,
            $prix,
            $statut,
            $id
        ]);

        return ['succes' => true, 'message' => 'Voyage modifié avec succès'];
    }

    // Annuler un voyage
    public function annuler($id) {

        $stmt = $this->pdo->prepare("SELECT id, statut, bus_id FROM voyage WHERE id = ?");
        $stmt->execute([$id]);
        $voyage = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$voyage) {
            return ['succes' => false, 'message' => 'Voyage introuvable'];
        }

        if ($voyage['statut'] != 0) {
            return ['succes' => false, 'message' => 'Impossible d annuler ce voyage'];
        }
        // Libérer le bus
        $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 1 WHERE id = ?");
        $stmt->execute([$voyage['bus_id']]);

        // ✅ Libérer le trajet_chauffeur
        $stmt = $this->pdo->prepare("UPDATE trajet_chauffeur SET statut = 1 WHERE id = ?");
        $stmt->execute([$voyage['trajetchauffeur_id']]);

        // Vérifier réservations actives
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS nb FROM reservation WHERE voyage_id = ? AND statut = 1");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['nb'] > 0) {
            return ['succes' => false, 'message' => 'Il y a ' . $result['nb'] . ' réservation(s) active(s)'];
        }

        $stmt = $this->pdo->prepare("UPDATE voyage SET statut = 3 WHERE id = ?");
        $stmt->execute([$id]);

        $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 1 WHERE id = ?");
        $stmt->execute([$voyage['bus_id']]);

        return ['succes' => true, 'message' => 'Voyage annulé avec succès'];
    }

    // Détails d'un voyage
    public function getDetails($id) {
    $stmt = $this->pdo->prepare("
        SELECT 
            v.id,
            v.trajetchauffeur_id,
            v.agencelocaledeapart_id,
            v.agenceloacledarrive_id,
            v.type_id,
            v.bus_id,
            t.villedepart,
            t.villearrive,
            t.distance,
            t.duree,
            v.dateheuredepart,
            v.dateheurearrive,
            v.prix,
            v.placerestante,
            v.statut,
            tv.libelle          AS type_voyage,
            b.immatriculation   AS bus,
            b.nbre_place,
            tb.libelle          AS type_bus,
            CONCAT(c.nom,' ',c.prenom) AS chauffeur,
            c.telephone         AS tel_chauffeur,
            al1.addresse        AS agence_depart,
            al1.photo           AS photo_depart,
            al2.addresse        AS agence_arrivee,
            al2.photo           AS photo_arrivee
        FROM voyage v
        JOIN trajet_chauffeur tc ON tc.id   = v.trajetchauffeur_id
        JOIN trajet t            ON t.id    = tc.trajet_id
        JOIN chauffeur c         ON c.id    = tc.chauffeur_id
        JOIN typevoyage tv       ON tv.id   = v.type_id
        JOIN bus b               ON b.id    = v.bus_id
        JOIN typebus tb          ON tb.id   = b.typebus_id
        JOIN agence_locale al1   ON al1.id  = v.agencelocaledeapart_id
        JOIN agence_locale al2   ON al2.id  = v.agenceloacledarrive_id
        WHERE v.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    // Passagers d'un voyage
    public function getPassagers($voyage_id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                u.nom,
                u.prenom,
                u.email,
                r.id               AS reservation_id,
                r.date_reservation,
                r.montant_total,
                GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
            FROM reservation r
            JOIN user u               ON u.id  = r.user_id
            JOIN reservation_siege rs ON rs.reservation_id = r.id
            JOIN siege s              ON s.id  = rs.siege_id
            WHERE s.voyage_id = ?
            AND   r.statut    = 1
            GROUP BY u.id, r.id
            ORDER BY u.nom ASC
        ");
        $stmt->execute([$voyage_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>