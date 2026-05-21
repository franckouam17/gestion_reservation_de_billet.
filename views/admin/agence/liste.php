<?php $titre = 'Agences – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-building text-primary"></i> Gestion des agences
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerAgence"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle agence
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Devise</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($agences)): ?>
                        <?php foreach ($agences as $a): ?>
                            <tr>
                                <td><?= $a['id'] ?></td>
                                <td class="fw-bold"><?= $a['nom'] ?></td>
                                <td><?= $a['description'] ?></td>
                                <td><?= $a['devise'] ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierAgence&id=<?= $a['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerAgence&id=<?= $a['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer cette agence ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucune agence
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>