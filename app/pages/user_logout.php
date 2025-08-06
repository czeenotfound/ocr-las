<?php 
    require '../app/configdb/constants.php';

    session_destroy();

    header('location: ' . ROOT_URL  . 'adminLogin');
    die();