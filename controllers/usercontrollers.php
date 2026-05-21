<?php
require_once MODELS . '/user.php';


class UserController {
    private $pdo;
    private $user;

    public function __construct($pdo) {
        $this->pdo  = $pdo;
        $this->user = new User($pdo);
    }

    // Page login
    public function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $resultat = $this->user->connecter(
            $_POST['email'],
            $_POST['mot_de_passe']
        );

        if ($resultat['succes']) {
            // Rediriger selon le rôle
            switch ($_SESSION['user_role']) {
                case 'admin':
                    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=dashboard');
                    break;
                case 'caissier':
                    header('Location: ' . BASE_URL . '/index.php?controller=caissier&action=dashboard');
                    break;
                case 'client':
                    // ✅ Rediriger vers la page d'accueil
                    header('Location: ' . BASE_URL . '/index.php');
                    break;
                default:
                    header('Location: ' . BASE_URL . '/index.php');
                    break;
            }
            exit();
        } else {
            $erreur = $resultat['message'];
        }
    }
    require_once VIEWS . '/user/login.php';
}

    // Page inscription
    public function inscription() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->user->inscrire(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                $_POST['mot_de_passe']
            );

            if ($resultat['succes']) {
                header('Location: index.php?controller=user&action=login');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once __DIR__ . '/../views/user/inscription.php';
    }

    // Déconnexion
    public function deconnecter() {
        $this->user->deconnecter();
    }

    // Modifier profil
    public function profil() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
        exit();
    }
    require VIEWS . '/user/profil.php';
}

public function modifierProfil() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Vérifier mots de passe
        if (!empty($_POST['nouveau_mot_de_passe']) && 
            $_POST['nouveau_mot_de_passe'] !== $_POST['confirmer_mot_de_passe']) {
            $erreur = 'Les mots de passe ne correspondent pas';
            require VIEWS . '/user/profil.php';
            return;
        }

        $resultat = $this->user->modifierProfil(
            $_SESSION['user_id'],
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            !empty($_POST['nouveau_mot_de_passe']) ? $_POST['nouveau_mot_de_passe'] : null
        );

        if ($resultat['succes']) {
            $message = 'Profil modifié avec succès';
        } else {
            $erreur = $resultat['message'];
        }
    }
    require VIEWS . '/user/profil.php';
}
}
?>