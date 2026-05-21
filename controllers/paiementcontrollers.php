<?php
require_once MODELS . '/Paiement.php';
require_once MODELS . '/Billet.php';
require_once MODELS . '/Reservation.php';

class PaiementController {
    private $pdo;
    private $paiement;
    private $billet;
    private $reservation;

    public function __construct($pdo) {
        $this->pdo         = $pdo;
        $this->paiement    = new Paiement($pdo);
        $this->billet      = new Billet($pdo);
        $this->reservation = new Reservation($pdo);
    }

    // Page paiement mobile (client)
    public function paiementMobile() {
        $this->verifierConnexion();
        $reservation_id = $_GET['reservation_id'];
        $reservation    = $this->reservation->getDetails($reservation_id);
        require VIEWS . '/reservation/paiement.php';
    }

    // Initier paiement Mobile Money (simulation)
    public function initier() {
        $this->verifierConnexion();

        $reservation_id = $_POST['reservation_id'];
        $reservation    = $this->reservation->getDetails($reservation_id);

        $resultat = $this->paiement->initierMobileMoney(
            $reservation_id,
            $_POST['montant'],
            $_POST['operateur'],
            $_POST['telephone'],
            $_SESSION['user_id']
        );
      

        if ($resultat['succes']) {
            $this->billet->generer($reservation_id);
         

            header('Location: ' . BASE_URL . '/index.php?controller=paiement&action=confirmation&paiement_id=' . $resultat['paiement_id']);
            exit();
        } else {
            $erreur = $resultat['message'];
            require VIEWS . '/reservation/paiement.php';
        }
    }

    // Page confirmation paiement
    public function confirmation() {
        $this->verifierConnexion();
        $paiement_id = $_GET['paiement_id'];
        $paiement    = $this->paiement->getDetails($paiement_id);
        $billets     = $this->billet->getParReservation($paiement['reservation_id']);
        require VIEWS . '/paiement/confirmation.php';
    }

    // Liste paiements (admin)
    public function liste() {
        $this->verifierRole('admin');
        $paiements = $this->paiement->listerTous();
        require VIEWS . '/paiement/liste.php';
    }

    // Chiffre d'affaires (admin)
    public function chiffreAffaires() {
        $this->verifierRole('admin');
        $stats = $this->paiement->chiffreAffaires();
        require VIEWS . '/paiement/stats.php';
    }

    // Vérifier connexion
    private function verifierConnexion() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
            exit();
        }
    }

    // Vérifier rôle
    private function verifierRole($role) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != $role) {
            header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
            exit();
        }
    }
}
?>