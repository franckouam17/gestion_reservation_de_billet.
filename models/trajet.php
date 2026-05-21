<?php
class Trajet {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lister() {
        $stmt = $this->pdo->prepare("SELECT * FROM trajet ORDER BY villedepart ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter($villedepart, $villearrive, $distance, $duree) {
        $stmt = $this->pdo->prepare("
            INSERT INTO trajet (villedepart, villearrive, distance, duree)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$villedepart, $villearrive, $distance, $duree]);
        return ['succes' => true, 'message' => 'Trajet ajouté', 'id' => $this->pdo->lastInsertId()];
    }

    public function modifier($id, $villedepart, $villearrive, $distance, $duree) {
        $stmt = $this->pdo->prepare("
            UPDATE trajet SET villedepart=?, villearrive=?, distance=?, duree=? WHERE id=?
        ");
        $stmt->execute([$villedepart, $villearrive, $distance, $duree, $id]);
        return ['succes' => true, 'message' => 'Trajet modifié'];
    }

    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM trajet WHERE id=?");
        $stmt->execute([$id]);
        return ['succes' => true, 'message' => 'Trajet supprimé'];
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM trajet WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>