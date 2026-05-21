<?php $titre = 'Dashboard Admin – GesRoad'; ?>
<?php require_once __DIR__ . '/../layout.php'; ?>

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-tachometer-alt text-primary"></i> Dashboard Admin
    </h3>
    <span class="text-muted">
        <i class="fas fa-calendar"></i> <?= date('d/m/Y') ?>
    </span>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">prochain voyage</p>
                        <h3 class="fw-bold text-primary"><?= $totalVoyages ?></h3>
                    </div>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-bus fa-lg"></i>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeVoyages"
                   class="btn btn-sm btn-outline-primary mt-2 w-100">
                    Voir les voyages
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Réservations journalières</p>
                        <h3 class="fw-bold text-success"><?= $totalReservations ?></h3>
                    </div>
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-ticket-alt fa-lg"></i>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeReservations"
                   class="btn btn-sm btn-outline-success mt-2 w-100">
                    Voir les réservations
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Utilisateurs</p>
                        <h3 class="fw-bold text-warning"><?= $totalClients ?></h3>
                    </div>
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    </div>
                    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeuser"
                   class="btn btn-sm btn-outline-danger mt-2 w-100">
                Gerer les utilisateurs
                </a>
                
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Recettes journalieres</p>
                        <h3 class="fw-bold text-danger">
                            <?= number_format($totalRecettes ?? 0, 0, ',', '.') ?> FCFA
                        </h3>
                    </div>
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                         style="width:55px; height:55px;">
                        <i class="fas fa-money-bill fa-lg"></i>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listePaiements"
                   class="btn btn-sm btn-outline-danger mt-2 w-100">
                    Voir les paiements
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Menu de gestion -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Gestion du système</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeAgences"
                           class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-building fa-2x d-block mb-2"></i>
                            Agences
                        </a>
                    </div>

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeAgencesLocales"
                           class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-map-marker-alt fa-2x d-block mb-2"></i>
                            Agences locales
                        </a>
                    </div>

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeTrajets"
                           class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-route fa-2x d-block mb-2"></i>
                            Trajets
                        </a>
                    </div>

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeChauffeurs"
                           class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-id-card fa-2x d-block mb-2"></i>
                            Chauffeurs
                        </a>
                    </div>

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeBus"
                           class="btn btn-outline-danger w-100 py-3">
                            <i class="fas fa-bus fa-2x d-block mb-2"></i>
                            Bus
                        </a>
                    </div>

                    <div class="col-md-2 mb-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=creerVoyage"
                           class="btn btn-primary w-100 py-3">
                            <i class="fas fa-plus fa-2x d-block mb-2"></i>
                            Nouveau voyage
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dernières réservations -->
<div class="card shadow border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-list"></i> Dernières réservations
        </h5>
        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeReservations"
           class="btn btn-sm btn-outline-light">
            Voir tout
        </a>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table  id="tableReservation" class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Trajet</th>
                        <th>Date départ</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Canal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dernieresReservations)): ?>
                        <?php foreach (array_slice($dernieresReservations, 0, 10) as $r): ?>
                            <tr>
                                <td><?= $r['id'] ?></td>
                                <td>
                                    <i class="fas fa-user text-muted"></i>
                                    <?= $r['client'] ?>
                                </td>
                                <td>
                                    <span class="text-primary"><?= $r['villedepart'] ?></span>
                                    <i class="fas fa-arrow-right text-warning mx-1"></i>
                                    <span class="text-success"><?= $r['villearrive'] ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($r['dateheuredepart'])) ?></td>
                                <td class="fw-bold">
                                    <?= number_format($r['montant_total'], 0, ',', '.') ?> FCFA
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
                                    <?php if ($r['canal'] == 'guichet'): ?>
                                        <span class="badge bg-info">Guichet</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">En ligne</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($r['statut'] == 1): ?>
                                        <a href="<?= BASE_URL ?>/index.php?controller=admin&action=annulerReservation&id=<?= $r['id'] ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Annuler cette réservation ?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Aucune réservation
                            </td>
                        </tr>
                    <?php endif; ?>
                    <script>
                    $(document).ready(function () {
                        $('#tableReservation').DataTable({
                            language: {
                                
                        });
                    });
                    </script>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include ROOT . '/views/layout_footer.php'; ?>