<?php
    require '../app/configdb/constants.php';

    $username = $_SESSION['login-data']['username'] ?? null;
    $password = $_SESSION['login-data']['password'] ?? null;

    unset($_SESSION['login-data']);
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
    <title>Admin | Log In</title>
</head>
<body>
    <!-- =========== NavBar ==============  -->
    <nav class="navbar navbar-expand px-3 border-bottom">
        
        <div class="navbar-collapse navbar">
            <div class="sidebar-logo text-start d-flex align-items-center gap-3">
                <img src="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png" alt="" class="" width="50px">
                <div class="d-flex flex-column">
                    <span class="text-white">WMSU Library</span>
                    <a href="#" class="text-white">OCR-Library Attendace System</a>
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

    <!-- =========== Header ==============  -->
    <header id="signin" class="mt-5 d-flex align-items-center justify-content-center">
        <div class="login-box">
            <div class="m-3 text-center">
                 <img src="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png" alt="" class="" width="140px">
            </div>
            <h2 class="text-center mb-4">Log In</h2>

            <?php if (isset($_SESSION ['user_register-success'])): ?>
                <div class="alert alert-success messages w-100 n">
                    <?= $_SESSION['LoginPage'];
                        unset($_SESSION['LoginPage']);
                    ?>
                </div>
            <?php elseif(isset($_SESSION ['LoginPage'])): ?>
                <div class="alert alert-danger messages w-100 n">
                    <?= $_SESSION['LoginPage'];
                        unset($_SESSION['LoginPage']);
                    ?>
                </div>
            <?php elseif(isset($_SESSION ['LoginPage'])): ?>
                <div class="alert alert-danger messages w-100 n">
                    <?= $_SESSION['LoginPage'];
                        unset($_SESSION['LoginPage']);
                    ?>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>user_login" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" placeholder="Enter your password">
                </div>
                
                <button type="submit" name="submit" class="btn-signin btn-primary w-100 fw-bold fs-5">Sign In</button>
            </form>
        </div>
    </header>
    <!-- =========== End of NavBar ==============  -->

    <!-- =========== Footer ============== -->

    <!-- =========== End of Footer ============== -->

    <!-- Jquery -->
    <script src="<?= ROOT_URL ?>/assets/JS/jquery-3.7.1.js"></script>
    <!-- JavaScript & bootstrap JS-->
    <script src="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>