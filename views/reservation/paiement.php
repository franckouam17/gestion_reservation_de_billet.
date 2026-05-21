<?php $titre = 'Paiement – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="fas fa-mobile-alt"></i> Paiement Mobile Money
                </h4>
            </div>
            <div class="card-body p-4">

                <!-- Récapitulatif -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between">
                        <span>Réservation #<?= $reservation['id'] ?></span>
                        <strong><?= number_format($reservation['montant_total'], 0, ',', '.') ?> FCFA</strong>
                    </div>
                    <small class="text-muted">
                        <?= $reservation['villedepart'] ?> → <?= $reservation['villearrive'] ?>
                        – <?= date('d/m/Y H:i', strtotime($reservation['dateheuredepart'])) ?>
                    </small>
                </div>

                <form method="POST" action="<?= BASE_URL ?>/index.php?controller=paiement&action=initier">
                    <input type="hidden" name="reservation_id" value="<?= $reservation['id'] ?>">
                    <input type="hidden" name="montant" value="<?= $reservation['montant_total'] ?>">

                    <!-- Choix opérateur -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Choisir l'opérateur</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="card border-2 operator-card"
                                     onclick="selectOperator(this, 'MTN')"
                                     style="cursor:pointer;">
                                    <div class="card-body text-center py-3">
                                        <div class="fw-bold fs-5 mb-1" style="color:#FFCC00;">MTN</div>
                                        <small class="text-muted">Mobile Money</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border-2 operator-card"
                                     onclick="selectOperator(this, 'ORANGE')"
                                     style="cursor:pointer;">
                                    <div class="card-body text-center py-3">
                                        <div class="fw-bold fs-5 mb-1" style="color:#FF6600;">Orange</div>
                                        <small class="text-muted">Money</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="operateur" id="operateur" required>
                    </div>

                    <!-- Numéro -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Numéro de téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text">+237</span>
                            <input type="tel" name="telephone"
                                   class="form-control"
                                   placeholder="6XXXXXXXX"
                                   maxlength="9"
                                   required>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Mode simulation – aucun vrai paiement ne sera effectué
                        </small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-lock"></i> 
                            Payer <?= number_format($reservation['montant_total'], 0, ',', '.') ?> FCFA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function selectOperator(el, operator) {
    document.querySelectorAll('.operator-card').forEach(card => {
        card.classList.remove('border-primary', 'bg-light');
    });
    el.classList.add('border-primary', 'bg-light');
    document.getElementById('operateur').value = operator;
}
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>