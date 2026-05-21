<?php $titre = 'Mes réservations – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-ticket-alt text-primary"></i> Mes réservations
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle réservation
    </a>
</div>
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-info alert-dismissible fade show">
        <i class="fas fa-info-circle"></i>
        <?= urldecode($_GET['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (!empty($reservations)): ?>
    <?php foreach ($reservations as $r): ?>
        <div class="card shadow border-0 mb-3">
            <div class="card-body">
                <div class="row align-items-center">

                    <!-- Trajet -->
                    <div class="col-md-3">
                        <h5 class="fw-bold mb-1">
                            <span class="text-primary"><?= $r['villedepart'] ?></span>
                            <i class="fas fa-arrow-right text-warning mx-2"></i>
                            <span class="text-success"><?= $r['villearrive'] ?></span>
                        </h5>
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i>
                            <?= date('d/m/Y H:i', strtotime($r['dateheuredepart'])) ?>
                        </small>
                    </div>

                    <!-- Agences -->
                    <div class="col-md-3">
                        <small class="text-muted d-block">Départ</small>
                        <span class="fw-bold"><?= $r['agence_depart'] ?></span>
                        <small class="text-muted d-block mt-1">Arrivée</small>
                        <span class="fw-bold"><?= $r['agence_arrivee'] ?></span>
                    </div>

                    <!-- Sièges -->
                    <div class="col-md-2 text-center">
                        <small class="text-muted d-block">Sièges</small>
                        <?php foreach (explode(',', $r['sieges']) as $siege): ?>
                            <span class="badge bg-warning text-dark">
                                <?= trim($siege) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>

                    <!-- Montant -->
                    <div class="col-md-2 text-center">
                        <small class="text-muted d-block">Montant</small>
                        <span class="fw-bold text-success">
                            <?= number_format($r['montant_total'], 0, ',', '.') ?> FCFA
                        </span>
                        <small class="text-muted d-block">
                            <?php if ($r['canal'] == 'guichet'): ?>
                                <span class="badge bg-info">Guichet</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">En ligne</span>
                            <?php endif; ?>
                        </small>
                    </div>

                    <!-- Statut + Actions -->
                    <div class="col-md-2 text-center">
                        <?php if ($r['statut'] == 1): ?>
                            <span class="badge bg-success mb-2 d-block">Active</span>
                            <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=detail&id=<?= $r['id'] ?>"
                               class="btn btn-sm btn-outline-primary mb-1 w-100">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                            <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=annuler&id=<?= $r['id'] ?>"
                               class="btn btn-sm btn-danger w-100"
                               onclick="return confirm('Annuler cette réservation ?')">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        <?php elseif ($r['statut'] == 2): ?>
                            <span class="badge bg-danger mb-2 d-block">Annulée</span>
                        <?php else: ?>
                            <span class="badge bg-warning mb-2 d-block">En attente</span>
                            <a href="<?= BASE_URL ?>/index.php?controller=paiement&action=paiementMobile&reservation_id=<?= $r['id'] ?>"
                               class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-mobile-alt"></i> Payer
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <div class="text-center py-5">
        <i class="fas fa-ticket-alt fa-4x text-muted mb-3 d-block"></i>
        <h5 class="text-muted">Aucune réservation</h5>
        <a href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche"
           class="btn btn-primary mt-3">
            <i class="fas fa-search"></i> Rechercher un voyage
        </a>
    </div>
<?php endif; ?>

<?php include ROOT . '/views/layout_footer.php'; ?>