<?php
class Siege {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Libérer les sièges en attente expirés (+ 15 min sans paiement)
   public function libererSiegesExpires() {
    
    // Trouver les réservations en attente depuis plus de 15 minutes
    $stmt = $this->pdo->prepare("
        SELECT r.id, r.voyage_id
        FROM reservation r
        WHERE r.statut = 0
        AND r.date_reservation < DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ");
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reservations as $reservation) {

        // Récupérer les sièges de cette réservation
        $stmt = $this->pdo->prepare("
            SELECT siege_id FROM reservation_siege 
            WHERE reservation_id = ?
        ");
        $stmt->execute([$reservation['id']]);
        $sieges = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Libérer les sièges
        foreach ($sieges as $siege) {
            $stmt = $this->pdo->prepare("
                UPDATE siege SET statut = 0 WHERE id = ? AND statut = 2
            ");
            $stmt->execute([$siege['siege_id']]);
        }

        // Remettre les places restantes
        $stmt = $this->pdo->prepare("
            UPDATE voyage 
            SET placerestante = placerestante + ?
            WHERE id = ?
        ");
        $stmt->execute([count($sieges), $reservation['voyage_id']]);

        // Annuler la réservation expirée
        $stmt = $this->pdo->prepare("
            UPDATE reservation SET statut = 2 WHERE id = ?
        ");
        $stmt->execute([$reservation['id']]);
    }

}
public function terminerVoyagesExpires() {

    // Trouver les voyages dont l'heure d'arrivée est passée
    $stmt = $this->pdo->prepare("
        SELECT id, bus_id, trajetchauffeur_id
        FROM voyage
        WHERE statut = 1
        AND dateheurearrive < NOW()
    ");
    $stmt->execute();
    $voyages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($voyages as $voyage) {

        // Marquer le voyage comme terminé
        $stmt = $this->pdo->prepare("UPDATE voyage SET statut = 2 WHERE id = ?");
        $stmt->execute([$voyage['id']]);

        // ✅ Libérer le bus
        $stmt = $this->pdo->prepare("UPDATE bus SET estdisponible = 1 WHERE id = ?");
        $stmt->execute([$voyage['bus_id']]);

        // ✅ Libérer le trajet_chauffeur
        $stmt = $this->pdo->prepare("UPDATE trajet_chauffeur SET statut = 1 WHERE id = ?");
        $stmt->execute([$voyage['trajetchauffeur_id']]);
    }

    // Trouver les voyages planifiés dont l'heure de départ est passée → en cours
    $stmt = $this->pdo->prepare("
        SELECT id FROM voyage
        WHERE statut = 0
        AND dateheuredepart < NOW()
        AND dateheurearrive > NOW()
    ");
    $stmt->execute();
    $voyagesEnCours = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($voyagesEnCours as $voyage) {
        $stmt = $this->pdo->prepare("UPDATE voyage SET statut = 1 WHERE id = ?");
        $stmt->execute([$voyage['id']]);
    }
}
}