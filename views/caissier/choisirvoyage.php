<?php $titre = 'Choisir un voyage – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-users text-warning"></i> Choisir un voyage
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
                        <th>Trajet</th>
                        <th>Date départ</th>
                        <th>Bus</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($voyages)): ?>
                        <?php foreach ($voyages as $v): ?>
                            <tr>
                                <td><?= $v['id'] ?></td>
                                <td>
                                    <span class="text-primary fw-bold"><?= $v['villedepart'] ?></span>
                                    <i class="fas fa-arrow-right text-warning mx-1"></i>
                                    <span class="text-success fw-bold"><?= $v['villearrive'] ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($v['dateheuredepart'])) ?></td>
                                <td><?= $v['bus'] ?></td>
                                <td>
                                    <?php if ($v['statut'] == 0): ?>
                                        <span class="badge bg-primary">Planifié</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">En cours</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=passagersVoyage&voyage_id=<?= $v['id'] ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-users"></i> Voir passagers
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun voyage disponible
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>