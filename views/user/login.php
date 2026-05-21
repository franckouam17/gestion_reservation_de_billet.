<?php $titre = 'Connexion – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="row justify-content-center ">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </h4>
            </div>
            <div class="card-body p-4">

            
     <?php if (isset($_SESSION['erreur'])): ?>

    <div class="alert alert-danger">
        <?= $_SESSION['erreur']; ?>
    </div>

    <?php unset($_SESSION['erreur']); ?>

<?php endif; ?>
                <form method="POST" action="<?= BASE_URL ?>/index.php?controller=user&action=login">

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
                                placeholder="votre@email"
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

                    <div class="d-grid -4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </button>
                    </div>

                </form>
            </div>
            <div class="card-footer text-center py-3">
                Pas encore de compte ?
                <a href="<?= BASE_URL ?>/index.php?controller=user&action=inscription" class="fw-bold text-primary">
                    S'inscrire
                </a>
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
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>mt