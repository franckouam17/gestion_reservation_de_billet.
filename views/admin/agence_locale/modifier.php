<?php $titre = 'Modifier agence locale – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-edit text-warning"></i> Modifier agence locale
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeAgencesLocales"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST"
              action="<?= BASE_URL ?>/index.php?controller=admin&action=modifierAgenceLocale&id=<?= $agence_locale['id'] ?>"
              enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label fw-bold">Agence principale</label>
                <select name="agence_id" class="form-select">
                    <?php foreach ($agences as $a): ?>
                        <option value="<?= $a['id'] ?>"
                            <?= $a['id'] == $agence_locale['agence_id'] ? 'selected' : '' ?>>
                            <?= $a['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Adresse</label>
                <input type="text" name="addresse" class="form-control"
                       value="<?= $agence_locale['addresse'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input type="text" name="telephone" class="form-control"
                       value="<?= $agence_locale['telephone'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Statut</label>
                <select name="statut" class="form-select">
                    <option value="1" <?= $agence_locale['statut'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $agence_locale['statut'] == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Photo</label>
                <?php if ($agence_locale['photo']): ?>
                    <div class="mb-2">
                        <img src="<?= BASE_URL ?>/uploads/agences/<?= $agence_locale['photo'] ?>"
                             style="height:80px;object-fit:cover;border-radius:6px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="photo" class="form-control"
                       accept="image/jpeg,image/png,image/webp">
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