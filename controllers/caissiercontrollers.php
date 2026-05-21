<?php
require_once MODELS . '/Reservation.php';
require_once MODELS . '/Paiement.php';
require_once MODELS . '/Billet.php';
require_once MODELS . '/Voyage.php';
require_once MODELS . '/User.php';

class CaissierController {
    private $pdo;
    private $reservation;
    private $paiement;
    private $billet;
    private $voyage;

    public function __construct($pdo) {
        $this->pdo         = $pdo;
        $this->reservation = new Reservation($pdo);
        $this->paiement    = new Paiement($pdo);
        $this->billet      = new Billet($pdo);
        $this->voyage      = new Voyage($pdo);
    }

    // Vérifier que c'est un caissier
    private function verifierCaissier() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'caissier') {
            header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
            exit();
        }
    }

    // ══ DASHBOARD ══
    public function dashboard() {
        $this->verifierCaissier();

        // Statistiques du jour
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) AS total 
            FROM paiement 
            WHERE statut = 1 
            AND DATE(datepaiement) = CURDATE()
            AND caissier_id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $paiementsAujourdhui = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->pdo->prepare("
            SELECT SUM(montant) AS total 
            FROM paiement 
            WHERE statut = 1 
            AND DATE(datepaiement) = CURDATE()
            AND caissier_id = ?
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $recettesAujourdhui = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM reservation
            WHERE  DATE(date_reservation) = CURDATE()");
        $stmt->execute();
        $reservationsGuichet = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Derniers paiements du caissier
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.montant,
                p.methode,
                p.datepaiement,
                p.referencetransaction,
                CONCAT(u.nom,' ',u.prenom) AS client,
                t.villedepart,
                t.villearrive
            FROM paiement p
            JOIN reservation r       ON r.id  = p.reservation_id
            JOIN user u              ON u.id  = r.user_id
            JOIN voyage v            ON v.id  = r.voyage_id
            JOIN trajet_chauffeur tc ON tc.id = v.trajetchauffeur_id
            JOIN trajet t            ON t.id  = tc.trajet_id
            WHERE p.caissier_id = ?
            AND   p.statut      = 1
            ORDER BY p.datepaiement DESC
            LIMIT 10
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $derniersPaiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once VIEWS . '/caissier/dashboard.php';
    }

    // ══ RECHERCHE VOYAGE (pour réservation guichet) ══
    public function rechercheVoyage() {
        $this->verifierCaissier();
        
        $voyages = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voyages = $this->voyage->rechercher(
                $_POST['villedepart'],
                $_POST['villearrive'],
                $_POST['date']
            );
        }
         require VIEWS . '/caissier/recherche.php';
    }

    // ══ RÉSERVATION AU GUICHET ══
   public function creerReservation() {
    $this->verifierCaissier();
    $voyage_id = $_GET['voyage_id'];
    $voyage    = $this->voyage->getDetails($voyage_id);
    $sieges    = $this->reservation->getSiegesDisponibles($voyage_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Vérifier si le client existe déjà
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        // Sinon créer le client
        if (!$client) {
            $userModel = new User($this->pdo);
            $resultat  = $userModel->inscrire(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['email'],
                uniqid(),
                'client'
            );
            $user_id = $resultat['id'];
        } else {
            $user_id = $client['id'];
        }

        // Créer la réservation
        $resultat = $this->reservation->creer(
            $user_id,
            $voyage_id,
            $_POST['sieges'],
            'guichet'
        );

        if ($resultat['succes']) {
            $reservation_id = $resultat['reservation_id'];

            // Mettre à jour les infos passagers
            $passager_noms = $_POST['passager_nom'] ?? [];
            $passager_tels = $_POST['passager_tel'] ?? [];

            foreach ($_POST['sieges'] as $siege_id) {
                $nom       = $passager_noms[$siege_id] ?? $_POST['nom'] . ' ' . $_POST['prenom'];
                $telephone = $passager_tels[$siege_id] ?? $_POST['telephone'] ?? '';

                $stmt = $this->pdo->prepare("
                    UPDATE reservation_siege 
                    SET nom = ?, telephone = ?
                    WHERE reservation_id = ? AND siege_id = ?
                ");
                $stmt->execute([$nom, $telephone, $reservation_id, $siege_id]);
            }

            // Rediriger directement vers paiement espèces
            header('Location: ' . BASE_URL . '/index.php?controller=caissier&action=effectuerPaiement&reservation_id=' . $reservation_id);
            exit();
        } else {
            $erreur = $resultat['message'];
        }
    }
    require VIEWS . '/caissier/creer_reservation.php';
}

    // ══ PAIEMENT ══
    public function effectuerPaiement() {
        $this->verifierCaissier();
        $reservation_id = $_GET['reservation_id'];
        $reservation    = $this->reservation->getDetails($reservation_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->paiement->effectuer(
                $reservation_id,
                $_SESSION['user_id'],
                $_POST['montant'],
                $_POST['methode']
            );

            if ($resultat['succes']) {
                // Générer automatiquement le billet
                $this->billet->generer($reservation_id);
                header('Location: ' . BASE_URL . '/index.php?controller=caissier&action=detailPaiement&id=' . $resultat['paiement_id']);
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/caissier/effectuer_paiement.php';
    }

    // ══ DÉTAIL PAIEMENT ══
    public function detailPaiement() {
    $this->verifierCaissier();
    $id       = $_GET['id'];
    $paiement = $this->paiement->getDetails($id);
    $billets  = $this->billet->getParReservation($paiement['reservation_id'] ?? null);
    $billet   = !empty($billets) ? $billets[0] : null;
    require VIEWS . '/caissier/detail_paiement.php';
}

    // ══ LISTE PAIEMENTS DU CAISSIER ══
    public function listePaiements() {
        $this->verifierCaissier();
        $stmt = $this->pdo->prepare("
            SELECT 
                p.id,
                p.montant,
                p.reservation_id,
                p.methode,
                p.statut,
                p.referencetransaction,
                p.datepaiement,
                CONCAT(u.nom,' ',u.prenom) AS client,
                t.villedepart,
                t.villearrive,
                v.dateheuredepart
            FROM paiement p
            JOIN reservation r       ON r.id  = p.reservation_id
            JOIN user u              ON u.id  = r.user_id
            JOIN voyage v            ON v.id  = r.voyage_id
            JOIN trajet_chauffeur tc ON tc.id = v.trajetchauffeur_id
            JOIN trajet t            ON t.id  = tc.trajet_id
            WHERE p.caissier_id = ?
            ORDER BY p.datepaiement DESC
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once VIEWS . '/caissier/liste_paiements.php';
    }

    // ══ LISTE PASSAGERS D'UN VOYAGE ══
    public function passagersVoyage() {
    $this->verifierCaissier();

    $voyage_id = $_GET['voyage_id'] ?? null;

    if (!$voyage_id) {
        die('Voyage introuvable');
    }

    $voyage = $this->voyage->getDetails($voyage_id);

    if (!$voyage) {
        die('Voyage inexistant');
    }

    $passagers = $this->voyage->getPassagers($voyage_id);

    require_once VIEWS . '/caissier/passagers.php';
}

    // ══ IMPRIMER BILLET ══
   public function imprimerBillet() {
    $this->verifierCaissier();
    $reservation_id = $_GET['reservation_id'];

    // Récupérer les billets
    $billets = $this->billet->getParReservation($reservation_id);

    // Si aucun billet → générer
    if (empty($billets)) {
        $this->billet->generer($reservation_id);
        $billets = $this->billet->getParReservation($reservation_id);
    }

    if (empty($billets)) {
        header('Location: ' . BASE_URL . '/index.php?controller=caissier&action=dashboard&message=Billet introuvable');
        exit();
    }

    // Prendre le premier billet
    $billet_id = $billets[0]['id'];
    $details   = $this->billet->getDetails($billet_id);

    require VIEWS . '/caissier/imprimer_billet.php';
}
// ══ CHOISIR VOYAGE POUR VOIR PASSAGERS ══
public function choisirVoyage() {
    $this->verifierCaissier();

    // Récupérer tous les voyages planifiés ou en cours
    $stmt = $this->pdo->prepare("
        SELECT 
            v.id,
            t.villedepart,
            t.villearrive,
            v.dateheuredepart,
            v.placerestante,
            v.statut,
            b.immatriculation AS bus
        FROM voyage v
        JOIN trajet_chauffeur tc ON tc.id = v.trajetchauffeur_id
        JOIN trajet t            ON t.id  = tc.trajet_id
        JOIN bus b               ON b.id  = v.bus_id
        WHERE v.statut IN (0, 1)
        ORDER BY v.dateheuredepart ASC
    ");
    $stmt->execute();
    $voyages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    require VIEWS . '/caissier/choisirvoyage.php';
}
}
?>