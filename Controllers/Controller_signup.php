<?php

class Controller_signup extends Controller{

    public function action_signup()
    {
        $m = Model::getModel();
        $nations = $m->getNation();

        $errors = [];
        $successMsg = '';
        $redirectUrl = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération et sécurisation des données du formulaire
            $nom           = htmlspecialchars($_POST['nom']);
            $prenom        = htmlspecialchars($_POST['prenom']);
            $email         = htmlspecialchars($_POST['email']);
            $id_nation     = htmlspecialchars($_POST['nations']);
            $numPass       = htmlspecialchars($_POST['numPass']);
            $dateExpPass   = htmlspecialchars($_POST['dateExpPass']);
            $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
            $password      = htmlspecialchars($_POST['password']);
            $password_c    = htmlspecialchars($_POST['password_c']);
            $loterie       = isset($_POST['loterie']) ? 1 : 0;
            $role          = "user";

            // Validation des données
            $dateNaissanceObj = DateTime::createFromFormat('Y-m-d', $dateNaissance);
            $dateNow = new DateTime();
            $ageInterval = $dateNow->diff($dateNaissanceObj);
            if ($ageInterval->y < 18) {
                $errors[] = 'Vous devez avoir au moins 18 ans pour vous inscrire.';
            }

            $dateExpPassObj = DateTime::createFromFormat('Y-m-d', $dateExpPass);
            if ($dateExpPassObj < $dateNow) {
                $errors[] = 'La date d\'expiration du passeport est dépassée.';
            }

            if (strlen($numPass) > 14) {
                $errors[] = 'Le numéro de passeport ne doit pas dépasser 14 caractères.';
            }

            if (strlen($password) < 8) {
                $errors[] = 'Le mot de passe doit comporter au moins 8 caractères.';
            }

            if ($m->emailExists($email)) {
                $errors[] = 'L\'adresse e-mail existe déjà.';
            }

            if ($m->numPassExists($numPass)) {
                $errors[] = 'Le passeport est déjà enregistré.';
            }

            if ($password != $password_c) {
                $errors[] = 'Les mots de passe ne sont pas identiques.';
            }

            if (empty($errors)) {
                // Hashage du mot de passe
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

                // Création de l'utilisateur
                $userId = $m->createUser($nom, $prenom, $email, $id_nation, $numPass, $dateExpPass, $dateNaissance, $passwordHashed, $loterie, $role);
                if ($userId) {
                    $user = $m->findUserByEmail($email);
                
                    // Stocker les informations de l'utilisateur dans la session
                    $_SESSION['login']  = 1;
                    $_SESSION['id']     = $user['id_utilisateur'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['role']   = $user['role'];

                    // Définir le message de succès et l'URL de redirection
                    $successMsg = 'Votre compte a bien été créé. Vous allez être redirigé...';

                    if ($user['role'] == 'admin') {
                        $redirectUrl = '?controller=admin';
                    } else {
                        $redirectUrl = '?controller=user';
                    }

                    // Passer les données à la vue et arrêter le script
                    $data = [
                        'successMsg'    => $successMsg,
                        'errorMessages' => '',
                        'nations'       => $nations,
                        'redirectUrl'   => $redirectUrl,
                    ];
                    $this->render('signup', $data);
                    exit();
                } else {
                    $errors[] = 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.';
                }
            }
        }

        // Concaténer les erreurs pour les afficher dans la vue
        $errorMessages = '';
        if (!empty($errors)) {
            $errorMessages = '<div class="alert alert-danger" style="text-align: center;">' . implode('<br>', $errors) . '</div>';
        }

        // Passer les données à la vue
        $data = [
            'successMsg'    => $successMsg,
            'errorMessages' => $errorMessages,
            'nations'       => $nations,
            'redirectUrl'   => '',
        ];
        $this->render('signup', $data);
    }

    public function action_default()
    {
        $this->action_signup();
    }
}
