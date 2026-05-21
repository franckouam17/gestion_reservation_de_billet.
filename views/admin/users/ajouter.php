<?php $titre = 'Ajouter utilisateur – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-user-plus text-success"></i> Ajouter un utilisateur
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=dashboard"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=ajouterUser">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prénom</label>
                    <input type="text" name="prenom" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Mot de passe</label>
                    <input type="password" name="mot_de_passe" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Rôle</label>
                    <select name="role" class="form-select" required id="selectRole"
                            onchange="toggleAgence()">
                        <option value="client">Client</option>
                        <option value="caissier">Caissier</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3" id="agenceBlock" style="display:none;">
                    <label class="form-label fw-bold">Agence locale</label>
                    <select name="agencelocale_id" class="form-select">
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences_locales as $al): ?>
                            <option value="<?= $al['id'] ?>">
                                <?= $al['nom_agence'] ?> – <?= $al['addresse'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function toggleAgence() {
    const role  = document.getElementById('selectRole').value;
    const block = document.getElementById('agenceBlock');
    // Afficher agence uniquement pour caissier
    block.style.display = (role === 'caissier') ? 'block' : 'none';
}
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>