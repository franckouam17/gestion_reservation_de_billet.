<!-- Infos client + récap -->
 <?php include ROOT . '/views/layout.php'; ?>
<div class="col-md-5">

    <!-- Infos client principal -->
    <div class="card shadow border-0 mb-3">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-user"></i> Client principal</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nom</label>
                <input type="text" id="client_nom" class="form-control"
                       placeholder="Nom du client"
                       form="formReservation" name="nom" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Prénom</label>
                <input type="text" id="client_prenom" class="form-control"
                       placeholder="Prénom"
                       form="formReservation" name="prenom">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" id="client_email" class="form-control"
                       placeholder="email@exemple.com"
                       form="formReservation" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input type="text" id="client_telephone" class="form-control"
                       placeholder="6XXXXXXXX"
                       form="formReservation" name="telephone">
            </div>
        </div>
    </div>

    <!-- Passagers supplémentaires (générés dynamiquement) -->
    <div id="passagers_supplementaires"></div>

    <!-- Récapitulatif -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-receipt"></i> Récapitulatif</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <p class="text-muted mb-1">Sièges sélectionnés :</p>
                <div id="listeSieges">
                    <span class="text-muted fst-italic">Aucun siège</span>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Total :</span>
                <span class="fw-bold text-success fs-5" id="totalMontant">0 FCFA</span>
            </div>
            <div class="alert alert-success mb-3">
                <i class="fas fa-money-bill"></i>
                Paiement en <strong>espèces</strong> au guichet
            </div>
            <div class="d-grid">
                <button type="button"
                        class="btn btn-primary btn-lg"
                        id="btnReserver"
                        onclick="validerReservation()"
                        disabled>
                    <i class="fas fa-ticket-alt"></i> Confirmer et encaisser
                </button>
            </div>
        </div>
    </div>
</div>
<script>
const prix  = <?= $voyage['prix'] ?>;
let sieges  = [];

function toggleSeat(el) {
    const id  = el.getAttribute('data-id');
    const num = el.getAttribute('data-num');

    if (el.classList.contains('selected')) {
        el.classList.remove('selected');
        el.classList.add('free');
        sieges = sieges.filter(s => s.id !== id);
    } else {
        el.classList.remove('free');
        el.classList.add('selected');
        sieges.push({ id, num });
    }
    majRecap();
    majPassagers();
}

function majRecap() {
    const listeSieges  = document.getElementById('listeSieges');
    const totalMontant = document.getElementById('totalMontant');
    const btnReserver  = document.getElementById('btnReserver');

    if (sieges.length === 0) {
        listeSieges.innerHTML = '<span class="text-muted fst-italic">Aucun siège</span>';
        totalMontant.textContent = '0 FCFA';
        btnReserver.disabled = true;
    } else {
        listeSieges.innerHTML = sieges.map(s =>
            `<span class="badge bg-warning text-dark me-1">Siège ${s.num}</span>`
        ).join('');
        totalMontant.textContent = (prix * sieges.length).toLocaleString('fr-FR') + ' FCFA';
        btnReserver.disabled = false;
    }
}

function majPassagers() {
    const container = document.getElementById('passagers_supplementaires');
    container.innerHTML = '';

    // Si plus d'un siège → afficher champs pour les autres passagers
    if (sieges.length > 1) {
        sieges.slice(1).forEach((s, index) => {
            container.innerHTML += `
                <div class="card shadow border-0 mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-user"></i> Passager siège ${s.num}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label">Nom complet</label>
                            <input type="text"
                                   name="passager_nom[${s.id}]"
                                   class="form-control"
                                   placeholder="Nom et prénom"
                                   required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Téléphone</label>
                            <input type="text"
                                   name="passager_tel[${s.id}]"
                                   class="form-control"
                                   placeholder="6XXXXXXXX">
                        </div>
                    </div>
                </div>
            `;
        });
    }
}

function validerReservation() {
    if (sieges.length === 0) {
        alert('Sélectionnez au moins un siège !');
        return;
    }

    const nom = document.getElementById('client_nom').value;
    const email = document.getElementById('client_email').value;

    if (!nom || !email) {
        alert('Remplissez les informations du client principal !');
        return;
    }

    const form      = document.getElementById('formReservation');
    const container = document.getElementById('siegesSelectionnes');
    container.innerHTML = '';

    // Ajouter les sièges
    sieges.forEach(s => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'sieges[]';
        input.value = s.id;
        container.appendChild(input);
    });

    // Ajouter passager principal pour le premier siège
    const inputPassager = document.createElement('input');
    inputPassager.type  = 'hidden';
    inputPassager.name  = `passager_nom[${sieges[0].id}]`;
    inputPassager.value = nom + ' ' + document.getElementById('client_prenom').value;
    container.appendChild(inputPassager);

    const inputTel = document.createElement('input');
    inputTel.type  = 'hidden';
    inputTel.name  = `passager_tel[${sieges[0].id}]`;
    inputTel.value = document.getElementById('client_telephone').value;
    container.appendChild(inputTel);

    form.submit();
}
</script>
<?php include ROOT . '/views/layout_footer.php'; ?>