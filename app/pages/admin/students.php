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
<?php if($action == 'add'):?>
    <?php if(isset($_SESSION['user_is_admin'])) : ?>   
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/students" class="text-decoration-none text-dark text-muted">Students</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Add New Student</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Add New Student</h2>
            </div>
            <div class="card border-0 p-3">
            <?php
                $student_id = $_SESSION['add_student_data']['student_id'] ?? null;
                $first_name = $_SESSION['add_student_data']['first_name'] ?? null;
                $middle_name = $_SESSION['add_student_data']['middle_name'] ?? null;
                $last_name = $_SESSION['add_student_data']['last_name'] ?? null;
                $gender = $_SESSION['add_student_data']['gender'] ?? null;
                $course_id = $_SESSION['add_student_data']['course_id'] ?? null;
                $year = $_SESSION['add_student_data']['year'] ?? null;
                $school_year = $_SESSION['add_student_data']['school_year'] ?? null;

                unset($_SESSION['add_student_data']);
            ?>
                <?php if (isset($_SESSION ['add_student'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_student'];
                            unset($_SESSION['add_student']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id">
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name">
                    </div>
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3"> 
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <?php while($course = mysqli_fetch_assoc($courses)) : ?>
                                <option value="<?= $course['id'] ?> = <?= $course['name'] ?>"><?= $course['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="yearlevel_id" class="form-label">Year</label>
                        <select class="form-select" id="yearlevel_id" name="yearlevel_id" required>
                            <option value="" disabled selected>Select Year</option>
                            <?php while($yearlevel = mysqli_fetch_assoc($yearlevels)) : ?>
                                <option value="<?= $yearlevel['id'] ?>"><?= $yearlevel['year'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <input type="text" class="form-control" id="section" name="section">
                    </div>
                    <div class="mb-3">
                        <label for="school_year" class="form-label">School Year Attended:</label>
                        <input type="text" class="form-control" id="school_year" name="school_year" placeholder="Ex. 20xx-20xx">
                    </div>
                    <hr>

                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/students" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Student</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </main>
    <?php else: ?>
        <h1>PAGE NOT FOUND</h2>
    <?php endif ?> 
<?php elseif($action == 'see'):?>
    <?php
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM students WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $view_students = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/students" class="text-decoration-none text-dark text-muted">Student Account</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">View Student</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">View Student</h2>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-2 profilehead">
                        <div class="card-body text-center">
                            <img src="<?= $avatarPath ?>" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3 text-capitalize"><?= $view_students['last_name'] ?>, <?= $view_students['first_name'] ?> <?= $view_students['middle_name'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card mb-4 profilehead">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Student ID</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['student_id'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">First Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['first_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Middle Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['middle_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Last Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['last_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Year</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['yearlevel_id'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Course</p>
                                </div>
                                <?php
                                    $course_id = $view_students['course_id'];
                                    $course_query = "SELECT name FROM course WHERE id=$course_id";
                                    $course_result = mysqli_query($connection, $course_query);
                                    $course_profile = mysqli_fetch_assoc($course_result);
                                ?>
                                <div class="col-sm-9">
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $course_profile['name'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Department</p>
                                </div>
                                <?php
                                    $department_id = $view_students['department_id'];
                                    $department_query = "SELECT name FROM department WHERE id=$department_id";
                                    $department_result = mysqli_query($connection, $department_query);
                                    $department_profile = mysqli_fetch_assoc($department_result);
                                ?>
                                <div class="col-sm-9">
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $department_profile['name'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">School Year</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_students['school_year'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                // Ensure $view_students['student_id'] is set and safe to use
                if(isset($view_students['student_id'])) {
                    $student_id = mysqli_real_escape_string($connection, $view_students['student_id']);

                    $query = "SELECT attendance.*, students.* 
                                FROM attendance 
                                LEFT JOIN students ON attendance.id_number = students.student_id 
                                WHERE attendance.id_number = '$student_id' 
                                ORDER BY attendance.date DESC";
                    $profile_attendance = mysqli_query($connection, $query);
                } else {
                    // Handle the case where $view_students['student_id'] is not set
                    echo "Student ID is not set.";
                    exit(); // or handle the error appropriately
                }
            ?>
            <hr>
            <div class="mt-5 mb-5">
                <h2 class="fw-bold">Student Attendance</h2>
            </div>
            <div class="card p-3 table-responsive">
                <table id="students" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Purpose</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $count = 1; // Initialize count
                            // Loop through each attendance record and display it in a table row
                            while ($attendance = mysqli_fetch_assoc($profile_attendance)) : 
                        ?>
                        <?php
                            $purpose_id = $attendance['purpose_id'];

                            $query = "SELECT * FROM purpose WHERE id=$purpose_id";
                            $purpose_result = mysqli_query($connection, $query);
                            $purpose = mysqli_fetch_assoc($purpose_result);
                        ?>
                        <tr>
                            <td class="text-capitalize"><?= $count++; ?></td>
                            <td class="text-capitalize"><?= $attendance['student_id']; ?></td>
                            <td class="text-capitalize"><?= $attendance['last_name'] . ', ' . $attendance['first_name'] . ' ' . $attendance['middle_name']; ?></td>
                            <td class="text-capitalize"><?= $purpose['description']; ?></td>
                            <td class="text-capitalize"><?= $attendance['semester']; ?></td>
                            <td class="text-capitalize"><?= $attendance['schoolyear']; ?></td>
                            <td class="text-capitalize"><?= $attendance['date']; ?></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Purpose</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </main>
<?php elseif($action == 'edit'):?>
    <?php if(isset($_SESSION['user_is_admin'])) : ?>   
    <?php
         if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM students WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $edit_students = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/students" class="text-decoration-none text-dark text-muted">Students</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Edit Student</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Edit Student</h2>
            </div>
            <div class="card border-0 p-3">
                <?php
                    $student_id = $_SESSION['add_student_data']['student_id'] ?? null;
                    $first_name = $_SESSION['add_student_data']['first_name'] ?? null;
                    $middle_name = $_SESSION['add_student_data']['middle_name'] ?? null;
                    $last_name = $_SESSION['add_student_data']['last_name'] ?? null;
                    $gender = $_SESSION['add_student_data']['gender'] ?? null;
                    $course_id = $_SESSION['add_student_data']['course_id'] ?? null;

                    unset($_SESSION['add_student_data']);
                ?>
                <!-- ADD User -->
                <?php if (isset($_SESSION ['add_student'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_student'];
                            unset($_SESSION['add_student']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST"> 
                    <input type="hidden" name="id" value="<?= $edit_students['id'] ?>">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?= $edit_students['student_id'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $edit_students['first_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $edit_students['middle_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $edit_students['last_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="<?= $edit_students['gender'] ?>"><?= $edit_students['gender'] ?></option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select" id="course_id" name="course_id" required>
                            <?php while($course = mysqli_fetch_assoc($courses)) : 
                                $selected = ($edit_students['course_id'] == $course['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $course['id'] ?>" <?= $selected ?>><?= $course['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/students" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-regular fa-pen-to-square"></i> Edit Student</button>
                    </div>
                    
                </form>
                <!-- END of User -->
            </div>
        </div>
    </main>
    <?php else: ?>
        <h1>PAGE NOT FOUND</h2>
    <?php endif ?>  
<?php elseif($action == 'delete'):?>
    <?php if(isset($_SESSION['user_is_admin'])) : ?>   
    <?php
         if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM students WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_student = mysqli_fetch_assoc($result);
        }
    ?>
    <div class="card m-5">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Delete</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_id" id="delete_id">
                <p>Are you sure you want to delete <span class="fw-bold">"Student (<?= $delete_student['last_name'] ?>, <?= $delete_student['first_name'] ?> <?= $delete_student['middle_name'] ?>)" ? </span></p>
            </div>
            
            <div class="modal-footer">      
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $delete_student['id'] ?>">
                    <div class="float-end">
                        <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                    </div>
                </form>              
                <a href="<?= ROOT_URL ?>admin/students" type="button" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h1>PAGE NOT FOUND</h2>
    <?php endif ?>  
    
<?php elseif($action == 'import'):?>
    <?php if(isset($_SESSION['user_is_admin'])) : ?>   
        <main class="content px-3 py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/students" class="text-decoration-none text-dark text-muted">Students</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Import Students</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Import Student</h2>
                </div>
                <div class="card border-0 p-3">
                    <?php if (isset($_SESSION ['import-students-failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['import-students-failed'];
                                unset($_SESSION['import-students-failed']);
                            ?>
                        </div>
                    <?php endif ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="import_students_excel" class="form-label">Excel File</label>
                            <input type="file" class="form-control" id="import_students_excel" name="import_students_excel" required>
                        </div>
                        <hr>
                        <div class="float-end">
                            <a href="<?= ROOT_URL ?>admin/students" type="button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-file-import"></i> Import Students</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    <?php else: ?>
        <h1>PAGE NOT FOUND</h2>
    <?php endif ?>  
<?php else:?>
<?php
    $count = 1;
    $student_query = "SELECT * FROM students ORDER BY last_name";
    $students = mysqli_query($connection, $student_query);
?>
            <!-- Main -->
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                    <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page">Students</li>
                                </ol> 
                            </nav>
                        </div>
                    </div>
                    <?php if (isset($_SESSION ['add-student-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['add-student-success'];
                                unset($_SESSION['add-student-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['add_student_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_student_failed'];
                                unset($_SESSION['add_student_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete-student-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['delete-student-success'];
                                unset($_SESSION['delete-student-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete_student_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['delete_student_failed'];
                                unset($_SESSION['delete_student_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['edit-student-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['edit-student-success'];
                                unset($_SESSION['edit-student-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['import-students-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['import-students-success'];
                                unset($_SESSION['import-students-success']);
                            ?>
                        </div>
                    <?php endif ?>
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Student Records</h2>
                    </div>

                    <!-- Table Element --> 
                    <div class="card border-0">
                        
                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                        <div class="card-header d-flex justify-content-end align-items-center ">
                            <a href="<?= ROOT_URL ?>admin/students/add" class="btn btn-outline-danger"><i class="fa-regular fa-user"></i> Add New Student</a>
                            <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><p class="mx-2 text-muted">Export</p></li>
                                <li><button class="dropdown-item" id="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Save as PDF</button></li>
                                <li><button class="dropdown-item" id="btn-csv"><i class="fa-solid fa-file-csv"></i> Save as CSV</button></li>
                                <li><button class="dropdown-item" id="btn-excel"><i class="fa-solid fa-file-excel"></i>  Save as Excel</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><p class="mx-2 text-muted">Print</p></li>
                                <li><button class="dropdown-item" id="btn-print"><i class="fa-solid fa-print"></i> Print</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><p class="mx-2 text-muted">Import</p></li>
                                <li><a href="<?= ROOT_URL ?>admin/students/import" class="dropdown-item btn btn-outline-danger"><i class="fa-solid fa-file-import"></i> Import Students</a></li>
                            </ul>
                        </div>
                        <?php elseif ($_SESSION['user_is_staff']) : ?>
                        <div class="card-header d-flex justify-content-end align-items-center ">
                            <button class="btn btn-outline-danger" disabled><i class="fa-regular fa-user"></i> Add New Student</button>
                            <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            
                        </div>
                        <?php endif; ?>
                        <?php if (mysqli_num_rows($students) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="students" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <th>Course</th>
                                        <th>Department</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th colspan="3">Action</th>
                                        <?php endif ?>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($student = mysqli_fetch_assoc($students)) : ?>
                                        <?php
                                            $course_id = $student['course_id'];
                                            $course_query = "SELECT name FROM course WHERE id=$course_id";
                                            $course_result = mysqli_query($connection, $course_query);
                                            $course = mysqli_fetch_assoc($course_result);
                                        ?>
                                        <?php
                                            $department_id = $student['department_id'];
                                            $department_query = "SELECT name FROM department WHERE id=$department_id";
                                            $department_result = mysqli_query($connection, $department_query);
                                            $department = mysqli_fetch_assoc($department_result);
                                        ?>
                                    <tr>
                                        <td class="text-capitalize"> <?= $count++; ?> </td>
                                        <td class="text-capitalize"> <?= $student['student_id']; ?> </td>
                                        <td class="text-capitalize"> <?= $student['last_name']; ?>, <?= $student['first_name']; ?> <?= $student['middle_name']; ?></td>
                                        <td class="text-capitalize"> <?= $student['gender']; ?> </td>
                                        <td class="text-capitalize"> <?= $student['yearlevel_id']; ?> </td>
                                        <td class="text-capitalize"> <?= $student['section']; ?> </td>
                                        <td class="text-capitalize"> <?= $course['name']; ?> </td>
                                        <td class="text-capitalize"> <?= $department['name']; ?> </td>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/students/see/?id=<?= $student['id'] ?>" class="btn btn-success" ><i class="fa-regular fa-eye"></i></a> </td>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/students/edit/?id=<?= $student['id'] ?>" class="btn btn-primary" ><i class="fa-regular fa-pen-to-square"></i></a> </td>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/students/delete/?id=<?= $student['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        <?php endif ?>  
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Year</th>
                                        <th>Section</th>
                                        <th>Course</th>
                                        <th>Department</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th colspan="3">Action</th>
                                        <?php endif ?>  
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php else: ?>
                            <h5 class="text-center p-4 alert-danger mb-0">There are no data</h2>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
        <!-- ========= End of Main Section ========= -->
    </div>
<?php endif;?>