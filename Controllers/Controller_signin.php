<?php 
class Controller_signin extends Controller{

    public function action_signin() {
        $errorLogin   = "";
        $successLogin = "";

        if (!empty($_POST["email"]) && !empty($_POST["password"])) {
            $email    = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);
            
            $password = 'aq1'.sha1($password.'1524').'25';

            $m        = Model::getModel();
            $user     = $m->findUserByEmail($email);
            $userRole = $m->getUserAndRole($email);
            
            if ($user !== false && $password == $user['password']) {
                // Logique pour authentifier l'utilisateur
                $_SESSION['login'] = 1;
                $_SESSION['id'] = $user['id_utilisateur'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['role'] = $userRole['role'];

                if ($userRole['role'] == 'admin') {
                    header('Location: ?controller=admin');
                    exit();
                } elseif ($userRole['role'] == 'user') {
                    header('Location: ?controller=user');
                    exit();
                }

                $successLogin = '<div style="color:green; text-align:center;">Vous êtes maintenant connecté.</div>';
            } else {
                $errorLogin = '<div style="color:red; text-align:center;">Mail ou mot de passe incorect.</div>';
            }
        }
        $data = ['errorLogin' => $errorLogin, 'successLogin' => $successLogin];
        $this->render('signin', $data);
    }

    public function action_default()
    {
        $this->action_signin() ;
    }
}