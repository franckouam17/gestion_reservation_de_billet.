<?php $titre = 'Passagers du voyage – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-users text-info"></i> Passagers du voyage
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeVoyages"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<!-- Infos voyage -->
<div class="card shadow border-0 mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3">
                <p class="text-muted mb-0">Trajet</p>
                <h5 class="fw-bold">
                    <span class="text-primary"><?= $voyage['villedepart'] ?></span>
                    <i class="fas fa-arrow-right text-warning mx-2"></i>
                    <span class="text-success"><?= $voyage['villearrive'] ?></span>
                </h5>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-0">Départ</p>
                <h5 class="fw-bold"><?= date('d/m/Y H:i', strtotime($voyage['dateheuredepart'])) ?></h5>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-0">Bus</p>
                <h5 class="fw-bold"><?= $voyage['bus'] ?></h5>
            </div>
            <div class="col-md-3">
                <p class="text-muted mb-0">Places restantes</p>
                <h5 class="fw-bold text-success"><?= $voyage['placerestante'] ?></h5>
            </div>
        </div>
    </div>
</div>

<!-- Liste passagers -->
<div class="card shadow border-0">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">
            <i class="fas fa-list"></i> 
            <?= count($passagers) ?> passager(s)
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Réservation</th>
                        <th>Sièges</th>
                        <th>Montant</th>
                        <th>Date réservation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($passagers)): ?>
                        <?php foreach ($passagers as $p): ?>
                            <tr>
                                <td><?= $p['reservation_id'] ?></td>
                                <td>
                                    <i class="fas fa-user text-muted"></i>
                                    <?= $p['nom'] . ' ' . $p['prenom'] ?>
                                </td>
                                <td><?= $p['email'] ?></td>
                                <td>#<?= $p['reservation_id'] ?></td>
                                <td>
                                    <span class="badge bg-primary"><?= $p['sieges'] ?></span>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= number_format($p['montant_total'], 0, ',', '.') ?> FCFA
                                </td>
                                <td>
                                    <?= date('d/m/Y H:i', strtotime($p['date_reservation'])) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                Aucun passager pour ce voyage
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>