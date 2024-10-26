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

            if ($userToDelete !== false && $userToDelete['nation'] != 'Égypte') { // Vérifie la nationalité
                // Procéder à la suppression uniquement si l'utilisateur n'est pas égyptien
                $m->removeUsers($id);
            }
        }

        // Rediriger vers la page admin après l'opération
        header('Location: ?controller=admin');
        exit();
    }

    public function action_draw()
    {
        // Vérifier si l'utilisateur est connecté et s'il est administrateur
        if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
            header('Location: ?controller=signin');
            exit();
        }

        $m = Model::getModel();
        $participantsCount = $m->countParticipants();

        // Vérifier s'il y a au moins 50 participants
        if ($participantsCount >= 50) {
            $winner = $m->selectRandomWinner();

            if ($winner !== false) {
                // Récupérer l'ID de la nationalité "Égyptienne"
                $egyptianNationId = $m->getNationIdByName('Égypte'); // Remplacez 'Egyptien' par le nom exact utilisé dans votre table

                if ($egyptianNationId !== false) {
                    // Mettre à jour la nationalité du gagnant en 'Égyptienne'
                    $m->updateUserNationality($winner['id_utilisateur'], $egyptianNationId);

                    // Stocker les informations du gagnant dans la session pour les afficher
                    $_SESSION['winnerEmail'] = $winner['email'];
                    $_SESSION['winnerName'] = $winner['prenom'] . ' ' . $winner['nom'];
                } else {
                    // Si l'ID de la nationalité 'Égyptienne' n'est pas trouvé
                    $_SESSION['errorMsg'] = 'La nationalité "Égyptienne" n\'a pas été trouvée dans la base de données.';
                }
            }
        } else {
            // Pas assez de participants
            $_SESSION['errorMsg'] = 'Il n\'y a pas assez de participants pour le tirage au sort (minimum 50 requis).';
        }

        // Rediriger vers la page admin pour afficher le résultat
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

        // Récupérer les messages d'erreur ou le gagnant
        $errorMsg = '';
        $winnerEmail = '';
        $winnerName = '';

        if (isset($_SESSION['errorMsg'])) {
            $errorMsg = $_SESSION['errorMsg'];
            unset($_SESSION['errorMsg']);
        }

        if (isset($_SESSION['winnerEmail'])) {
            $winnerEmail = $_SESSION['winnerEmail'];
            $winnerName = $_SESSION['winnerName'];
            unset($_SESSION['winnerEmail'], $_SESSION['winnerName']);
        }

        $data = [
            'welcome'     => $welcome,
            'users'       => $users,
            'errorMsg'    => $errorMsg,
            'winnerEmail' => $winnerEmail,
            'winnerName'  => $winnerName
        ];
        $this->render('admin', $data);
    }

    public function action_default()
    {
        $this->action_admin();
    }
}
