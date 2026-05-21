<?php $titre = 'Chauffeurs – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-id-card text-primary"></i> Gestion des chauffeurs
    </h3>
    <div class="d-flex gap-2">
        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=assignerChauffeur"
           class="btn btn-success">
            <i class="fas fa-link"></i> Assigner à un trajet
        </a>
        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerChauffeur"
           class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau chauffeur
        </a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>N° Permis</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($chauffeurs)): ?>
                        <?php foreach ($chauffeurs as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td class="fw-bold"><?= $c['nom'] ?></td>
                                <td><?= $c['prenom'] ?></td>
                                <td><?= $c['telephone'] ?></td>
                                <td><?= $c['num_permi'] ?></td>
                                <td>
                                    <?php if ($c['statut'] == 1): ?>
                                        <span class="badge bg-success">Actif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierChauffeur&id=<?= $c['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerChauffeur&id=<?= $c['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Supprimer ce chauffeur ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun chauffeur
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>