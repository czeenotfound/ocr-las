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
        $purpose_id = $_POST['purpose_id'];
        $custom_purpose = isset($_POST['other_purpose']) ? trim($_POST['other_purpose']) : '';
        $schoolyear = $_POST['schoolyear'];
        $semester = $_POST['semester'];

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
                // If there's an existing record, show error message
                $_SESSION['input_failed'] = 'Attendance already recorded for '.$name;
            } else{
                // If 'Others' is selected, insert the custom purpose and use its ID
                if ($purpose_id === 'other' && $custom_purpose !== '') {
                    $stmt = mysqli_prepare($connection, "INSERT INTO purpose (description) VALUES (?)");
                    mysqli_stmt_bind_param($stmt, "s", $custom_purpose);
                    mysqli_stmt_execute($stmt);
                    $purpose_id = mysqli_insert_id($connection);
                } else {
                    $purpose_id = filter_var($purpose_id, FILTER_SANITIZE_NUMBER_INT);
                }
                // Insert a new attendance record with status 0 (time-in) using the database ID format
                $sql = "INSERT INTO attendance(id_number, time_in, date, period, purpose_id, schoolyear, semester, status) VALUES(?, ?, ?, ?, ?, ?, ?, '0')";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "sssssss", $db_id, $time, $date, $time_suffix, $purpose_id, $schoolyear, $semester);
                if(mysqli_stmt_execute($stmt)){
                    $_SESSION['input_success'] = 'Successfully Time In: '.$name;
                }
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
