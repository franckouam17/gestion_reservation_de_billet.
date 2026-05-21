<?php $titre = 'GesRoad – Réservation de transport'; ?>
<?php 
require_once __DIR__ . '/../../config.php';
include __DIR__ . '/../../views/layout.php'; ?>
    
<!--  Section -->
<div class="bg-dark text-white rounded p-5 mb-5 text-center" 
     style="background: linear-gradient(135deg, #1a1a2e, #16213e) !important;">
    <h1 class="display-4 fw-bold mb-3">
        <i class="fas fa-bus text-warning"></i> GesRoad
    </h1>
    <p class="lead mb-4">
        Réservez vos billets de transport en ligne rapidement et facilement
    </p>
    <div class="d-flex justify-content-center gap-3">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>/index.php?controller=user&action=inscription" 
               class="btn btn-warning btn-lg fw-bold">
                <i class="fas fa-user-plus"></i> S'inscrire gratuitement
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=user&action=login" 
               class="btn btn-outline-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche" 
               class="btn btn-warning btn-lg fw-bold">
                <i class="fas fa-search"></i> Rechercher un voyage
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Statistiques -->
<div class="row text-center mb-5">
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body py-4">
                <i class="fas fa-bus fa-3x text-primary mb-3"></i>
   <h3 class="fw-bold text-primary"><?= $totalVoyages ?>+</h3>
                <p class="text-muted mb-0">Voyages disponibles</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body py-4">
                <i class="fas fa-map-marker-alt fa-3x text-success mb-3"></i>
                <h3 class="fw-bold text-success">10+</h3>
                <p class="text-muted mb-0">Villes desservies</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body py-4">
                <i class="fas fa-ticket-alt fa-3x text-warning mb-3"></i>
                <h3 class="fw-bold text-warning">100%</h3>
                <p class="text-muted mb-0">Réservation sécurisée</p>
            </div>
        </div>
    </div>
</div>

<!-- Comment ça marche -->
<div class="mb-5">
    <h3 class="text-center fw-bold mb-4">
        <i class="fas fa-info-circle text-primary"></i> Comment ça marche ?
    </h3>
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:60px; height:60px;">
                        <i class="fas fa-user-plus fa-lg"></i>
                    </div>
                    <h6 class="fw-bold">1. S'inscrire</h6>
                    <p class="text-muted small">Créez votre compte gratuitement en quelques secondes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:60px; height:60px;">
                        <i class="fas fa-search fa-lg"></i>
                    </div>
                    <h6 class="fw-bold">2. Rechercher</h6>
                    <p class="text-muted small">Trouvez le voyage qui vous convient par ville et date</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:60px; height:60px;">
                        <i class="fas fa-chair fa-lg"></i>
                    </div>
                    <h6 class="fw-bold">3. Choisir</h6>
                    <p class="text-muted small">Sélectionnez vos sièges sur le plan du bus</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body py-4">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:60px; height:60px;">
                        <i class="fas fa-ticket-alt fa-lg"></i>
                    </div>
                    <h6 class="fw-bold">4. Réserver</h6>
                    <p class="text-muted small">Confirmez et téléchargez votre billet PDF</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aperçu des prochains voyages -->
<div class="mb-5">
    <h3 class="text-center fw-bold mb-4">
        <i class="fas fa-bus text-primary"></i> Prochains voyages disponibles
    </h3>

    <?php if (!empty($voyages)): ?>
        <div class="row">
            <?php foreach ($voyages as $voyage): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-0 h-100">

                        <!-- Photo agence départ -->
                        <?php if ($voyage['photo_depart']): ?>
                            <img 
                                src="<?= BASE_URL ?>/uploads/agences/<?= $voyage['photo_depart'] ?>"
                                class="card-img-top"
                                style="height: 150px; object-fit: cover;"
                                alt="<?= $voyage['agence_depart'] ?>"
                            >
                        <?php else: ?>
                            <div class="bg-primary d-flex align-items-center justify-content-center"
                                 style="height: 150px;">
                                <i class="fas fa-bus fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <!-- Trajet -->
                            <h5 class="fw-bold text-center mb-3">
                                <span class="text-primary"><?= $voyage['agence_depart'] ?></span><br> </br>
                                <i class="fas fa-arrow-right text-warning mx-2"></i>
                                <span class="text-success"><?= $voyage['agence_arrivee'] ?></span>
                            </h5>

                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Départ</small>
                                    <span class="fw-bold">
                                        <?= date('d/m/Y', strtotime($voyage['dateheuredepart'])) ?>
                                    </span><br>
                                    <span class="text-primary fw-bold">
                                        <?= date('H:i', strtotime($voyage['dateheuredepart'])) ?>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Places</small>
                                    <span class="fw-bold text-success">
                                        <?= $voyage['placerestante'] ?> dispo
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-info"><?= $voyage['type_voyage'] ?></span>
                                <span class="fw-bold text-success fs-5">
                                    <?= number_format($voyage['prix'], 0, ',', '.') ?> FCFA
                                </span>
                            </div>
                        </div>

                        <div class="card-footer border-0 bg-white">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=creer&voyage_id=<?= $voyage['id'] ?>"
                                   class="btn btn-primary w-100">
                                    <i class="fas fa-ticket-alt"></i> Réserver
                                </a>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/index.php?controller=user&action=login"
                                   class="btn btn-outline-primary w-100">
                                    <i class="fas fa-sign-in-alt"></i> Connectez-vous pour réserver
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-3">
            <a href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche"
               class="btn btn-outline-primary btn-lg">
                <i class="fas fa-search"></i> Rechercher un voyage
            </a>
        </div>

    <?php else: ?>
        <div class="text-center py-4">
            <i class="fas fa-bus fa-4x text-muted mb-3"></i>
            <p class="text-muted">Aucun voyage disponible pour le moment</p>
        </div>
    <?php endif; ?>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>