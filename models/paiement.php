<?php
class Paiement {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Paiement en espèces (caissier)
    public function effectuer($reservation_id, $caissier_id, $montant, $methode) {

        $stmt = $this->pdo->prepare("SELECT id, statut, montant_total FROM reservation WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            return ['succes' => false, 'message' => 'Réservation introuvable'];
        }

        $reference = 'PAY-' . date('Ymd') . '-' . strtoupper(uniqid());

        $stmt = $this->pdo->prepare("
            INSERT INTO paiement (reservation_id, caissier_id, montant, methode, statut, referencetransaction, datepaiement)
            VALUES (?, ?, ?, ?, 1, ?, NOW())
        ");
        $stmt->execute([$reservation_id, $caissier_id, $montant, $methode, $reference]);

        $paiement_id = $this->pdo->lastInsertId();

        // Activer la réservation
        $stmt = $this->pdo->prepare("UPDATE reservation SET statut = 1 WHERE id = ?");
        $stmt->execute([$reservation_id]);

        // Confirmer les sièges définitivement
        $stmt = $this->pdo->prepare("
            UPDATE siege s
            JOIN reservation_siege rs ON rs.siege_id = s.id
            SET s.statut = 1
            WHERE rs.reservation_id = ?
        ");
        $stmt->execute([$reservation_id]);

        return [
            'succes'      => true,
            'message'     => 'Paiement effectué avec succès',
            'paiement_id' => $paiement_id,
            'reference'   => $reference
        ];
    }

    // Paiement Mobile Money (client en ligne)
    public function initierMobileMoney($reservation_id, $montant, $operateur, $telephone, $caissier_id = null) {

        $stmt = $this->pdo->prepare("SELECT id, statut FROM reservation WHERE id = ?");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            return ['succes' => false, 'message' => 'Réservation introuvable'];
        }

        $reference = 'PAY-' . date('Ymd') . '-' . strtoupper(uniqid());

        $stmt = $this->pdo->prepare("
            INSERT INTO paiement (reservation_id, caissier_id, montant, methode, statut, referencetransaction, datepaiement)
            VALUES (?, ?, ?, ?, 1, ?, NOW())
        ");
        $stmt->execute([
            $reservation_id,
            $caissier_id,
            $montant,
            $operateur . '_MOMO',
            $reference
        ]);

        $paiement_id = $this->pdo->lastInsertId();

        // Activer la réservation
        $stmt = $this->pdo->prepare("UPDATE reservation SET statut = 1 WHERE id = ?");
        $stmt->execute([$reservation_id]);

        // Confirmer les sièges définitivement
        $stmt = $this->pdo->prepare("
            UPDATE siege s
            JOIN reservation_siege rs ON rs.siege_id = s.id
            SET s.statut = 1
            WHERE rs.reservation_id = ?
        ");
        $stmt->execute([$reservation_id]);

        return [
            'succes'         => true,
            'message'        => 'Paiement effectué avec succès',
            'paiement_id'    => $paiement_id,
            'reference'      => $reference,
            'reservation_id' => $reservation_id
        ];
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.montant,
                p.methode,
                p.statut,
                p.referencetransaction,
                p.datepaiement,
                p.reservation_id,
                CONCAT(u.nom,' ',u.prenom)   AS caissier,
                CONCAT(cl.nom,' ',cl.prenom) AS client,
                r.montant_total,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart
            FROM paiement p
            LEFT JOIN user u          ON u.id  = p.caissier_id
            JOIN reservation r        ON r.id  = p.reservation_id
            JOIN user cl              ON cl.id = r.user_id
            JOIN voyage v             ON v.id  = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id = v.trajetchauffeur_id
            JOIN trajet t             ON t.id  = tc.trajet_id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listerTous() {
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.reservation_id,
                p.montant,
                p.methode,
                p.statut,
                p.referencetransaction,
                p.datepaiement,
                CONCAT(u.nom,' ',u.prenom)   AS caissier,
                CONCAT(cl.nom,' ',cl.prenom) AS client,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart
            FROM paiement p
            LEFT JOIN user u          ON u.id  = p.caissier_id
            JOIN reservation r        ON r.id  = p.reservation_id
            JOIN user cl              ON cl.id = r.user_id
            JOIN voyage v             ON v.id  = r.voyage_id
            JOIN trajet_chauffeur tc  ON tc.id = v.trajetchauffeur_id
            JOIN trajet t             ON t.id  = tc.trajet_id
            ORDER BY p.datepaiement DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function chiffreAffaires() {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(id) AS nb_paiements, SUM(montant) AS total
            FROM paiement WHERE statut = 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>