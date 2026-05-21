<?php
class Chauffeur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lister() {
        $stmt = $this->pdo->prepare("SELECT * FROM chauffeur ORDER BY nom ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter($nom, $prenom, $telephone, $num_permi) {
        $stmt = $this->pdo->prepare("
            INSERT INTO chauffeur (nom, prenom, telephone, num_permi, statut)
            VALUES (?, ?, ?, ?, 1)
        ");
        $stmt->execute([$nom, $prenom, $telephone, $num_permi]);
        return ['succes' => true, 'message' => 'Chauffeur ajouté', 'id' => $this->pdo->lastInsertId()];
    }

    public function modifier($id, $nom, $prenom, $telephone, $num_permi, $statut) {
        $stmt = $this->pdo->prepare("
            UPDATE chauffeur SET nom=?, prenom=?, telephone=?, num_permi=?, statut=? WHERE id=?
        ");
        $stmt->execute([$nom, $prenom, $telephone, $num_permi, $statut, $id]);
        return ['succes' => true, 'message' => 'Chauffeur modifié'];
    }

    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM chauffeur WHERE id=?");
        $stmt->execute([$id]);
        return ['succes' => true, 'message' => 'Chauffeur supprimé'];
    }

    public function listerActifs() {
        $stmt = $this->pdo->prepare("SELECT * FROM chauffeur WHERE statut = 1 ORDER BY nom ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM chauffeur WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Assigner chauffeur à un trajet
    public function assignerTrajet($trajet_id, $chauffeur_id) {
        // Vérifier si déjà assigné
        $stmt = $this->pdo->prepare("
            SELECT id FROM trajet_chauffeur 
            WHERE trajet_id = ? AND chauffeur_id = ?
        ");
        $stmt->execute([$trajet_id, $chauffeur_id]);

        if ($stmt->rowCount() > 0) {
            return ['succes' => false, 'message' => 'Ce chauffeur est déjà assigné à ce trajet'];
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO trajet_chauffeur (trajet_id, chauffeur_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$trajet_id, $chauffeur_id]);
        return ['succes' => true, 'message' => 'Chauffeur assigné au trajet'];
    }

    // Retirer chauffeur d'un trajet
    public function retirerTrajet($trajet_id, $chauffeur_id) {
        $stmt = $this->pdo->prepare("
            DELETE FROM trajet_chauffeur 
            WHERE trajet_id = ? AND chauffeur_id = ?
        ");
        $stmt->execute([$trajet_id, $chauffeur_id]);
        return ['succes' => true, 'message' => 'Chauffeur retiré du trajet'];
    }
}
?>