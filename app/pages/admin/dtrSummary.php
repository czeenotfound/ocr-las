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
    date_default_timezone_set('Asia/Hong_Kong');
    // Get the current timestamp
    $current_timestamp = time();
    $date = date('Y-m-d', $current_timestamp);

    // function currentschoolyear(){
    //     $currentYear = date('Y');
    //     $testMonth = 5; // Example: September

    //     // Use the specified test month if set, otherwise use the current month
    //     $month = isset($testMonth) ? $testMonth : date('n');

	// 	return (in_array($month,array(7,8,9,10,11,12))) ? $currentYear . "-" . ($currentYear + 1) : ($currentYear - 1) . "-" . $currentYear;
    // }
    function currentschoolyear(){
        $currentYear = date('Y');

		return (in_array(date('n'),array(7,8,9,10,11,12))) ? $currentYear . "-" . ($currentYear + 1) : ($currentYear - 1) . "-" . $currentYear;
    }

    $overall_attendance_query = "SELECT *,
                                CASE 
                                    WHEN students.student_id IS NOT NULL THEN CONCAT(students.last_name, ', ', students.first_name, ' ', students.middle_name)
                                    WHEN faculty.faculty_id IS NOT NULL THEN CONCAT(faculty.last_name, ', ', faculty.first_name, ' ', faculty.middle_name)
                                    WHEN visitors.visitor_id IS NOT NULL THEN CONCAT(visitors.last_name, ', ', visitors.first_name, ' ', visitors.middle_name)
                                    ELSE 'Unknown Name'
                                END AS full_name,
                                students.course_id AS student_course_id,
                                students.department_id AS student_department_id,
                                faculty.department_id AS faculty_department_id,
                                course.name AS course_name,
                                department.name AS faculty_department_name,
                                department_students.name AS student_department_name,
                                attendance.purpose_id AS purpose_id,
                                purpose.description AS purpose_description
                            FROM attendance 
                            LEFT JOIN students ON attendance.id_number = students.student_id 
                            LEFT JOIN faculty ON attendance.id_number = faculty.faculty_id
                            LEFT JOIN visitors ON attendance.id_number = visitors.visitor_id
                            LEFT JOIN course ON students.course_id = course.id
                            LEFT JOIN department AS department ON faculty.department_id = department.id
                            LEFT JOIN department AS department_students ON students.department_id = department_students.id
                            LEFT JOIN purpose ON attendance.purpose_id = purpose.id
                            ORDER BY IFNULL(time_out, time_in) DESC";

    $overall_attendance_result = mysqli_query($connection, $overall_attendance_query);

    $purpose_query = "SELECT DISTINCT purpose_id, purpose.description AS purpose_description FROM attendance
    LEFT JOIN purpose ON attendance.purpose_id = purpose.id";
    $purpose_result = mysqli_query($connection, $purpose_query);

    // Get distinct courses from the database
    $course_query = "SELECT DISTINCT course_id, course.name AS course_name FROM attendance
    LEFT JOIN students ON attendance.id_number = students.student_id
    LEFT JOIN course ON students.course_id = course.id";
    $course_result = mysqli_query($connection, $course_query);

    // Get distinct departments from the database
    $department_query = "SELECT DISTINCT department_id, department.name AS department_name FROM attendance
    LEFT JOIN faculty ON attendance.id_number = faculty.faculty_id
    LEFT JOIN department ON faculty.department_id = department.id";
    $department_result = mysqli_query($connection, $department_query);
?>

<!-- Main -->
<main class="content px-3 py-2 ">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                    <ol class="breadcrumb mb-0 d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dtr" class="text-decoration-none text-dark text-muted">Attendance</a></li>
                        <li class="breadcrumb-item active text-dark" aria-current="page">DTR Summary</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="mt-4 mb-5">
            <h2 class="fw-bold">Daily Time Record Summary</h2>
        </div>
        
        
        <!-- Table Element -->
        <div class="card border-0">
            <div class="card-header">
                <h5 class="card-title text-center">
                    Overall Attendance (S.Y. <?= currentschoolyear() ?>)
                    <div class="btn-group float-end">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><p class="mx-2 text-muted">Export</p></li>
                            <li><button class="dropdown-item" id="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Save as PDF</button></li>
                            <li><button class="dropdown-item" id="btn-csv"><i class="fa-solid fa-file-csv"></i> Save as CSV</button></li>
                            <li><button class="dropdown-item" id="btn-excel"><i class="fa-solid fa-file-excel"></i> Save as Excel</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><p class="mx-2 text-muted">Print</p></li>
                            <li><button class="dropdown-item" id="btn-print"><i class="fa-solid fa-print"></i> Print</button></li>
                        </ul>
                    </div> 
                </h5>
            </div>

            <?php if (mysqli_num_rows($overall_attendance_result) > 0): ?>
            <div class="card-body table-responsive"> 
                <table id="DTRsummary" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Name</th>
                            <th>AM Time In</th>
                            <th>AM Time Out</th>
                            <th>PM Time In</th>
                            <th>PM Time Out</th>
                            <th>Purpose</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($overall_attendance = mysqli_fetch_assoc($overall_attendance_result)) : ?>
                           
                            <tr>
                                <td> <?= $overall_attendance['student_id'] ? : $overall_attendance['faculty_id'] ? : $overall_attendance['visitor_id']; ?> </td>
                                <td class="text-capitalize"> <?= $overall_attendance['full_name'];?> </td>
                                <td> <?= ($overall_attendance['period'] == 'AM') ? $overall_attendance['time_in'] : ''; ?> </td>
                                <td> <?= ($overall_attendance['period'] == 'AM') ? $overall_attendance['time_out'] : ''; ?> </td>
                                <td> <?= ($overall_attendance['period'] == 'PM') ? $overall_attendance['time_in'] : ''; ?> </td>
                                <td> <?= ($overall_attendance['period'] == 'PM') ? $overall_attendance['time_out'] : ''; ?> </td>
                                <td class="text-capitalize"> <?= $overall_attendance['purpose_description']; ?></td>
                                <td class="text-capitalize"><?= $overall_attendance['course_name']; ?></td>
                                <td class="text-capitalize"><?= $overall_attendance['student_department_name'] ? : $overall_attendance['faculty_department_name']; ?></td>
                                <td> <?= $overall_attendance['schoolyear']; ?></td>
                                <td> <?= $overall_attendance['semester']; ?></td>
                                <td> <?= $overall_attendance['date']; ?></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID Number</th>
                            <th>Name</th>
                            <th>AM Time In</th>
                            <th>AM Time Out</th>
                            <th>PM Time In</th>
                            <th>PM Time Out</th>
                            <th>Purpose</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php else: ?>
                <h5 class="text-center p-4 alert-danger mb-0">No attendance recorded</h5>
            <?php endif ?>
        </div>
    </div>
</main>