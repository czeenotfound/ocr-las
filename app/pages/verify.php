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
        // Remove any existing hyphens first
        $clean_id = str_replace('-', '', $id);
        
        // If ID is 8 digits (like 202100645), add hyphen after 4th character
        if (strlen($clean_id) == 8 && is_numeric($clean_id)) {
            return substr($clean_id, 0, 4) . '-' . substr($clean_id, 4);
        }
        // If ID is 9 digits (like 202100645), add hyphen after 4th character
        elseif (strlen($clean_id) == 9 && is_numeric($clean_id)) {
            return substr($clean_id, 0, 4) . '-' . substr($clean_id, 4);
        }
        return $id;
    }

    require '../app/configdb/dbconnection.php';

    // echo "hello World";
    if(isset($_POST['studentID'])) {
        $id = $_POST['studentID'];
        $normalized_id = normalizeIdNumber($id); // Remove hyphens
        $hyphenated_id = addHyphensToId($id); // Add hyphens if needed
    
        date_default_timezone_set('Asia/Hong_Kong');
        $current_timestamp = time();
        $time = date("h:i:s A", $current_timestamp); // Format as AM/PM time
        $date = date('Y-m-d', $current_timestamp);
        $time_suffix = date("A", $current_timestamp); // Get AM/PM indicator

        // Check if there's any record associated with the provided ID number (original, normalized, and hyphenated)
        $query_student = "SELECT * FROM students WHERE student_id = ? OR student_id = ? OR student_id = ?";
        $stmt_student = mysqli_prepare($connection, $query_student);
        mysqli_stmt_bind_param($stmt_student, "sss", $id, $normalized_id, $hyphenated_id);
        mysqli_stmt_execute($stmt_student);
        $result_student = mysqli_stmt_get_result($stmt_student);

        // Check if there's any record associated with the provided ID number in the faculty table (original, normalized, and hyphenated)
        $query_faculty = "SELECT * FROM faculty WHERE faculty_id = ? OR faculty_id = ? OR faculty_id = ?";
        $stmt_faculty = mysqli_prepare($connection, $query_faculty);
        mysqli_stmt_bind_param($stmt_faculty, "sss", $id, $normalized_id, $hyphenated_id);
        mysqli_stmt_execute($stmt_faculty);
        $result_faculty = mysqli_stmt_get_result($stmt_faculty);
        
        if(mysqli_num_rows($result_student) > 0) {
            $row = mysqli_fetch_assoc($result_student);
            $name = $row['last_name'] . ', ' . $row['first_name'] .' '. $row['middle_name'] ;
            $year = $row['yearlevel_id'];
            $section = $row['section'];

            $course_id = $row['course_id'];
            $department_id = $row['department_id'];

            // Query the course name
            $course_query = "SELECT name FROM course WHERE id=?";
            $stmt_course = mysqli_prepare($connection, $course_query);
            mysqli_stmt_bind_param($stmt_course, "i", $course_id);
            mysqli_stmt_execute($stmt_course);
            $course_result = mysqli_stmt_get_result($stmt_course);
            $course_row = mysqli_fetch_assoc($course_result);
            $course_name = $course_row['name'];

            // Query the department name
            $department_query = "SELECT name FROM department WHERE id=?";
            $stmt_department = mysqli_prepare($connection, $department_query);
            mysqli_stmt_bind_param($stmt_department, "i", $department_id);
            mysqli_stmt_execute($stmt_department);
            $department_result = mysqli_stmt_get_result($stmt_department);
            $department_row = mysqli_fetch_assoc($department_result);
            $department_name = $department_row['name'];

            // Use the original ID format from database for consistency
            $db_id = $row['student_id'];

            // Check if there's an existing attendance record for the ID for the current date and period (AM/PM)
            $attendance_query = "SELECT * FROM attendance WHERE id_number=? AND date=? AND period=? AND status='0'";
            $stmt = mysqli_prepare($connection, $attendance_query);
            mysqli_stmt_bind_param($stmt, "sss", $db_id, $date, $time_suffix);
            mysqli_stmt_execute($stmt);
            $attendance_result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($attendance_result) > 0){
                $_SESSION['show_modal2'] = true;
                $_SESSION['matched_student_id'] = $db_id;
                redirect('home');
            } 

            $table = "Student"; // Set table name to "students"

            // Set session variables
            $_SESSION['matched_student_id'] = $db_id;
            $_SESSION['fullname'] = $name;
            $_SESSION['year'] = $year;
            $_SESSION['section'] = $section;
            $_SESSION['course_id'] = $course_id;
            $_SESSION['course_name'] = $course_name; // Add course name to session
            $_SESSION['department_id'] = $department_id;
            $_SESSION['department_name'] = $department_name; // Add department name to session
            $_SESSION['table'] = $table;

            // Set the session variable to trigger the modal
            $_SESSION['show_modal1'] = true;
        } elseif(mysqli_num_rows($result_faculty) > 0) {
            $row = mysqli_fetch_assoc($result_faculty);
            $name = $row['last_name'] . ', ' . $row['first_name'] .' '. $row['middle_name'] ;
            $year = ''; // Assuming faculty doesn't have a year field
            $department_id = $row['department_id'];

            // Query the department name
            $department_query = "SELECT name FROM department WHERE id=?";
            $stmt_department = mysqli_prepare($connection, $department_query);
            mysqli_stmt_bind_param($stmt_department, "i", $department_id);
            mysqli_stmt_execute($stmt_department);
            $department_result = mysqli_stmt_get_result($stmt_department);
            $department_row = mysqli_fetch_assoc($department_result);
            $department_name = $department_row['name'];
 
            // Use the original ID format from database for consistency
            $db_id = $row['faculty_id'];

            // Check if there's an existing attendance record for the ID for the current date and period (AM/PM)
            $attendance_query = "SELECT * FROM attendance WHERE id_number=? AND date=? AND period=? AND status='0'";
            $stmt = mysqli_prepare($connection, $attendance_query);
            mysqli_stmt_bind_param($stmt, "sss", $db_id, $date, $time_suffix);
            mysqli_stmt_execute($stmt);
            $attendance_result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($attendance_result) > 0){
                $_SESSION['show_modal2'] = true;
                $_SESSION['matched_student_id'] = $db_id;
                redirect('home');
            } 

            $table = "Faculty"; // Set table name to "faculty"
            // Set session variables
            $_SESSION['fullname'] = $name;
            $_SESSION['matched_student_id'] = $db_id;
            $_SESSION['department_name'] = $department_name; // Add department name to session
            $_SESSION['year'] = $year;
            $_SESSION['table'] = $table;

            // Set the session variable to trigger the modal
            $_SESSION['show_modal1'] = true;
        } else {
            $_SESSION['input_failed'] = "Cannot find ID number: $id (tried: $normalized_id, $hyphenated_id)";
        }
        // Redirect to home page after processing
        redirect('home');
    } else {
        // Redirect to home page if student ID is not set
       redirect('home');
    }

?>
