<?php
    function redirect($page){
        header('location: '. ROOT_URL .$page);
        die();
    }
    require '../app/configdb/dbconnection.php';

    if(isset($_POST['submit'])) {
        $full_name = filter_var($_POST['visitor_name_out'], FILTER_SANITIZE_NUMBER_INT);

        date_default_timezone_set('Asia/Hong_Kong');
        $current_timestamp = time();
        $time = date("h:i:s A", $current_timestamp); // Format as AM/PM time
        $date = date('Y-m-d', $current_timestamp);
        $time_suffix = date("A", $current_timestamp); // Get AM/PM indicator

        // Check if there's any record associated with the provided id
        $query = "SELECT * FROM visitors WHERE id = $full_name";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0) {
            // If visitor exists, proceed with time out
            $row = mysqli_fetch_assoc($result);
            $visitor_id = $row['visitor_id'];
            $visitor_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];

             // Check if there's an existing attendance record for the visitor for the current date and period (AM/PM)
            $attendance_query = "SELECT * FROM attendance WHERE id_number='$visitor_id' AND date='$date' AND period='$time_suffix' AND status='0'";
            $attendance_result = mysqli_query($connection, $query);

            if(mysqli_num_rows($attendance_result) > 0){
                // If there's an existing record, update the time out
                $sql = "UPDATE attendance SET time_out=?, status='1' WHERE id_number=? AND date=? AND period=?";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $time, $visitor_id, $date, $time_suffix);
                mysqli_stmt_execute($stmt);

                
                $_SESSION['input_success'] = 'Successfully Time Out: '.$visitor_name;
            } else {
                $_SESSION['input_failed'] = 'Visitor has already been timed out or has no time in record for today.';
            }
        } else {
            $_SESSION['input_failed'] = "Cannot find visitor with the provided name";
        }
        redirect('home');
    } else {
        redirect('home');
    }
?>
