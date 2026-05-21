<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Inscription
    public function inscrire($nom, $prenom, $email, $mot_de_passe, $role = 'client', $agencelocale_id = null) {
        
        // Vérifier si email existe déjà
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            return [
                'succes'  => false,
                'message' => 'Cet email est déjà utilisé'
            ];
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO user (nom, prenom, email, mot_de_passe, role, statut, agencelocale_id, date_creation)
            VALUES (?, ?, ?, SHA1(?), ?, 1, ?, NOW())
        ");
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe, $role, $agencelocale_id]);

        return [
            'succes'  => true,
            'message' => 'Inscription réussie',
            'id'      => $this->pdo->lastInsertId()
        ];
    }

    // Connexion
    public function connecter($email, $mot_de_passe) {
        $stmt = $this->pdo->prepare("
            SELECT id, nom, prenom, email, role, agencelocale_id,statut
            FROM user
            WHERE email = ? AND mot_de_passe = SHA1(?)
        ");
        $stmt->execute([$email, $mot_de_passe]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($user) {
            $_SESSION['user_id']         = $user['id'];
            $_SESSION['user_nom']        = $user['nom'];
            $_SESSION['user_prenom']     = $user['prenom'];
            $_SESSION['user_email']      = $user['email'];
            $_SESSION['user_role']       = $user['role'];
            $_SESSION['agencelocale_id'] = $user['agencelocale_id'];
            $_SESSION['user_statut']     = $user['statut'];
                 
            return [
                'succes'  => true,
                'message' => 'Connexion réussie',
                'user'    => $user
            ];
        }

        return [
            'succes'  => false,
            'message' => 'Email ou mot de passe incorrect'
        ];
          if ($user['statut'] == 0) {

    $_SESSION['erreur'] = "Votre compte a été suspendu. Contactez l'administrateur.";

    header("Location: " . BASE_URL . "/index.php?controller=user&action=login");
    exit();
}
    }

    // Déconnexion
    public function deconnecter() {
        session_destroy();
        header('Location: index.php?controller=user&action=login');
        exit();
    }

    // Modifier profil
    public function modifierProfil($id, $nom, $prenom, $email, $nouveau_mot_de_passe = null) {

        // Vérifier si email utilisé par un autre
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);

        if ($stmt->rowCount() > 0) {
            return [
                'succes'  => false,
                'message' => 'Cet email est déjà utilisé par un autre utilisateur'
            ];
        }

        if ($nouveau_mot_de_passe != null) {
            $stmt = $this->pdo->prepare("
                UPDATE user
                SET nom          = ?,
                    prenom       = ?,
                    email        = ?,
                    mot_de_passe = SHA1(?)
                WHERE id = ?
            ");
            $stmt->execute([$nom, $prenom, $email, $nouveau_mot_de_passe, $id]);
        } else {
            $stmt = $this->pdo->prepare("
                UPDATE user
                SET nom    = ?,
                    prenom = ?,
                    email  = ?
                WHERE id   = ?
            ");
            $stmt->execute([$nom, $prenom, $email, $id]);
        }

        $_SESSION['user_nom']    = $nom;
        $_SESSION['user_prenom'] = $prenom;
        $_SESSION['user_email']  = $email;

        return [
            'succes'  => true,
            'message' => 'Profil modifié avec succès'
        ];
    }

    // Vérifier si connecté
    public function estConnecte() {
        return isset($_SESSION['user_id']);
    }

    // Vérifier le rôle
    public function aLRole($role) {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == $role;
    }
}
?>