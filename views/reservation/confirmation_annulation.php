<?php $titre = 'Annulation confirmée – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-body text-center py-5">

                <i class="fas fa-check-circle fa-5x text-success mb-3 d-block"></i>
                <h3 class="fw-bold text-success">Réservation annulée !</h3>
                <p class="text-muted">Votre remboursement a été initié.</p>

                <!-- Référence remboursement -->
                <div class="alert alert-success mb-4">
                    <i class="fas fa-receipt"></i>
                    Référence : <strong><?= $remboursement['reference_remboursement'] ?></strong>
                </div>

                <!-- Détails remboursement -->
                <div class="card border-0 bg-light mb-4">
                    <div class="card-body">
                        <table class="table table-borderless text-start mb-0">
                            <tr>
                                <td class="text-muted">Montant payé</td>
                                <td class="fw-bold">
                                    <?= number_format($remboursement['montant_total'], 0, ',', '.') ?> FCFA
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Remboursement (75%)</td>
                                <td class="fw-bold text-success fs-5">
                                    <?= number_format($remboursement['montant_rembourse'], 0, ',', '.') ?> FCFA
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Frais d'annulation (25%)</td>
                                <td class="fw-bold text-danger">
                                    <?= number_format($remboursement['montant_total'] * 0.25, 0, ',', '.') ?> FCFA
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Méthode</td>
                                <td>
                                    <span class="badge bg-info"><?= $remboursement['methode'] ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Message selon méthode -->
                <?php if ($remboursement['methode'] == 'especes'): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-store"></i>
                        Votre remboursement de
                        <strong><?= number_format($remboursement['montant_rembourse'], 0, ',', '.') ?> FCFA</strong>
                        est disponible au guichet de votre agence.
                    </div>

                <?php elseif ($remboursement['methode'] == 'MTN_MOMO'): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-mobile-alt"></i>
                        Votre remboursement de
                        <strong><?= number_format($remboursement['montant_rembourse'], 0, ',', '.') ?> FCFA</strong>
                        sera crédité sur votre compte <strong>MTN Mobile Money</strong>
                        dans les 24 heures.
                    </div>
                    <!-- Simulation -->
                    <div class="alert alert-success">
                        <i class="fas fa-check"></i>
                        <strong>Simulation :</strong> Remboursement MTN MoMo envoyé avec succès !
                    </div>

                <?php elseif ($remboursement['methode'] == 'ORANGE_MOMO'): ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-mobile-alt"></i>
                        Votre remboursement de
                        <strong><?= number_format($remboursement['montant_rembourse'], 0, ',', '.') ?> FCFA</strong>
                        sera crédité sur votre compte <strong>Orange Money</strong>
                        dans les 24 heures.
                    </div>
                    <!-- Simulation -->
                    <div class="alert alert-success">
                        <i class="fas fa-check"></i>
                        <strong>Simulation :</strong> Remboursement Orange Money envoyé avec succès !
                    </div>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=liste"
                   class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-list"></i> Mes réservations
                </a>

            </div>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>