<?php $titre = 'Paiement – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-money-bill text-success"></i> Encaissement
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=caissier&action=dashboard"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>
</div>

<!-- Infos réservation -->
<div class="card shadow border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fas fa-info-circle"></i> Réservation #<?= $reservation['id'] ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3">
                <small class="text-muted">Client</small>
                <p class="fw-bold mb-0"><?= $reservation['client'] ?></p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Trajet</small>
                <p class="fw-bold mb-0">
                    <span class="text-primary"><?= $reservation['villedepart'] ?></span>
                    → <span class="text-success"><?= $reservation['villearrive'] ?></span>
                </p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Sièges</small>
                <p class="fw-bold mb-0">
                    <span class="badge bg-warning text-dark"><?= $reservation['sieges'] ?></span>
                </p>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Montant à payer</small>
                <p class="fw-bold text-success fs-4 mb-0">
                    <?= number_format($reservation['montant_total'], 0, ',', '.') ?> FCFA
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire paiement cash -->
<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=caissier&action=effectuerPaiement&reservation_id=<?= $reservation['id'] ?>">

            <input type="hidden" name="methode" value="especes">

            <div class="mb-4">
                <label class="form-label fw-bold fs-5">Montant reçu (FCFA)</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text">
                        <i class="fas fa-money-bill"></i>
                    </span>
                    <input type="number" 
                           name="montant" 
                           class="form-control form-control-lg"
                           value="<?= $reservation['montant_total'] ?>"
                           required>
                    <span class="input-group-text fw-bold">FCFA</span>
                </div>
            </div>

            <!-- Monnaie à rendre -->
            <div class="alert alert-warning mb-4" id="monnaie_block" style="display:none;">
                <i class="fas fa-coins"></i>
                Monnaie à rendre : <strong id="monnaie">0 FCFA</strong>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-check"></i> Confirmer l'encaissement
                </button>
            </div>

        </form>
    </div>
</div>

<script>
const montantDu = <?= $reservation['montant_total'] ?>;

document.querySelector('input[name="montant"]').addEventListener('input', function() {
    const recu    = parseFloat(this.value) || 0;
    const monnaie = recu - montantDu;
    const block   = document.getElementById('monnaie_block');
    const span    = document.getElementById('monnaie');

    if (recu > montantDu) {
        block.style.display = 'block';
        span.textContent    = monnaie.toLocaleString('fr-FR') + ' FCFA';
    } else {
        block.style.display = 'none';
    }
});
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>