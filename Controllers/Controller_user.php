<?php

class Controller_user extends Controller {

    public function action_user() {
        // Vérifier si l'utilisateur est connecté et si c'est un "user"
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        $m = Model::getModel();
        $visaRequests = $m->getVisaRequestsByUser($_SESSION['id']);

        // Récupérer le prénom de l'utilisateur connecté
        $welcome = htmlspecialchars($_SESSION['prenom']);

        $data = [
            'welcome' => $welcome,
            'visaRequests' => $visaRequests
        ];
        $this->render('user', $data);
    }

    public function action_new_request() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifier que tous les champs sont remplis
            if (!empty($_POST['pays_residence']) && !empty($_POST['adresse']) && !empty($_POST['code_postal']) && !empty($_POST['ville'])) {
                $pays_residence = $_POST['pays_residence'];
                $adresse = $_POST['adresse'];
                $code_postal = $_POST['code_postal'];
                $ville = $_POST['ville'];

                // Stocker les données dans la session
                $_SESSION['request_data'] = [
                    'pays_residence' => $pays_residence,
                    'adresse' => $adresse,
                    'code_postal' => $code_postal,
                    'ville' => $ville
                ];

                // Rediriger vers le paiement
                header('Location: ?controller=user&action=payment');
                exit();
            } else {
                // Afficher une erreur si des champs sont manquants
                $error = 'Veuillez remplir tous les champs.';
                $this->render('new_request', ['error' => $error]);
            }
        } else {
            $this->render('new_request');
        }
    }

    public function action_payment() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        // Vérifier que les données de la demande sont présentes
        if (!isset($_SESSION['request_data'])) {
            header('Location: ?controller=user&action=new_request');
            exit();
        }

        $this->render('payment');
    }

    public function action_submit_payment() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifier que tous les champs sont remplis
            if (!empty($_POST['card_number']) && !empty($_POST['card_cvv']) && !empty($_POST['card_expiry'])) {
                $card_number = str_replace(' ', '', $_POST['card_number']);
                $card_cvv = $_POST['card_cvv'];
                $card_expiry = $_POST['card_expiry'];

                // Valider le numéro de carte (16 chiffres)
                if (!preg_match('/^\d{16}$/', $card_number)) {
                    $error = 'Le numéro de carte doit contenir 16 chiffres.';
                    $this->render('payment', ['error' => $error]);
                    exit();
                }

                // Valider le code CVV (3 chiffres)
                if (!preg_match('/^\d{3}$/', $card_cvv)) {
                    $error = 'Le code CVV doit contenir 3 chiffres.';
                    $this->render('payment', ['error' => $error]);
                    exit();
                }

                // Valider la date d'expiration
                $currentDate = date('Y-m');
                if ($card_expiry < $currentDate) {
                    $error = 'La date d\'expiration de la carte est invalide.';
                    $this->render('payment', ['error' => $error]);
                    exit();
                }

                // Paiement réussi, stocker une indication dans la session
                $_SESSION['payment_done'] = true;

                // Rediriger vers la page de révision
                header('Location: ?controller=user&action=review_request');
                exit();

            } else {
                $error = 'Veuillez remplir tous les champs du formulaire de paiement.';
                $this->render('payment', ['error' => $error]);
                exit();
            }
        } else {
            header('Location: ?controller=user&action=payment');
            exit();
        }
    }

    public function action_review_request() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        // Vérifier que le paiement a été effectué
        if (!isset($_SESSION['payment_done']) || $_SESSION['payment_done'] !== true) {
            header('Location: ?controller=user&action=payment');
            exit();
        }

        // Vérifier que les données de la demande sont présentes
        if (!isset($_SESSION['request_data'])) {
            header('Location: ?controller=user&action=new_request');
            exit();
        }

        $m = Model::getModel();
        $user = $m->findUserById($_SESSION['id']);

        $data = [
            'user' => $user,
            'request_data' => $_SESSION['request_data']
        ];
        $this->render('review_request', $data);
    }

    public function action_submit_request() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        // Vérifier si 'request_data' est défini dans la session
        if (!isset($_SESSION['request_data'])) {
            header('Location: ?controller=user&action=new_request');
            exit();
        }

        if (isset($_POST['confirm'])) {
            $m = Model::getModel();
            $user = $m->findUserById($_SESSION['id']);
            $request_data = $_SESSION['request_data'];

            // Vérifier la date d'expiration du passeport
            $today = date('Y-m-d');
            if ($user['dateExpPass'] < $today) {
                $statut = 'Refusé';
            } else {
                // Vérifier si la nationalité est bannie
                if ($m->isNationalityBanned($user['id_nation'])) {
                    $statut = 'Refusé';
                } else {
                    $statut = 'Accepté';
                }
            }

            // Générer une référence unique
            $reference = "VISAREF-" . date("YmdHis");

            // Insérer la demande dans la base de données
            $m->createVisaRequest(
                $user['id_utilisateur'],
                $request_data['pays_residence'],
                $request_data['adresse'],
                $request_data['code_postal'],
                $request_data['ville'],
                $reference,
                $statut
            );

            // Générer le PDF et stocker le contenu dans la session
            if ($statut == 'Accepté') {
                $pdfContent = $this->generatePDF($user, $request_data, $reference);
                $_SESSION['pdf_content'] = $pdfContent;
                $_SESSION['pdf_filename'] = 'v_' . $reference . '.pdf';
            }

            // Supprimer les données de la session
            unset($_SESSION['request_data']);
            unset($_SESSION['payment_done']);

            // Rediriger vers le téléchargement du PDF si le visa est accepté
            if ($statut == 'Accepté') {
                header('Location: ?controller=user&action=download_pdf');
                exit();
            } else {
                // Rediriger vers la page principale
                header('Location: ?controller=user');
                exit();
            }
        } elseif (isset($_POST['cancel'])) {
            // Annuler la demande et rediriger
            unset($_SESSION['request_data']);
            unset($_SESSION['payment_done']);
            header('Location: ?controller=user');
            exit();
        } else {
            // Rediriger si accès non autorisé
            header('Location: ?controller=user');
            exit();
        }
    }

    public function generatePDF($user, $request_data, $reference) {
        // Inclure la bibliothèque FPDF
        require_once('fpdf/fpdf.php');
    
        // Créer une instance de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
    
        // Définir la police
        $pdf->SetFont('Arial', 'B', 16);
    
        // Titre principal
        $pdf->Cell(0, 10, mb_convert_encoding('Visa Valide', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $pdf->Ln(10);
    
        // Informations personnelles
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, mb_convert_encoding('Informations Personnelles', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
    
        // Nom
        $pdf->Cell(50, 10, mb_convert_encoding('Nom :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($user['nom'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Prénom
        $pdf->Cell(50, 10, mb_convert_encoding('Prénom :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($user['prenom'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Email
        $pdf->Cell(50, 10, mb_convert_encoding('Email :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($user['email'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Nationalité
        $pdf->Cell(50, 10, mb_convert_encoding('Nationalité :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($user['nation'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Numéro de passeport
        $pdf->Cell(50, 10, mb_convert_encoding('Numéro de passeport :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($user['numPass'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Date d'expiration du passeport
        $pdf->Cell(70, 10, mb_convert_encoding('Date d\'expiration du passeport :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $dateExpPass = date('d/m/Y', strtotime($user['dateExpPass']));
        $pdf->Cell(0, 10, mb_convert_encoding($dateExpPass, 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Informations de résidence
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, mb_convert_encoding('Informations de Résidence', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
    
        // Pays de résidence
        $pdf->Cell(50, 10, mb_convert_encoding('Pays de résidence :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($request_data['pays_residence'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Adresse
        $pdf->Cell(50, 10, mb_convert_encoding('Adresse :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->MultiCell(0, 10, mb_convert_encoding($request_data['adresse'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Code Postal
        $pdf->Cell(50, 10, mb_convert_encoding('Code Postal :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($request_data['code_postal'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Ville
        $pdf->Cell(50, 10, mb_convert_encoding('Ville :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($request_data['ville'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Référence
        $pdf->Ln(5);
        $pdf->Cell(50, 10, mb_convert_encoding('Référence :', 'ISO-8859-1', 'UTF-8'), 0, 0);
        $pdf->Cell(0, 10, mb_convert_encoding($reference, 'ISO-8859-1', 'UTF-8'), 0, 1);
    
        // Retourner le PDF en tant que chaîne
        return $pdf->Output('', 'S');
    }
    
    

    public function action_download_pdf() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        // Désactiver la sortie de buffering
        if (ob_get_length()) ob_end_clean();

        // Vérifier si le contenu du PDF est présent dans la session
        if (isset($_SESSION['pdf_content']) && isset($_SESSION['pdf_filename'])) {
            $pdfContent = $_SESSION['pdf_content'];
            $filename = $_SESSION['pdf_filename'];

            // Envoyer les en-têtes appropriés
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($pdfContent));

            // Envoyer le contenu du PDF
            echo $pdfContent;

            // Supprimer le contenu du PDF de la session
            unset($_SESSION['pdf_content']);
            unset($_SESSION['pdf_filename']);
        } else {
            // Si le PDF n'est pas disponible, rediriger vers la page principale
            header('Location: ?controller=user');
            exit();
        }
    }
    
    public function action_default() {
        $this->action_user();
    }
}
