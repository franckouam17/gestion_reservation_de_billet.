<?php $titre = 'Modifier bus – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-edit text-warning"></i> Modifier le bus
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeBus"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=modifierBus&id=<?= $bus['id'] ?>">
            <div class="mb-3">
                <label class="form-label fw-bold">Type de bus</label>
                <select name="typebus_id" class="form-select" required>
                    <?php foreach ($types_bus as $tb): ?>
                        <option value="<?= $tb['id'] ?>"
                            <?= $tb['id'] == $bus['typebus_id'] ? 'selected' : '' ?>>
                            <?= $tb['libelle'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Immatriculation</label>
                <input type="text" name="immatriculation" class="form-control"
                       value="<?= $bus['immatriculation'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nombre de places</label>
                <input type="number" name="nbre_place" class="form-control"
                       value="<?= $bus['nbre_place'] ?>" min="1" required>
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