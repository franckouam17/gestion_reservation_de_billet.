<?php $titre = 'Liste des voyages – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-bus text-primary"></i> Liste des voyages 
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerVoyage"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau voyage
    </a>
</div>
<a href="<?= BASE_URL ?>/index.php?controller=admin&action=listervoyages"
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
                        <th>Trajet</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Bus</th>
                        <th>Chauffeur</th>
                        <th>Prix</th>
                        <th>Places</th>
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
                                <td>
                                    <small><?= date('d/m/Y', strtotime($v['dateheuredepart'])) ?></small><br>
                                    <strong><?= date('H:i', strtotime($v['dateheuredepart'])) ?></strong>
                                </td>
                                <td>
                                    <small><?= date('d/m/Y', strtotime($v['dateheurearrive'])) ?></small><br>
                                    <strong><?= date('H:i', strtotime($v['dateheurearrive'])) ?></strong>
                                </td>
                                <td>
                                    <i class="fas fa-bus text-muted"></i>
                                    <?= $v['bus'] ?>
                                </td>
                                <td>
                                    <i class="fas fa-user text-muted"></i>
                                    <?= $v['chauffeur'] ?>
                                </td>
                                <td class="fw-bold text-success">
                                    <?= number_format($v['prix'], 0, ',', '.') ?> FCFA
                                </td>
                                <td>
                                    <?php if ($v['placerestante'] > 5): ?>
                                        <span class="badge bg-success"><?= $v['placerestante'] ?></span>
                                    <?php elseif ($v['placerestante'] > 0): ?>
                                        <span class="badge bg-warning"><?= $v['placerestante'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Complet</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($v['statut'] == 0): ?>
                                        <span class="badge bg-primary">Planifié</span>
                                    <?php elseif ($v['statut'] == 1): ?>
                                        <span class="badge bg-success">En cours</span>
                                    <?php elseif ($v['statut'] == 2): ?>
                                        <span class="badge bg-secondary">Terminé</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Annulé</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierVoyage&id=<?= $v['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                            </svg>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=passagersVoyage&id=<?= $v['id'] ?>"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-users"></i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                            </svg>
                                        </a>
                                        <?php if ($v['statut'] == 0): ?>
                                           <a href="<?= BASE_URL ?>/index.php?controller=admin&action=annulerVoyage&id=<?= $v['id'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Annuler ce voyage ?')">
                                                    
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        class="bi bi-trash3" viewBox="0 0 16 16" style="margin-right:5px;">
                                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                    </svg>

                                                    
                                                </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-bus fa-2x mb-2 d-block"></i>
                                Aucun voyage
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>