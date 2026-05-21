<?php $titre = 'Détail réservation – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-ticket-alt text-primary"></i> Détail de la réservation
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=liste"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Mes réservations
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informations du voyage
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Trajet</small>
                        <p class="fw-bold mb-0">
                            <span class="text-primary"><?= $reservation['villedepart'] ?></span>
                            <i class="fas fa-arrow-right text-warning mx-2"></i>
                            <span class="text-success"><?= $reservation['villearrive'] ?></span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Date de départ</small>
                        <p class="fw-bold mb-0">
                            <?= date('d/m/Y H:i', strtotime($reservation['dateheuredepart'])) ?>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Agence de départ</small>
                        <p class="fw-bold mb-0"><?= $reservation['agence_depart'] ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Agence d'arrivée</small>
                        <p class="fw-bold mb-0"><?= $reservation['agence_arrivee'] ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Bus</small>
                        <p class="fw-bold mb-0"><?= $reservation['bus'] ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <small class="text-muted">Chauffeur</small>
                        <p class="fw-bold mb-0"><?= $reservation['chauffeur'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chair"></i> Sièges réservés
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach (explode(',', $reservation['sieges']) as $siege): ?>
                        <span class="badge bg-warning text-dark fs-6 p-2">
                            <i class="fas fa-chair"></i> Siège <?= trim($siege) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-receipt"></i> Récapitulatif
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">Réservation #</td>
                        <td class="fw-bold"><?= $reservation['id'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Date réservation</td>
                        <td class="fw-bold">
                            <?= date('d/m/Y H:i', strtotime($reservation['date_reservation'])) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Canal</td>
                        <td>
                            <?php if ($reservation['canal'] == 'guichet'): ?>
                                <span class="badge bg-info">Guichet</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">En ligne</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Statut</td>
                        <td>
                            <?php if ($reservation['statut'] == 1): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif ($reservation['statut'] == 2): ?>
                                <span class="badge bg-danger">Annulée</span>
                            <?php else: ?>
                                <span class="badge bg-warning">En attente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Total</td>
                        <td class="fw-bold text-success fs-5">
                            <?= number_format($reservation['montant_total'], 0, ',', '.') ?> FCFA
                        </td>
                    </tr>
                </table>

                <?php if ($reservation['statut'] == 1): ?>
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>/index.php?controller=billet&action=telecharger&reservation_id=<?= $reservation['id'] ?>"
                           class="btn btn-success">
                            <i class="fas fa-download"></i> Télécharger le billet
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=annuler&id=<?= $reservation['id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Annuler cette réservation ?')">
                            <i class="fas fa-times"></i> Annuler la réservation
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
// Calculer les heures restantes avant départ
$dateDepart      = new DateTime($reservation['dateheuredepart']);
$maintenant      = new DateTime();
$diff            = $maintenant->diff($dateDepart);
$heuresRestantes = ($diff->days * 24) + $diff->h;
$peutAnnuler     = $maintenant < $dateDepart && $heuresRestantes >= 5;
?>

<?php if ($reservation['statut'] == 1): ?>
    <?php if ($peutAnnuler): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            En cas d'annulation, vous serez remboursé à
            <strong>75%</strong> soit
            <strong>
                <?= number_format($reservation['montant_total'] * 0.75, 0, ',', '.') ?> FCFA
            </strong>
        </div>
        <a href="<?= BASE_URL ?>/index.php?controller=reservation&action=annuler&id=<?= $reservation['id'] ?>"
           class="btn btn-danger w-100"
           onclick="return confirm('Confirmer l annulation ? Vous serez remboursé à 75%.')">
            <i class="fas fa-times"></i> Annuler la réservation
        </a>
    <?php else: ?>
        <div class="alert alert-danger">
            <i class="fas fa-lock"></i>
            Annulation impossible — départ dans moins de 5 heures
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include ROOT . '/views/layout_footer.php'; ?>