<?php $titre = 'Imprimer billet – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-print text-primary"></i> Billet de voyage
    </h3>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
    </div>
</div>

<!-- Billet imprimable -->
<div id="billet_print">
    <div class="card shadow border-0 mb-3" 
         style="border-left: 5px solid #0d6efd !important;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="fw-bold text-primary mb-3">
                        <i class="fas fa-bus"></i> GesRoad – Billet de voyage
                    </h4>
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted">N° Billet</td>
                            <td class="fw-bold"><?= $details['numero'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Passager</td>
                            <td class="fw-bold"><?= $details['client'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Trajet</td>
                            <td class="fw-bold">
                                <?= $details['villedepart'] ?> → <?= $details['villearrive'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Départ</td>
                            <td class="fw-bold">
                                <?= date('d/m/Y H:i', strtotime($details['dateheuredepart'])) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Agence départ</td>
                            <td><?= $details['agence_depart'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Agence arrivée</td>
                            <td><?= $details['agence_arrivee'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Bus</td>
                            <td><?= $details['bus'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Chauffeur</td>
                            <td><?= $details['chauffeur'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sièges</td>
                            <td>
                                <span class="badge bg-warning text-dark fs-6">
                                    <?= $details['sieges'] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-bold">Montant</td>
                            <td class="fw-bold text-success fs-5">
                                <?= number_format($details['montant_total'], 0, ',', '.') ?> FCFA
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="bg-light p-3 rounded mb-3">
                        <i class="fas fa-qrcode fa-5x text-dark"></i>
                    </div>
                    <small class="text-muted"><?= $details['numero'] ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    nav, .btn, .d-flex.justify-content-between { display: none !important; }
    #billet_print { margin: 0; padding: 0; }
}
</style>

<?php include ROOT . '/views/layout_footer.php'; ?>