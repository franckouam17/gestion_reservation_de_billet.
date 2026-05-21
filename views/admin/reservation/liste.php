<?php $titre = 'Réservations – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-ticket-alt text-primary"></i> Toutes les réservations
    </h3>
</div>
<a href="<?= BASE_URL ?>/index.php?controller=admin&action=listerReservations"
   class="btn btn-sm btn-primary">
    Voir tout
</a>
<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Trajet</th>
                        <th>Départ</th>
                        <th>Sièges</th>
                        <th>Montant</th>
                        <th>Canal</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservations)): ?>
                        <?php foreach ($reservations as $r): ?>
                            <tr>
                                <td><?= $r['id'] ?></td>
                                <td>
                                    <i class="fas fa-user text-muted"></i>
                                    <?= $r['client'] ?><br>
                                    <small class="text-muted"><?= $r['email'] ?></small>
                                </td>
                                <td>
                                    <span class="text-primary"><?= $r['villedepart'] ?></span>
                                    <i class="fas fa-arrow-right text-warning mx-1"></i>
                                    <span class="text-success"><?= $r['villearrive'] ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($r['dateheuredepart'])) ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark"><?= $r['sieges'] ?></span>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= number_format($r['montant_total'], 0, ',', '.') ?> FCFA
                                </td>
                                <td>
                                    <?php if ($r['canal'] == 'guichet'): ?>
                                        <span class="badge bg-info">Guichet</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">En ligne</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r['statut'] == 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($r['statut'] == 2): ?>
                                        <span class="badge bg-danger">Annulée</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">En attente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                   <?php if ($r['statut'] == 1): ?>

    <!-- Suspendre -->
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=annulerReservation&id=<?= $r['id'] ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Annuler cette réservation ?')">

                            <i class="fas fa-times"></i>
                        </a>

                    <?php elseif ($r['statut'] == 2): ?>

                        <!-- Réactiver -->
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=reactiverReservation&id=<?= $r['id'] ?>"
                        class="btn btn-sm btn-success"
                        onclick="return confirm('Réactiver cette réservation ?')">

                            <i class="fas fa-check"></i>
                        </a>

                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Aucune réservation
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>