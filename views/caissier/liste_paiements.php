<?php $titre = 'Mes paiements – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-list text-primary"></i> Mes paiements
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Trajet</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($paiements)): ?>
                        <?php foreach ($paiements as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= $p['client'] ?></td>
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
                                <td>
                                    
                                    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=imprimerBillet&reservation_id=<?= $p['id'] ?>"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Aucun paiement
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>