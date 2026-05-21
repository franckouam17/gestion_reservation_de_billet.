<?php $titre = 'Bus – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-bus text-primary"></i> Gestion des bus
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerBus"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau bus
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Immatriculation</th>
                        <th>Type</th>
                        <th>Places</th>
                        <th>Disponible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bus)): ?>
                        <?php foreach ($bus as $b): ?>
                            <tr>
                                <td><?= $b['id'] ?></td>
                                <td class="fw-bold"><?= $b['immatriculation'] ?></td>
                                <td><?= $b['type_bus'] ?></td>
                                <td><?= $b['nbre_place'] ?></td>
                                <td>
                                    <?php if ($b['estdisponible'] == 1): ?>
                                        <span class="badge bg-success">Disponible</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">En service</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierBus&id=<?= $b['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerBus&id=<?= $b['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce bus ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun bus
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>