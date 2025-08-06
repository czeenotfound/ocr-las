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

    // Count the number of attendance records for today
    $attendance_count = mysqli_num_rows($attendance_result);
    $visitor_count = mysqli_num_rows($visitor_result);

    $studentsCount = getCount($connection, 'students');
    $facultyCount = getCount($connection, 'faculty');
    $visitorCount = getCount($connection, 'visitors');

    function getCount($connection, $tableName){
        $query = "SELECT COUNT(*) AS count FROM $tableName";
        $result = $connection->query($query);

        if($result && $result -> num_rows > 0){
            $row = $result -> fetch_assoc();
            return $row['count'];
        } else{
            return 0;
        }
        
    }

?>          
    <?php if (isset($_SESSION ['edit-user-success'])): ?>
        <div class="alert alert-success messages w-100 n">
            <?= $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
            ?>
        </div>
    <?php elseif (isset($_SESSION ['edit-user-error'])): ?>
        <div class="alert alert-success messages w-100 n">
            <?= $_SESSION['edit-user-error'];
                unset($_SESSION['edit-user-error']);
            ?>
        </div>
    <?php elseif(isset($_SESSION ['changepass'])): ?>
        <div class="alert alert-danger messages w-100 n">
            <?= $_SESSION['changepass'];
                unset($_SESSION['changepass']);
            ?>
        </div>
    <?php endif ?> 
            <!-- Main -->
            <main class="content px-3 py-2 mt-5">
                <div class="container-fluid">
                    <div class="mb-4">
                        <h2 class="fw-bold">Dashboard</h2>
                    </div>
                    <div id="infoDashboard" class="row">
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="card text-white bg-primary mb-3 border-0 shadow">
                                <div class="card-body row">
                                    <div class=" col-md-8">
                                        <p class="card-text fw-bold fs-1"><?= $attendance_count + $visitor_count ?></p>
                                        <p class="card-title text-start fw-bold text-nowrap">Attendance Today</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-light ">
                                    <a href="<?= ROOT_URL ?>admin/dtr" type="button" class="bg-transparent text-dark">More Info <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="card text-white bg-success mb-3 border-0 shadow">
                                <div class="card-body row">
                                    <div class="col-md-8 ">
                                        <p class="card-text fw-bold fs-1"><?= $studentsCount; ?></p>
                                        <p class="card-title text-start fw-bold">Students</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-light ">
                                    <a href="<?= ROOT_URL ?>admin/students" type="button" class="bg-transparent text-dark">More Info <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="card text-white bg-warning mb-3 border-0 shadow">
                                <div class="card-body row">
                                    <div class="col-md-8 ">
                                        <p class="card-text fw-bold fs-1"><?= $facultyCount; ?></p>
                                        <p class="card-title text-start fw-bold">Faculty</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center bg-light ">
                                    <a href="<?= ROOT_URL ?>admin/faculty" type="button" class="bg-transparent text-dark">More Info <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6">
                            <div class="card text-white bg-danger mb-3 border-0 shadow">
                                <div class="card-body row">
                                    <div class="col-md-8 ">
                                        <p class="card-text fw-bold fs-1"><?= $visitorCount; ?></p>
                                        <p class="card-title text-start fw-bold">Visitors</p>
                                    </div> 
                                </div>
                                <div class="card-footer text-center bg-light ">
                                    <a href="<?= ROOT_URL ?>admin/visitor" type="button" class="bg-transparent text-dark">More Info <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                Attendance Today -- <?= date('F d, Y', strtotime($date)) ?>
                            </h5>
                        </div>
                        <?php if (mysqli_num_rows($attendance_result) > 0 || mysqli_num_rows($visitor_result) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="dashboardDtr" class="table table-striped" style="width:100%">
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
                                            <td><?= $attendance['id_number']; ?></td>
                                            <td><?= $attendance['last_name'].', '.$attendance['first_name'].' '.$attendance['middle_name'];?></td>
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
                                        <?php
                                            $purpose_id = $visitor['purpose_id'];
                                            $purpose_query = "SELECT description FROM purpose WHERE id=$purpose_id";
                                            $purpose_result = mysqli_query($connection, $purpose_query);
                                            $purpose = mysqli_fetch_assoc($purpose_result);
                                        ?>
                                        <!-- Display visitors -->
                                        <tr>
                                            <td>visitor<?= $visitor['id_number']; ?></td>
                                            <td><?= $visitor['last_name'].', '.$visitor['first_name'].' '.$visitor['middle_name'];?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_out'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_out'] : ''; ?></td>
                                            <td><?= $purpose['description']; ?></td>
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