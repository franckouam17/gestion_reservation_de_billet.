<?php $titre = 'Détail paiement – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-receipt text-success"></i> Paiement confirmé
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body text-center py-4">
        <i class="fas fa-check-circle fa-4x text-success mb-3 d-block"></i>
        <h4 class="fw-bold text-success">Paiement enregistré !</h4>

        <div class="alert alert-success mt-3">
            Référence : <strong><?= $paiement['referencetransaction'] ?></strong>
        </div>

        <table class="table table-borderless text-start mt-3">
            <tr>
                <td class="text-muted">Client</td>
                <td class="fw-bold"><?= $paiement['client'] ?></td>
            </tr>
            <tr>
                <td class="text-muted">Trajet</td>
                <td class="fw-bold">
                    <?= $paiement['villedepart'] ?> → <?= $paiement['villearrive'] ?>
                </td>
            </tr>
            <tr>
                <td class="text-muted">Montant</td>
                <td class="fw-bold text-success">
                    <?= number_format($paiement['montant'], 0, ',', '.') ?> FCFA
                </td>
            </tr>
            <tr>
                <td class="text-muted">Méthode</td>
                <td><span class="badge bg-info"><?= $paiement['methode'] ?></span></td>
            </tr>
            <tr>
                <td class="text-muted">Date</td>
                <td><?= date('d/m/Y H:i', strtotime($paiement['datepaiement'])) ?></td>
            </tr>
        </table>

        <?php if ($billet): ?>
            <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=imprimerBillet&reservation_id=<?= $paiement['reservation_id'] ?>"
               class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-print"></i> Imprimer le billet
            </a>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>