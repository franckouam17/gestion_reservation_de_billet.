<?php $titre = 'Inscription – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus"></i> Inscription
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="<?= BASE_URL ?>/index.php?controller=user&action=inscription">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="nom" 
                                    class="form-control" 
                                    placeholder="Votre nom"
                                    value="<?= isset($_POST['nom']) ? $_POST['nom'] : '' ?>"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Prénom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="prenom" 
                                    class="form-control" 
                                    placeholder="Votre prénom"
                                    value="<?= isset($_POST['prenom']) ? $_POST['prenom'] : '' ?>"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control" 
                                placeholder="votre@email.com"
                                value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>"
                                required
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                name="mot_de_passe" 
                                id="mot_de_passe"
                                class="form-control" 
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('mot_de_passe')"
                            >
                                <i class="fas fa-eye" id="icon_mot_de_passe"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirmer mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                name="confirmer_mot_de_passe" 
                                id="confirmer_mot_de_passe"
                                class="form-control" 
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                class="btn btn-outline-secondary"
                                onclick="togglePassword('confirmer_mot_de_passe')"
                            >
                                <i class="fas fa-eye" id="icon_confirmer_mot_de_passe"></i>
                            </button>
                        </div>
                        <!-- Message erreur confirmation -->
                        <div id="erreur_confirmation" class="text-danger small mt-1" style="display:none;">
                            Les mots de passe ne correspondent pas
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg" id="btn_inscrire">
                            <i class="fas fa-user-plus"></i> S'inscrire
                        </button>
                    </div>

                </form>
            </div>
            <div class="card-footer text-center py-3">
                Déjà un compte ?
                <a href="<?= BASE_URL ?>/index.php?controller=user&action=login" class="fw-bold text-success">
                    Se connecter
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Script vérification mot de passe -->
<script>
    // Afficher/cacher mot de passe
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
    const mdp         = document.getElementById('mot_de_passe');
    const confirmer   = document.getElementById('confirmer_mot_de_passe');
    const erreur      = document.getElementById('erreur_confirmation');
    const btnInscrire = document.getElementById('btn_inscrire');

    confirmer.addEventListener('keyup', function() {
        if (mdp.value !== confirmer.value) {
            erreur.style.display    = 'block';
            btnInscrire.disabled    = true;
            confirmer.classList.add('is-invalid');
        } else {
            erreur.style.display       = 'none';
            btnInscrire.disabled       = false;
            confirmer.classList.remove('is-invalid');
            confirmer.classList.add('is-valid');
        }
    });
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>