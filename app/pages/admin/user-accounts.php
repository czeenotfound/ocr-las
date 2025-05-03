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
<?php if(isset($_SESSION['user_is_admin'])) : ?>
    <?php if($action == 'add'):?>
        <main class="content px-3 py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/user-accounts" class="text-decoration-none text-dark text-muted">Users Account</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Add New User</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Add New User</h2>
                </div>
                <div class="card border-0 p-3">
                <?php
                    $first_name = $_SESSION['add_user_data']['first_name'] ?? null;
                    $middle_name = $_SESSION['add_user_data']['middle_name'] ?? null;
                    $last_name = $_SESSION['add_user_data']['last_name'] ?? null;
                    $username = $_SESSION['add_user_data']['username'] ?? null;
                    $mobile = $_SESSION['add_user_data']['mobile'] ?? null;
                    $createpassword = $_SESSION['add_user_data']['createpassword'] ?? null;
                    $confirmpassword = $_SESSION['add_user_data']['confirmpassword'] ?? null;
                
                    unset($_SESSION['add_user_data']);
                    ?>
                    <!-- ADD User -->
                        <?php if (isset($_SESSION ['add_user'])): ?>
                            <div class="alert alert-danger messages w-100 n">
                                <?= $_SESSION['add_user'];
                                    unset($_SESSION['add_user']);
                                ?>
                            </div>
                        <?php endif ?>
                        <form method="POST">
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>"   >
                                </div>
                                <div class="mb-3 col">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $last_name ?>"  >
                                </div>
                                <div class="mb-3 col">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>"  >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" >
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="form-label">Mobile Number <small class="text-muted">(ex. 09xxxxxxxxx)</small></label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $mobile ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Create Password</label>
                                <input type="password" class="form-control" id="password" name="createpassword" value="<?= $createpassword ?>">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirmpassword" value="<?= $confirmpassword ?>">
                            </div>
                            <div class="mb-3">
                                <label for="user_role" class="form-label">User Role</label>
                                <select class="form-select" required name="user_role" id="user_role">
                                    <option value="0">Disable</option>
                                    <option value="1">Staff</option>
                                    <option value="2">Admin</option>
                                </select>
                            </div>
                            <hr>
                            <div class="float-end">
                                <a href="<?= ROOT_URL ?>admin/user-accounts" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    <!-- END of User -->
                </div>
            </div>
        </main>
    <?php elseif($action == 'see'):?>
        <?php
            if(isset($_GET['id'])){
                $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
                $query = "SELECT * FROM users WHERE id=$id";
                $result = mysqli_query($connection, $query);
                $view_users = mysqli_fetch_assoc($result);
            }
        ?>
        <main class="content px-3 py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/user-accounts" class="text-decoration-none text-dark text-muted">Users Account</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">View User</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">View User</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card mb-2 profilehead">
                            <div class="card-body text-center">
                                <img src="<?= $avatarPath ?>" alt="avatar"
                                class="rounded-circle img-fluid" style="width: 150px;">
                                <h5 class="my-3"><?= $view_users['username'] ?></h5>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="<?= ROOT_URL ?>admin/user-accounts/edit/?id=<?= $view_users['id'] ?>" type="button" class="btn btn-dark text-white ms-1">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card mb-4 profilehead">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">First Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $view_users['first_name'] ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Middle Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $view_users['middle_name'] ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Last Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $view_users['last_name'] ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $view_users['mobile'] ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Position</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">
                                            <?php  switch ($view_users['status']) {
                                                case 0:
                                                    echo '<i class="fa-solid fa-ban text-danger"></i> Disabled';
                                                    break;
                                                case 1:
                                                    echo 'Staff';
                                                    break;
                                                case 2:
                                                    echo 'Admin';
                                                    break;
                                                default:
                                                    echo 'Unknown'; }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php elseif($action == 'edit'):?>
        <?php
            if(isset($_GET['id'])){
                $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
                $query = "SELECT * FROM users WHERE id=$id";
                $result = mysqli_query($connection, $query);
                $edit_users = mysqli_fetch_assoc($result);
            }
        ?>
        <main class="content px-3 py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/user-accounts" class="text-decoration-none text-dark text-muted">Users Account</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Edit User</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Edit User</h2>
                </div>
                <div class="card border-0 p-3">
                    <?php
                        $first_name = $_SESSION['add_user']['first_name'] ?? null;
                        $middle_name = $_SESSION['add_user']['middle_name'] ?? null;
                        $last_name = $_SESSION['add_user']['last_name'] ?? null;
                        $username = $_SESSION['add_user']['username'] ?? null;

                        unset($_SESSION['add_user_data']);
                    ?>
                    <!-- ADD User -->
                    <?php if (isset($_SESSION ['add_user'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_user'];
                                unset($_SESSION['add_user']);
                            ?>
                        </div>
                    <?php endif ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $edit_users['id'] ?>">
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $edit_users['first_name'] ?>" readonly>
                                </div>
                                <div class="mb-3 col">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $edit_users['middle_name'] ?>" readonly>
                                </div>
                                <div class="mb-3 col">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $edit_users['last_name'] ?>" readonly>
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $edit_users['username'] ?>"readonly>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= $edit_users['mobile'] ?>"readonly>
                            </div>

                            <div class="mb-3">
                                <label for="user_role" class="form-label">User Role</label>
                                <select class="form-select" required name="user_role" id="user_role">
                                    <option value="0" <?= ($edit_users['status'] == 0) ? 'selected' : '' ?>>Disable</option>
                                    <option value="1" <?= ($edit_users['status'] == 1) ? 'selected' : '' ?>>Staff</option>
                                    <option value="2" <?= ($edit_users['status'] == 2) ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </div>
                            <hr>
                            <div class="float-end">
                                <a href="<?= ROOT_URL ?>admin/user-accounts" type="button" class="btn btn-secondary">Cancel</a>
                                <button type="submit" name="submit" class="btn btn-primary">Edit User</button>
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
                $query = "SELECT * FROM users WHERE id=$id";
                $result = mysqli_query($connection, $query);
                $delete_users = mysqli_fetch_assoc($result);
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
                        <p>Are you sure you want to delete <span class="fw-bold">"User (<?= $delete_users['last_name'] ?>, <?= $delete_users['first_name'] ?>)" ? </span></p>
                    </div>
                    
                    <div class="modal-footer">      
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $delete_users['id'] ?>">
                            <div class="float-end">
                                <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                            </div>
                        </form>              
                        <a href="<?= ROOT_URL ?>admin/user-accounts" type="button" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
            
            <!-- End of User -->
        <!-- End of DELETE -->
    <?php else:?>
    <?php
        $current_admin_id = $_SESSION['user-id'];

        $query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
        $users = mysqli_query($connection, $query);

    ?>  

                <!-- Main -->
                <main class="content px-3 py-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                    <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                        <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                        <li class="breadcrumb-item active text-dark" aria-current="page">Users Account</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <?php if (isset($_SESSION ['add-user-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['add-user-success'];
                                    unset($_SESSION['add-user-success']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['edit-user-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['edit-user-success'];
                                    unset($_SESSION['edit-user-success']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['delete-user-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['delete-user-success'];
                                    unset($_SESSION['delete-user-success']);
                                ?>
                            </div>
                        <?php endif ?>
                        <div class="mt-4 mb-5">
                            <h2 class="fw-bold">Manage Users</h2>
                        </div>
                        <div class="card border-0">
                            <div class="card-header d-flex justify-content-end align-items-center ">
                                <a href="<?= ROOT_URL ?>admin/user-accounts/add" class="btn btn-outline-danger"><i class="fa-regular fa-user"></i> Add New User</a>
                                <button type="button" class="btn btn-danger  dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><p class="mx-2 text-muted">Export</p></li>
                                    <li><button class="dropdown-item" id="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Save as PDF</button></li>
                                    <li><button class="dropdown-item" id="btn-excel"><i class="fa-solid fa-file-excel"></i>  Save as Excel</button></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><p class="mx-2 text-muted">Print</p></li>
                                    <li><button class="dropdown-item" id="btn-print"><i class="fa-solid fa-print"></i> Print</button></li>
                                </ul>
                            </div>
                            <?php if (mysqli_num_rows($users) > 0): ?>
                            <div class="card-body">
                                <table id="users" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>User Role</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                                        <tr>
                                            <td> <?= $user['id']; ?> </td>
                                            <td class="text-capitalize"> <?= $user['username']; ?> </td>
                                            <td class="text-capitalize"> <?= $user['last_name']; ?>, <?= $user['first_name']; ?> <?= $user['middle_name']; ?></td>
                                            <td class="text-capitalize">
                                                <?php   switch ($user['status']) {
                                                        case 0:
                                                            echo '<i class="fa-solid fa-ban text-danger"></i> Disabled';
                                                            break;
                                                        case 1:
                                                            echo 'Staff';
                                                            break;
                                                        case 2:
                                                            echo 'Admin';
                                                            break;
                                                        default:
                                                            echo 'Unknown'; }
                                                ?>
                                            </td>
                                            <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/user-accounts/see/?id=<?= $user['id'] ?>" class="btn btn-success" ><i class="fa-regular fa-eye"></i></a> </td>
                                            <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/user-accounts/edit/?id=<?= $user['id'] ?>" class="btn btn-primary" ><i class="fa-regular fa-pen-to-square"></i></a> </td>
                                            <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/user-accounts/delete/?id=<?= $user['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>User Role</th>
                                            <th colspan="3">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php else : ?>
                                <h5 class="text-center p-4 alert-danger mb-0">There are no data</h2>
                            <?php endif ?>
                        </div>
                    </div>
                </main>
            </div>
            <!-- ========= End of Main Section ========= -->
        </div>
    <?php endif;?>
<?php else: ?>
    <h1>PAGE NOT FOUND</h2>
<?php endif ?>  