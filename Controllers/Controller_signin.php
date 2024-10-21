<?php

class Controller_signin extends Controller{

    public function action_signin()
    {



        /**
        * Affiche la vue
        * @param 'signin' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = [];
        $this->render('signin', $data);
    }

    /**
     * Affiche l'action home par defaut
     */
    public function action_default()
    {
        $this->action_signin();
    }
}