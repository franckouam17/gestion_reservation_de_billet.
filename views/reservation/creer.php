<?php $titre = 'Choisir vos sièges – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<!-- Infos voyage -->
<div class="card shadow border-0 mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3">
                <small class="text-muted">Trajet</small>
                <h5 class="fw-bold">
                    <span class="text-primary"><?= $voyage['villedepart'] ?></span>
                    <i class="fas fa-arrow-right text-warning mx-2"></i>
                    <span class="text-success"><?= $voyage['villearrive'] ?></span>
                </h5>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Départ</small>
                <h5 class="fw-bold"><?= date('d/m/Y H:i', strtotime($voyage['dateheuredepart'])) ?></h5>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Prix / siège</small>
                <h5 class="fw-bold text-success"><?= number_format($voyage['prix'], 0, ',', '.') ?> FCFA</h5>
            </div>
            <div class="col-md-3">
                <small class="text-muted">Places disponibles</small>
                <h5 class="fw-bold text-primary"><?= $voyage['placerestante'] ?></h5>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Plan du bus -->
    <div class="col-md-7">
        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="mb-0"><i class="fas fa-bus"></i> Plan du bus – <?= $voyage['bus'] ?></h5>
            </div>
            <div class="card-body">

                <!-- Légende -->
                <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;background:#28a745;border-radius:6px;"></div>
                        <span>Libre</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;background:#ffc107;border-radius:6px;"></div>
                        <span>Sélectionné</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;background:#fd7e14;border-radius:6px;"></div>
                        <span>En attente</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;background:#dc3545;border-radius:6px;"></div>
                        <span>Réservé</span>
                    </div>
                </div>

                <form method="POST" 
                      action="<?= BASE_URL ?>/index.php?controller=reservation&action=creer&voyage_id=<?= $voyage['id'] ?>" 
                      id="formReservation">

                    <div class="bus-container mx-auto">
                        <?php
                        $nbre_place = $voyage['nbre_place'];
                        $seatNumber = 1;
                        $rows       = ceil($nbre_place / 5);
                        $door1      = 3;
                        $door2      = ($nbre_place > 30) ? $rows - 3 : null;
                        $lastRow    = $rows - 1;

                        $siegesIndex = [];
                        foreach ($sieges as $s) {
                            $siegesIndex[$s['numero']] = $s;
                        }

                        for ($row = 0; $row < $rows; $row++):
                        ?>
                            <div class="bus-row">
                                <?php if ($row == 0): ?>
                                    <div class="bus-driver">🚍</div>
                                    <div class="bus-empty"></div>
                                    <div class="bus-empty"></div>
                                    <div class="bus-aisle"></div>
                                    <?php for ($i = 0; $i < 2; $i++): ?>
                                        <?php if ($seatNumber <= $nbre_place):
                                            $siege    = $siegesIndex[$seatNumber] ?? null;
                                            $statut   = $siege ? $siege['statut'] : 0;
                                            $siege_id = $siege ? $siege['id'] : 0;
                                        ?>
                                            <?php if ($statut == 1): ?>
                                                <div class="bus-seat occupied" title="Réservé"><?= $seatNumber ?></div>
                                            <?php elseif ($statut == 2): ?>
                                                <div class="bus-seat pending" title="En attente"><?= $seatNumber ?></div>
                                            <?php else: ?>
                                                <div class="bus-seat free"
                                                     data-id="<?= $siege_id ?>"
                                                     data-num="<?= $seatNumber ?>"
                                                     onclick="toggleSeat(this)">
                                                    <?= $seatNumber ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php $seatNumber++; endif; ?>
                                    <?php endfor; ?>

                                <?php else: ?>
                                    <?php for ($i = 0; $i < 3; $i++): ?>
                                        <?php if ($seatNumber <= $nbre_place):
                                            $siege    = $siegesIndex[$seatNumber] ?? null;
                                            $statut   = $siege ? $siege['statut'] : 0;
                                            $siege_id = $siege ? $siege['id'] : 0;
                                        ?>
                                            <?php if ($statut == 1): ?>
                                                <div class="bus-seat occupied" title="Réservé"><?= $seatNumber ?></div>
                                            <?php elseif ($statut == 2): ?>
                                                <div class="bus-seat pending" title="En attente"><?= $seatNumber ?></div>
                                            <?php else: ?>
                                                <div class="bus-seat free"
                                                     data-id="<?= $siege_id ?>"
                                                     data-num="<?= $seatNumber ?>"
                                                     onclick="toggleSeat(this)">
                                                    <?= $seatNumber ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php $seatNumber++; endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($row != $lastRow): ?>
                                        <div class="bus-aisle"></div>
                                    <?php endif; ?>

                                    <?php if ($row == $door1): ?>
                                        <div class="bus-door">🚪</div>
                                        <?php $seatNumber += 2; ?>
                                    <?php elseif ($door2 !== null && $row == $door2): ?>
                                        <div class="bus-door">🚪</div>
                                        <?php $seatNumber += 2; ?>
                                    <?php else: ?>
                                        <?php for ($i = 0; $i < 2; $i++): ?>
                                            <?php if ($seatNumber <= $nbre_place):
                                                $siege    = $siegesIndex[$seatNumber] ?? null;
                                                $statut   = $siege ? $siege['statut'] : 0;
                                                $siege_id = $siege ? $siege['id'] : 0;
                                            ?>
                                                <?php if ($statut == 1): ?>
                                                    <div class="bus-seat occupied" title="Réservé"><?= $seatNumber ?></div>
                                                <?php elseif ($statut == 2): ?>
                                                    <div class="bus-seat pending" title="En attente"><?= $seatNumber ?></div>
                                                <?php else: ?>
                                                    <div class="bus-seat free"
                                                         data-id="<?= $siege_id ?>"
                                                         data-num="<?= $seatNumber ?>"
                                                         onclick="toggleSeat(this)">
                                                        <?= $seatNumber ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php $seatNumber++; endif; ?>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>

                        <div id="siegesSelectionnes"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Récapitulatif -->
    <div class="col-md-5">
        <div class="card shadow border-0 sticky-top" style="top:80px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-receipt"></i> Récapitulatif</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted">Trajet</td>
                        <td class="fw-bold"><?= $voyage['villedepart'] ?> → <?= $voyage['villearrive'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Départ</td>
                        <td class="fw-bold"><?= date('d/m/Y H:i', strtotime($voyage['dateheuredepart'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Bus</td>
                        <td class="fw-bold"><?= $voyage['bus'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Chauffeur</td>
                        <td class="fw-bold"><?= $voyage['chauffeur'] ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Prix / siège</td>
                        <td class="fw-bold text-success"><?= number_format($voyage['prix'], 0, ',', '.') ?> FCFA</td>
                    </tr>
                </table>

                <hr>

                <div class="mb-3">
                    <p class="text-muted mb-1">Sièges sélectionnés :</p>
                    <div id="listeSieges">
                        <span class="text-muted fst-italic">Aucun siège sélectionné</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold">Total :</span>
                    <span class="fw-bold text-success fs-5" id="totalMontant">0 FCFA</span>
                </div>

                <div class="d-grid">
                    <button type="button"
                            class="btn btn-primary btn-lg"
                            id="btnReserver"
                            onclick="validerReservation()"
                            disabled>
                        <i class="fas fa-arrow-right"></i> Continuer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Bus -->
<style>
.bus-container { max-width:320px; background:#f8f9fa; border:3px solid #343a40; border-radius:20px; padding:15px; }
.bus-row { display:flex; align-items:center; justify-content:center; gap:5px; margin-bottom:5px; }
.bus-seat { width:38px; height:38px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:bold; cursor:pointer; transition:all 0.2s; }
.bus-seat.free { background:#28a745; color:white; }
.bus-seat.free:hover { background:#218838; transform:scale(1.1); }
.bus-seat.selected { background:#ffc107; color:#343a40; border:2px solid #e0a800; transform:scale(1.1); }
.bus-seat.occupied { background:#dc3545; color:white; cursor:not-allowed; }
.bus-seat.pending { background:#fd7e14; color:white; cursor:not-allowed; }
.bus-aisle { width:20px; }
.bus-door, .bus-driver, .bus-empty { width:38px; height:38px; display:flex; align-items:center; justify-content:center; font-size:20px; }
</style>

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
}

function majRecap() {
    const listeSieges  = document.getElementById('listeSieges');
    const totalMontant = document.getElementById('totalMontant');
    const btnReserver  = document.getElementById('btnReserver');
    if (sieges.length === 0) {
        listeSieges.innerHTML = '<span class="text-muted fst-italic">Aucun siège sélectionné</span>';
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

function validerReservation() {
    if (sieges.length === 0) {
        alert('Sélectionnez au moins un siège !');
        return;
    }
    const form      = document.getElementById('formReservation');
    const container = document.getElementById('siegesSelectionnes');
    container.innerHTML = '';
    sieges.forEach(s => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'sieges[]';
        input.value = s.id;
        container.appendChild(input);
    });
    form.submit();
}
</script>

<?php include ROOT . '/views/layout_footer.php'; ?>