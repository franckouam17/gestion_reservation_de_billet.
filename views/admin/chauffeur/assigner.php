<?php $titre = 'Assigner chauffeur – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-link text-success"></i> Assigner chauffeur à un trajet
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeChauffeurs"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=assignerChauffeur">

            <div class="mb-3">
                <label class="form-label fw-bold">Trajet</label>
                <select name="trajet_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($trajets as $t): ?>
                        <option value="<?= $t['id'] ?>">
                            <?= $t['villedepart'] ?> → <?= $t['villearrive'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Chauffeur</label>
                <select name="chauffeur_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    <?php foreach ($chauffeurs as $c): ?>
                        <option value="<?= $c['id'] ?>">
                            <?= $c['nom'] ?> <?= $c['prenom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-link"></i> Assigner
                </button>
            </div>

        </form>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>