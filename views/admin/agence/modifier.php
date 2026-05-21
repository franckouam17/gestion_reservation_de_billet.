<?php $titre = 'Modifier agence – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-edit text-warning"></i> Modifier l'agence
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeAgences"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=modifierAgence&id=<?= $agence['id'] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Nom</label>
                <input type="text" name="nom" class="form-control"
                       value="<?= $agence['nom'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= $agence['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Devise</label>
                <input type="text" name="devise" class="form-control"
                       value="<?= $agence['devise'] ?>">
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