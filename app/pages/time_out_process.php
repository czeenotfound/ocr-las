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
    function redirect($page){
        header('location: '. ROOT_URL .$page);
        die();
    }
    require '../app/configdb/dbconnection.php';

    if(isset($_POST['submit'])) {
        $id = $_POST['id_number'];
        $purpose_id = filter_var($_POST['purpose_id'], FILTER_SANITIZE_NUMBER_INT);
        $schoolyear = $_POST['schoolyear'];

        date_default_timezone_set('Asia/Hong_Kong');
        $current_timestamp = time();
        $time = date("h:i:s A", $current_timestamp); // Format as AM/PM time
        $date = date('Y-m-d', $current_timestamp);
        $time_suffix = date("A", $current_timestamp); // Get AM/PM indicator

        // Check if there's any record associated with the provided ID number
        $query = "SELECT * FROM students WHERE student_id = ? UNION SELECT * FROM faculty WHERE faculty_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ss", $id, $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['last_name'] . ', ' . $row['first_name'] .' '. $row['middle_name'] ;

            // Check if there's an existing attendance record for the ID for the current date and period (AM/PM)
            $attendance_query = "SELECT * FROM attendance WHERE id_number=? AND date=? AND period=? AND status='0'";
            $stmt = mysqli_prepare($connection, $attendance_query);
            mysqli_stmt_bind_param($stmt, "sss", $id, $date, $time_suffix);
            mysqli_stmt_execute($stmt);
            $attendance_result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($attendance_result) > 0){
                // If there's an existing record, update the time out
                $sql = "UPDATE attendance SET time_out=?, status='1' WHERE id_number=? AND date=? AND period=?";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $time, $id, $date, $time_suffix);
                mysqli_stmt_execute($stmt);
                $_SESSION['input_success'] = 'Successfully Time Out: '.$name;
            } else{
                // If no existing record, show error message
                $_SESSION['input_failed'] = 'Cannot time out '.$name.'. Time in record not found.';
            }   
            redirect('home'); 
            exit();
        } else {
            $_SESSION['input_failed'] = "Cannot find ID number";
            redirect('home');
        }
    } else {
        redirect('home');
    }
?>
