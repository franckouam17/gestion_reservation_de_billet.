<?php
require_once MODELS . '/Billet.php';

class BilletController {
    private $pdo;
    private $billet;

    public function __construct($pdo) {
        $this->pdo    = $pdo;
        $this->billet = new Billet($pdo);
    }

    // Générer un billet
    public function generer() {
        $this->verifierRole('caissier');

        $reservation_id = $_GET['reservation_id'];
        $resultat       = $this->billet->generer($reservation_id);

        if ($resultat['succes']) {
            header('Location: index.php?controller=billet&action=detail&id=' . $resultat['billet_id']);
            exit();
        } else {
            header('Location: index.php?controller=billet&action=detail&message=' . $resultat['message']);
            exit();
        }
    }

    // Détails d'un billet
    public function detail() {
        $this->verifierConnexion();
        $id     = $_GET['id'];
        $billet = $this->billet->getDetails($id);
        require_once VIEWS . '/billet/detail.php';
    }

    // Télécharger un billet (client)
//    // public function telecharger() {
//         $this->verifierConnexion();
//         $reservation_id = $_GET['reservation_id'];
//         $billet         = $this->billet->getParReservation($reservation_id);

//         if (!$billet) {
//             header('Location: index.php?controller=reservation&action=liste&message=Billet introuvable');
//             exit();
//         }

//         require_once VIEWS . '/billet/detail.php';
//     }

    // Vérifier connexion
    private function verifierConnexion() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

    // Vérifier rôle
    private function verifierRole($role) {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != $role) {
            header('Location: index.php?controller=user&action=login');
            exit();
        }
    }

public function telechargerPDF() {
    $this->verifierConnexion();
    $id     = $_GET['id'];
        $billet = $this->billet->getDetails($id);

    require_once ROOT . '/fpdf/fpdf.php';

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // En-tête
    $pdf->SetFillColor(13, 110, 253);
    $pdf->Rect(0, 0, 210, 30, 'F');
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetXY(10, 8);
    $pdf->Cell(0, 14, 'GesRoad - Billet de voyage', 0, 1);

    // Numéro billet
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(10, 20);
    $pdf->Cell(0, 8, 'N: ' . $billet['numero'], 0, 1);

    // Retour couleur normale
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetY(40);

    // Trajet
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Rect(10, 38, 190, 25, 'F');
    $pdf->SetXY(10, 42);
    $pdf->Cell(85, 10, $billet['villedepart'], 0, 0, 'C');
    $pdf->Cell(20, 10, '--->', 0, 0, 'C');
    $pdf->Cell(85, 10, $billet['villearrive'], 0, 0, 'C');

    // Heures
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetXY(10, 52);
    $pdf->Cell(85, 8, date('H:i d/m/Y', strtotime($billet['dateheuredepart'])), 0, 0, 'C');
    $pdf->Cell(20, 8, '', 0, 0, 'C');
    $pdf->Cell(85, 8, date('H:i d/m/Y', strtotime($billet['dateheurearrive'])), 0, 0, 'C');

    $pdf->SetY(70);

    // Infos passager
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, 'Informations passager', 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(50, 7, 'Nom :', 0, 0);
    $pdf->Cell(0, 7, $billet['client'], 0, 1);
    $pdf->Cell(50, 7, 'Email :', 0, 0);
    $pdf->Cell(0, 7, $billet['email'], 0, 1);

    $pdf->SetY($pdf->GetY() + 5);

    // Infos voyage
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, 'Informations voyage', 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(50, 7, 'Bus :', 0, 0);
    $pdf->Cell(0, 7, $billet['bus'], 0, 1);
    $pdf->Cell(50, 7, 'Chauffeur :', 0, 0);
    $pdf->Cell(0, 7, $billet['chauffeur'], 0, 1);
    $pdf->Cell(50, 7, 'Agence depart :', 0, 0);
    $pdf->Cell(0, 7, $billet['agence_depart'], 0, 1);
    $pdf->Cell(50, 7, 'Agence arrivee :', 0, 0);
    $pdf->Cell(0, 7, $billet['agence_arrivee'], 0, 1);

    $pdf->SetY($pdf->GetY() + 5);

    // Siège + Montant
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 8, 'Reservation', 0, 1);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(50, 7, 'Siege(s) :', 0, 0);
    $pdf->Cell(0, 7, $billet['sieges'], 0, 1);
    $pdf->Cell(50, 7, 'Montant paye :', 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 7, number_format($billet['montant_total'], 0, ',', '.') . ' FCFA', 0, 1);

    // Pied de page
    $pdf->SetY(260);
    $pdf->SetFillColor(13, 110, 253);
    $pdf->Rect(0, 265, 210, 30, 'F');
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetXY(10, 270);
    $pdf->Cell(0, 6, 'GesRoad - Systeme de reservation de transport routier', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Presentez ce billet lors de lembarquement', 0, 1, 'C');
    $pdf->Cell(0, 6, $billet['numero'], 0, 1, 'C');

    // Télécharger
    $pdf->Output('D', 'billet_' . $billet['numero'] . '.pdf');
    exit();
}
}
?>