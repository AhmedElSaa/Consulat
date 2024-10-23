<?php

class Controller_admin extends Controller{

    public function action_admin()
    {
        // Vérifier si l'utilisateur est connecté et si c'est un "admin"
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
            header('Location: ?controller=signin');
            exit();
        }

        // Récupérer le prénom de l'utilisateur connecté
        $welcome = htmlspecialchars($_SESSION['prenom']);

        $data = ['welcome' => $welcome];
        $this->render('admin', $data);
    }

    public function action_default()
    {
        $this->action_admin();
    }
}
