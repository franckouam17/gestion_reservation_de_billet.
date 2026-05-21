<?php
session_start();
require_once 'config.php';
require_once 'connexion.php';

// Libérer les sièges expirés + terminer les voyages
require_once MODELS . '/Siege.php';
$siegeModel = new Siege($pdo);
$siegeModel->libererSiegesExpires();
$siegeModel->terminerVoyagesExpires();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action'])     ? $_GET['action']     : 'index';

switch ($controller) {
    case 'home':
        require_once CONTROLLERS . '/HomeControllers.php';
        $ctrl = new HomeController($pdo);
        break;
    case 'user':
        require_once CONTROLLERS . '/UserControllers.php';
        $ctrl = new UserController($pdo);
        break;
    case 'voyage':
        require_once CONTROLLERS . '/VoyageControllers.php';
        $ctrl = new VoyageController($pdo);
        break;
    case 'reservation':
        require_once CONTROLLERS . '/ReservationControllers.php';
        $ctrl = new ReservationController($pdo);
        break;
    case 'paiement':
        require_once CONTROLLERS . '/PaiementControllers.php';
        $ctrl = new PaiementController($pdo);
        break;
    case 'billet':
        require_once CONTROLLERS . '/BilletControllers.php';
        $ctrl = new BilletController($pdo);
        break;
    case 'admin':
        require_once CONTROLLERS . '/AdminControllers.php';
        $ctrl = new AdminController($pdo);
        break;
    case 'caissier':
        require_once CONTROLLERS . '/CaissierControllers.php';
        $ctrl = new CaissierController($pdo);
        break;
    default:
        require_once CONTROLLERS . '/HomeControllers.php';
        $ctrl = new HomeController($pdo);
        break;
}

if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger'>
                <h4>Erreur 404</h4>
                <p>La page <b>$controller/$action</b> n'existe pas.</p>
                <a href='index.php' class='btn btn-primary'>Retour à l'accueil</a>
            </div>
          </div>";
}
?>