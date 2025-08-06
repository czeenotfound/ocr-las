<?php
    function redirect($page){
        header('location: '. ROOT_URL .$page);
        die();
    }

    require '../app/configdb/dbconnection.php';

    if (isset($_POST['submit'])) {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (!$username){
            $_SESSION['LoginPage'] = 'Username required';
        } elseif (!$password){
            $_SESSION['LoginPage'] = 'Password Required';
        } else {
            $fetch_user_query = "SELECT * FROM users WHERE username=?";
            $stmt = mysqli_prepare($connection, $fetch_user_query);
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $user = mysqli_fetch_assoc($result);
                $db_password = $user['password'];

                if (password_verify($password, $db_password)){
                    
                    $_SESSION['user-id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['status'] = $user['status'];

                    if(isset($_SESSION['status'])) {
                        if($_SESSION['status'] == 2) {
                            $_SESSION['user_is_admin'] = true;
                            unset($_SESSION['user_is_staff']);
                            unset($_SESSION['user_is_disabled']);
                        } elseif($_SESSION['status'] == 0) {
                            $_SESSION['LoginPage'] = 'Your account has been disabled. Please contact the administrator for assistance.';
                            $_SESSION['user_is_disabled'] = true;
                            unset($_SESSION['user_is_admin']);
                            unset($_SESSION['user_is_staff']);
                        } elseif($_SESSION['status'] == 1) {
                            $_SESSION['user_is_staff'] = true;
                            unset($_SESSION['user_is_admin']);
                            unset($_SESSION['user_is_disabled']);
                        }
                    }

                    if(isset($_SESSION['user_is_admin']) || isset($_SESSION['user_is_staff'])) {
                        redirect('admin/dashboard');
                    } elseif(isset($_SESSION['user_is_disabled'])) {
                        redirect('adminLogin');
                    }
                } else {
                    $_SESSION['LoginPage'] = "Password didn't match";
                }
            } else {
                $_SESSION['LoginPage'] = "User not found";
            }
        }
        redirect('adminLogin');
    } else {
        redirect('adminLogin');
    }
?>
