<?php

session_start(); //Init la session
session_unset(); //Desactiver la session
session_destroy();//Detruit la session
header("location: index.php");//redirection

?>