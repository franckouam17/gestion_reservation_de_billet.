
<?php $titre = 'Recherche de voyage – GesRoute'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<!-- Bannière de recherche -->
<div class="bg-primary text-white rounded p-4 mb-4">
    <h3 class="text-center mb-3">
        <i class="fas fa-search"></i> Rechercher un voyage
    </h3>
    <form method="POST" action="index.php?controller=voyage&action=recherche">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Ville de départ</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input 
                        type="text" 
                        name="villedepart" 
                        class="form-control" 
                        placeholder="Ex: Douala"
                        value="<?= isset($_POST['villedepart']) ? $_POST['villedepart'] : '' ?>"
                        required
                    >
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ville d'arrivée</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-map-marker"></i>
                    </span>
                    <input 
                        type="text" 
                        name="villearrive" 
                        class="form-control" 
                        placeholder="Ex: Yaounde"
                        value="<?= isset($_POST['villearrive']) ? $_POST['villearrive'] : '' ?>"
                        required
                    >
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-calendar"></i>
                    </span>
                    <input 
                        type="date" 
                        name="date" 
                        class="form-control"
                        min="<?= date('Y-m-d') ?>"
                        value="<?= isset($_POST['date']) ? $_POST['date'] : '' ?>"
                        required
                    >
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-warning w-100 fw-bold">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Résultats -->
<?php if (!empty($voyages)): ?>
    <h5 class="mb-3">
        <i class="fas fa-list"></i> 
        <?= count($voyages) ?> voyage(s) trouvé(s)
    </h5>

    <?php foreach ($voyages as $voyage): ?>
        <div class="card shadow mb-3">
            <div class="card-body">
                <div class="row align-items-center">

                    <!-- Agence départ -->
                    <div class="col-md-3 text-center">
                        <?php if ($voyage['photo_depart']): ?>
                            <img 
                                src="uploads/agences/<?= $voyage['photo_depart'] ?>" 
                                alt="Agence départ"
                                class="img-fluid rounded mb-2"
                                style="height: 80px; object-fit: cover; width: 100%;"
                            >
                        <?php else: ?>
                            <div class="bg-light rounded p-3 mb-2">
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                        <?php endif; ?>
                        <p class="mb-0 fw-bold text-primary">
                            <?= $voyage['villedepart'] ?>
                        </p>
                        <small class="text-muted"><?= $voyage['agence_depart'] ?></small><br>
                        <small class="text-dark fw-bold">
                            <?= date('H:i', strtotime($voyage['dateheuredepart'])) ?>
                        </small>
                    </div>

                    <!-- Flèche -->
                    <div class="col-md-2 text-center">
                        <i class="fas fa-arrow-right fa-2x text-warning"></i>
                        <p class="mb-0 small text-muted mt-1">
                            <i class="fas fa-bus"></i> <?= $voyage['bus'] ?>
                        </p>
                        <p class="mb-0 small text-muted">
                            <i class="fas fa-user"></i> <?= $voyage['chauffeur'] ?>
                        </p>
                    </div>

                    <!-- Agence arrivée -->
                    <div class="col-md-3 text-center">
                        <?php if ($voyage['photo_arrivee']): ?>
                            <img 
                                src="uploads/agences/<?= $voyage['photo_arrivee'] ?>" 
                                alt="Agence arrivée"
                                class="img-fluid rounded mb-2"
                                style="height: 80px; object-fit: cover; width: 100%;"
                            >
                        <?php else: ?>
                            <div class="bg-light rounded p-3 mb-2">
                                <i class="fas fa-building fa-2x text-success"></i>
                            </div>
                        <?php endif; ?>
                        <p class="mb-0 fw-bold text-success">
                            <?= $voyage['villearrive'] ?>
                        </p>
                        <small class="text-muted"><?= $voyage['agence_arrivee'] ?></small><br>
                        <small class="text-dark fw-bold">
                            <?= date('H:i', strtotime($voyage['dateheurearrive'])) ?>
                        </small>
                    </div>

                    <!-- Infos -->
                    <div class="col-md-2 text-center">
                        <span class="badge bg-info mb-2">
                            <?= $voyage['type_voyage'] ?>
                        </span>
                        <p class="mb-0 fw-bold text-success fs-5">
                            <?= number_format($voyage['prix'], 0, ',', '.') ?> FCFA
                        </p>
                        <small class="text-muted">
                            <i class="fas fa-chair"></i> 
                            <?= $voyage['placerestante'] ?> place(s)
                        </small>
                    </div>

                    <!-- Bouton réserver -->
                    <div class="col-md-2 text-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a 
                                href="index.php?controller=reservation&action=creer&voyage_id=<?= $voyage['id'] ?>"
                                class="btn btn-primary w-100"
                            >
                                <i class="fas fa-ticket-alt"></i> Réserver
                            </a>
                        <?php else: ?>
                            <a 
                                href="index.php?controller=user&action=login"
                                class="btn btn-outline-primary w-100"
                            >
                                <i class="fas fa-sign-in-alt"></i> Connectez-vous
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="text-center py-5">
        <i class="fas fa-bus fa-4x text-muted mb-3"></i>
        <h5 class="text-muted">Aucun voyage trouvé pour ce trajet et cette date</h5>
        <p class="text-muted">Essayez une autre date ou un autre trajet</p>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layout_footer.php';?>