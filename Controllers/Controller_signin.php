<?php 
class Controller_signin extends Controller{

    public function action_signin() {
        $errorLogin = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST["email"]) && !empty($_POST["password"])) {
                $email    = strtolower(trim(htmlspecialchars($_POST["email"])));
                $password = htmlspecialchars($_POST["password"]);

                $m    = Model::getModel();
                $user = $m->findUserByEmail($email);

                if ($user !== false) {
                    if (password_verify($password, $user['password'])) {
                        // Authentification réussie
                        $_SESSION['login']  = 1;
                        $_SESSION['id']     = $user['id_utilisateur'];
                        $_SESSION['prenom'] = $user['prenom'];
                        $_SESSION['role']   = $user['role'];

                        // Redirection en fonction du rôle
                        if ($user['role'] == 'admin') {
                            header('Location: ?controller=admin');
                            exit();
                        } elseif ($user['role'] == 'user') {
                            header('Location: ?controller=user');
                            exit();
                        } else {
                            // Si le rôle est inconnu, rediriger vers la page d'accueil ou afficher une erreur
                            header('Location: ?controller=home');
                            exit();
                        }
                    } else {
                        // Mot de passe incorrect
                        $errorLogin = '<div style="color:red; text-align:center;">Mot de passe incorrect.</div>';
                    }
                } else {
                    // Utilisateur non trouvé
                    $errorLogin = '<div style="color:red; text-align:center;">Adresse e-mail non trouvée.</div>';
                }
            } else {
                // Champs manquants
                $errorLogin = '<div style="color:red; text-align:center;">Veuillez remplir tous les champs.</div>';
            }
        }

        // Affichage du formulaire avec le message d'erreur s'il y a lieu
        $data = ['errorLogin' => $errorLogin];
        $this->render('signin', $data);
    }

    public function action_default()
    {
        $this->action_signin();
    }
}
