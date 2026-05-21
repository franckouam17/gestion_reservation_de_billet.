<?php
require_once MODELS . '/Voyage.php';

class HomeController {
    private $pdo;
    private $voyage;

    public function __construct($pdo) {
        $this->pdo    = $pdo;
        $this->voyage = new Voyage($pdo);
    }

    public function index() {
        $voyages      = $this->getProchainVoyages();
        $totalVoyages = $this->getTotalVoyages();
        require_once VIEWS . '/home/index.php';
    }

   private function getProchainVoyages() {
    $stmt = $this->pdo->prepare("
        SELECT 
            v.id,
            t.villedepart,
            t.villearrive,
            v.dateheuredepart,
            v.prix,
            v.placerestante,
            tv.libelle        AS type_voyage,
            al1.addresse       AS agence_depart,
            al1.photo         AS photo_depart,
            al2.addresse       AS agence_arrivee,
            al2.photo         AS photo_arrivee
        FROM voyage v
        JOIN trajet_chauffeur tc ON tc.id  = v.trajetchauffeur_id
        JOIN trajet t            ON t.id   = tc.trajet_id
        JOIN typevoyage tv       ON tv.id  = v.type_id
        JOIN agence_locale al1   ON al1.id = v.agencelocaledeapart_id
        JOIN agence_locale al2   ON al2.id = v.agenceloacledarrive_id
        WHERE v.statut          = 0
        AND   v.placerestante   > 0
        AND   v.dateheuredepart >= NOW()
        ORDER BY v.dateheuredepart ASC
        LIMIT 6
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

private function getTotalVoyages() {
    $stmt = $this->pdo->prepare("
        SELECT COUNT(*) AS total 
        FROM voyage 
        WHERE statut = 0 
        AND placerestante > 0
        AND dateheuredepart >= NOW()
    ");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}
public function apropos() {
    require_once VIEWS . '/home/apropos.php';
}
    
}
?>