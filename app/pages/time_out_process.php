<?php
    function redirect($page){
        header('location: '. ROOT_URL .$page);
        die();
    }

    // Function to normalize ID number by removing hyphens
    function normalizeIdNumber($id) {
        return str_replace('-', '', $id);
    }

    // Function to add hyphens to ID number (for reverse matching)
    function addHyphensToId($id) {
        // If ID is 8 digits (like 202100645), add hyphen after 4th character
        if (strlen($id) == 8 && is_numeric($id)) {
            return substr($id, 0, 4) . '-' . substr($id, 4);
        }
        return $id;
    }

    require '../app/configdb/dbconnection.php';

    if(isset($_POST['submit'])) {
        $id = $_POST['id_number'];
        $normalized_id = normalizeIdNumber($id); // Remove hyphens
        $hyphenated_id = addHyphensToId($id); // Add hyphens if needed
        $purpose_id = filter_var($_POST['purpose_id'], FILTER_SANITIZE_NUMBER_INT);
        $schoolyear = $_POST['schoolyear'];

        date_default_timezone_set('Asia/Hong_Kong');
        $current_timestamp = time();
        $time = date("h:i:s A", $current_timestamp); // Format as AM/PM time
        $date = date('Y-m-d', $current_timestamp);
        $time_suffix = date("A", $current_timestamp); // Get AM/PM indicator

        // Check if there's any record associated with the provided ID number (original, normalized, and hyphenated)
        $query = "SELECT * FROM students WHERE student_id = ? OR student_id = ? OR student_id = ? UNION SELECT * FROM faculty WHERE faculty_id = ? OR faculty_id = ? OR faculty_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $id, $normalized_id, $hyphenated_id, $id, $normalized_id, $hyphenated_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['last_name'] . ', ' . $row['first_name'] .' '. $row['middle_name'] ;
            
            // Use the original ID format from database for consistency
            $db_id = $row['student_id'] ?? $row['faculty_id'];

            // Check if there's an existing attendance record for the ID for the current date and period (AM/PM)
            $attendance_query = "SELECT * FROM attendance WHERE id_number=? AND date=? AND period=? AND status='0'";
            $stmt = mysqli_prepare($connection, $attendance_query);
            mysqli_stmt_bind_param($stmt, "sss", $db_id, $date, $time_suffix);
            mysqli_stmt_execute($stmt);
            $attendance_result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($attendance_result) > 0){
                // If there's an existing record, update the time out
                $sql = "UPDATE attendance SET time_out=?, status='1' WHERE id_number=? AND date=? AND period=?";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $time, $db_id, $date, $time_suffix);
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
