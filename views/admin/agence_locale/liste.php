<?php $titre = 'Agences locales – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-map-marker-alt text-primary"></i> Agences locales
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerAgenceLocale"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle agence locale
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Agence</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($agences_locales)): ?>
                        <?php foreach ($agences_locales as $al): ?>
                            <tr>
                                <td><?= $al['id'] ?></td>
                                <td>
                                    <?php if ($al['photo']): ?>
                                        <img src="<?= BASE_URL ?>/uploads/agences/<?= $al['photo'] ?>"
                                             style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width:50px;height:50px;">
                                            <i class="fas fa-building text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= $al['nom_agence'] ?></td>
                                <td><?= $al['addresse'] ?></td>
                                <td><?= $al['telephone'] ?></td>
                                <td>
                                    <?php if ($al['statut'] == 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierAgenceLocale&id=<?= $al['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerAgenceLocale&id=<?= $al['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucune agence locale
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>