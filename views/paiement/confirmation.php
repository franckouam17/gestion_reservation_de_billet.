<?php $titre = 'Paiement confirmé – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <!-- Succès -->
        <div class="card shadow border-0 mb-4">
            <div class="card-body text-center py-4">
                <i class="fas fa-check-circle fa-5x text-success mb-3 d-block"></i>
                <h3 class="fw-bold text-success">Paiement confirmé !</h3>
                <p class="text-muted">
                    Vos billets ont été générés automatiquement.
                </p>
                <div class="alert alert-success">
                    <i class="fas fa-receipt"></i>
                    Référence : <strong><?= $paiement['referencetransaction'] ?></strong>
                </div>
            </div>
        </div>

        <!-- Un billet par passager -->
        <?php foreach ($billets as $billet): ?>
            <div class="card shadow border-0 mb-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt"></i>
                        Billet – Siège <?= $billet['numero_siege'] ?>
                    </h5>
                    <span class="badge bg-light text-dark"><?= $billet['numero'] ?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Passager</td>
                                    <td class="fw-bold"><?= $billet['passager_nom'] ?: $paiement['client'] ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Téléphone</td>
                                    <td><?= $billet['passager_tel'] ?: '-' ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Siège</td>
                                    <td>
                                        <span class="badge bg-warning text-dark fs-6">
                                            <?= $billet['numero_siege'] ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-muted">Trajet</td>
                                    <td class="fw-bold">
                                        <span class="text-primary"><?= $paiement['villedepart'] ?></span>
                                        <i class="fas fa-arrow-right text-warning mx-1"></i>
                                        <span class="text-success"><?= $paiement['villearrive'] ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Départ</td>
                                    <td><?= date('d/m/Y H:i', strtotime($paiement['dateheuredepart'])) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prix</td>
                                    <td class="fw-bold text-success">
                                        <?= number_format($paiement['montant'] / count($billets), 0, ',', '.') ?> FCFA
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <a href="<?= BASE_URL ?>/index.php?controller=billet&action=detail&id=<?= $billet['id'] ?>"
                           class="btn btn-success">
                            <i class="fas fa-eye"></i> Voir le billet
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=billet&action=telechargerPDF&id=<?= $billet['id'] ?>"
                           class="btn btn-outline-primary">
                            <i class="fas fa-download"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Boutons -->
        <div class="d-flex gap-3 mt-3">
            <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=liste"
               class="btn btn-outline-primary btn-lg">
                <i class="fas fa-list"></i> Mes réservations
            </a>
            <a href="<?= BASE_URL ?>/index.php?controller=voyage&action=recherche"
               class="btn btn-primary btn-lg">
                <i class="fas fa-search"></i> Nouveau voyage
            </a>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>