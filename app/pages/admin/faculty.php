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
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/faculty" class="text-decoration-none text-dark text-muted">Faculty</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Add New Faculty</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Add New Faculty</h2>
            </div>
            <div class="card border-0 p-3">
            <?php
                $faculty_id = $_SESSION['add_faculty_data']['faculty_id'] ?? null;
                $first_name = $_SESSION['add_faculty_data']['first_name'] ?? null;
                $middle_name = $_SESSION['add_faculty_data']['middle_name'] ?? null;
                $last_name = $_SESSION['add_faculty_data']['last_name'] ?? null;
                $gender = $_SESSION['add_faculty_data']['gender'] ?? null;
                $school_year = $_SESSION['add_faculty_data']['school_year'] ?? null;

                unset($_SESSION['add_faculty_data']);
            ?>
                <?php if (isset($_SESSION ['add_faculty'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_faculty'];
                            unset($_SESSION['add_faculty']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Faculty ID</label>
                        <input type="text" class="form-control" id="faculty_id" name="faculty_id" value=<?= $faculty_id ?>>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value=<?= $first_name ?>>
                    </div>
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value=<?= $middle_name ?>>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value=<?= $last_name ?>>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3"> 
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <?php while($department = mysqli_fetch_assoc($departments)) : ?>
                                <option value="<?= $department['id'] ?> = <?= $department['name'] ?>"><?= $department['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="school_year" class="form-label">School Year Attended:</label>
                        <input type="text" class="form-control" id="school_year" name="school_year" placeholder="Ex. 20xx-20xx" value=<?= $school_year ?>>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/faculty" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Faculty</button>
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
            $query = "SELECT * FROM faculty WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $view_faculty = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/faculty" class="text-decoration-none text-dark text-muted">Faculty Account</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">View Faculty</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">View Faculty</h2>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-2 profilehead">
                        <div class="card-body text-center">
                            <img src="<?= $avatarPath ?>" alt="avatar"
                            class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3 text-capitalize"><?= $view_faculty['last_name'] ?>, <?= $view_faculty['first_name'] ?> <?= $view_faculty['middle_name'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card mb-4 profilehead">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Faculty ID</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_faculty['faculty_id'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">First Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_faculty['first_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Middle Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_faculty['middle_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Last Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $view_faculty['last_name'] ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Department</p>
                                </div>
                                <?php
                                    $department_id = $view_faculty['department_id'];
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
                                    <p class="text-muted mb-0"><?= $view_faculty['school_year'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                // Ensure $view_faculty['faculty_id'] is set and safe to use
                if(isset($view_faculty['faculty_id'])) {
                    $faculty_id = mysqli_real_escape_string($connection, $view_faculty['faculty_id']);

                    $query = "SELECT attendance.*, faculty.* 
                                FROM attendance 
                                LEFT JOIN faculty ON attendance.id_number = faculty.faculty_id 
                                WHERE attendance.id_number = '$faculty_id' 
                                ORDER BY attendance.date DESC";
                    $profile_attendance = mysqli_query($connection, $query);
                } else {
                    // Handle the case where $view_facultys['faculty_id'] is not set
                    echo "Faculty ID is not set.";
                    exit(); // or handle the error appropriately
                }
            ?>
            <div class="card p-3 table-responsive">
                <table id="profile" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Faculty ID</th>
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
                            <td class="text-capitalize"><?= $attendance['faculty_id']; ?></td>
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
                            <th>Faculty ID</th>
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
        // Department
        $departmentquery = "SELECT * FROM department";
        $departments = mysqli_query($connection, $departmentquery);
        $department_query = "SELECT * FROM department";
        $departments_faculty = mysqli_query($connection, $department_query);

        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM faculty WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $edit_faculty = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/faculty" class="text-decoration-none text-dark text-muted">Faculty</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Edit Faculty</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Edit Faculty</h2>
            </div>
            <div class="card border-0 p-3">
                <?php
                    $faculty_id = $_SESSION['add_faculty_data']['faculty_id'] ?? null;
                    $first_name = $_SESSION['add_faculty_data']['first_name'] ?? null;
                    $middle_name = $_SESSION['add_faculty_data']['middle_name'] ?? null;
                    $last_name = $_SESSION['add_faculty_data']['last_name'] ?? null;
                    $gender = $_SESSION['add_faculty_data']['gender'] ?? null;
                    $course_id = $_SESSION['add_faculty_data']['course_id'] ?? null;

                    unset($_SESSION['add_faculty_data']);
                ?>
                <!-- ADD User -->
                <?php if (isset($_SESSION ['add_faculty'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_faculty'];
                            unset($_SESSION['add_faculty']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                <input type="hidden" name="id" value="<?= $edit_faculty['id'] ?>">
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">Faculty ID</label>
                        <input type="text" class="form-control" id="faculty_id" name="faculty_id" value="<?= $edit_faculty['faculty_id'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $edit_faculty['first_name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $edit_faculty['middle_name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $edit_faculty['last_name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="<?= $edit_faculty['gender'] ?>"><?= $edit_faculty['gender'] ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <?php 
                            while($department = mysqli_fetch_assoc($departments)) : 
                                $selected = ($edit_faculty['department_id'] == $department['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $department['id'] ?>" <?= $selected ?>><?= $department['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/faculty" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-regular fa-pen-to-square"></i> Edit Faculty</button>
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
            $query = "SELECT * FROM faculty WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_faculty = mysqli_fetch_assoc($result);
        }
    ?>
        <div class="card m-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Delete</h2>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <p>Are you sure you want to delete <span class="fw-bold">"Faculty (<?= $delete_faculty['last_name'] ?>, <?= $delete_faculty['first_name'] ?> <?= $delete_faculty['middle_name'] ?>)" ? </span></p>
                </div>
                
                <div class="modal-footer">      
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $delete_faculty['id'] ?>">
                        <div class="float-end">
                            <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                        </div>
                    </form>              
                    <a href="<?= ROOT_URL ?>admin/faculty" type="button" class="btn btn-secondary">Cancel</a>
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
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/faculty" class="text-decoration-none text-dark text-muted">Faculty</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Import Faculty</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Import Faculty</h2>
            </div>
            <div class="card border-0 p-3">
                <?php if (isset($_SESSION ['import-faculty-failed'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['import-faculty-failed'];
                            unset($_SESSION['import-faculty-failed']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="import_faculty_excel" class="form-label">Excel File</label>
                        <input type="file" class="form-control" id="import_faculty_excel" name="import_faculty_excel" required>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/faculty" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-file-import"></i> Import Faculty</button>
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
    $faculty_query = "SELECT * FROM faculty ORDER BY last_name";
    $faculty_result = mysqli_query($connection, $faculty_query);
?> 
            <!-- Main -->
            <main class="content px-3 py-2 ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                    <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page">Faculty</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <?php if (isset($_SESSION ['add-faculty-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['add-faculty-success'];
                                unset($_SESSION['add-faculty-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['add_faculty_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_faculty_failed'];
                                unset($_SESSION['add_faculty_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete-faculty-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['delete-faculty-success'];
                                unset($_SESSION['delete-faculty-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete_faculty_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['delete_faculty_failed'];
                                unset($_SESSION['delete_faculty_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['edit-faculty-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['edit-faculty-success'];
                                unset($_SESSION['edit-faculty-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['import-faculty-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['import-faculty-success'];
                                unset($_SESSION['import-faculty-success']);
                            ?>
                        </div>
                    <?php endif ?>
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Faculty Records</h2>
                    </div>

                    <!-- Table Element -->
                    <div class="card border-0">

                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                        <div class="card-header d-flex justify-content-end align-items-center ">
                            <a href="<?= ROOT_URL ?>admin/faculty/add" class="btn btn-outline-danger"><i class="fa-regular fa-user"></i> Add New Faculty</a>
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
                                <li><a href="<?= ROOT_URL ?>admin/faculty/import" class="dropdown-item btn btn-outline-danger"><i class="fa-solid fa-file-import"></i> Import Faculty</a></li>
                            </ul>
                        </div>
                        <?php elseif ($_SESSION['user_is_staff']) : ?>
                        <div class="card-header d-flex justify-content-end align-items-center ">
                            <button class="btn btn-outline-danger" disabled><i class="fa-regular fa-user"></i> Add New Faculty</button>
                            <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            
                        </div>
                        <?php endif; ?>
                        <?php if (mysqli_num_rows($faculty_result) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="faculty" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Department</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th colspan="3">Action</th>
                                        <?php endif ?>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($faculty = mysqli_fetch_assoc($faculty_result)) : ?>
                                        <?php
                                            $department_id = $faculty['department_id'];
                                            $department_query = "SELECT name FROM department WHERE id=$department_id";
                                            $department_result = mysqli_query($connection, $department_query);
                                            $department = mysqli_fetch_assoc($department_result);
                                        ?>
                                    <tr>
                                        <td class="text-capitalize"> <?= $count++; ?> </td>
                                        <td class="text-capitalize"> <?= $faculty['faculty_id']; ?> </td>
                                        <td class="text-capitalize"> <?= $faculty['last_name']; ?>, <?= $faculty['first_name']; ?> <?= $faculty['middle_name']; ?> </td>
                                        <td class="text-capitalize"> <?= $faculty['gender']; ?> </td>
                                        <td class="text-capitalize"> <?= $department['name']; ?> </td>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                            <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/faculty/see/?id=<?= $faculty['id'] ?>" class="btn btn-success" ><i class="fa-regular fa-eye"></i></a> </td>    
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/faculty/edit/?id=<?= $faculty['id'] ?>" class="btn btn-primary" ><i class="fa-regular fa-pen-to-square"></i></a> </td>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/faculty/delete/?id=<?= $faculty['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        <?php endif ?>      
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
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
<?php endif?>