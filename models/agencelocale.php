<?php
class AgenceLocale {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function lister() {
        $stmt = $this->pdo->prepare("
            SELECT al.*, a.nom AS nom_agence
            FROM agence_locale al
            JOIN agence a ON a.id = al.agence_id
            ORDER BY a.nom ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouter($agence_id, $addresse, $telephone) {
        $stmt = $this->pdo->prepare("
            INSERT INTO agence_locale (agence_id, addresse, telephone, statut)
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$agence_id, $addresse, $telephone]);
        return ['succes' => true, 'message' => 'Agence locale ajoutée', 'id' => $this->pdo->lastInsertId()];
    }

    public function modifier($id, $addresse, $telephone, $statut) {
        $stmt = $this->pdo->prepare("
            UPDATE agence_locale SET addresse=?, telephone=?, statut=? WHERE id=?
        ");
        $stmt->execute([$addresse, $telephone, $statut, $id]);
        return ['succes' => true, 'message' => 'Agence locale modifiée'];
    }

    public function supprimer($id) {
        $stmt = $this->pdo->prepare("DELETE FROM agence_locale WHERE id=?");
        $stmt->execute([$id]);
        return ['succes' => true, 'message' => 'Agence locale supprimée'];
    }

    public function uploadPhoto($id, $fichier) {
        $dossier    = 'uploads/agences/';
        if (!file_exists($dossier)) mkdir($dossier, 0777, true);

        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $extension  = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensions)) {
            return ['succes' => false, 'message' => 'Format non autorisé'];
        }

        if ($fichier['size'] > 2 * 1024 * 1024) {
            return ['succes' => false, 'message' => 'Image trop lourde (max 2Mo)'];
        }

        $nom_fichier = uniqid('agence_') . '.' . $extension;

        if (move_uploaded_file($fichier['tmp_name'], $dossier . $nom_fichier)) {
            $stmt = $this->pdo->prepare("UPDATE agence_locale SET photo=? WHERE id=?");
            $stmt->execute([$nom_fichier, $id]);
            return ['succes' => true, 'message' => 'Photo mise à jour'];
        }

        return ['succes' => false, 'message' => 'Erreur upload'];
    }

    public function getDetails($id) {
        $stmt = $this->pdo->prepare("
            SELECT al.*, a.nom AS nom_agence
            FROM agence_locale al
            JOIN agence a ON a.id = al.agence_id
            WHERE al.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>