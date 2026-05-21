<?php $titre = 'Créer trajet – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-plus text-primary"></i> Créer un trajet
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeTrajets"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=creerTrajet">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ville de départ</label>
                    <input type="text" name="villedepart" class="form-control"
                           placeholder="Ex: Douala" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ville d'arrivée</label>
                    <input type="text" name="villearrive" class="form-control"
                           placeholder="Ex: Yaounde" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Distance (km)</label>
                    <input type="number" name="distance" class="form-control"
                           placeholder="Ex: 250" step="0.1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Durée</label>
                    <input type="text" name="duree" class="form-control"
                           placeholder="Ex: 4h00">
                </div>
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