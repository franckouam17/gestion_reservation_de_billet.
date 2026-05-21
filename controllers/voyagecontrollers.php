<?php
require_once MODELS . '/Voyage.php';

class VoyageController {
    private $pdo;
    private $voyage;

    public function __construct($pdo) {
        $this->pdo    = $pdo;
        $this->voyage = new Voyage($pdo);
    }

    // Liste des voyages
    public function liste() {
        $voyages = $this->voyage->lister();
        require_once VIEWS . '/voyage/liste.php';
    }
  
    public function recherche() {
        $voyages = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voyages = $this->voyage->rechercher(
                $_POST['villedepart'],
                $_POST['villearrive'],
                $_POST['date']
            );
        }
        require_once VIEWS . '/voyage/recherche.php';
    }

    // Détails
    public function detail() {
        $id     = $_GET['id'];
        $voyage = $this->voyage->getDetails($id);
        require_once VIEWS . '/voyage/detail.php';
    }

    // Créer
    public function creer() {
        $this->verifierRole('admin');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->voyage->creer(
                $_POST['trajet_id'],
                $_POST['agencedepart_id'],
                $_POST['agencearrive_id'],
                $_POST['type_id'],
                $_POST['bus_id'],
                $_POST['chauffeur_id'],
                $_POST['dateheuredepart'],
                $_POST['dateheurearrive'],
                $_POST['prix']
            );
            $message = $resultat['message'];
        }
        require_once VIEWS . '/voyage/creer.php';
    }

    // Modifier
    public function modifier() {
        $this->verifierRole('admin');
        $id     = $_GET['id'];
        $voyage = $this->voyage->getDetails($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->voyage->modifier(
                $id,
                $_POST['trajet_id'],
                $_POST['agencedepart_id'],
                $_POST['agencearrive_id'],
                $_POST['type_id'],
                $_POST['bus_id'],
                $_POST['chauffeur_id'],
                $_POST['dateheuredepart'],
                $_POST['dateheurearrive'],
                $_POST['prix'],
                $_POST['statut']
            );
            $message = $resultat['message'];
        }
        require_once VIEWS . '/voyage/modifier.php';
    }

    // Annuler
    public function annuler() {
        $this->verifierRole('admin');
        $id       = $_GET['id'];
        $resultat = $this->voyage->annuler($id);
        header('Location: index.php?controller=voyage&action=liste&message=' . $resultat['message']);
        exit();
    }

    // Passagers
    public function passagers() {
        $this->verifierRole('admin');
        $id        = $_GET['id'];
        $voyage    = $this->voyage->getDetails($id);
        $passagers = $this->voyage->getPassagers($id);
        require_once VIEWS . '/voyage/passagers.php';
    }

    // Vérifier le rôle
    private function verifierRole($role) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != $role) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }
}
?>