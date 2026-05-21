<?php require_once __DIR__ . '/../layout.php'; ?>
<h3 class="mb-4">Toutes les réservations</h3>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Trajet</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Statut</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($reservations as $r): ?>
            <tr>
                <td><?= $r['id'] ?></td>
                <td><?= $r['client_nom'] ?? '' ?></td>
                <td><?= $r['trajet'] ?? '' ?></td>
                <td><?= $r['date_reservation'] ?></td>
                <td><?= $r['montant'] ?> FCFA</td>
                <td><?= $r['statut'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include ROOT . '/views/layout_footer.php'; ?>