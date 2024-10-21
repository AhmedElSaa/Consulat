<?php

class Controller_visa extends Controller{

    public function action_visa()
    {

        /**
        * Affiche la vue
        * @param 'visa' nom de la vue
        * @param array $data tableau contenant les données à passer à la vue
        */
        $data = [];
        $this->render('visa', $data);
    }

    /**
     * Affiche l'action home par defaut
     */
    public function action_default()
    {
        $this->action_visa();
    }
}