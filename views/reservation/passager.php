<?php $titre = 'Informations passagers – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-users text-primary"></i> Informations des passagers
    </h3>
</div>

<!-- Infos voyage -->
<div class="alert alert-info mb-4">
    <strong>
        <?= $voyage['villedepart'] ?> → <?= $voyage['villearrive'] ?>
    </strong>
    – <?= date('d/m/Y H:i', strtotime($voyage['dateheuredepart'])) ?>
    – <?= number_format($voyage['prix'], 0, ',', '.') ?> FCFA / siège
</div>

<form method="POST" action="<?= BASE_URL ?>/index.php?controller=reservation&action=confirmer">
    <input type="hidden" name="voyage_id" value="<?= $voyage['id'] ?>">

    <?php foreach ($sieges_selectionnes as $index => $siege_id): ?>

        <?php
        $numero_siege = 0;
        foreach ($sieges as $s) {
            if ($s['id'] == $siege_id) {
                $numero_siege = $s['numero'];
                break;
            }
        }
        ?>

        <input type="hidden" name="sieges[]" value="<?= $siege_id ?>">

        <div class="card shadow border-0 mb-3">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-chair"></i> Siège <?= $numero_siege ?>
                </h5>
            </div>

            <div class="card-body">

                <!-- Choix passager -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ce siège est pour :</label>

                    <div class="d-flex gap-3">

                        <?php if ($index == 0): ?>
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="type[<?= $siege_id ?>]"
                                   value="moi"
                                   checked
                                   onchange="togglePassager(<?= $siege_id ?>, 'moi')">
                            <label class="form-check-label">
                                <i class="fas fa-user text-primary"></i> Moi-même
                            </label>
                        </div>
                        <?php endif; ?>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="radio"
                                   name="type[<?= $siege_id ?>]"
                                   value="autre"
                                   <?= $index > 0 ? 'checked' : '' ?>
                                   onchange="togglePassager(<?= $siege_id ?>, 'autre')">
                            <label class="form-check-label">
                                <i class="fas fa-user-friends text-success"></i> Autre personne
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Infos passager -->
                <div id="infos_<?= $siege_id ?>" style="display:none;">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text"
                                       name="nom[<?= $siege_id ?>]"
                                       class="form-control"
                                       placeholder="Nom et prénom">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text">+237</span>
                                <input type="tel"
                                       name="telephone[<?= $siege_id ?>]"
                                       class="form-control"
                                       placeholder="6XXXXXXXX">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    <?php endforeach; ?>

    <!-- Total -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body d-flex justify-content-between">
            <span class="fw-bold fs-5">Total :</span>
            <span class="fw-bold text-success fs-4">
                <?= number_format($voyage['prix'] * count($sieges_selectionnes), 0, ',', '.') ?> FCFA
            </span>
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-arrow-right"></i> Continuer vers le paiement
        </button>
    </div>

</form>

<!-- JS -->
<script>
function togglePassager(siege_id, type) {
    const infos = document.getElementById('infos_' + siege_id);

    if (!infos) return;

    const inputs = infos.querySelectorAll('input');

    if (type === 'autre') {
        infos.style.display = 'block';
        inputs.forEach(input => input.required = true);
    } else {
        infos.style.display = 'none';
        inputs.forEach(input => {
            input.required = false;
            input.value = '';
        });
    }
}

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="infos_"]').forEach(infos => {
        const siege_id = infos.id.replace('infos_', '');

        const selected = document.querySelector(
            `input[name="type[${siege_id}]"]:checked`
        );

        if (selected) {
            togglePassager(siege_id, selected.value);
        }
    });

    console.log("SCRIPT OK");
});
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>