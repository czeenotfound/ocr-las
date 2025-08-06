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
                                attendance.schoolyear,
                                students.yearlevel_id AS student_year_level,
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
    LEFT JOIN course ON students.course_id = course.id
    LEFT JOIN department ON course.department_id = department.id";
    $course_result = mysqli_query($connection, $course_query);

    // Get distinct departments from the database
    $department_query = "SELECT DISTINCT department.id AS department_id, department.name AS department_name
    FROM department
    LEFT JOIN students ON department.id = students.department_id
    LEFT JOIN faculty ON department.id = faculty.department_id
    WHERE students.department_id IS NOT NULL OR faculty.department_id IS NOT NULL";
    $department_result = mysqli_query($connection, $department_query);
    

     // Query to fetch distinct school years from the attendance table
    $school_year_query = "SELECT DISTINCT schoolyear FROM attendance";
    $school_year_result = mysqli_query($connection, $school_year_query);

    $school_semester_query = "SELECT DISTINCT semester FROM attendance";
    $school_semester_result = mysqli_query($connection, $school_semester_query);
    
    $year_level_query = "SELECT DISTINCT yearlevel_id, students.yearlevel_id AS student_year FROM attendance
    LEFT JOIN students ON attendance.id_number = students.student_id
    LEFT JOIN students_year_level ON students.yearlevel_id = students_year_level.id";
    $year_level_result = mysqli_query($connection, $year_level_query);
 
