<?php $titre = 'Modifier chauffeur – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-edit text-warning"></i> Modifier le chauffeur
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeChauffeurs"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=modifierChauffeur&id=<?= $chauffeur['id'] ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nom</label>
                    <input type="text" name="nom" class="form-control"
                           value="<?= $chauffeur['nom'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prénom</label>
                    <input type="text" name="prenom" class="form-control"
                           value="<?= $chauffeur['prenom'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                           value="<?= $chauffeur['telephone'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">N° Permis</label>
                    <input type="text" name="num_permi" class="form-control"
                           value="<?= $chauffeur['num_permi'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="statut" class="form-select">
                        <option value="1" <?= $chauffeur['statut'] == 1 ? 'selected' : '' ?>>Actif</option>
                        <option value="0" <?= $chauffeur['statut'] == 0 ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>