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
    header('location: '. ROOT_URL . $page);
    die();
}

require '../app/configdb/dbconnection.php';

if(isset($_POST['submit'])) {
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $mobile = filter_var($_POST['mobile'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $purpose_id = filter_var($_POST['purpose_id'], FILTER_SANITIZE_NUMBER_INT);
    $schoolyear = $_POST['schoolyear'];
    $semester = $_POST['semester'];
 

    if(!$first_name) {
        $_SESSION['add_visitor'] = "Please enter your first name";
    } elseif(!$middle_name) {
        $_SESSION['add_visitor'] = "Please enter your middle name";
    } elseif(!$last_name) {
        $_SESSION['add_visitor'] = "Please enter last name";
    } elseif(!$gender) {
        $_SESSION['add_visitor'] = "Select a gender";
    } elseif(!$mobile) {
        $_SESSION['add_visitor'] = "Please enter your Mobile Number";
    } 
    

    if($_SESSION ['add_visitor']) { 
        $_SESSION['add_visitor_data'] = $_POST;
        $_SESSION['show_modal'] = true;  // Set a flag to trigger the modal on page load
        redirect('home');
    } else{
        date_default_timezone_set('Asia/Hong_Kong');
        $current_timestamp = time();
        $time = date("h:i:s A", $current_timestamp); // Format as AM/PM time
        $date = date('Y-m-d', $current_timestamp);
        $time_suffix = date("A", $current_timestamp); // Get AM/PM indicator

        // Generate random id_number
        $id_number = uniqid();

        // Insert visitor into visitors table
        $insert_visitor_query = "INSERT INTO visitors (visitor_id, first_name, middle_name, last_name, gender, mobile, created_date) VALUES ('$id_number', '$first_name', '$middle_name', '$last_name', '$gender', '$mobile' , '$date')";
        $insert_visitor_result = mysqli_query($connection, $insert_visitor_query);

        if($insert_visitor_result) {
            // Retrieve the inserted visitor's full name
            $get_visitor_query = "SELECT first_name, middle_name, last_name FROM visitors WHERE visitor_id = '$id_number'";
            $get_visitor_result = mysqli_query($connection, $get_visitor_query);

            if(mysqli_num_rows($get_visitor_result) > 0) {
                $visitor_row = mysqli_fetch_assoc($get_visitor_result);
                $visitor_full_name = $visitor_row['first_name'] . ' ' . $visitor_row['middle_name'] . ' ' . $visitor_row['last_name'];

                // Insert visitor's attendance record
                $insert_attendance_query = "INSERT INTO attendance (id_number, time_in, date, period, purpose_id, schoolyear, semester, status) VALUES ('$id_number', '$time', '$date', '$time_suffix', '$purpose_id', '$schoolyear', '$semester', '0')";
                $insert_attendance_result = mysqli_query($connection, $insert_attendance_query);

                if($insert_attendance_result) {
                    $_SESSION['input_success'] = 'Successfully Time In: '.$visitor_full_name;
                } else {
                    $_SESSION['input_failed'] = "Error adding visitor's attendance record";
                }
            } else {
                $_SESSION['input_failed'] = "Error retrieving visitor's full name";
            }
        } else {
            $_SESSION['input_failed'] = "Error adding visitor";
        }
    }

    redirect('home');
} else {
    redirect('home');
}
?>
