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
    function currentschoolyear(){
        $currentYear = date('Y');
        // $testMonth = 9; // Example: September

        // // Use the specified test month if set, otherwise use the current month
        // $month = isset($testMonth) ? $testMonth : date('n');

		return (in_array(date('n'),array(7,8,9,10,11,12))) ? $currentYear . "-" . ($currentYear + 1) : ($currentYear - 1) . "-" . $currentYear;
    }
    function currentSemester() {
        $month = date('n');
        // $testMonth = 6; // Example: September
        // $month = isset($testMonth) ? $testMonth : date('n');

        if ($month >= 1 && $month <= 5) {
            return "2nd"; // Second semester from January to May
        } elseif ($month >= 7 && $month <= 12) {
            return "1st"; // First semester from June to December
        } else {
            return "Summer"; // Summer classes in June
        }
    }

    function ordinal($number) {
        $suffix = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if (($number % 100) >= 11 && ($number % 100) <= 13) {
            return $number . 'th';
        } else {
            return $number . $suffix[$number % 10];
        }
    }
    function isCurrentlyOpen() {
        // Get current time
        $currentTime = strtotime(date('H:i'));
    
        // Define opening and closing times
        $openingTime = strtotime('08:00');
        $closingTime = strtotime('17:00');
    
        // Check if current time is within opening hours
        if ($currentTime >= $openingTime && $currentTime <= $closingTime) {
            return true; // It's open
        } else {
            return false; // It's closed
        }
    }
    require '../app/configdb/dbconnection.php';

    date_default_timezone_set('Asia/Hong_Kong');
    // Get the current timestamp
    $current_timestamp = time();
    $date = date('Y-m-d', $current_timestamp);
    $currentYear = date('Y');

    // invisible
    $attendance_query  = "SELECT *, 'student' AS type FROM students 
                          LEFT JOIN attendance ON students.student_id = attendance.id_number
                          WHERE date = '$date' 
                          UNION
                          SELECT *, 'faculty' AS type FROM faculty 
                          LEFT JOIN attendance ON faculty.faculty_id = attendance.id_number
                          WHERE date = '$date' 
                          ORDER BY IFNULL(time_out, time_in) DESC";
    $attendance_result = mysqli_query($connection, $attendance_query);

    $visitor_query = "SELECT *, 'visitor' AS type FROM visitors 
                  LEFT JOIN attendance ON visitors.visitor_id = attendance.id_number
                  WHERE date = '$date'
                  ORDER BY IFNULL(time_out, time_in) DESC";
    $visitor_result = mysqli_query($connection, $visitor_query);

    // visible in modal
    $attendance_query1  = "SELECT *, 'student' AS type FROM students 
                          LEFT JOIN attendance ON students.student_id = attendance.id_number
                          WHERE date = '$date' 
                          UNION
                          SELECT *, 'faculty' AS type FROM faculty 
                          LEFT JOIN attendance ON faculty.faculty_id = attendance.id_number
                          WHERE date = '$date' 
                          ORDER BY IFNULL(time_out, time_in) DESC";
    $attendance_result1 = mysqli_query($connection, $attendance_query1);

    $visitor_query1 = "SELECT *, 'visitor' AS type FROM visitors 
                  LEFT JOIN attendance ON visitors.visitor_id = attendance.id_number
                  WHERE date = '$date'
                  ORDER BY IFNULL(time_out, time_in) DESC";
    $visitor_result1 = mysqli_query($connection, $visitor_query1);

    $visitorquery = "SELECT * FROM visitors WHERE created_date = '$date'";
    $visitors = mysqli_query($connection, $visitorquery);

    $purposequery = "SELECT * FROM purpose";
    $visitors_purposes = mysqli_query($connection, $purposequery);

    $purposequery = "SELECT * FROM purpose";
    $student_faculty_purposes = mysqli_query($connection, $purposequery);

    
    $year = isset($_SESSION['year']) ? $_SESSION['year'] : '';
    $display_year = '';

    if ($year >= 1 && $year <= 5) {
        $display_year = ordinal($year);
    } else {
        $display_year = $year;
    }
?>
 
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/datatables/dataTables.dataTables.css">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/CSS/TimeInTimeOut.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>/assets/fontawesome-free-6.5.1/css/all.css"/>
    <link rel="icon" href="<?= ROOT_URL ?>/assets/images/wmsulibraryLogo.png"/>
    <title>OCR-LAS | Time in & Time out</title>

</head>
<body>
    <!-- Navbar -->
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
                    <a id="admin" href="<?= ROOT_URL ?>adminLogin" class="d-flex align-items-center justify-content-center text-white bg-dark rounded-circle" style="width:40px; height:40px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Admin">
                        <i class="fa-solid fa-user-tie" style="font-size: 1rem;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End of Navbar -->