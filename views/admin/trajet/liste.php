<?php $titre = 'Trajets – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-route text-primary"></i> Gestion des trajets
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerTrajet"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau trajet
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Distance</th>
                        <th>Durée</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($trajets)): ?>
                        <?php foreach ($trajets as $t): ?>
                            <tr>
                                <td><?= $t['id'] ?></td>
                                <td class="fw-bold text-primary"><?= $t['villedepart'] ?></td>
                                <td class="fw-bold text-success"><?= $t['villearrive'] ?></td>
                                <td><?= $t['distance'] ?> km</td>
                                <td><?= $t['duree'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierTrajet&id=<?= $t['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerTrajet&id=<?= $t['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce trajet ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun trajet
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>