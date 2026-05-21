<?php $titre = 'Créer un voyage – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-plus text-primary"></i> Créer un voyage
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeVoyages"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=creerVoyage">

            <div class="row">
                <!-- Trajet + Chauffeur -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Trajet – Chauffeur</label>
                    <select name="trajetchauffeur_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($trajets_chauffeurs as $tc): ?>
                            <option value="<?= $tc['id'] ?>"><?= $tc['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Type voyage -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Type de voyage</label>
                    <select name="type_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($types_voyage as $tv): ?>
                            <option value="<?= $tv['id'] ?>"><?= $tv['libelle'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Bus -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Bus</label>
                    <select name="bus_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($bus_disponibles as $b): ?>
                            <option value="<?= $b['id'] ?>">
                                <?= $b['immatriculation'] ?> – <?= $b['type_bus'] ?> (<?= $b['nbre_place'] ?> places)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Prix -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prix (FCFA)</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-money-bill"></i>
                        </span>
                        <input type="number" name="prix" class="form-control"
                               placeholder="Ex: 5000" min="0" required>
                    </div>
                </div>

                <!-- Agence départ -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Agence de départ</label>
                    <select name="agencelocaledeapart_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences_locales as $al): ?>
                            <option value="<?= $al['id'] ?>">
                                <?= $al['nom_agence'] ?> – <?= $al['addresse'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Agence arrivée -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Agence d'arrivée</label>
                    <select name="agenceloacledarrive_id" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($agences_locales as $al): ?>
                            <option value="<?= $al['id'] ?>">
                                <?= $al['nom_agence'] ?> – <?= $al['addresse'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Date heure départ -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date et heure de départ</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="datetime-local" name="dateheuredepart"
                               class="form-control" required>
                    </div>
                </div>

                <!-- Date heure arrivée -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Date et heure d'arrivée</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="datetime-local" name="dateheurearrive"
                               class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Créer le voyage
                </button>
            </div>

        </form>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>
