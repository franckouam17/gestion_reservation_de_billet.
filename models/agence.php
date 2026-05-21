<?php
class Agence {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lister() {
        $stmt = $this->pdo->prepare("SELECT * FROM agence ORDER BY nom ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter($nom, $description, $logo, $devise) {
        $stmt = $this->pdo->prepare("
            INSERT INTO agence (nom, description, logo, devise)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$nom, $description, $logo, $devise]);
        return ['succes' => true, 'message' => 'Agence ajoutée', 'id' => $this->pdo->lastInsertId()];
    }

    public function modifier($id, $nom, $description, $devise) {
        $stmt = $this->pdo->prepare("UPDATE agence SET nom=?, description=?, devise=? WHERE id=?");
        $stmt->execute([$nom, $description, $devise, $id]);
        return ['succes' => true, 'message' => 'Agence modifiée'];
    }

    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM agence WHERE id=?");
        $stmt->execute([$id]);
        return ['succes' => true, 'message' => 'Agence supprimée'];
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM agence WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>