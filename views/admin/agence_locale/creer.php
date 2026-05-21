<?php $titre = 'Créer agence locale – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-plus text-primary"></i> Créer une agence locale
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeAgencesLocales"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" 
              action="<?= BASE_URL ?>/index.php?controller=admin&action=creerAgenceLocale"
              enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label fw-bold">Agence principale</label>
                <select name="agence_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($agences as $a): ?>
                        <option value="<?= $a['id'] ?>"><?= $a['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Adresse</label>
                <input type="text" name="addresse" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input type="text" name="telephone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Photo</label>
                <input type="file" name="photo" class="form-control"
                       accept="image/jpeg,image/png,image/webp">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>