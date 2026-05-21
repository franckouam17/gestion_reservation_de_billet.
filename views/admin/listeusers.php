<!-- Liste des utilisateurs -->
 <?php $titre = 'liste des utilisateurs'; ?>
<?php require_once __DIR__ . '/../layout.php'; ?>

<div class="card shadow border-0 mt-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-users"></i> Utilisateurs
        </h5>
        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=ajouterUser"
           class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Ajouter
        </a>
    </div>
    <div class="card-body p-0">

        <!-- Barre de recherche -->
        <div class="p-3 border-bottom">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text"
                       id="rechercheUsers"
                       class="form-control border-start-0"
                       placeholder="Rechercher un utilisateur..."
                       onkeyup="rechercherTableau('rechercheUsers', 'tableauUsers')">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0" id="tableauUsers">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>statut</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($utilisateurs)): ?>
                        <?php foreach ($utilisateurs as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td class="fw-bold"><?= $u['nom'] ?></td>
                                <td><?= $u['prenom'] ?></td>
                                <td><?= $u['email'] ?></td>
                                <td>
                                    <!-- Dropdown pour changer le rôle -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle
                                            <?php
                                            if ($u['role'] == 'admin')   echo 'btn-danger';
                                            elseif ($u['role'] == 'caissier') echo 'btn-warning';
                                            else echo 'btn-primary';
                                            ?>"
                                            type="button"
                                            data-bs-toggle="dropdown">
                                            <?= $u['role'] ?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item"
                                                   href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierRoleUser&id=<?= $u['id'] ?>&role=client">
                                                    <i class="fas fa-user text-primary"></i> Client
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                   href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierRoleUser&id=<?= $u['id'] ?>&role=caissier">
                                                    <i class="fas fa-cash-register text-warning"></i> Caissier
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                   href="<?= BASE_URL ?>/index.php?controller=admin&action=modifierRoleUser&id=<?= $u['id'] ?>&role=admin">
                                                    <i class="fas fa-user-shield text-danger"></i> Admin
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($u['statut'] == 1): ?>
                                        <span class="badge bg-success">Actif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactif</span>
                                    <?php endif; ?>                                
                                <td>
                                    <small><?= date('d/m/Y', strtotime($u['date_creation'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($u['statut'] == 1): ?>

    <!-- Suspendre -->
                                    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=supprimerUser&id=<?= $u['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('suspendre cet utilisateur ?')">

                                        <i class="fas fa-times"></i>
                                    </a>

                                <?php elseif ($u['statut'] == 0): ?>

                                    <!-- Réactiver -->
                                    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=reactiveruser&id=<?= $u['id'] ?>"
                                    class="btn btn-sm btn-success"
                                    onclick="return confirm('Réactiver cet utilisateur ?')">

                                        <i class="fas fa-check"></i>
                                    </a>

                                <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun utilisateur
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include ROOT . '/views/layout_footer.php'; ?>
