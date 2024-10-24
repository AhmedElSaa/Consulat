<?php

class Controller_admin extends Controller{

    public function action_remove()
    {
        // Vérifier si l'utilisateur est connecté et s'il est administrateur
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
            header('Location: ?controller=signin');
            exit();
        }

        if (isset($_GET['id_utilisateur']) && preg_match('/^[1-9]\d*$/', $_GET['id_utilisateur'])) {
            $id = $_GET['id_utilisateur'];

            $m = Model::getModel();
            $userToDelete = $m->findUserById($id);

            if ($userToDelete !== false && $userToDelete['role'] != 'admin') {
                // Procéder à la suppression uniquement si l'utilisateur n'est pas un administrateur
                $m->removeUsers($id);
            }
        }

        // Rediriger vers la page admin après l'opération
        header('Location: ?controller=admin');
        exit();
    }

    public function action_admin()
    {
        // Vérifier si l'utilisateur est connecté et s'il est administrateur
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
            header('Location: ?controller=signin');
            exit();
        }

        $m = Model::getModel();
        $users = $m->listUsers();

        // Récupérer le prénom de l'utilisateur connecté
        $welcome = htmlspecialchars($_SESSION['prenom']);

        $data = [
            'welcome' => $welcome,
            'users'   => $users
        ];
        $this->render('admin', $data);
    }

    public function action_default()
    {
        $this->action_admin();
    }
}
