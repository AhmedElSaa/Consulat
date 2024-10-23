<?php

class Controller_user extends Controller{

    public function action_user()
    {
        session_start();

        // Vérifier si l'utilisateur est connecté et si c'est un "user"
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
            header('Location: ?controller=signin');
            exit();
        }

        // Le reste du code pour afficher la page utilisateur

        
        // Récupérer le prénom de l'utilisateur connecté
        $welcome = htmlspecialchars($_SESSION['prenom']);

        /**
        * Affiche la vue
        * @param 'user' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = ['welcome' => $welcome];
        $this->render('user', $data);
    }

    /**
     * Affiche l'action user par défaut
     */
    public function action_default()
    {
        $this->action_user();
    }
}
