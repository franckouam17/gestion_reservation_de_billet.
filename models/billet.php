<?php
class Billet {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Générer un billet
  public function generer($reservation_id) {

    // Vérifier que la réservation est payée
    $stmt = $this->pdo->prepare("SELECT id FROM paiement WHERE reservation_id = ? AND statut = 1");
    $stmt->execute([$reservation_id]);

    if ($stmt->rowCount() == 0) {
        return ['succes' => false, 'message' => 'La réservation n est pas encore payée'];
    }

    // Récupérer les infos générales de la réservation
    $stmt = $this->pdo->prepare("
        SELECT 
            r.id,
            r.montant_total,
            r.date_reservation,
            CONCAT(u.nom,' ',u.prenom) AS client,
            u.email,
            t.villedepart,
            t.villearrive,
            v.dateheuredepart,
            v.dateheurearrive,
            al1.addresse AS agence_depart,
            al2.addresse AS agence_arrivee,
            CONCAT(c.nom,' ',c.prenom) AS chauffeur,
            b.immatriculation          AS bus,
            v.prix
        FROM reservation r
        JOIN user u               ON u.id   = r.user_id
        JOIN voyage v             ON v.id   = r.voyage_id
        JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
        JOIN trajet t             ON t.id   = tc.trajet_id
        JOIN chauffeur c          ON c.id   = tc.chauffeur_id
        JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
        JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
        JOIN bus b                ON b.id   = v.bus_id
        WHERE r.id = ?
    ");
    $stmt->execute([$reservation_id]);
    $infos = $stmt->fetch(PDO::FETCH_ASSOC);

    // Récupérer chaque siège avec les infos du passager
    $stmt = $this->pdo->prepare("
        SELECT 
            rs.siege_id,
            rs.nom        AS passager_nom,
            rs.telephone  AS passager_tel,
            s.numero      AS numero_siege
        FROM reservation_siege rs
        JOIN siege s ON s.id = rs.siege_id
        WHERE rs.reservation_id = ?
        ORDER BY s.numero ASC
    ");
    $stmt->execute([$reservation_id]);
    $sieges = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $billets_generes = [];

    // Générer un billet par siège
    foreach ($sieges as $siege) {

        // Vérifier qu'un billet n'existe pas déjà pour ce siège
        $stmt = $this->pdo->prepare("
            SELECT id FROM billet 
            WHERE reservation_id = ? AND siege_id = ?
        ");
        $stmt->execute([$reservation_id, $siege['siege_id']]);

        if ($stmt->rowCount() > 0) {
            continue; // Billet déjà généré pour ce siège
        }

        $numero    = 'BILL-' . date('Ymd') . '-' . strtoupper(uniqid());
        $nom_pdf   = 'billets/' . $numero . '.pdf';

        // Nom du passager
        $passager = !empty($siege['passager_nom']) 
                    ? $siege['passager_nom'] 
                    : $infos['client'];

        $qr_contenu = json_encode([
            'numero'   => $numero,
            'passager' => $passager,
            'siege'    => $siege['numero_siege'],
            'trajet'   => $infos['villedepart'] . ' → ' . $infos['villearrive'],
            'depart'   => $infos['dateheuredepart'],
            'montant'  => $infos['prix']
        ]);

        $stmt = $this->pdo->prepare("
            INSERT INTO billet (reservation_id, siege_id, numero, datereservation, fichierpdf, QRcode)
            VALUES (?, ?, ?, NOW(), ?, ?)
        ");
        $stmt->execute([
            $reservation_id,
            $siege['siege_id'],
            $numero,
            $nom_pdf,
            $qr_contenu
        ]);

        $billets_generes[] = [
            'billet_id'    => $this->pdo->lastInsertId(),
            'numero'       => $numero,
            'passager'     => $passager,
            'siege'        => $siege['numero_siege'],
            'telephone'    => $siege['passager_tel']
        ];
    }

    return [
        'succes'  => true,
        'message' => count($billets_generes) . ' billet(s) généré(s)',
        'billets' => $billets_generes
    ];
}

    // Détails d'un billet
   public function getDetails($id) {
    $stmt = $this->pdo->prepare("
        SELECT 
            b.id,
            b.numero,
            b.datereservation,
            b.fichierpdf,
            b.QRcode,
            r.montant_total,
            CONCAT(u.nom,' ',u.prenom) AS client,
            u.email,
            t.villedepart,
            t.villearrive,
            v.dateheuredepart,
            v.dateheurearrive,
            al1.addresse AS agence_depart,
            al2.addresse AS agence_arrivee,
            CONCAT(c.nom,' ',c.prenom) AS chauffeur,
            bus.immatriculation        AS bus,
            GROUP_CONCAT(s.numero ORDER BY s.numero) AS sieges
        FROM billet b
        JOIN reservation r        ON r.id   = b.reservation_id
        JOIN user u               ON u.id   = r.user_id
        JOIN voyage v             ON v.id   = r.voyage_id
        JOIN trajet_chauffeur tc  ON tc.id  = v.trajetchauffeur_id
        JOIN trajet t             ON t.id   = tc.trajet_id
        JOIN chauffeur c          ON c.id   = tc.chauffeur_id
        JOIN agence_locale al1    ON al1.id = v.agencelocaledeapart_id
        JOIN agence_locale al2    ON al2.id = v.agenceloacledarrive_id
        JOIN bus                  ON bus.id = v.bus_id
        JOIN reservation_siege rs ON rs.reservation_id = r.id
        JOIN siege s              ON s.id   = rs.siege_id
        WHERE b.id = ?
        GROUP BY b.id
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Récupérer billet par réservation
  public function getParReservation($reservation_id) {
    $stmt = $this->pdo->prepare("
        SELECT 
            b.*,
            COALESCE(s.numero, 0)    AS numero_siege,
            COALESCE(rs.nom, '')     AS passager_nom,
            COALESCE(rs.telephone, '') AS passager_tel
        FROM billet b
        LEFT JOIN siege s              ON s.id  = b.siege_id
        LEFT JOIN reservation_siege rs ON rs.siege_id = b.siege_id 
                                       AND rs.reservation_id = b.reservation_id
        WHERE b.reservation_id = ?
        ORDER BY b.id ASC
    ");
    $stmt->execute([$reservation_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>