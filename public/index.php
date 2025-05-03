<!--
    /* 
    * Copyright (C) 2024 SURV Co. - All Rights Reserved
    * 
    * OCR-Library Attendance System
    *
    * IT 132 - Software Engineering
    * (SURV Co.) Members:
    * Sanguila, Mary Joy
    * Undo, Khalil M.
    * Rodrigo, Jondino  
    * Vergara, Kayce
    *
    */
 -->

<?php
     // echo "Home Page!";
    $url = $_GET['url'] ?? 'home';
    $url = strtolower($url);
    $url = explode("/", $url);

    $page_name = trim($url[0]);

    $filename = "../app/pages/".$page_name.".php";

    if (file_exists($filename)) {
        require_once $filename;
    } else {
        require_once "../app/pages/404.php";
    }