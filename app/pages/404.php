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
    require '../app/configdb/constants.php';

?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/TimeInTimeOut.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/fontawesome-free-6.5.1/css/all.min.css"/>
    <title>404 NOT FOUND</title>
</head>
<body>
    <!-- =========== NavBar ==============  -->
    <nav class="navbar navbar-expand px-3 border-bottom">
        
        <div class="navbar-collapse navbar">
            <div class="sidebar-logo text-start d-flex align-items-center gap-3">
                <img src="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png" alt="" class="" width="50px">
                <div class="d-flex flex-column">
                    <span class="text-white">WMSU Library</span>
                    <a href="<?= ROOT_URL ?>home" class="text-white">OCR-Library Attendace System</a>
                </div>
                
            </div>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="<?= ROOT_URL ?>home" class="d-flex align-items-center justify-content-center text-white bg-dark rounded-circle" style="width:40px; height:40px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Admin">
                     <i class="fa-solid fa-chevron-left" style="font-size: 1rem;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- =========== End of NavBar ==============  -->
    <div class="container text-center mt-5">
        <h1>404 PAGE NOT FOUND!</h1>
    </div>
    

    <!-- Jquery -->
    <script src="<?= ROOT_URL ?>/assets/JS/jquery-3.7.1.js"></script>
    <!-- JavaScript & bootstrap JS-->
    <script src="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>