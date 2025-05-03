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

    $attendance_query  = "SELECT students.*, attendance.*, 'student' AS type, course.name AS course_name, department.name AS department_name
                        FROM students 
                        LEFT JOIN attendance ON students.student_id = attendance.id_number
                        LEFT JOIN course ON students.course_id = course.id
                        LEFT JOIN department ON students.department_id = department.id
                        WHERE date = '$date' 
                        UNION
                        SELECT faculty.*, attendance.*, 'faculty' AS type, NULL AS course_name, department.name AS department_name
                        FROM faculty 
                        LEFT JOIN attendance ON faculty.faculty_id = attendance.id_number
                        LEFT JOIN department ON faculty.department_id = department.id
                        WHERE date = '$date' 
                        ORDER BY IFNULL(time_out, time_in) DESC";

    $attendance_result = mysqli_query($connection, $attendance_query);

    
    $visitor_query = "SELECT *, 'visitor' AS type FROM visitors 
                    LEFT JOIN attendance ON visitors.visitor_id = attendance.id_number
                    WHERE date = '$date'
                    ORDER BY IFNULL(time_out, time_in) DESC";
    $visitor_result = mysqli_query($connection, $visitor_query);
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
                                    <li class="breadcrumb-item active text-dark" aria-current="page">DTR</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Daily Time Record</h2>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                Attendance Today -- <?= date('F d, Y', strtotime($date)) ?>
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
                        <?php if (mysqli_num_rows($attendance_result) > 0 || mysqli_num_rows($visitor_result) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="DTR" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>AM Time In</th>
                                        <th>AM Time Out</th>
                                        <th>PM Time In</th>
                                        <th>PM Time In</th>
                                        <th>Purpose</th>
                                        <th>Course</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($attendance = mysqli_fetch_assoc($attendance_result)) : ?>
                                        <?php
                                            $purpose_id = $attendance['purpose_id'];
                                            $purpose_query = "SELECT description FROM purpose WHERE id=$purpose_id";
                                            $purpose_result = mysqli_query($connection, $purpose_query);
                                            $purpose = mysqli_fetch_assoc($purpose_result);
                                        ?>
                                         <?php
                                            $course_id = $attendance['id_number'];
                                            $course_query = "SELECT name FROM course WHERE id=$course_id";
                                            $course_result = mysqli_query($connection, $course_query);
                                            $course = mysqli_fetch_assoc($course_result);
                                        ?>
                                        <tr>
                                            <td><?= $attendance['student_id']; ?></td>
                                            <td class="text-capitalize"><?= $attendance['last_name'].', '.$attendance['first_name'].' '.$attendance['middle_name'];?></td>
                                            <td><?= ($attendance['period'] == 'AM') ? $attendance['time_in'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'AM') ? $attendance['time_out'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'PM') ? $attendance['time_in'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'PM') ? $attendance['time_out'] : ''; ?></td>
                                            <td><?= $purpose['description']; ?></td>
                                            <td><?= $attendance['course_name']; ?></td>
                                            <td><?= $attendance['department_name']; ?></td>
                                            <td><?= $attendance['date']; ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                    <?php while ($visitor = mysqli_fetch_assoc($visitor_result)) : ?>
                                        
                                        <!-- Display visitors -->
                                        <tr>
                                            <td><?= $visitor['id_number']; ?></td>
                                            <td class="text-capitalize"><?= $visitor['last_name'].', '.$visitor['first_name'].' '.$visitor['middle_name'];?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_out'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_out'] : ''; ?></td>
                                            <td class="text-capitalize"><?= $purpose['description']; ?></td>
                                            <td> </td>
                                            <td> </td>
                                            <td><?= $visitor['date']; ?></td>
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
                                        <th>PM Time In</th>
                                        <th>Purpose</th>
                                        <th>Course</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php else: ?>
                            <h5 class="text-center p-4 alert-danger mb-0">No attendance recorded for today.</h2>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
        <!-- ========= End of Main Section ========= -->
    </div>