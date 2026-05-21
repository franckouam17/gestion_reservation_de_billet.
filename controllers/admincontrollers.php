<?php
require_once MODELS . '/Voyage.php';
require_once MODELS . '/Reservation.php';
require_once MODELS . '/Paiement.php';
require_once MODELS . '/Agence.php';
require_once MODELS . '/AgenceLocale.php';
require_once MODELS . '/Trajet.php';
require_once MODELS . '/Bus.php';
require_once MODELS . '/Chauffeur.php';
require_once MODELS . '/user.php';

class AdminController {
    private $pdo;
    private $voyage;
    private $reservation;
    private $paiement;
    private $agence;
    private $agenceLocale;
    private $trajet;
    private $bus;
    private $chauffeur;
   

    public function __construct($pdo) {
        $this->pdo          = $pdo;
        $this->voyage       = new Voyage($pdo);
        $this->reservation  = new Reservation($pdo);
        $this->paiement     = new Paiement($pdo);
        $this->agence       = new Agence($pdo);
        $this->agenceLocale = new AgenceLocale($pdo);
        $this->trajet       = new Trajet($pdo);
        $this->bus          = new Bus($pdo);
        $this->chauffeur    = new Chauffeur($pdo);
    }

    // Vérifier que c'est un admin
    private function verifierAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header('Location: ' . BASE_URL . '/index.php?controller=user&action=login');
            exit();
        }
    }

    // ══ DASHBOARD ══
    public function dashboard(

    ) {
    
      

      
  $this->verifierAdmin();
        // Statistiques
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM voyage WHERE statut = 0 and Date(dateheuredepart) >= NOW()");
        $stmt->execute();
        $totalVoyages = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM reservation WHERE  DATE(date_reservation) = CURDATE()");
        $stmt->execute();
        $totalReservations = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Remplace la requête totalClients par
        $stmt = $this->pdo->prepare("SELECT id, nom, prenom, email, role, date_creation FROM user ORDER BY date_creation DESC");
        $stmt->execute();
        $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM user");
        $stmt->execute();
        $totalClients = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $this->pdo->prepare("SELECT SUM(montant) AS total FROM paiement WHERE statut = 1  AND DATE(datepaiement) = CURDATE()");
        $stmt->execute();
        $totalRecettes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Dernières réservations
        $dernieresReservations = $this->reservation->listerToute();
        

        require VIEWS . '/admin/dashboard.php';
        
    }
    public function reactiverReservation()
{
    $id = $_GET['id'];

    $sql = "UPDATE reservation SET statut = 1 WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listereservatiions');
}
public function reactiveruser()
{
    $id = $_GET['id'];

    $sql = "UPDATE user SET statut = 0 WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeuser');
}

    // ══ GESTION VOYAGES ══
    public function listeVoyages() {
        $this->verifierAdmin();
        $voyages = $this->voyage->lister();
        require_once VIEWS . '/admin/voyage/liste.php';
    }
    //lister tout les voyages
    public function listervoyages(){
        $this->verifierAdmin();
        $voyages = $this->voyage->listertout();
        require_once VIEWS . '/admin/voyage/listetout.php';
    }
    public function creerVoyage() {
        $this->verifierAdmin();
        $trajets_chauffeurs = $this->getTrajetsChaufeurs();
        $agences_locales    = $this->agenceLocale->lister();
        $types_voyage       = $this->getTypesVoyage();
        $bus_disponibles    = $this->bus->listerDisponibles();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->voyage->creer(
                $_POST['trajetchauffeur_id'],
                $_POST['agencelocaledeapart_id'],
                $_POST['agenceloacledarrive_id'],
                $_POST['type_id'],
                $_POST['bus_id'],
                $_POST['dateheuredepart'],
                $_POST['dateheurearrive'],
                $_POST['prix']
            );
            $message = $resultat['message'];
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeVoyages');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/voyage/creer.php';
    }

    public function modifierVoyage() {
        
        $this->verifierAdmin();
        $id                 = $_GET['id'];
        $voyage             = $this->voyage->getDetails($id);
        $trajets_chauffeurs = $this->getTrajetsChaufeurs();
        $agences_locales    = $this->agenceLocale->lister();
        $types_voyage       = $this->getTypesVoyage();
        $bus_disponibles    = $this->bus->listerDisponibles();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->voyage->modifier(
                $id,
                $_POST['trajetchauffeur_id'],
                $_POST['agencelocaledeapart_id'],
                $_POST['agenceloacledarrive_id'],
                $_POST['type_id'],
                $_POST['bus_id'],
                $_POST['dateheuredepart'],
                $_POST['dateheurearrive'],
                $_POST['prix'],
                $_POST['statut']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeVoyages');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/voyage/modifier.php';
    }

    public function annulerVoyage() {
        $this->verifierAdmin();
        $id       = $_GET['id'];
        $resultat = $this->voyage->annuler($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeVoyages&message=' . $resultat['message']);
        exit();
    }

    public function passagersVoyage() {
        $this->verifierAdmin();
        $id        = $_GET['id'];
        $voyage    = $this->voyage->getDetails($id);
        $passagers = $this->voyage->getPassagers($id);
        require_once VIEWS . '/admin/voyage/passager.php';
    }

    // ══ GESTION RESERVATIONS ══
    //par jour
    public function listeReservations() {
        $this->verifierAdmin();
        $reservations = $this->reservation->listerToutes();
        require_once VIEWS . '/admin/reservation/liste.php';
    }
    // toute
    public function listerReservations() {
        $this->verifierAdmin();
        $reservations = $this->reservation->listertoute();
        require_once VIEWS . '/admin/reservation/listetout.php';
    }

    public function annulerReservation() {
        $this->verifierAdmin();
        $id       = $_GET['id'];
        $resultat = $this->reservation->annuler($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeReservations&message=' . $resultat['message']);
        exit();
    }

    // ══ GESTION AGENCES ══
    public function listeAgences() {
        $this->verifierAdmin();
        $agences = $this->agence->lister();
        require_once VIEWS . '/admin/agence/liste.php';
    }

    public function creerAgence() {
        $this->verifierAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->agence->ajouter(
                $_POST['nom'],
                $_POST['description'],
                $_POST['logo'],
                $_POST['devise']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgences');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/agence/creer.php';
    }

    public function modifierAgence() {
        $this->verifierAdmin();
        $id     = $_GET['id'];
        $agence = $this->agence->getDetails($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->agence->modifier(
                $id,
                $_POST['nom'],
                $_POST['description'],
                $_POST['devise']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgences');
                exit();
            }
        }
        require_once VIEWS . '/admin/agence/modifier.php';
    }

    public function supprimerAgence() {
        $this->verifierAdmin();
        $id = $_GET['id'];
        $this->agence->supprimer($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgences');
        exit();
    }

    // ══ GESTION AGENCES LOCALES ══
    public function listeAgencesLocales() {
        $this->verifierAdmin();
        $agences_locales = $this->agenceLocale->lister();
        require_once VIEWS . '/admin/agence_locale/liste.php';
    }

    public function creerAgenceLocale() {
        $this->verifierAdmin();
        $agences = $this->agence->lister();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->agenceLocale->ajouter(
                $_POST['agence_id'],
                $_POST['addresse'],
                $_POST['telephone']
            );
            if ($resultat['succes']) {
                // Upload photo si fournie
                if (!empty($_FILES['photo']['name'])) {
                    $this->agenceLocale->uploadPhoto($resultat['id'], $_FILES['photo']);
                }
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgencesLocales');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/agence_locale/creer.php';
    }

    public function modifierAgenceLocale() {
        $this->verifierAdmin();
        $id           = $_GET['id'];
        $agence_locale = $this->agenceLocale->getDetails($id);
        $agences      = $this->agence->lister();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->agenceLocale->modifier(
                $id,
                $_POST['addresse'],
                $_POST['telephone'],
                $_POST['statut']
            );
            if (!empty($_FILES['photo']['name'])) {
                $this->agenceLocale->uploadPhoto($id, $_FILES['photo']);
            }
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgencesLocales');
                exit();
            }
        }
        require_once VIEWS . '/admin/agence_locale/modifier.php';
    }

    public function supprimerAgenceLocale() {
        $this->verifierAdmin();
        $id = $_GET['id'];
        $this->agenceLocale->supprimer($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeAgencesLocales');
        exit();
    }

    // ══ GESTION TRAJETS ══
    public function listeTrajets() {
        $this->verifierAdmin();
        $trajets = $this->trajet->lister();
        require_once VIEWS . '/admin/trajet/liste.php';
    }

    public function creerTrajet() {
        $this->verifierAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->trajet->ajouter(
                $_POST['villedepart'],
                $_POST['villearrive'],
                $_POST['distance'],
                $_POST['duree']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeTrajets');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/trajet/creer.php';
    }

    public function modifierTrajet() {
        $this->verifierAdmin();
        $id     = $_GET['id'];
        $trajet = $this->trajet->getDetails($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->trajet->modifier(
                $id,
                $_POST['villedepart'],
                $_POST['villearrive'],
                $_POST['distance'],
                $_POST['duree']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeTrajets');
                exit();
            }
        }
        require_once VIEWS . '/admin/trajet/modifier.php';
    }

    public function supprimerTrajet() {
        $this->verifierAdmin();
        $id = $_GET['id'];
        $this->trajet->supprimer($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeTrajets');
        exit();
    }

    // ══ GESTION BUS ══
    public function listeBus() {
        $this->verifierAdmin();
        $bus = $this->bus->lister();
        require_once VIEWS . '/admin/bus/liste.php';
    }

    public function creerBus() {
        $this->verifierAdmin();
        $types_bus = $this->getTypesBus();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->bus->ajouter(
                $_POST['typebus_id'],
                $_POST['immatriculation'],
                $_POST['nbre_place']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeBus');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/bus/creer.php';
    }

    public function modifierBus() {
        $this->verifierAdmin();
        $id        = $_GET['id'];
        $bus       = $this->bus->getDetails($id);
        $types_bus = $this->getTypesBus();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->bus->modifier(
                $id,
                $_POST['typebus_id'],
                $_POST['immatriculation'],
                $_POST['nbre_place']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeBus');
                exit();
            }
        }
        require_once VIEWS . '/admin/bus/modifier.php';
    }

    public function supprimerBus() {
        $this->verifierAdmin();
        $id = $_GET['id'];
        $this->bus->supprimer($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeBus');
        exit();
    }

    // ══ GESTION CHAUFFEURS ══
    public function listeChauffeurs() {
        $this->verifierAdmin();
        $chauffeurs = $this->chauffeur->lister();
        require_once VIEWS . '/admin/chauffeur/liste.php';
    }

    public function creerChauffeur() {
        $this->verifierAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->chauffeur->ajouter(
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['telephone'],
                $_POST['num_permi']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeChauffeurs');
                exit();
            } else {
                $erreur = $resultat['message'];
            }
        }
        require_once VIEWS . '/admin/chauffeur/creer.php';
    }

    public function modifierChauffeur() {
        $this->verifierAdmin();
        $id        = $_GET['id'];
        $chauffeur = $this->chauffeur->getDetails($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->chauffeur->modifier(
                $id,
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['telephone'],
                $_POST['num_permi'],
                $_POST['statut']
            );
            if ($resultat['succes']) {
                header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeChauffeurs');
                exit();
            }
        }
        require_once VIEWS . '/admin/chauffeur/modifier.php';
    }

    public function supprimerChauffeur() {
        $this->verifierAdmin();
        $id = $_GET['id'];
        $this->chauffeur->supprimer($id);
        header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeChauffeurs');
        exit();
    }

    public function assignerChauffeur() {
        $this->verifierAdmin();
        $trajets    = $this->trajet->lister();
        $chauffeurs = $this->chauffeur->listerActifs();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resultat = $this->chauffeur->assignerTrajet(
                $_POST['trajet_id'],
                $_POST['chauffeur_id']
            );
            $message = $resultat['message'];
        }
        require_once VIEWS . '/admin/chauffeur/assigner.php';
    }

    // ══ GESTION PAIEMENTS ══
    public function listePaiements() {
        $this->verifierAdmin();
        $paiements = $this->paiement->listerTous();
        require_once VIEWS . '/admin/paiement/liste.php';
    }

    public function statsRecettes() {
        $this->verifierAdmin();
        $stats = $this->paiement->chiffreAffaires();
        require_once VIEWS . '/admin/paiement/stats.php';
    }

    private function getTrajetsChaufeurs() {
    $stmt = $this->pdo->prepare("
        SELECT 
            tc.id,
            CONCAT(t.villedepart,' → ',t.villearrive,' – ',c.nom,' ',c.prenom) AS libelle
        FROM trajet_chauffeur tc
        JOIN trajet t    ON t.id = tc.trajet_id
        JOIN chauffeur c ON c.id = tc.chauffeur_id
        WHERE c.statut  = 1
        AND   tc.statut = 1  -- ✅ seulement les disponibles
        ORDER BY t.villedepart ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    private function getTypesVoyage() {
        $stmt = $this->pdo->prepare("SELECT * FROM typevoyage ORDER BY libelle ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getTypesBus() {
        $stmt = $this->pdo->prepare("SELECT * FROM typebus ORDER BY libelle ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Ajouter un utilisateur
public function ajouterUser() {
    $this->verifierAdmin();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userModel = new user($this->pdo);
        $resultat  = $userModel->inscrire(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['mot_de_passe'],
            $_POST['role'],
            $_POST['agencelocale_id'] ?? null
        );

        if ($resultat['succes']) {
            header('Location: ' . BASE_URL . '/index.php?controller=admin&action=dashboard');
            exit();
        } else {
            $erreur = $resultat['message'];
        }
    }

    $agences_locales = $this->agenceLocale->lister();
    require VIEWS . '/admin/users/ajouter.php';
}

// Modifier le rôle d'un utilisateur
public function modifierRoleUser() {
    $this->verifierAdmin();
    $id   = $_GET['id'];
    $role = $_GET['role'];

    $stmt = $this->pdo->prepare("UPDATE user SET role = ? WHERE id = ?");
    $stmt->execute([$role, $id]);

    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=dashboard');
    exit();
}

// Supprimer un utilisateur
public function supprimerUser()
{
    $this->verifierAdmin();

    $id = $_GET['id'];

    // Récupérer l'utilisateur ciblé
    $stmt = $this->pdo->prepare("SELECT role FROM user WHERE id = ?");
    $stmt->execute([$id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe
    if (!$user) {
        die("Utilisateur introuvable");
    }

    // Autoriser seulement client et caissier
    if ($user['role'] != 'client' && $user['role'] != 'caissier') {
        die("Impossible de suspendre cet utilisateur");
    }

    // Suspension au lieu de suppression
    $stmt = $this->pdo->prepare("UPDATE user SET statut = 0 WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ' . BASE_URL . '/index.php?controller=admin&action=listeuser');
    exit();
}
public function listeuser(){
    $this->verifierAdmin();
    $stmt = $this->pdo->prepare("SELECT * FROM user");
$stmt->execute();

$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

   require VIEWS . '/admin/listeusers.php';
}
}
?>