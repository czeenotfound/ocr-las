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
 
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $section = $url[1] ?? 'dashboard';
    $action  = $url[2] ?? 'view';
    $id      = $url[3] ?? 0;

    $filename = "../app/pages/admin/".$section.".php";

    if (!file_exists($filename)) {
        $filename = "../app/pages/admin/404.php";
    }

    // ADD USER ACCOUNT method or controller
    if($section == 'user-accounts'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'add'){
                if (isset($_POST['submit'])) {
                    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name = filter_var($_POST['last_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $mobile = filter_var($_POST['mobile'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $user_role = filter_var($_POST['user_role'],FILTER_SANITIZE_NUMBER_INT);
                    

                    // ====== validating input data =======
            
                    if(!$first_name) {
                        $_SESSION['add_user'] = "Please enter your First Name";
                    }   elseif(!$middle_name) {
                        $_SESSION['add_user'] = "Please enter your Middle Name";
                    }   elseif(!$last_name) {
                        $_SESSION['add_user'] = "Please enter your Last Name";
                    }   elseif(!$username) {
                        $_SESSION['add_user'] = "Please enter your Username";
                    }   elseif(!$mobile) {
                        $_SESSION['add_user'] = "Please enter your Mobile Number";
                    }   elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
                        $_SESSION['add_user'] = 'Must be at least 8+ characters';
                    }   else {
                        if ($createpassword !== $confirmpassword) {
                            $_SESSION['add_user'] = "Password didn't match";
                        } else {
                            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            
                            $user_check_query = "SELECT * FROM users WHERE username = '$username'";
                            $user_check_result = mysqli_query($connection, $user_check_query);
                            
                            if(mysqli_num_rows($user_check_result) > 0) {
                                $_SESSION['add_user'] = "Username already exist";
                            } 
                        }
                    }
            
                    if($_SESSION ['add_user']) { 
                        $_SESSION['add_user_data'] = $_POST;
                        redirect('admin/user-accounts/add');
                    } else{
                        $insert_user_query = "INSERT INTO users (first_name, middle_name, last_name, username, mobile, password, status) VALUES('$first_name', '$middle_name', '$last_name','$username', '$mobile', '$hashed_password', $user_role)";
            
                        $insert_user_query = mysqli_query($connection, $insert_user_query); 
            
                        if(!mysqli_errno($connection)){
                            $_SESSION['add-user-success'] = "New user " . '"' . $username . '"' . " added successfully";
                            redirect('admin/user-accounts');
                        }
                    } 
                } else {
                    redirect('admin/user-accounts');
                }
            }elseif($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
                    $first_name = filter_var($_POST['first_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name  = filter_var($_POST['last_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $status = filter_var($_POST['user_role'],FILTER_SANITIZE_NUMBER_INT);
            
                    if (!$first_name|| !$last_name || !$username) {
                        redirect('admin/user-accounts');
                    } else {
                        $query = "UPDATE users SET first_name='$first_name', last_name='$last_name', username='$username', status=$status WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-user-success'] = "User updated successfully";
                            redirect('admin/user-accounts');
                        } else {
                            $_SESSION['edit-user-error'] = "Failed to update user";
                        }
                    }
                } 
                redirect('admin/user-accounts');
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM users WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $user = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM users WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_user_failed'] = "Couldn't delete '{$user['first_name']} '{$user['last_name']} '";
                    } else{
                        $_SESSION['delete-user-success'] = "The User has been deleted successfully";
                    }
                } 
                redirect('admin/user-accounts');
            }
        }
    }elseif($section == 'students'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';

            if($action == 'add'){
                if(isset($_POST['submit'])) {
                    $student_id = filter_var($_POST['student_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $course_id = filter_var($_POST['course_id'], FILTER_SANITIZE_NUMBER_INT);
                    $yearlevel_id = filter_var($_POST['yearlevel_id'], FILTER_SANITIZE_NUMBER_INT);
                    $section = filter_var($_POST['section'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $school_year = $_POST['school_year'];

                    // echo $student_id, $first_name, $middle_name, $last_name, $gender, $course_id, $yearlevel_id;
                    if(!$student_id) {
                        $_SESSION['add_student'] = "Please enter an ID Number";
                    } elseif(!$first_name) {
                        $_SESSION['add_student'] = "Please enter First Name";
                    } elseif(!$middle_name) {
                        $_SESSION['add_student'] = "Please enter Middle Name";
                    } elseif(!$last_name) {
                        $_SESSION['add_student'] = "Please enter Last Name";
                    } elseif(!$gender) {
                        $_SESSION['add_student'] = "Select a Gender";
                    } elseif(!$course_id) {
                        $_SESSION['add_student'] = "Select a Course"; 
                    } elseif(!$yearlevel_id) {
                        $_SESSION['add_student'] = "Select a Course"; 
                    } elseif(!$section) {
                        $_SESSION['add_student'] = "Please enter Section";
                    } elseif(!$school_year) {
                        $_SESSION['add_student'] = "Please enter School Year Attended";
                    }
                    
                    // Retrieve course name and department ID based on selected course ID
                    $course_query = "SELECT name, department_id FROM course WHERE id = $course_id";
                    $course_result = mysqli_query($connection, $course_query);
                    
                    if($_SESSION ['add_student']) { 
                        $_SESSION['add_student_data'] = $_POST;
                        redirect('admin/students/add');
                    } else{
                        $student_check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
                        $student_check_result = mysqli_query($connection, $student_check_query);
                        
                        if(mysqli_num_rows($student_check_result) > 0) {
                            $_SESSION['add_student_failed'] = "Student already exist";
                            redirect('admin/students');
                            exit();
                        } 

                        if ($course_result && mysqli_num_rows($course_result) > 0) {
                            $course_data = mysqli_fetch_assoc($course_result);
                            $course_name = $course_data['name'];
                            $department_id = $course_data['department_id'];
                
                            // Proceed with insertion
                            $query = "INSERT INTO students (student_id, first_name, middle_name, last_name, gender, course_id, department_id, yearlevel_id, section, school_year) 
                                    VALUES ('$student_id', '$first_name', '$middle_name', '$last_name', '$gender', $course_id, $department_id, $yearlevel_id, '$section', '$school_year')";
                            $result = mysqli_query($connection, $query);
                
                            if($result) {
                                $_SESSION['add-student-success'] = "New student added successfully";
                                redirect('admin/students');
                                exit();
                            } else {
                                $_SESSION['add_student'] = "Error adding student";
                            }
                        } else {
                            $_SESSION['add_student'] = "Invalid course selection";
                        }
                    }
                } else{
                    redirect('admin/students');
                }
            }elseif($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                    $student_id = filter_var($_POST['student_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $course_id = filter_var($_POST['course_id'], FILTER_SANITIZE_NUMBER_INT);
                    
                    
                    // Retrieve course name and department ID based on selected course ID
                    $course_query = "SELECT name, department_id FROM course WHERE id = $course_id";
                    $course_result = mysqli_query($connection, $course_query);
            
                    // Check for required fields
                    if ($course_result && mysqli_num_rows($course_result) > 0) {
                        $course_data = mysqli_fetch_assoc($course_result);
                        $course_name = $course_data['name'];
                        $department_id = $course_data['department_id'];
            
                        $query = "UPDATE students SET student_id='$student_id', first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', course_id=$course_id, department_id=$department_id WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-student-success'] = "Student " . '"' . $last_name . ", " . $first_name . " " . $middle_name . '"' . " updated successfully";
                            redirect('admin/students');
                        } else {
                            $_SESSION['edit-student-error'] = "Failed to update student";
                        }
                    }
                } else {
                    redirect('admin/students');
                }
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM students WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $student = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM students WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_student_failed'] = "Couldn't delete '{$student['first_name']} '{$student['last_name']} '";
                    } else{
                        $_SESSION['delete-student-success'] = "The Student has been deleted successfully";
                    }
                } 
                redirect('admin/students');
            }elseif($action == 'import'){
                require_once '../vendor/autoload.php';

                if(isset($_POST['submit'])){
                    $filename = $_FILES['import_students_excel']['name'];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

                    $allowed_extension = [ 'xls','csv','xlsx'];

                    if(in_array($file_extension, $allowed_extension)){
                        $inputFileNamePath = $_FILES['import_students_excel']['tmp_name'];
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                        $data = $spreadsheet->getActiveSheet()->toArray();

                        $count = "0";

                        foreach($data as $row){

                            if($count > 0){

                            $student_id = $row['0'];
                            $first_name = $row['1'];
                            $middle_name = $row['2'];
                            $last_name = $row['3'];
                            $gender = $row['4'];
                            $course_id = $row['5'];
                            $department_id = $row['6'];
                            $yearlevel_id = $row['7'];
                            $section = $row['8'];
                            $school_year= $row['9'];
                            
                            $check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
                            $check_result = mysqli_query($connection, $check_query);

                            if(mysqli_num_rows($check_result) == 0) {
                                $students_query = "INSERT INTO students (student_id, first_name, middle_name, last_name, gender, course_id, department_id, yearlevel_id, section, school_year) VALUES ('$student_id', '$first_name', '$middle_name', '$last_name', '$gender', $course_id, $department_id, '$yearlevel_id', '$section', '$school_year')";
                                $students_result = mysqli_query($connection, $students_query);
                            } else {
                                $_SESSION['import-students-failed'] = "Duplicate";
                                redirect('admin/students/import');
                            }
                           
                            } else{
                                $count = "1";
                            }
                        }

                        if($students_result ) {
                            $_SESSION['import-students-success'] = "Import Students added successfully";
                            redirect('admin/students');
                        } 

                    } else{
                        $_SESSION['import-students-failed'] = "File format is Invalid";
                        redirect('admin/students/import');
                    }
                }
            }
        }
    }elseif($section == 'faculty'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'add'){
                if(isset($_POST['submit'])) {
                    $faculty_id = filter_var($_POST['faculty_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $department_id = filter_var($_POST['department_id'], FILTER_SANITIZE_NUMBER_INT);
                    $school_year = $_POST['school_year'];

                    if(!$faculty_id) {
                        $_SESSION['add_faculty'] = "Please enter an ID Number";
                    } elseif(!$first_name) {
                        $_SESSION['add_faculty'] = "Please enter First Name";
                    } elseif(!$middle_name) {
                        $_SESSION['add_faculty'] = "Please enter Middle Name";
                    } elseif(!$last_name) {
                        $_SESSION['add_faculty'] = "Please enter Last Name";
                    } elseif(!$gender) {
                        $_SESSION['add_faculty'] = "Select a gender";
                    } elseif(!$school_year) {
                        $_SESSION['add_faculty'] = "Please enter School Year Attended";
                    }
                    

                    if($_SESSION ['add_faculty']) { 
                        $_SESSION['add_faculty_data'] = $_POST;
                        redirect('admin/faculty/add');
                    } else{
                        $faculty_check_query = "SELECT * FROM faculty WHERE faculty_id = '$faculty_id'";
                        $faculty_check_result = mysqli_query($connection, $faculty_check_query);
                        
                        if(mysqli_num_rows($faculty_check_result) > 0) {
                            $_SESSION['add_faculty_failed'] = "Faculty already exist";
                            redirect('admin/faculty');
                        } 

                        // Proceed with insertion
                        $query = "INSERT INTO faculty (faculty_id, first_name, middle_name, last_name, gender, department_id, school_year) 
                                VALUES ('$faculty_id', '$first_name', '$middle_name', '$last_name', '$gender', $department_id, '$school_year')";
                        $result = mysqli_query($connection, $query);
            
            
                        if($result) {
                            $_SESSION['add-faculty-success'] = "New faculty added successfully";
                            redirect('admin/faculty');
                        } else {
                            $_SESSION['add_faculty'] = "Error adding faculty";
                        }
                    }
                }else{
                    redirect('admin/faculty');
                }
            }elseif($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                    $faculty_id = filter_var($_POST['faculty_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $department_id = filter_var($_POST['department_id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // Check for required fields
                    if (!$id || !$faculty_id || !$gender) {
                        redirect('admin/faculty');
                    } else {
                        $query = "UPDATE faculty SET faculty_id='$faculty_id', first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', department_id=$department_id WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-faculty-success'] = "Faculty " . '"' . $last_name . ", " . $first_name . " " . $middle_name . '"' . " updated successfully";
                            redirect('admin/faculty');
                        } else {
                            $_SESSION['edit-faculty-error'] = "Failed to update faculty";
                        }
                    }
                } else {
                    redirect('admin/faculty');
                }
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM faculty WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $faculty = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM faculty WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_faculty_failed'] = "Couldn't delete '{$faculty['first_name']} '{$faculty['last_name']} '";
                    } else{
                        $_SESSION['delete-faculty-success'] = "The Faculty has been deleted successfully";
                    }
                } 
                redirect('admin/faculty');
            }elseif($action == 'import'){
                require_once '../vendor/autoload.php';

                if(isset($_POST['submit'])){
                    $filename = $_FILES['import_faculty_excel']['name'];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            
                    $allowed_extension = [ 'xls','csv','xlsx'];
            
                    if(in_array($file_extension, $allowed_extension)){
                        $inputFileNamePath = $_FILES['import_faculty_excel']['tmp_name'];
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                        $data = $spreadsheet->getActiveSheet()->toArray();
            
                        $count = "0";
            
                        foreach($data as $row){
            
                            if($count > 0){
            
                            $faculty_id = $row['0'];
                            $first_name = $row['1'];
                            $middle_name = $row['2'];
                            $last_name = $row['3'];
                            $gender = $row['4'];
                            $course_id = $row['5'];
                            $department_id = $row['6'];
                            $yearlevel_id = $row['7'];
                            $section = $row['8'];
                            $school_year= $row['9'];
            
                            // Check if faculty ID already exists
                            $check_query = "SELECT * FROM faculty WHERE faculty_id = '$faculty_id'";
                            $check_result = mysqli_query($connection, $check_query);

                            if(mysqli_num_rows($check_result) == 0) {
                                // Faculty ID does not exist, proceed with insertion
                                $faculty_query = "INSERT INTO faculty (faculty_id, first_name, middle_name, last_name, gender, department_id, school_year) VALUES ('$faculty_id', '$first_name', '$middle_name', '$last_name', '$gender', $department_id, '$school_year')";
                                $faculty_result = mysqli_query($connection, $faculty_query);
                            } else {
                                // Faculty ID already exists, handle accordingly (e.g., skip insertion, update existing record, etc.)
                                // For now, let's just skip this record
                                $_SESSION['import-faculty-failed'] = "Duplicate";
                                redirect('admin/faculty/import');
                            }
                            
                            } else{
                                $count = "1";
                            }
                        }
            
                        if($faculty_result) {
                            $_SESSION['import-faculty-success'] = "Import Faculty added successfully";
                            redirect('admin/faculty');
                        } 
            
                    } else{
                        $_SESSION['import-faculty-failed'] = "File Format is Invalid";
                        redirect('admin/faculty/import');
                    }
                }
            }
        }
    }elseif($section == 'course'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';

            if($action == 'add'){
                if (isset($_POST['submit'])) {
                    $name = filter_var($_POST['course_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $department_id = filter_var($_POST['department_id'], FILTER_SANITIZE_NUMBER_INT);
            
                    $course_check_query = "SELECT * FROM course WHERE name = '$name'";
                    $course_check_result = mysqli_query($connection, $course_check_query);
                    
                    if(mysqli_num_rows($course_check_result) > 0) {
                        $_SESSION['add_course_failed'] = "Course already exist";
                        redirect('admin/course');
                    } 
            
                    if (!$name) {
                        $_SESSION['add_course'] = 'Enter Course';
                    } elseif (!$department_id) {
                        $_SESSION['add_course'] = "Select Department";
                    } else {
                        $query = "INSERT INTO course (name, department_id) VALUES ('$name', $department_id)";
                        $result = mysqli_query($connection, $query);
            
                        if (mysqli_errno($connection)) {
                            $_SESSION['add_course-failed'] = "Couldn't add course";
                        } else {
                            $_SESSION["add-course-success"] = "Course " . '"' . $name . '"' . " added successfully";
                        }
                        redirect('admin/course');
                    }
                }
            }elseif($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $department_id = filter_var($_POST['department_id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // Check for required fields
                    if (!$name|| !$department_id) {
                        redirect('admin/course/edit');
                    } else {
                        $query = "UPDATE course SET name='$name', department_id=$department_id WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-course-success'] = "Course " . '"' . $name . '"' . " updated successfully";
                            redirect('admin/course');
                        } else {
                            $_SESSION['edit-course-error'] = "Failed to update course";
                        }
                    }
                } else {
                    redirect('admin/course');
                }
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM course WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $course = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM course WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_course_failed'] = "Couldn't delete '{$course['name']}'";
                    } else{
                        $_SESSION['delete-course-success'] = "The Course has been deleted successfully";
                    }
                } 
                redirect('admin/course');
            }elseif($action == 'import'){
                require_once '../vendor/autoload.php';

                if(isset($_POST['submit'])){
                    $filename = $_FILES['import_course_excel']['name'];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            
                    $allowed_extension = ['xls','csv','xlsx'];
                    
                    if(in_array($file_extension, $allowed_extension)){
                        $inputFileNamePath = $_FILES['import_course_excel']['tmp_name'];
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                        $data = $spreadsheet->getActiveSheet()->toArray();
            
                        $count = "0";
            
                        foreach($data as $row){
            
                            if($count > 0){
            
                            $name = $row['0'];
                            $department_id = $row['1'];
            
                            $course_query = "INSERT INTO course (name, department_id) VALUES ('$name', $department_id)";
                            $course_result = mysqli_query($connection, $course_query);
                            } else{
                                $count = "1";
                            }
                        }
            
                        if($course_result ) {
                            $_SESSION['import-course-success'] = "Import Courses added successfully";
                            redirect('admin/course');
                        } 
                    } else{
                        $_SESSION['import-course-failed'] = "File format is Invalid";
                        redirect('admin/course/import');
                    }
                }
            }
        }
    }elseif($section == 'department'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'add'){
                if (isset($_POST['submit'])) {
                    $name = filter_var($_POST['department_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
                    if(!$name) {
                        $_SESSION['add_department'] = 'Enter Department';
                    } 
            
                    if(isset($_SESSION['add_department'])) {
                        $_SESSION['add-department-data'] = $_POST;
                        redirect('admin/department/add');
                    } else {
                        $query = "INSERT INTO department (name) VALUES ('$name')";
                        $result = mysqli_query($connection, $query);
                        if(mysqli_errno($connection)) {
                            $_SESSION['add_department_failed'] = "Couldn't add department";
                            header("location: ". ROOT_URL ."admin/includes/footer.php");
                            die();
                        } else{
                            $_SESSION["add-department-success"] = "Department " . '"' . $name . '"' . " added successfully";
                            redirect('admin/department');
                        }
                    }
                }
            }elseif($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                    $name = filter_var($_POST['department_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
                    // Check for required fields
                    if (!$name) {
                        redirect('admin/department/edit');
                    } else {
                        $query = "UPDATE department SET name='$name' WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-department-success'] = "Department " . '"' . $name . '"' . " updated successfully";
                             redirect('admin/department');
                        } else {
                            $_SESSION['edit-department-error'] = "Failed to update department";
                        }
                    }
                } else {
                    redirect('admin/department');
                }
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM department WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $department = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM department WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_department_failed'] = "Couldn't delete '{$department['name']}'";
                    } else{
                        $_SESSION['delete-department-success'] = "Department has been deleted successfully";
                    }
                } 
                redirect('admin/department');
            }
            elseif($action == 'import'){
                require '../vendor/autoload.php';

                if(isset($_POST['submit'])){
                    $filename = $_FILES['import_department_excel']['name'];
                    $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

                    $allowed_extension = [ 'xls','csv','xlsx'];

                    if(in_array($file_extension, $allowed_extension)){
                        $inputFileNamePath = $_FILES['import_department_excel']['tmp_name'];
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
                        $data = $spreadsheet->getActiveSheet()->toArray();

                        $count = "0";

                        foreach($data as $row){

                            if($count > 0){

                            $name = $row['0'];

                            $department_query = "INSERT INTO department (name) VALUES ('$name')";
                            $department_result = mysqli_query($connection, $department_query);
                            } else{
                                $count = "1";
                            }
                        }

                        if($department_result ) {
                            $_SESSION['import-department-success'] = "Import Departments added successfully";
                            redirect('admin/department');
                        } 

                    } else{
                        $_SESSION['import-department-failed'] = "File format is Invalid";
                        redirect('admin/department/import');
                    }
                }
            }
        }
    }elseif($section == 'visitor'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM visitors WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $visitor = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM visitors WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_visitor_failed'] = "Couldn't delete '{$student['first_name']}' '{$student['last_name']}'";
                    } else{
                        $_SESSION['delete-visitor-success'] = "The Visitor has been deleted successfully";
                    }
                } 
                redirect('admin/visitor');
            }
        }
    }elseif($section == 'settings'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'add'){
                if (isset($_POST['submit'])) {
                    $purpose_description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
                    if(!$purpose_description) {
                        $_SESSION['add_purpose'] = 'Enter Purpose';
                    } 
            
                    if(isset($_SESSION['add_purpose'])) {
                        $_SESSION['add-purpose-data'] = $_POST;
                        redirect('admin/settings/add');
                    } else {
                        $query = "INSERT INTO purpose (description) VALUES ('$purpose_description')";
                        $result = mysqli_query($connection, $query);
                        if(mysqli_errno($connection)) {
                            $_SESSION['add_purpose_failed'] = "Couldn't add purpose";
                            redirect('admin/settings/add');
                        } else{
                            $_SESSION["add-purpose-success"] = "Purpose " . '"' . $purpose_description . '"' . " added successfully";
                            redirect('admin/settings');
                        }
                    }
                }
            }elseif($action == 'delete'){
                if(isset($_GET['id'])){
                    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            
                    // echo $id;
                    $query = "SELECT * FROM purpose WHERE id=$id";
                    $result = mysqli_query($connection, $query);
                    $purpose = mysqli_fetch_assoc($result);
            
                    $delete_user_query = "DELETE FROM purpose WHERE id=$id";
                    $delete_user_query = mysqli_query($connection, $delete_user_query);
                    if(mysqli_errno($connection)){
                        $_SESSION['delete_purpose_failed'] = "Couldn't delete '{$purpose['name']}'";
                    } else{
                        $_SESSION['delete-purpose-success'] = "Purpose has been deleted successfully";
                    }
                } 
                redirect('admin/settings');
            }
        }
    }elseif($section == 'profile'){
        if(!empty($_POST)){
            require_once '../app/configdb/dbconnection.php';
            if($action == 'edit'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
                    $first_name = filter_var($_POST['first_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $middle_name = filter_var($_POST['middle_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $last_name  = filter_var($_POST['last_name'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    if (!$first_name|| !$last_name || !$username) {
                        redirect('admin/profile/edit');
                    } else {
                        $query = "UPDATE users SET first_name='$first_name', middle_name='$middle_name', last_name='$last_name', username='$username' WHERE id=$id LIMIT 1";
                        $result = mysqli_query($connection, $query);
            
                        if($result && mysqli_affected_rows($connection) > 0){
                            $_SESSION['edit-user-success'] = "User updated successfully";
                            redirect('admin/dashboard');
                        } else {
                            $_SESSION['edit-user-error'] = "Failed to update user";
                        }
                    }
                } 
                redirect('admin/dashboard');
            }
            elseif($action == 'chpass'){
                if(isset($_POST['submit'])){
                    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
                    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $old_password = filter_var($_POST['old_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $createpassword = filter_var($_POST['create_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    if (!$username){
                        $_SESSION['changepass'] = 'Username required';
                    } elseif (!$old_password){
                        $_SESSION['changepass'] = 'Password Required';
                        redirect('admin/profile/?id=' . $id);
                    } else {
                        // Prepare and execute the SQL query using prepared statements
                        $fetch_user_query = "SELECT * FROM users WHERE username=?";
                        $stmt = mysqli_prepare($connection, $fetch_user_query);
                        mysqli_stmt_bind_param($stmt, 's', $username);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
            
                        if(mysqli_num_rows($result) == 1){
                            $user = mysqli_fetch_assoc($result);
                            $db_password = $user['password'];
            
                            if (password_verify($old_password, $db_password)){
                                if ($createpassword !== $confirm_password) {
                                    // Passwords don't match, handle the error (e.g., display an error message)
                                    // You can redirect back to the form with an error message
                                    // Redirect to the change password form with an error message
                                    $_SESSION['changepass'] = "Password didn't match";
                                    redirect('admin/profile/?id=' . $id);
                                } else {
                                    // Passwords match, update the password for the user with the specified ID
                                    $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

                                    // Update neto yung pass
                                    $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE username = '$username'";
                                    $update_password_result = mysqli_query($connection, $update_password_query);
            
                                    // Redirect to the dashboard after successful password change
                                    if ($update_password_result) {
                                        $_SESSION['changepass-success'] = "Your password was updated successfully!";
                                        redirect('admin/profile/?id=' . $id);
                                    } 
                                }
                            } else {
                                $_SESSION['changepass'] = "Password didn't match";
                            }
                        } else {
                            $_SESSION['changepass'] = "User not found";
                        }
                    }
                    // Always redirect to the login page after processing the login attempt
                    $_SESSION['changepass'] = "fail";
                    redirect('admin/dashboard');

                } else {
                    $_SESSION['changepass'] = "FAIL";
                    redirect('admin/dashboard');
                }
            }
        }
    }
    
    require 'admin/includes/header.php';
?>           

    <?php
        require_once $filename;
    ?>
     <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal']) : ?>
                var myModal = new bootstrap.Modal(document.getElementById('visitorTimeInModal'));
                myModal.show();
                <?php unset($_SESSION['show_modal']); // Clear the session variable ?>
            <?php endif; ?>
        });
    </script>
<?php
    include 'admin/includes/footer.php';
    include 'admin/includes/scripts.php';
?>