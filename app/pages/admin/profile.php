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
    $current_user_id = $_SESSION['user-id'];

    // Fetch user profile data
    $query = "SELECT * FROM users WHERE id=$current_user_id";
    $result = mysqli_query($connection, $query);
    $profile_user = mysqli_fetch_assoc($result);
?>
<?php if($action == 'edit'):?>
    <?php
        if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM users WHERE id=$current_user_id";
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
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/profile/?id=<?= $profile_users['id'] ?>" class="text-decoration-none text-dark text-muted">Profile</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Edit Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Edit Profile</h2>
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
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $edit_users['first_name'] ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $edit_users['middle_name'] ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $edit_users['last_name'] ?>">
                            </div>
                        </div>
                    
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $edit_users['username'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $edit_users['mobile'] ?>">
                        </div>
                        <hr>
                        <div class="float-end">
                            <a href="<?= ROOT_URL ?>admin/profile/?id=<?= $profile_users['id'] ?>" type="button" class="btn btn-secondary">Cancel</a>
                            <button type="submit" name="submit" class="btn btn-primary">Edit Profile</button>
                        </div>
                    </form>
                <!-- END of User -->
            </div>
        </div>
    </main>
<?php else:?>
            <!-- Main -->
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                    <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Profile</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card mb-2 profilehead">
                                <div class="card-body text-center">
                                    <img src="<?= $avatarPath ?>" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px;">
                                    <h5 class="my-3"><?= $profile_user['first_name'] ?></h5>
                                    <div class="d-flex justify-content-center mb-2">
                                        <a href="<?= ROOT_URL ?>admin/profile/edit/?id=<?= $profile_users['id'] ?>" type="button" class="btn btn-dark text-white ms-1">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <h4 class="mb-3">My Profile</h4>    
                            <div class="card mb-4 profilehead">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">First Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?= $profile_user['first_name'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Middle Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?= $profile_user['middle_name'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Last Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?= $profile_user['last_name'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Phone</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?= $profile_user['mobile'] ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Position</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0"><?php
                                            switch ($profile_user['status']) {
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
                                                    echo 'Unknown';
                                            }
                                        ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-9">
                            <?php if(isset($_SESSION ['changepass'])): ?>
                                <div class="alert alert-danger messages w-100 n">
                                    <?= $_SESSION['changepass'];
                                        unset($_SESSION['changepass']);
                                    ?>
                                </div>
                            <?php elseif(isset($_SESSION ['changepass-success'])): ?>
                                <div class="alert alert-success messages w-100 n">
                                    <?= $_SESSION['changepass-success'];
                                        unset($_SESSION['changepass-success']);
                                    ?>
                                </div>
                            <?php endif ?> 
                            <div class="card mb-4 profilehead">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <p class="mb-0">Change Password</p>
                                            </div>
                                            <div class="col-sm-9">
                                                <button class="btn btn-primary" id="changePasswordBtn">Change</button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <div class="col-lg-3">
                            </div>

                            <div class="col-lg-9" id="changePasswordFormContainer" style="display: none;">
                                <h4 class="mb-3">Change Password</h4>          
                                <div class="card mb-4 profilehead">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="row p-3">
                                                <form action="<?= ROOT_URL ?>admin/profile/chpass/?id=<?= $profile_users['id'] ?>" method="POST">
                                                    <input type="hidden" id="username" name="username"  value="<?= $profile_user['username'] ?>">
                                                    <div class="col mb-3">
                                                        <label for="old_password" class="form-label">Old Password</label>
                                                        <input type="password" class="form-control" id="old_password" name="old_password">
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label for="create_password" class="form-label">Create New Password</label>
                                                        <input type="password" class="form-control" id="create_password" name="create_password">
                                                    </div>
                                                    <div class="col mb-3">
                                                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                    </div>

                                                    <div class="float-end">
                                                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- ========= End of Main Section ========= -->
    </div>
    <script>
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            var formContainer = document.getElementById('changePasswordFormContainer');
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        });
    </script>

    
<?php endif;?>