<?php $titre = 'Modifier un voyage – GesRoad'; ?>
<?php include ROOT . '/views/layout.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">
        <i class="fas fa-edit text-warning"></i> Modifier le voyage
    </h3>
    <a href="<?= BASE_URL ?>/index.php?controller=admin&action=listeVoyages"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-4">
        <form method="POST" action="<?= BASE_URL ?>/index.php?controller=admin&action=modifierVoyage&id=<?= $voyage['id'] ?>">

            <div class="row">
                <!-- Trajet + Chauffeur -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Trajet – Chauffeur</label>
                    <select name="trajetchauffeur_id" class="form-select" required>
                        <?php foreach ($trajets_chauffeurs as $tc): ?>
                            <option value="<?= $tc['id'] ?>"
                                <?= $tc['id'] == $voyage['trajetchauffeur_id'] ? 'selected' : '' ?>>
                                <?= $tc['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Type voyage -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Type de voyage</label>
                    <select name="type_id" class="form-select" required>
                        <?php foreach ($types_voyage as $tv): ?>
                            <option value="<?= $tv['id'] ?>"
                                <?= $tv['id'] == $voyage['type_id'] ? 'selected' : '' ?>>
                                <?= $tv['libelle'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Bus -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Bus</label>
                    <select name="bus_id" class="form-select" required>
                        <?php foreach ($bus_disponibles as $b): ?>
                            <option value="<?= $b['id'] ?>"
                                <?= $b['id'] == $voyage['bus_id'] ? 'selected' : '' ?>>
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
                               value="<?= $voyage['prix'] ?>" required>
                    </div>
                </div>

                <!-- Agence départ -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Agence de départ</label>
                    <select name="agencelocaledeapart_id" class="form-select" required>
                        <?php foreach ($agences_locales as $al): ?>
                            <option value="<?= $al['id'] ?>"
                                <?= $al['id'] == $voyage['agencelocaledeapart_id'] ? 'selected' : '' ?>>
                                <?= $al['nom_agence'] ?> – <?= $al['addresse'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Agence arrivée -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Agence d'arrivée</label>
                    <select name="agenceloacledarrive_id" class="form-select" required>
                        <?php foreach ($agences_locales as $al): ?>
                            <option value="<?= $al['id'] ?>"
                                <?= $al['id'] == $voyage['agenceloacledarrive_id'] ? 'selected' : '' ?>>
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
                               class="form-control"
                               value="<?= date('Y-m-d\TH:i', strtotime($voyage['dateheuredepart'])) ?>"
                               required>
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
                               class="form-control"
                               value="<?= date('Y-m-d\TH:i', strtotime($voyage['dateheurearrive'])) ?>"
                               required>
                    </div>
                </div>

                <!-- Statut -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Statut</label>
                    <select name="statut" class="form-select" required>
                        <option value="0" <?= $voyage['statut'] == 0 ? 'selected' : '' ?>>Planifié</option>
                        <option value="1" <?= $voyage['statut'] == 1 ? 'selected' : '' ?>>En cours</option>
                        <option value="2" <?= $voyage['statut'] == 2 ? 'selected' : '' ?>>Terminé</option>
                        <option value="3" <?= $voyage['statut'] == 3 ? 'selected' : '' ?>>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>
</div>

<?php include ROOT . '/views/layout_footer.php'; ?>