<?php $titre = 'Paiements – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-money-bill text-primary"></i> Tous les paiements
    </h3>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Caissier</th>
                        <th>Trajet</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($paiements)): ?>
                        <?php foreach ($paiements as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= $p['client'] ?></td>
                                <td><?= $p['caissier'] ?></td>
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
                                    <?php if ($p['statut'] == 1): ?>
                                        <span class="badge bg-success">Payé</span>
                                    <?php elseif ($p['statut'] == 2): ?>
                                        <span class="badge bg-danger">Annulé</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">En attente</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
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