<?php $titre = 'Dashboard Caissier – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-cash-register text-success"></i> Dashboard Caissier
    </h3>
    <span class="text-muted">
        <i class="fas fa-calendar"></i> <?= date('d/m/Y') ?>
    </span>
</div>

<!-- Statistiques du jour -->
<div class="row mb-4">
    <!-- div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Paiements aujourd'hui</p>
                        <h3 class="fw-bold text-primary"><?= $paiementsAujourdhui ?></h3>
                    </div>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-money-bill fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Recettes aujourd'hui</p>
                        <h3 class="fw-bold text-success">
                            <?= number_format($recettesAujourdhui ?? 0, 0, ',', '.') ?> FCFA
                        </h3>
                    </div>
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-coins fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Réservations journalieres</p>
                        <h3 class="fw-bold text-warning"><?= $reservationsGuichet ?></h3>
                    </div>
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-ticket-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=rechercheVoyage"
                           class="btn btn-primary w-100 py-3">
                            <i class="fas fa-search fa-2x d-block mb-2"></i>
                            Nouvelle réservation
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=listePaiements"
                           class="btn btn-success w-100 py-3">
                            <i class="fas fa-list fa-2x d-block mb-2"></i>
                            Mes paiements
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                       
                        <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=choisirVoyage"
                        class="btn btn-warning w-100 py-3">
                            <i class="fas fa-users fa-2x d-block mb-2"></i>
                            Liste passagers
                        </a>
</div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Derniers paiements -->
<div class="card shadow border-2">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-history"></i> Mes derniers paiements
        </h5>
        <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=listePaiements"
           class="btn btn-sm btn-outline-light">
            Voir tout
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Trajet</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Référence</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($derniersPaiements)): ?>
                        <?php foreach ($derniersPaiements as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>
                                    <i class="fas fa-user text-muted"></i>
                                    <?= $p['client'] ?>
                                </td>
                                <td>
                                    <span class="text-primary"><?= $p['villedepart'] ?></span>
                                    <i class="fas fa-arrow-right text-warning mx-1"></i>
                                    <span class="text-success"><?= $p['villearrive'] ?></span>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= number_format($p['montant'], 0, ',', '.') ?> FCFA
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= $p['methode'] ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?= $p['referencetransaction'] ?></small>
                                </td>
                                <td>
                                    <small><?= date('d/m/Y H:i', strtotime($p['datepaiement'])) ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun paiement aujourd'hui
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>