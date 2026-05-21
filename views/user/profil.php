<?php $titre = 'Mon profil – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-user text-primary"></i> Mon profil
    </h3>
</div>

<div class="row">
    <!-- Infos profil -->
    <div class="col-md-4">
        <div class="card shadow border-0 mb-4">
            <div class="card-body text-center py-4">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:80px; height:80px; font-size:2rem;">
                    <?= strtoupper(substr($_SESSION['user_nom'], 0, 1)) ?>
                </div>
                <h4 class="fw-bold"><?= $_SESSION['user_nom'] . ' ' . $_SESSION['user_prenom'] ?></h4>
                <p class="text-muted mb-1"><?= $_SESSION['user_email'] ?></p>
                <span class="badge bg-primary"><?= $_SESSION['user_role'] ?></span>
            </div>
        </div>
    </div>

    <!-- Formulaire modification -->
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-edit"></i> Modifier mon profil
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?= BASE_URL ?>/index.php?controller=user&action=modifierProfil">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="nom" class="form-control"
                                       value="<?= $_SESSION['user_nom'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Prénom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="prenom" class="form-control"
                                       value="<?= $_SESSION['user_prenom'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                   value="<?= $_SESSION['user_email'] ?>" required>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold text-muted mb-3">
                        <i class="fas fa-lock"></i> Changer le mot de passe
                        <small class="text-muted fw-normal">(laisser vide pour ne pas changer)</small>
                    </h6>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nouveau mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="nouveau_mot_de_passe"
                                   id="nouveau_mdp"
                                   class="form-control"
                                   placeholder="••••••••">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('nouveau_mdp')">
                                <i class="fas fa-eye" id="icon_nouveau_mdp"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Confirmer mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="confirmer_mot_de_passe"
                                   id="confirmer_mdp"
                                   class="form-control"
                                   placeholder="••••••••">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePassword('confirmer_mdp')">
                                <i class="fas fa-eye" id="icon_confirmer_mdp"></i>
                            </button>
                        </div>
                        <div id="erreur_mdp" class="text-danger small mt-1" style="display:none;">
                            Les mots de passe ne correspondent pas
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSauvegarder">
                            <i class="fas fa-save"></i> Sauvegarder
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const icon  = document.getElementById('icon_' + id);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Vérifier que les mots de passe correspondent
const nouveauMdp  = document.getElementById('nouveau_mdp');
const confirmerMdp = document.getElementById('confirmer_mdp');
const erreurMdp   = document.getElementById('erreur_mdp');
const btnSauvegarder = document.getElementById('btnSauvegarder');

confirmerMdp.addEventListener('keyup', function() {
    if (nouveauMdp.value !== confirmerMdp.value) {
        erreurMdp.style.display    = 'block';
        btnSauvegarder.disabled    = true;
        confirmerMdp.classList.add('is-invalid');
    } else {
        erreurMdp.style.display       = 'none';
        btnSauvegarder.disabled       = false;
        confirmerMdp.classList.remove('is-invalid');
        confirmerMdp.classList.add('is-valid');
    }
});
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>