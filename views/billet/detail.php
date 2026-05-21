<?php $titre = 'Mon billet – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-ticket-alt text-primary"></i> Mon billet
    </h3>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/index.php?controller=billet&action=telechargerPDF&id=<?= $billet['id'] ?>"
           class="btn btn-success">
            <i class="fas fa-download"></i> Télécharger PDF
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=liste"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- Billet -->
<div id="billet_print">
    <div class="card shadow border-0"
         style="border-left: 6px solid #0d6efd !important; max-width:700px; margin:auto;">
        <div class="card-body p-4">

            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-primary mb-0">
                        <i class="fas fa-bus"></i> GesRoad
                    </h4>
                    <small class="text-muted">Système de réservation de transport</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-success fs-6">✓ Billet valide</span>
                    <p class="text-muted small mb-0 mt-1">
                        Émis le <?= date('d/m/Y H:i', strtotime($billet['datereservation'])) ?>
                    </p>
                </div>
            </div>

            <hr>

            <!-- Trajet -->
            <div class="row text-center mb-4">
                <div class="col-5">
                    <h3 class="fw-bold text-primary"><?= $billet['villedepart'] ?></h3>
                    <p class="text-muted mb-0"><?= $billet['agence_depart'] ?></p>
                    <h5 class="fw-bold mt-1">
                        <?= date('H:i', strtotime($billet['dateheuredepart'])) ?>
                    </h5>
                    <small class="text-muted">
                        <?= date('d/m/Y', strtotime($billet['dateheuredepart'])) ?>
                    </small>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <i class="fas fa-arrow-right fa-2x text-warning"></i>
                        <p class="text-muted small mb-0 mt-1"><?= $billet['duree'] ?? '' ?></p>
                    </div>
                </div>
                <div class="col-5">
                    <h3 class="fw-bold text-success"><?= $billet['villearrive'] ?></h3>
                    <p class="text-muted mb-0"><?= $billet['agence_arrivee'] ?></p>
                    <h5 class="fw-bold mt-1">
                        <?= date('H:i', strtotime($billet['dateheurearrive'])) ?>
                    </h5>
                    <small class="text-muted">
                        <?= date('d/m/Y', strtotime($billet['dateheurearrive'])) ?>
                    </small>
                </div>
            </div>

            <hr>

            <!-- Infos passager + siège -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted">Passager</td>
                            <td class="fw-bold"><?= $billet['client'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><?= $billet['email'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Bus</td>
                            <td class="fw-bold"><?= $billet['bus'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Chauffeur</td>
                            <td><?= $billet['chauffeur'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted">N° Billet</td>
                            <td class="fw-bold"><?= $billet['numero'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Siège(s)</td>
                            <td>
                                <span class="badge bg-warning text-dark fs-6">
                                    <?= $billet['sieges'] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Montant</td>
                            <td class="fw-bold text-success fs-5">
                                <?= number_format($billet['montant_total'], 0, ',', '.') ?> FCFA
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <!-- QR Code + numéro -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        Présentez ce billet lors de l'embarquement
                    </small>
                </div>
                <div class="text-center">
                    <i class="fas fa-qrcode fa-4x text-dark"></i>
                    <p class="small text-muted mt-1"><?= $billet['numero'] ?></p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    nav, .btn, .d-flex.justify-content-between.mb-4 { display: none !important; }
    #billet_print { margin: 0; padding: 0; }
    .card { border: 1px solid #ccc !important; }
}
</style>

<?php include ROOT . '/views/layout_footer.php'; ?>