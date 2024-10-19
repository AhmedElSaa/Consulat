<?php

class Controller_home extends Controller{

    public function action_home()
    {



        /**
        * Affiche la vue
        * @param 'home' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = [];
        $this->render('home', $data);
    }

    /**
     * Affiche l'action home par defaut
     */
    public function action_default()
    {
        $this->action_home();
    }
}