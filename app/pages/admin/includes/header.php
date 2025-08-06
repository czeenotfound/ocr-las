<!--
    /* 
    * Copyright (C) 2025 SURV Co. - All Rights Reserved
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
    require '../app/configdb/dbconnection.php';

    // fetch user data from database
    // if user is in session
    if (isset($_SESSION['user-id'])) {
        $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT username FROM users WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $avatar = mysqli_fetch_assoc($result);
    } else {
        session_destroy();
        header('location: ' . ROOT_URL . 'adminLogin'); // RESTRICTING USER TO ACCESS TO THE WEBSITE NEED TO LOGIN SESSION FIRST
    }

    // Check if the user has uploaded an avatar
    if (!empty($avatar['avatar'])) {
        $avatarPath = ROOT_URL . 'assets/images/' . $avatar['avatar'];
    } else {
    // If the user doesn't have an avatar, use the default image
        $avatarPath = ROOT_URL . 'assets/images/icons8-male-user-96.png';
    }

    // Course
    $name= $_SESSION['add_course'] ?? null;
    unset($_SESSION['add-course-data']);
    
    $query = "SELECT * FROM department";
    $department_ids = mysqli_query($connection, $query);

    $yearlevelquery = "SELECT * FROM students_year_level";
    $yearlevels = mysqli_query($connection, $yearlevelquery);
    // Department
    $coursequery = "SELECT * FROM course";
    $courses = mysqli_query($connection, $coursequery);

    $departmentquery = "SELECT * FROM department";
    $departments = mysqli_query($connection, $departmentquery);

    $course_query = "SELECT * FROM course";
    $courses_faculty = mysqli_query($connection, $course_query);

    $current_user_id = $_SESSION['user-id'];
    
    $query = "SELECT id FROM users WHERE id=$current_user_id";
    $profile_result = mysqli_query($connection, $query);
    $profile_users = mysqli_fetch_assoc($profile_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    
    <!-- DATATABLES CSS-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/datatables/dataTables.dataTables.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/datatables/buttons.dataTables.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/datatables/dataTables.bootstrap5.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/main.css">
    
    <!-- fontawesome -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/fontawesome-free-6.5.1/css/all.css" />
    <link rel="icon" href="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png"/>
    <title>OCR-LAS SE</title>
</head>
<body>

    <div class="wrapper">
        <!-- ========= Sidebar ========= -->
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo text-center gap-3 d-flex align-items-center justify-content-center">
                    <img src="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png">
                    <div class="d-flex flex-column text-start">
                        <span class="text-white">WMSU Library</span>
                        <a href="<?= ROOT_URL ?>admin/dashboard" class="text-white">OCR-Library Attendace System</a>
                    </div>
                </div>
                
                <ul class="sidebar-nav">
                    <?php if (isset($_SESSION['user-id'])) : ?>
                    <li class="mb-3">
                        <a href="<?= ROOT_URL ?>admin/profile/?id=<?= $profile_users['id'] ?>" class="profile">
                            <div class="profile-pic">
                                <img src="<?= $avatarPath ?>" alt="">
                            </div>
                            <div class="handle">
                                <span class="text-capitalize"><?= ($_SESSION['first_name'])?>
                                    <span class="d-block text-muted">
                                        <?php
                                            switch ($_SESSION['status']) {
                                                case 0:
                                                    echo '<i class="fa-solid fa-ban text-danger"></i> Disabled';
                                                    break;
                                                case 1:
                                                    echo 'Staff';
                                                    break;
                                                case 2:
                                                    echo 'Admin';
                                                    break;
                                                default:
                                                    echo 'Unknown';
                                            }
                                        ?>
                                    </span>
                                </span>
                            </div>
                        </a>
                    </li>
                    <?php endif ?>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/dashboard" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/students" class="sidebar-link">
                            <i class="fa-solid fa-users pe-2"></i>
                            Students
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/faculty" class="sidebar-link">
                            <i class="fa-solid fa-users pe-2"></i>
                            Faculty
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/visitor" class="sidebar-link">
                            <i class="fa-solid fa-users pe-2"></i>
                            Visitors
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-file-lines pe-2"></i>
                            Attendance
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="<?= ROOT_URL ?>admin/dtr" class="sidebar-link">Daily Time Record</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="<?= ROOT_URL ?>admin/dtrSummary" class="sidebar-link">DTR Summary</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-header">
                        Maintainance
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/course" class="sidebar-link">
                        <i class="fa-solid fa-graduation-cap pe-2"></i>
                            Course
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= ROOT_URL ?>admin/department" class="sidebar-link">
                            <i class="fa-solid fa-building pe-2"></i>
                            Department
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-sliders pe-2"></i>
                            Report Generator
                        </a>
                        <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="<?= ROOT_URL ?>admin/attendanceReport" class="sidebar-link">Attendance</a>
                            </li>
                        </ul>
                    </li>
    
                </ul>
            </div>
        </aside>
        <!-- ========= End of Sidebar ========= -->

        <!-- ========= Main Section ========= -->
        <div class="main">
            <!-- Navbar -->
            <nav class="navbar navbar-expand navbar-light px-3 border-bottom">
                <button class="btn fs-5" id="sidebar-toggle" type="button" >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Profile Config -->
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0 ">
                                <img src="<?= $avatarPath ?>" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a> -->
                                <a href="<?= ROOT_URL ?>admin/profile/?id=<?= $profile_users['id'] ?>" class="dropdown-item"><i class="fa-solid fa-user"></i> Profile</a>    
                                <?php if(isset($_SESSION['user_is_admin'])) : ?>   
                                    <a href="<?= ROOT_URL ?>admin/user-accounts" class="dropdown-item"><i class="fa-solid fa-user-tie"></i> Users Account</a>
                                <?php endif ?>  
                                <!-- <a href="<?= ROOT_URL ?>admin/user-accounts" class="dropdown-item"><i class="fa-solid fa-user-tie"></i> Users Account</a> -->
                                <a href="<?= ROOT_URL ?>admin/settings" class="dropdown-item"><i class="fa-solid fa-gear"></i> Settings</a>    
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- End of Navbar Profile Config -->
            </nav>
            <!-- End of Navbar -->