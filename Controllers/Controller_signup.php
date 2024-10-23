<?php

class Controller_signup extends Controller{

    public function action_signup()
    {

        $m      = Model::getModel();
        $nations = $m->getNation();

        $errors = [];
        $successMsg = '';

        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['nations']) && !empty($_POST['numPass']) && !empty($_POST['dateExpPass']) && !empty($_POST['dateNaissance']) && !empty($_POST['password']) && !empty($_POST['password_c'])) {
            $nom           = htmlspecialchars($_POST['nom']);
            $prenom        = htmlspecialchars($_POST['prenom']);
            $email         = htmlspecialchars($_POST['email']);
            $nationalite   = htmlspecialchars($_POST['nations']);
            $numPass       = htmlspecialchars($_POST['numPass']);
            $dateExpPass   = htmlspecialchars($_POST['dateExpPass']);
            $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
            $password      = htmlspecialchars($_POST['password']);
            $password_c    = htmlspecialchars($_POST['password_c']);
            $loterie       = isset($_POST['loterie']) ? 1 : 0;
            $role          = "user";

            $m = Model::getModel();

            // Vérifier que l'utilisateur a au moins 18 ans
            $dateNaissanceObj = DateTime::createFromFormat('Y-m-d', $dateNaissance);
            $dateNow = new DateTime();
            $ageInterval = $dateNow->diff($dateNaissanceObj);
            if ($ageInterval->y < 18) {
                $errors[] = 'Vous devez avoir au moins 18 ans pour vous inscrire.';
            }

            // Vérifier que la date d'expiration du passeport est dans le futur
            $dateExpPassObj = DateTime::createFromFormat('Y-m-d', $dateExpPass);
            if ($dateExpPassObj < $dateNow) {
                $errors[] = 'La date d\'expiration du passeport est dépassé.';
            }

            // Vérifier que le numéro de passeport a un maximum de 14 caractères
            if (strlen($numPass) > 14) {
                $errors[] = 'Le numéro de passeport ne doit pas dépasser 14 caractères.';
            }

            // Vérifier que le mot de passe a au moins 8 caractères et contient un caractère spécial
            if (strlen($password) < 8) {
                $errors[] = 'Le mot de passe doit comporter au moins 8 caractères.';
            }

            if ($m->emailExists($email)) {
                    $errors[] = 'Le mail existe déjà.';
            }

            if ($m->numPassExists($numPass)) {
                $errors[] = 'Le passeport est déjà enregistré.';
            }

            if ($password != $password_c) {
                $errors[] = 'Les mots de passe ne sont pas identiques.';
            }

            if (empty($errors)) {
                // Hashage du mot de passe avant de le stocker
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

                // Créer l'utilisateur avec le mot de passe haché
                $userId = $m->createUser($nom, $prenom, $email, $nationalite, $numPass, $dateExpPass, $dateNaissance, $passwordHashed, $loterie, $role);
                if ($userId) {
                    $user = $m->findUserByEmail($email);
                
                    // Démarrer la session
                    session_start();
                
                    // Stocker les informations de l'utilisateur dans la session
                    $_SESSION['login']  = 1;
                    $_SESSION['id']     = $user['id_utilisateur'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['role']   = $user['role'];  // Stocke le rôle de l'utilisateur
                
                    // Afficher un message de succès pendant 2 secondes
                    echo '<p style="color:green; text-align:center;">Votre compte a bien été créé. Vous allez être redirigé...</p>';
                
                    // Délai de 2 secondes avant la redirection
                    echo '<meta http-equiv="refresh" content="2">';
                
                    // Vérification du rôle et redirection
                    if ($user['role'] == 'admin') {
                        // Rediriger vers la page admin après 2 secondes
                        header("Refresh: 2; URL=?controller=admin");
                    } else {
                        // Rediriger vers la page utilisateur après 2 secondes
                        header("Refresh: 2; URL=?controller=user");
                    }
                    
                    exit();
                } else {
                    $errors[] = 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.';
                }
                
            }
            
        }

        // Concaténer toutes les erreurs dans un seul message à afficher dans la vue
        $errorMessages = '';
        if (!empty($errors)) {
            $errorMessages = '<div class="alert alert-danger" style="text-align: center;">' . implode('<br>', $errors) . '</div>';
        }

        /**
        * Affiche la vue
        * @param 'signup' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = [
            'successMsg'    => $successMsg,
            'errorMessages' => $errorMessages,
            'nations'       => $nations
        ];
        $this->render('signup', $data);
    }

    /**
     * Affiche l'action home par defaut
     */
    public function action_default()
    {
        $this->action_signup();
    }
}
