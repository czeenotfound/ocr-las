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
    <!-- LOGOUT MODAL -->
    <div class="modal fade " id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="<?= ROOT_URL ?>user_logout" type="button" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END of LOGOUT MODAL -->
     <!-- <?php
     $first_name = $_SESSION['add_user']['first_name'] ?? null;
     $last_name = $_SESSION['add_user']['last_name'] ?? null;
     $username = $_SESSION['add_user']['username'] ?? null;
     $createpassword = $_SESSION['add_user']['createpassword'] ?? null;
     $confirmpassword = $_SESSION['add_user']['confirmpassword'] ?? null;
 
     unset($_SESSION['add_user_data']);
     ?> -->
    <!-- ADD User -->
    <!-- <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION ['add_user'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_user'];
                                unset($_SESSION['add_user']);
                            ?>
                        </div>
                    <?php endif ?>
                    <form action="<?= ROOT_URL ?>admin/add-user-method" method="POST">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>"   >
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>"  >
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Create Password</label>
                            <input type="password" class="form-control" id="password" name="createpassword" value="<?= $createpassword ?>"  required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirmpassword" value="<?= $confirmpassword ?>"  required>
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">User Role</label>
                            <select class="form-select" required name="user_role" id="user_role">
                                <option value="0">Staff</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="float-end">
                            <button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  -->
    <!-- END of User -->


    <!-- ADD Student --> 
    <?php if($action == 'import'):?>
        <div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Import Excel Students</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="import_students_excel" class="form-label">Excel File</label>
                                <input type="file" class="form-control" id="import_students_excel" name="import_students_excel" required>
                            </div>
                            <hr>
                            <div class="float-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif?>
    <!-- End of student modal -->

    <!-- ADD Faculty -->

    <div class="modal fade" id="addFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacultyModalLabel">Add New Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION ['add_faculty'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_faculty'];
                                unset($_SESSION['add_faculty']);
                            ?>
                        </div>
                    <?php endif ?>
                    <form action="<?= ROOT_URL ?>admin/add-faculty-method.php" method="POST">
                        <div class="mb-3">
                            <label for="faculty_id" class="form-label">Faculty ID</label>
                            <input type="text" class="form-control" id="faculty_id" name="faculty_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
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
                                <?php while($course = mysqli_fetch_assoc($courses_faculty)) : ?>
                                    
                                    <option value="<?= $course['id'] ?> = <?= $course['name'] ?>"><?= $course['name'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department_id" name="department_id" readonly>
                        </div> -->
                        <hr>

                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Faculty</button>
                        </div>
                        
                    </form>
                </div>

                <!-- Script course and department name  -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="importFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacultyModalLabel">Import Excel Faculty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>admin/import-faculty-method.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="import_faculty_excel" class="form-label">Excel File</label>
                            <input type="file" class="form-control" id="import_faculty_excel" name="import_faculty_excel" required>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Import</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- End of faculty modal -->

    <!-- ADD Course -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION ['add_course'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_course'];
                                unset($_SESSION['add_course']);
                            ?>
                        </div>
                    <?php endif ?>
                    <form action="<?= ROOT_URL ?>admin/add-course-method.php" method="POST">
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="department_id">Department</label>
                            <select class="form-control" name="department_id">
                                <?php while($name = mysqli_fetch_assoc($department_ids)) : ?>
                                    <option value="<?= $name['id'] ?> = <?= $name['name'] ?>"><?= $name['name'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Course</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="importCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Import Excel Courses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>admin/import-course-method.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="import_course_excel" class="form-label">Excel File (.xls, .csv, .xlsx)</label>
                            <input type="file" class="form-control" id="import_course_excel" name="import_course_excel" required>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Import</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- End of course modal -->

    <!-- ADD Department -->

    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>admin/add-department-method.php" method="POST">
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="department_name" name="department_name" required>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Department</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="importDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Import Excel Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>admin/import-department-method.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="import_department_excel" class="form-label">Excel File</label>
                            <input type="file" class="form-control" id="import_department_excel" name="import_department_excel" required>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Import</button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- End of department modal -->
    
    <script src="<?= ROOT_URL ?>/assets/JS/jquery-3.7.1.js"></script>
    <script src="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>/assets/JS/datatables/dataTables.bootstrap5.js"></script>
    <script src="<?= ROOT_URL ?>/assets/JS/datatables/dataTables.js"></script>
    <!-- <script src="/assets/JS/exportDatatables/dataTables.buttons.js"></script>
    <script src="/assets/JS/exportDatatables/jszip.min.js"></script>
    <script src="/assets/JS/exportDatatables/pdfmake.min.js"></script>
    <script src="/assets/JS/exportDatatables/vfs_fonts.js"></script>
    <script src="/assets/JS/exportDatatables/buttons.html5.min.js"></script>
    <script src="/assets/JS/exportDatatables/buttons.print.min.js"></script> -->
    
    <script src="<?= ROOT_URL ?>/assets/JS/script.js"></script>
</body>
</html>