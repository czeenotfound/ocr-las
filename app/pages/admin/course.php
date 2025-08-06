<?php if($action == 'add'):?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/course" class="text-decoration-none text-dark text-muted">Course</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Add New Course</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Add New Course</h2>
            </div>
            <div class="card border-0 p-3">
                <?php if (isset($_SESSION ['add_course'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_course'];
                            unset($_SESSION['add_course']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
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
                        <a href="<?= ROOT_URL ?>admin/course" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Course</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php elseif($action == 'edit'):?>
    <?php
        $departmentquery = "SELECT * FROM department";
        $departments = mysqli_query($connection, $departmentquery);

        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM course WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $edit_course = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/course" class="text-decoration-none text-dark text-muted">Course</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Edit Course</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Edit Course</h2>
            </div>
            <div class="card border-0 p-3">
                <!-- ADD User -->
                <?php if (isset($_SESSION ['add_course'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_course'];
                            unset($_SESSION['add_course']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $edit_course['id'] ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $edit_course['name'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <?php while($department = mysqli_fetch_assoc($departments)) : 
                                $selected = ( $edit_course['department_id'] == $department['id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $department['id'] ?>" <?= $selected ?>><?= $department['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <hr>

                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/course" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-regular fa-pen-to-square"></i> Edit Course</button>
                    </div>
                </form>
                <!-- END of User -->
            </div>
        </div>
    </main>
<?php elseif($action == 'delete'):?>
    <?php
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM course WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_course = mysqli_fetch_assoc($result);
        } 
    ?>
    <!-- DELETE -->
        <!-- User -->
        <div class="card m-5">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Delete</h2>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <p>Are you sure you want to delete <span class="fw-bold">"Course (<?= $delete_course['name'] ?>)" ? </span></p>
                </div>
                
                <div class="modal-footer">      
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $delete_course['id'] ?>">
                        <div class="float-end">
                            <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                        </div>
                    </form>              
                    <a href="<?= ROOT_URL ?>admin/course" type="button" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
        
        <!-- End of User -->
    <!-- End of DELETE -->
<?php elseif($action == 'import'):?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/course" class="text-decoration-none text-dark text-muted">Course</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Import Course</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Import Course</h2>
            </div>
            <div class="card border-0 p-3">
                <?php if (isset($_SESSION ['import-course-failed'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['import-course-failed'];
                            unset($_SESSION['import-course-failed']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="import_course_excel" class="form-label">Excel File</label>
                        <input type="file" class="form-control" id="import_course_excel" name="import_course_excel" required>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/course" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-file-import"></i> Import Course</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php else:?>
<?php
    $count = 1;
    $query = "SELECT * FROM course ORDER BY name";
    $courses = mysqli_query($connection, $query);
?>

            <!-- Main -->
            <main class="content px-3 py-2 ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                    <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page">Course</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <?php if (isset($_SESSION ['add-course-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['add-course-success'];
                                unset($_SESSION['add-course-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['import-course-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['import-course-success'];
                                unset($_SESSION['import-course-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['add_course_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_course_failed'];
                                unset($_SESSION['add_course_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['import-course-failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['import-course-failed'];
                                unset($_SESSION['import-course-failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete-course-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['delete-course-success'];
                                unset($_SESSION['delete-course-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete_course_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['delete_course_failed'];
                                unset($_SESSION['delete_course_failed']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['edit-course-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['edit-course-success'];
                                unset($_SESSION['edit-course-success']);
                            ?>
                        </div>
                    <?php endif ?>
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Course</h2>
                    </div>
                    
                    <div class="card border-0">
                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                        <div class="card-header d-flex justify-content-end align-items-center">
                            <a href="<?= ROOT_URL ?>admin/course/add" class="btn btn-outline-danger"><i class="fa-regular fa-user"></i> Add New Course</a>
                            <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                                <ul class="dropdown-menu">
                                    <li><p class="mx-2 text-muted">Export</p></li>
                                    <li><button class="dropdown-item" id="btn-excel"><i class="fa-solid fa-file-excel"></i> Save as Excel</button></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><p class="mx-2 text-muted">Import</p></li>
                                    <li><a href="<?= ROOT_URL ?>admin/course/import" class="dropdown-item btn btn-outline-danger"><i class="fa-solid fa-file-import"></i> Import Courses</a></li>
                                </ul>
                        </div>
                        <?php endif ?>  
                        <?php if (mysqli_num_rows($courses) > 0): ?>
                        <div class="card-body">
                            <table id="course" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Department</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th colspan="2">Action</th>
                                        <?php endif ?>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($course = mysqli_fetch_assoc($courses)) : ?>
                                        <?php
                                            $department_id = $course['department_id'];
                                            $department_query = "SELECT name FROM department WHERE id=$department_id";
                                            $department_result = mysqli_query($connection, $department_query);
                                            $department = mysqli_fetch_assoc($department_result);
                                        ?>
                                    
                                    <tr>
                                        <td> <?= $count++; ?> </td>
                                        <td class="text-capitalize"> <?= $course['name']; ?></td>
                                        <td class="text-capitalize"> <?= $department['name']; ?> </td>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/course/edit/?id=<?= $course['id'] ?>" class="btn btn-primary" ><i class="fa-regular fa-pen-to-square"></i></a> </td>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/course/delete/?id=<?= $course['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        <?php endif ?>     
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Department</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th colspan="2">Action</th>
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