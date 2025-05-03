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
<?php if($action == 'delete'):?>
    <?php
         if(isset($_GET['id'])){
            $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
            $query = "SELECT * FROM visitors WHERE id=$id";
            $result = mysqli_query($connection, $query);
            $delete_visitor = mysqli_fetch_assoc($result);
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
                    <p>Are you sure you want to delete <span class="fw-bold">"Visitor (<?= $delete_visitor['last_name'] ?>, <?= $delete_visitor['first_name'] ?> <?= $delete_visitor['middle_name'] ?>)" ? </span></p>
                </div>
                
                <div class="modal-footer">      
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $delete_visitor['id'] ?>">
                        <div class="float-end">
                            <button type="submit" name="submit" class="btn btn-danger" name="deleteData">DELETE</button>
                        </div>
                    </form>              
                    <a href="<?= ROOT_URL ?>admin/visitor" type="button" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
        
        <!-- End of User -->
    <!-- End of DELETE -->
<?php else:?>
<?php
    date_default_timezone_set('Asia/Hong_Kong');
    // Get the current timestamp
    $current_timestamp = time();
    $date = date('Y-m-d', $current_timestamp);

    $count = 1;
    $visitor_query = "SELECT * FROM visitors";
    $visitor_result = mysqli_query($connection, $visitor_query);
?>

            <!-- Main -->
            <main class="content px-3 py-2 ">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-3 mt-3">
                                <ol class="breadcrumb mb-0 d-flex justify-content-end">
                                    <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-dark text-muted">Dashboard</a></li>
                                    <li class="breadcrumb-item active text-dark" aria-current="page"> Visitors</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <?php if (isset($_SESSION ['delete-visitor-success'])): ?>
                        <div class="alert alert-success messages w-100 n">
                            <?= $_SESSION['delete-visitor-success'];
                                unset($_SESSION['delete-visitor-success']);
                            ?>
                        </div>
                    <?php elseif (isset($_SESSION ['delete_visitor_failed'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['delete_visitor_failed'];
                                unset($_SESSION['delete_visitor_failed']);
                            ?>
                        </div>
                    <?php endif ?> 
                    <!-- Table Element -->
                    <div class="mt-4 mb-5">
                        <h2 class="fw-bold">Visitors</h2>
                    </div>

                    
                    <div class="card border-0">
                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                <div class="btn-group float-end">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        Export
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
                                </div> 
                            </h5>
                        </div>
                        <?php endif ?>  
                        <?php if (mysqli_num_rows($visitor_result) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="visitors" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Visitor ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Mobile No.</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th>Action</th>
                                        <?php endif ?>  
                                    </tr>
                                </thead>
                                <tbody>
                                <?php while ($visitor = mysqli_fetch_assoc($visitor_result)) : ?>
                                    <tr>
                                        <td>  <?= $count++; ?></td>
                                        <td>  <?= $visitor['visitor_id']; ?></td>
                                        <td class="text-capitalize"> <?= $visitor['last_name']; ?>, <?= $visitor['first_name']; ?> <?= $visitor['middle_name']; ?></td>
                                        <td class="text-capitalize">  <?= $visitor['gender']; ?></td>
                                        <td>  <?= $visitor['mobile']; ?></td>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <td class="text-capitalize"> <a href="<?= ROOT_URL ?>admin/visitor/delete/?id=<?= $visitor['id'] ?>" class="btn btn-danger" ><i class="fa-regular fa-trash-can"></i></a></td>
                                        <?php endif ?>      
                                    </tr>
                                <?php endwhile ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Visitor ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Mobile No.</th>
                                        <?php if(isset($_SESSION['user_is_admin'])) : ?>
                                        <th>Action</th>
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