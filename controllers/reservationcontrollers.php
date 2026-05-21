<?php
require_once MODELS . '/Reservation.php';
require_once MODELS . '/voyage.php';

class ReservationController {
    private $pdo;
    private $reservation;
    private $voyage;

    public function __construct($pdo) {
        $this->pdo         = $pdo;
        $this->reservation = new Reservation($pdo);
         $this->voyage      = new Voyage($pdo);
    }

    
   
    // Créer au guichet (caissier)
    public function creerGuichet() {
        $this->verifierRole('caissier');

        $voyage_id = $_GET['voyage_id'];
        $sieges    = $this->reservation->getSiegesDisponibles($voyage_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->reservation->creer(
                $_POST['user_id'],
                $voyage_id,
                $_POST['sieges'],
                'guichet'
            );

            if ($resultat['succes']) {
                header('Location: index.php?controller=reservation&action=detail&id=' . $resultat['reservation_id']);
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/reservation/creer.php';
    }

    // Détails
    public function detail() {
        $this->verifierConnexion();
        $id          = $_GET['id'];
        $reservation = $this->reservation->getDetails($id);
        require_once VIEWS . '/reservation/detail.php';
    }

    // Liste client
    public function liste() {
        $this->verifierConnexion();
        $reservations = $this->reservation->listerParClient($_SESSION['user_id']);
        require_once VIEWS . '/reservation/liste.php';
    }

    // Liste admin
    public function listeAdmin() {
        $this->verifierRole('admin');
        $reservations = $this->reservation->listerToutes();
        require_once VIEWS . '/reservation/liste_admin.php';
    }

    // Annuler
   public function annuler() {
    $this->verifierConnexion();
    $id       = $_GET['id'];
    $resultat = $this->reservation->annuler($id);

    if ($resultat['succes']) {
        // Rediriger vers page confirmation remboursement
        $_SESSION['remboursement'] = $resultat;
        header('Location: ' . BASE_URL . '/index.php?controller=reservation&action=confirmationAnnulation');
        exit();
    } else {
        header('Location: ' . BASE_URL . '/index.php?controller=reservation&action=liste&message=' . urlencode($resultat['message']));
        exit();
    }
}

// Page confirmation annulation
public function confirmationAnnulation() {
    $this->verifierConnexion();

    if (!isset($_SESSION['remboursement'])) {
        header('Location: ' . BASE_URL . '/index.php?controller=reservation&action=liste');
        exit();
    }

    $remboursement = $_SESSION['remboursement'];
    unset($_SESSION['remboursement']);

    require VIEWS . '/reservation/confirmation_annulation.php';
}

    // Vérifier connexion
    private function verifierConnexion() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

    // Vérifier rôle
    private function verifierRole($role) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != $role) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

    // Créer une réservation
  // Après sélection des sièges → page infos passagers
public function creer() {
    $this->verifierConnexion();

    $voyage_id = $_GET['voyage_id'];
    $voyage    = $this->voyage->getDetails($voyage_id);
    $sieges    = $this->reservation->getSiegesDisponibles($voyage_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les sièges sélectionnés
        $sieges_selectionnes = $_POST['sieges'];

        // Rediriger vers page infos passagers
        $_SESSION['sieges_selectionnes'] = $sieges_selectionnes;
        $_SESSION['voyage_id']           = $voyage_id;

        header('Location: ' . BASE_URL . '/index.php?controller=reservation&action=passagers');
        exit();
    }
    require VIEWS . '/reservation/creer.php';
}

// Page infos passagers
public function passagers() {
    $this->verifierConnexion();

    if (!isset($_SESSION['sieges_selectionnes'])) {
        header('Location: ' . BASE_URL . '/index.php?controller=voyage&action=recherche');
        exit();
    }

    $voyage_id          = $_SESSION['voyage_id'];
    $sieges_selectionnes = $_SESSION['sieges_selectionnes'];
    $voyage             = $this->voyage->getDetails($voyage_id);
    $sieges             = $this->reservation->getSiegesDisponibles($voyage_id);

    require VIEWS . '/reservation/passager.php';
}

// Confirmer réservation + infos passagers
public function confirmer() {
    $this->verifierConnexion();

    $voyage_id = $_POST['voyage_id'];
    $sieges    = $_POST['sieges'];
    $types     = $_POST['type']      ?? [];
    $noms      = $_POST['nom']       ?? [];
    $telephones = $_POST['telephone'] ?? [];

    // Créer la réservation
    $resultat = $this->reservation->creer(
        $_SESSION['user_id'],
        $voyage_id,
        $sieges,
        'en_ligne'
    );

    if ($resultat['succes']) {
        $reservation_id = $resultat['reservation_id'];

        // Mettre à jour les infos passagers
        foreach ($sieges as $siege_id) {
            $type = $types[$siege_id] ?? 'moi';

            if ($type == 'moi') {
                $nom       = $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom'];
                $telephone = '';
            } else {
                $nom       = $noms[$siege_id]       ?? '';
                $telephone = $telephones[$siege_id] ?? '';
            }

            $stmt = $this->pdo->prepare("
                UPDATE reservation_siege 
                SET nom = ?, telephone = ?
                WHERE reservation_id = ? AND siege_id = ?
            ");
            $stmt->execute([$nom, $telephone, $reservation_id, $siege_id]);
        }

        unset($_SESSION['sieges_selectionnes']);
        unset($_SESSION['voyage_id']);

        header('Location: ' . BASE_URL . '/index.php?controller=paiement&action=paiementMobile&reservation_id=' . $reservation_id);
        exit();

    } else {
        // ✅ Redéfinir $voyage et $sieges avant d'afficher creer.php
        $erreur = $resultat['message'];
        $voyage = $this->voyage->getDetails($voyage_id);
        $sieges = $this->reservation->getSiegesDisponibles($voyage_id);
        require VIEWS . '/reservation/creer.php';
    }
}
}
?>