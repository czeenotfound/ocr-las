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
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/department" class="text-decoration-none text-dark text-muted">Department</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Add New Department</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Add New Department</h2>
            </div>
            <div class="card border-0 p-3">
            <?php
                $name = $_SESSION['add_department_data']['department_name'] ?? null;

                unset($_SESSION['add_department_data']);
            ?>
                <?php if (isset($_SESSION ['add_department'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_department'];
                            unset($_SESSION['add_department']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="department_name" name="department_name">
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/department" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Department</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </main>
<?php elseif($action == 'edit'):?>
    <?php
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM department WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $edit_department = mysqli_fetch_assoc($result);
        }
    ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/department" class="text-decoration-none text-dark text-muted">Department</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Edit Department</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Edit Department</h2>
            </div>
            <div class="card border-0 p-3">
            <?php
                $name = $_SESSION['add_department_data']['department_name'] ?? null;

                unset($_SESSION['add_department_data']);
            ?>
                <?php if (isset($_SESSION ['add_department'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_department'];
                            unset($_SESSION['add_department']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $edit_department['id'] ?>">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" value="<?= $edit_department['name']?>">
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/department" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-regular fa-pen-to-square"></i> Edit Department</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </main>
<?php elseif($action == 'delete'):?>
    <?php
         if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM department WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_department = mysqli_fetch_assoc($result);
        }
    ?>
    <div class="card m-5">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Delete</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_id" id="delete_id">
                <p>Are you sure you want to delete <span class="fw-bold">"Department (<?= $delete_department['name'] ?>)" ? </span></p>
            </div>
            
            <div class="modal-footer">      
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $delete_department['id'] ?>">
                    <div class="float-end">
                        <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                    </div>
                </form>              
                <a href="<?= ROOT_URL ?>admin/department" type="button" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
<?php elseif($action == 'import'):?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/department" class="text-decoration-none text-dark text-muted">Department</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Import Department</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Import Department</h2>
            </div>
            <div class="card border-0 p-3">
                <?php if (isset($_SESSION ['import-department-failed'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['import-department-failed'];
                            unset($_SESSION['import-department-failed']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="import_department_excel" class="form-label">Excel File</label>
                        <input type="file" class="form-control" id="import_department_excel" name="import_department_excel" required>
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/department" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-file-import"></i> Import Department</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php else:?>
<?php
    $count = 1;
    $query = "SELECT * FROM department ORDER BY name";
    $departments = mysqli_query($connection, $query);
?>
        <!-- Main -->
        <main class="content px-3 py-2 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Department</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <?php if (isset($_SESSION ['add-department-success'])): ?>
                    <div class="alert alert-success messages w-100 n">
                        <?= $_SESSION['add-department-success'];
                            unset($_SESSION['add-department-success']);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION ['add_department_failed'])): ?>
                    <div class="alert alert-success messages w-100 n">
                        <?= $_SESSION['add_department_failed'];
                            unset($_SESSION['add_department_failed']);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION ['delete-department-success'])): ?>
                    <div class="alert alert-success messages w-100 n">
                        <?= $_SESSION['delete-department-success'];
                            unset($_SESSION['delete-department-success']);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION ['delete_department_failed'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['delete_department_failed'];
                            unset($_SESSION['delete_department_failed']);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION ['edit-department-success'])): ?>
                    <div class="alert alert-success messages w-100 n">
                        <?= $_SESSION['edit-department-success'];
                            unset($_SESSION['edit-department-success']);
                        ?>
                    </div>
                <?php elseif (isset($_SESSION ['import-department-success'])): ?>
                    <div class="alert alert-success messages w-100 n">
                        <?= $_SESSION['import-department-success'];
                            unset($_SESSION['import-department-success']);
                        ?>
                    </div>
                <?php endif ?>
                <!-- Table Element -->
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Department</h2>
                </div>

                
                <div class="card border-0">
                    <?php if(isset($_SESSION['user_is_admin'])) : ?>
                    <div class="card-header d-flex justify-content-end align-items-center">
                    <a href="<?= ROOT_URL ?>admin/department/add" class="btn btn-outline-danger"><i class="fa-regular fa-plus"></i> Add New Department</a>
                        <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                            <ul class="dropdown-menu">
                                <li><p class="mx-2 text-muted">Export</p></li>
                                <li><button class="dropdown-item" id="btn-excel"><i class="fa-solid fa-file-excel"></i> Save as Excel</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><p class="mx-2 text-muted">Import</p></li>
                                <li><a href="<?= ROOT_URL ?>admin/department/import" class="dropdown-item btn btn-outline-danger"><i class="fa-solid fa-file-import"></i> Import Department</a></li>
                            </ul>
                    </div>
                    <?php endif ?>  
                    <?php if (mysqli_num_rows($departments) > 0): ?>
                    <div class="card-body">
                        <table id="department" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Department Name</th>
                                    <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                    <th colspan="2">Action</th>
                                    <?php endif ?>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($department = mysqli_fetch_assoc($departments)) : ?>
                                <tr>
                                    <td> <?= $count++ ?></td>
                                    <td> <?= $department['name']; ?> </td>
                                    <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                    <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/department/edit/?id=<?= $department['id'] ?>" class="btn btn-primary" ><i class="fa-regular fa-pen-to-square"></i></a> </td>
                                    <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/department/delete/?id=<?= $department['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                    <?php endif ?>      
                                </tr>
                                <?php endwhile ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Department Name</th>
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