?>
        <!-- Main -->
        <main class="content px-3 py-2 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item text-decoration-none text-dark text-muted">Report Generator</li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Attendance Report</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Attendance Report</h2>
                </div>
                
                <div id="infoDashboard" class="row">
                    <div class="col">
                        <div class="col-xl-6 col-lg-6 mb-3">
                            <button class="btn btn-danger" id="clearFiltersBtn">Clear Filters</button>
                        </div>
                        <div class="card mb-3 border-0 shadow p-3">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <h5>Select School Year:</h5>
                                    <select class="form-select" id="filterSchoolYear">
                                        <option value="" disabled selected>Select a School Year</option>
                                        <?php while ($school_year_row = mysqli_fetch_assoc($school_year_result)) : ?>
                                            <option value="<?= $school_year_row['schoolyear'] ?>"><?= $school_year_row['schoolyear'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                    
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3" id="semesterContainer" style="display: none;">
                                    <h5>Select School Semester:</h5>
                                    <select class="form-select" id="filterSchoolSemester">
                                        <option value="">All Semester</option>
                                        <?php while ($school_semester_row = mysqli_fetch_assoc($school_semester_result)) : ?>
                                            <option value="<?= $school_semester_row['semester'] ?>"><?= $school_semester_row['semester'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div> 
                                <div class="col-xl-6 col-lg-6 mb-3" id="purposeContainer" style="display: none;">
                                    <h5>Select Purpose:</h5>
                                    <select class="form-select" id="filterPurpose">
                                        <option value="">All Purposes</option>
                                        <?php while ($purpose_row = mysqli_fetch_assoc($purpose_result)) : ?>
                                            <option value="<?= $purpose_row['purpose_description'] ?>"><?= $purpose_row['purpose_description'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3" id="yearlevelContainer" style="display: none;">
                                    <h5>Select Year Level:</h5>
                                    <select class="form-select" id="filterYear">
                                        <option value="">All Year Level</option>
                                        <?php while ($year_level_row = mysqli_fetch_assoc($year_level_result)) : ?>
                                            <option value="<?= $year_level_row['student_year'] ?>"><?= $year_level_row['student_year'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3" id="departmentContainer" style="display: none;">
                                    <h5>Select Department:</h5>
                                    <select class="form-select" id="filterDepartment">
                                        <option value="">All Departments</option>
                                        <?php while ($department_row = mysqli_fetch_assoc($department_result)) : ?>
                                            <option value="<?= $department_row['department_name'] ?>"><?= $department_row['department_name'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>

                                <!-- Hidden initially -->
                                <div class="col-xl-6 col-lg-6 mb-3" id="courseContainer" style="display: none;">
                                    <h5>Select Course:</h5>
                                    <select class="form-select" id="filterCourse">
                                        <option value="">All Courses</option>
                                        <?php while ($course_row = mysqli_fetch_assoc($course_result)) : ?>
                                            <option value="<?= $course_row['course_name'] ?>"><?= $course_row['course_name'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="btn-group">
                                
                                <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="exportBtn" disabled>
                                    Export/Print
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
                                <div id="printAllBtn" style="display: block;">
                                    <button type="button" id="btn-print1" class="btn btn-danger">
                                        <i class="fa-solid fa-print"></i> Print All
                                    </button>
                                </div>
                            </div>
                        </div>
                         
                    </div>  
                   
                    <?php if (mysqli_num_rows($overall_attendance_result) > 0): ?>
                    <div class="card">
                        <!-- <div class="card-body table-responsive" style="display: none;">  -->
                        <div class="card-body table-responsive" > 
                            <table id="AttendanceReport" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>AM Time In</th>
                                        <th>AM Time Out</th>
                                        <th>PM Time In</th>
                                        <th>PM Time Out</th>
                                        <th>Purpose</th>
                                        <th>Year Level</th>
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
                                            <td> <?= $overall_attendance['student_year_level'] ?></td>
                                            <td class="text-capitalize"> <?= $overall_attendance['course_name']; ?></td>
                                            <td class="text-capitalize"> <?= $overall_attendance['student_department_name'] ? : $overall_attendance['faculty_department_name']; ?></td>
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
                                        <th>Year Level</th>
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
            </div>
        </main>
    </div>
    <!-- ========= End of Main Section ========= -->
</div>

<script> 
    // JavaScript to handle showing/hiding department and course based on school year selection
    document.getElementById('filterSchoolYear').addEventListener('change', function() {
        var selectedSchoolYear = this.value;
        var exportBtn = document.getElementById('exportBtn');

        if (selectedSchoolYear !== '') {
            exportBtn.disabled = false;
            // Show department and course select boxes
            document.getElementById('printAllBtn').style.display = 'none';
            document.getElementById('purposeContainer').style.display = 'block';
            document.getElementById('semesterContainer').style.display = 'block';
            document.getElementById('yearlevelContainer').style.display = 'block';
            document.getElementById('departmentContainer').style.display = 'block';
            document.getElementById('courseContainer').style.display = 'block';
        } else {
            exportBtn.disabled = true;
            // Hide department and course select boxes if no school year selected
            document.getElementById('printAllBtn').style.display = 'block';
            document.getElementById('purposeContainer').style.display = 'none';
            document.getElementById('semesterContainer').style.display = 'none';
            document.getElementById('yearlevelContainer').style.display = 'none';
            document.getElementById('departmentContainer').style.display = 'none';
            document.getElementById('courseContainer').style.display = 'none';
        }

    });
    document.getElementById('clearFiltersBtn').addEventListener('click', function() {
        // Clear the selected options in all select elements
        document.getElementById('filterSchoolYear').selectedIndex = 0;
        document.getElementById('filterSchoolSemester').selectedIndex = 0;
        document.getElementById('filterPurpose').selectedIndex = 0;
        document.getElementById('filterYear').selectedIndex = 0;
        document.getElementById('filterDepartment').selectedIndex = 0;
        document.getElementById('filterCourse').selectedIndex = 0;

        // Optionally, you can also hide the containers if you want
        document.getElementById('semesterContainer').style.display = 'none';
        document.getElementById('purposeContainer').style.display = 'none';
        document.getElementById('yearlevelContainer').style.display = 'none';
        document.getElementById('departmentContainer').style.display = 'none';
        document.getElementById('courseContainer').style.display = 'none';
    });
   
</script>