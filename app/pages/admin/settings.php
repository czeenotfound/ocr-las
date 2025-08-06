<?php
    function currentschoolyear(){
        $currentYear = date('Y');
        // $testMonth = 9; // Example: September

        // // Use the specified test month if set, otherwise use the current month
        // $month = isset($testMonth) ? $testMonth : date('n');

        return (in_array(date('n'),array(7,8,9,10,11,12))) ? $currentYear . "-" . ($currentYear + 1) : ($currentYear - 1) . "-" . $currentYear;
    }
    function currentSemester() {
        $month = date('n');
        // $testMonth = 6; // Example: September
        // $month = isset($testMonth) ? $testMonth : date('n');

        if ($month >= 1 && $month <= 5) {
            return "2nd"; // Second semester from January to May
        } elseif ($month >= 7 && $month <= 12) {
            return "1st"; // First semester from June to December
        } else {
            return "Summer"; // Summer classes in June
        }
    }

    date_default_timezone_set('Asia/Hong_Kong');
    // Get the current timestamp
    $current_timestamp = time();
    $date = date('Y-m-d', $current_timestamp);
?>
<?php if($action == 'add'):?>
    <?php if(isset($_SESSION['user_is_admin'])) : ?>
    <main class="content px-3 py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                        <ol class="breadcrumb mb-0 d-flex justify-content-end">
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/dashboard" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?= ROOT_URL ?>admin/settings" class="text-decoration-none text-dark text-muted">Settings</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Add New Purpose</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <h2 class="fw-bold">Add New Purpose</h2>
            </div>
            <div class="card border-0 p-3">
            <?php
                $description = $_SESSION['add_purpose_data']['description'] ?? null;

                unset($_SESSION['add_purpose_data']);
            ?>
                <?php if (isset($_SESSION ['add_purpose'])): ?>
                    <div class="alert alert-danger messages w-100 n">
                        <?= $_SESSION['add_purpose'];
                            unset($_SESSION['add_purpose']);
                        ?>
                    </div>
                <?php endif ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="description" class="form-label">Purpose Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <hr>
                    <div class="float-end">
                        <a href="<?= ROOT_URL ?>admin/settings" type="button" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fa-solid fa-plus"></i> Add Purpose</button>
                    </div>
                </form>
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
            $query = "SELECT * FROM purpose WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_purpose = mysqli_fetch_assoc($result);
        }
    ?>
    <div class="card m-5">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Delete</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delete_id" id="delete_id">
                <p>Are you sure you want to delete <span class="fw-bold">"Purpose (<?= $delete_purpose['description'] ?>) ?</span></p>
            </div>
            
            <div class="modal-footer">      
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $delete_purpose['id'] ?>">
                    <div class="float-end">
                        <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                    </div>
                </form>              
                <a href="<?= ROOT_URL ?>admin/settings" type="button" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
    <?php else: ?>
        <h1>PAGE NOT FOUND</h2>
    <?php endif ?>  
<?php else:?>
<?php
    $count = 1;
    $purpose_query = "SELECT * FROM purpose";
    $purposes = mysqli_query($connection, $purpose_query);
?>
        <!-- Main -->
        <main class="content px-3 py-2 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                            <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Settings</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <h2 class="fw-bold">Settings</h2>
                </div>

                <!-- Table Element -->
                <div id="infoDashboard" class="row">
                    <div class="col-xl-12">    
                        <div class="card mb-4 profilehead">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">User Accounts</p>
                                    </div>
                                    <?php if(isset($_SESSION['user_is_admin'])) : ?>   
                                        <div class="col-sm-6">
                                            <a href="<?= ROOT_URL ?>admin/user-accounts" class="btn btn-primary mb-0"><i class="fa-solid fa-user-tie"></i> Manage Accounts</a>
                                        </div>
                                    <?php elseif ($_SESSION['user_is_staff']) : ?>
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary mb-0" disabled><i class="fa-solid fa-user-tie"></i> Manage Accounts</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">    
                        <div class="card mb-4 profilehead">
                            <div class="card-header p-2">
                                <h5 class="card-title text-center p-3">
                                    System's Information
                                </h5>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">System Name</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0">OCR-LAS (OCR-Library Attendance System)</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">System Created</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0">February 24, 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6">    
                        <div class="card border-0 shadow mb-4 profilehead">
                            <div class="card-header p-2">
                                <h5 class="card-title text-center p-3">
                                    Academic Year
                                </h5>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">School Year</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0"><?= currentschoolyear() ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">School Semester</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0"><?= currentSemester() ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="mb-0">Date</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0"><?= date('F d, Y', strtotime($date)) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <?php if (isset($_SESSION ['add-purpose-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['add-purpose-success'];
                                    unset($_SESSION['add-purpose-success']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['add_purpose_failed'])): ?>
                            <div class="alert alert-danger messages w-100 n">
                                <?= $_SESSION['add_purpose_failed'];
                                    unset($_SESSION['add_purpose_failed']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['edit-purpose-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['edit-purpose-success'];
                                    unset($_SESSION['edit-purpose-success']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['edit_purpose_failed'])): ?>
                            <div class="alert alert-danger messages w-100 n">
                                <?= $_SESSION['edit_purpose_failed'];
                                    unset($_SESSION['edit_purpose_failed']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['delete-purpose-success'])): ?>
                            <div class="alert alert-success messages w-100 n">
                                <?= $_SESSION['delete-purpose-success'];
                                    unset($_SESSION['delete-purpose-success']);
                                ?>
                            </div>
                        <?php elseif (isset($_SESSION ['delete_purpose_failed'])): ?>
                            <div class="alert alert-danger messages w-100 n">
                                <?= $_SESSION['delete_purpose_failed'];
                                    unset($_SESSION['delete_purpose_failed']);
                                ?>
                            </div>
                        <?php endif ?>
                        <div class="card-header p-2">
                            <h5 class="card-title text-left p-3">
                                Library Purposes
                                <div class="btn-group float-end">
                                    <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <a href="<?= ROOT_URL ?>admin/settings/add" class="btn btn-dark" ><i class="fa-regular fa-plus"></i></a>
                                    <?php endif ?>
                                </div>
                            </h5>
                        </div>
                        
                        <?php if (mysqli_num_rows($purposes) > 0): ?>
                        <div class="card mb-3 border-0 shadow p-3 table-responsive">
                            <table id="purpose" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Library Purposes</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th>Action</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($purpose = mysqli_fetch_assoc($purposes)) : ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $purpose['description'] ?></td>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                            <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/settings/delete/?id=<?= $purpose['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        <?php endif ?>
                                    </tr>
                                <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <h5 class="text-center p-4 alert-danger mb-0">There are no data</h2>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- ========= End of Main Section ========= -->
</div>
<?php endif?>