<?php

class Controller_signup extends Controller{

    public function action_signup()
    {

        $m      = Model::getModel();
        $nations = $m->getNation();

        $errorMail  = '';
        $errorMdp   = '';
        $errorCreation = '';
        $successMsg = '';

        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_c'])) {
            $nom           = htmlspecialchars($_POST['nom']);
            $prenom        = htmlspecialchars($_POST['prenom']);
            $email         = htmlspecialchars($_POST['email']);
            $nationalite   = htmlspecialchars($_POST['nations']);
            $numPass       = htmlspecialchars($_POST['numPass']);
            $dateExpPass   = htmlspecialchars($_POST['dateExpPass']);
            $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
            $password      = htmlspecialchars($_POST['password']);
            $password_c    = htmlspecialchars($_POST['password_c']);
            $loterie       = htmlspecialchars($_POST['loterie']);

            
            $m = Model::getModel();

            if ($m->emailExists($email)) {
                $errorMail = '<p style="color:red; text-align:center;">Le mail existe deja.</p>';
            } else if ($password != $password_c) {
                $errorMdp = '<p style="color:red; text-align:center;">Les mots de passe ne sont pas identique.</p>';
            } else {
                $m = Model::getModel();
                $userId = $m->createUser($nom, $prenom, $email, $nationalite, $numPass, $dateExpPass, $dateNaissance, $password, $loterie);
                if ($userId) {
                    $successMsg = '<p style="color:green; text-align:center;">Votre compte a été créé. Connectez-vous <a href="?controller=signin">ICI</a></p>';
                } else {
                    $errorCreation = '<p style="color:red; text-align:center;">Une erreur est survenue lors de la création du compte. Veuillez réessayer.</p>';
                }
            }
        }

        /**
        * Affiche la vue
        * @param 'signup' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = [
            'successMsg' => $successMsg,
            'errorMail'  => $errorMail,
            'errorMdp'   => $errorMdp,
            'errorCreation' => $errorCreation,
            'nations' => $nations
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