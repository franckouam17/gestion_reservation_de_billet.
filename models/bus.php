<?php
class Bus {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lister() {
        $stmt = $this->pdo->prepare("
            SELECT b.*, tb.libelle AS type_bus
            FROM bus b
            JOIN typebus tb ON tb.id = b.typebus_id
            ORDER BY b.immatriculation ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter($typebus_id, $immatriculation, $nbre_place) {
        $stmt = $this->pdo->prepare("
            INSERT INTO bus (typebus_id, immatriculation, nbre_place, estdisponible)
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$typebus_id, $immatriculation, $nbre_place]);
        return ['succes' => true, 'message' => 'Bus ajouté', 'id' => $this->pdo->lastInsertId()];
    }

    public function modifier($id, $typebus_id, $immatriculation, $nbre_place) {
        $stmt = $this->pdo->prepare("
            UPDATE bus SET typebus_id=?, immatriculation=?, nbre_place=? WHERE id=?
        ");
        $stmt->execute([$typebus_id, $immatriculation, $nbre_place, $id]);
        return ['succes' => true, 'message' => 'Bus modifié'];
    }

    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM bus WHERE id=?");
        $stmt->execute([$id]);
        return ['succes' => true, 'message' => 'Bus supprimé'];
    }

    public function listerDisponibles() {
        $stmt = $this->pdo->prepare("
            SELECT b.*, tb.libelle AS type_bus
            FROM bus b
            JOIN typebus tb ON tb.id = b.typebus_id
            WHERE b.estdisponible = 1
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("
            SELECT b.*, tb.libelle AS type_bus
            FROM bus b
            JOIN typebus tb ON tb.id = b.typebus_id
            WHERE b.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>