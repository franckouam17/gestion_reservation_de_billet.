<?php $titre = 'Recherche voyage – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-search text-primary"></i> Rechercher un voyage
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>
</div>

<!-- Formulaire -->
<div class="card shadow border-0 mb-4">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=caissier&action=rechercheVoyage">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Ville de départ</label>
                    <input type="text" name="villedepart" class="form-control"
                           placeholder="Ex: Douala"
                           value="<?= isset($_POST['villedepart']) ? $_POST['villedepart'] : '' ?>"
                           required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Ville d'arrivée</label>
                    <input type="text" name="villearrive" class="form-control"
                           placeholder="Ex: Yaounde"
                           value="<?= isset($_POST['villearrive']) ? $_POST['villearrive'] : '' ?>"
                           required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" name="date" class="form-control"
                           min="<?= date('Y-m-d') ?>"
                           value="<?= isset($_POST['date']) ? $_POST['date'] : '' ?>"
                           required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Résultats -->
<?php if (!empty($voyages)): ?>
    <h5 class="mb-3">
        <i class="fas fa-list"></i>
        <?= count($voyages) ?> voyage(s) trouvé(s)
    </h5>

    <?php foreach ($voyages as $v): ?>
        <div class="card shadow border-0 mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="fw-bold">
                            <span class="text-primary"><?= $v['villedepart'] ?></span>
                            <i class="fas fa-arrow-right text-warning mx-2"></i>
                            <span class="text-success"><?= $v['villearrive'] ?></span>
                        </h5>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i>
                            <?= date('d/m/Y H:i', strtotime($v['dateheuredepart'])) ?>
                        </small>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Bus</small>
                        <span class="fw-bold"><?= $v['bus'] ?></span>
                        <small class="text-muted d-block">Chauffeur</small>
                        <span><?= $v['chauffeur'] ?></span>
                    </div>
                    <div class="col-md-2 text-center">
                        <small class="text-muted d-block">Places</small>
                        <?php if ($v['placerestante'] > 5): ?>
                            <span class="badge bg-success fs-6"><?= $v['placerestante'] ?></span>
                        <?php elseif ($v['placerestante'] > 0): ?>
                            <span class="badge bg-warning fs-6"><?= $v['placerestante'] ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger">Complet</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 text-center">
                        <span class="fw-bold text-success fs-5">
                            <?= number_format($v['prix'], 0, ',', '.') ?> FCFA
                        </span>
                        <small class="text-muted d-block"><?= $v['type_voyage'] ?></small>
                    </div>
                    <div class="col-md-1 text-center">
                        <?php if ($v['placerestante'] > 0): ?>
                            <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=creerReservation&voyage_id=<?= $v['id'] ?>"
                               class="btn btn-primary">
                                <i class="fas fa-ticket-alt"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="text-center py-4">
        <i class="fas fa-bus fa-3x text-muted mb-3 d-block"></i>
        <p class="text-muted">Aucun voyage trouvé</p>
    </div>
<?php endif; ?>

<?php include ROOT . '/views/layout_footer.php'; ?>