<?php $action = $_GET['action'] ?? 'index'; ?>
<?php require_once __DIR__ . '/../config.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titre) ? $titre : 'GesRoad' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="preload" as="image" href="<?= BASE_URL ?>/assets/image/fond.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/datatable/datatables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= BASE_URL ?>assets/datatable/dataTables.min.js"></script>
</head>
<body>
    

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow ">
    <div class="container">

        <!-- LOGO -->
        <a class="navbar-brand fw-bold fs-3"  href="
    <?php
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            echo BASE_URL . '/index.php?controller=admin&action=dashboard';
        } elseif ($_SESSION['user_role'] == 'caissier') {
            echo BASE_URL . '/index.php?controller=caissier&action=dashboard';
        } else {
            echo BASE_URL . '/index.php?controller=home&action=index';
        }
    } else {
        echo BASE_URL . '/index.php?controller=home&action=index';
    }
    ?>">
            <i class="fas fa-bus text-warning"></i>
            <span class="text-white">Ges</span><span class="text-warning">Road</span>
        </a>

        <!-- TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <!-- LIENS À GAUCHE -->
            <ul class="navbar-nav align-items-lg-center gap-lg-2">

                <?php if (isset($_SESSION['user_id'])): ?>

                    <?php if ($_SESSION['user_role'] == 'client'): ?>

                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'index') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=home&action=index">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'recherche') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche">
                                <i class="fas fa-search"></i> Rechercher voyages
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'liste') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=reservation&action=liste">
                                <i class="fas fa-ticket-alt"></i> Mes réservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'apropos') ? 'active' : '' ?>"
                            href="<?= BASE_URL ?>/index.php?controller=home&action=apropos">
                                <i class="fas fa-info-circle"></i> À propos
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if ($_SESSION['user_role'] == 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'dashboard') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=admin&action=dashboard">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if ($_SESSION['user_role'] == 'caissier'): ?>

                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'dashboard') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard">
                                <i class="fas fa-home"></i> Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold <?= ($action == 'rechercheVoyage') ? 'active' : '' ?>"
                               href="<?= BASE_URL ?>/index.php?controller=caissier&action=rechercheVoyage">
                                <i class="fas fa-search"></i> Rechercher un voyage
                            </a>
                        </li>

                    <?php endif; ?>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?= ($action == 'login') ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>/index.php?controller=user&action=login">
                            Connexion
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold <?= ($action == 'inscription') ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>/index.php?controller=user&action=inscription">
                            Inscription
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
 
            <!-- DROPDOWN À DROITE -->
            <?php if (isset($_SESSION['user_id'])): ?>
     
                <ul class="navbar-nav ms-auto ">

                    <li class="nav-item dropdown ">

                        <a class="nav-link dropdown-toggle fw-semibold user-link"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">

                            <i class="fas fa-user-circle"></i>
                            <?= $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom'] ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li>
                                <a class="dropdown-item"
                                   href="<?= BASE_URL ?>/index.php?controller=user&action=profil">
                                    <i class="fas fa-user-edit"></i> Modifier profil
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item text-danger"
                                   href="<?= BASE_URL ?>/index.php?controller=user&action=deconnecter"
                                   onclick="return confirm('Voulez-vous vraiment vous déconnecter ?')">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </a>
                            </li>

                        </ul>

                    </li>

                </ul>

            <?php endif; ?>

        </div>
    </div>
</nav>

    <!-- CONTENU – PAS DE </div> ICI -->
    <div class="container mt-4">
        <?php if (isset($message)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($erreur)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $erreur ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <!-- LE CONTENU S'INSÈRE ICI -->
         <script>
const images = [
    "assets/image/fond.jpg",
    "assets/image/fond2.jpg",
    "assets/image/fond3.jpg",
    "assets/image/fond4.jpg"
];

let i = 0;

function changeBackground() {
    document.body.style.backgroundImage = "url('" + images[i] + "')";
    i = (i + 1) % images.length;
}

changeBackground(); // premier affichage
setInterval(changeBackground, 5000); // change toutes les 5 secondes
</script>
         