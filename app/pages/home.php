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
    include 'includes/header.php';

    
    // Check if user is logged in
    if(isset($_SESSION['username'])) {
        // Destroy the session
        session_unset();
        session_destroy();
        
        // Redirect to the logout page or any other page
        header("Location: home.php");
        exit();
    }
?>  
    <main class="content px-3 py-2 mt-5">
        <div class="container-fluid row">
            <div class="mb-4 text-center">
                <h1 id="clock" class="fw-bold">0:0:0 </h1>
                <h5 class="fw-bold">S.Y. <?= currentschoolyear() ?> - <?= currentSemester() ?> Semester</h5>
                <h5 class="fw-bold"><?php if (isCurrentlyOpen()) { echo "We are currently open!"; } else { echo "We are currently closed."; } ?> </h5>
            </div>
            <!--  TIME  -->
            
            <!-- end of TIME  -->
            <?php if (isset($_SESSION ['error_purpose'])): ?>
                <div class='alert bg-danger alert-dismissible fade show text-white' role="alert" id="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h4><i class='icon fa fa-warning'></i>
                        <?= $_SESSION['error_purpose'];
                            unset($_SESSION['error_purpose']);
                        ?>
                    </h4>
                </div>
            <?php endif ?>
            <!-- Left Section -->
            <div id="leftSection" class="col mb-3">
                <div class="card h-100">
                    <button id="SCANID" class="col form-horizontal bg-danger border-0 fw-bold" data-bs-toggle="modal" data-bs-target="#SCANIDModal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Visitor Time In & Time Out">
                     <i class="fa-solid fa-expand"></i> Scan ID Number
                    </button>
                </div>
            </div>
            
            <!-- end of Left Section -->

            <!-- Right Section -->
            <div id="rightSection" class="col">
                <div class="col-xl-12 col-lg-12 col-md-12 mb-3">
                    <?php if (isset($_SESSION ['input_success'])): ?>
                        <div class='alert bg-success alert-dismissible fade show text-white' role="alert" id="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <h4><i class='icon fa fa-check'></i> 
                                <?= $_SESSION['input_success'];
                                    unset($_SESSION['input_success']);
                                ?>
                            </h4>
                        </div>
                    <?php elseif (isset($_SESSION ['input_failed'])): ?>
                        <div class='alert bg-danger alert-dismissible fade show text-white' role="alert" id="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <h4><i class='icon fa fa-warning'></i>
                                <?= $_SESSION['input_failed'];
                                    unset($_SESSION['input_failed']);
                                ?>
                            </h4>
                        </div>
                    <?php endif ?>
                    <div id="resulttt"></div>
                    <div class="card px-4 col-xl-12 col-lg-12 col-md-12">
                        <form action="<?= ROOT_URL ?>verify" method="POST" class="form-horizontal p-3" id="divvideo">
                            <i class="fa-regular fa-id-card"></i>
                            <label>ID Number</label><p id="time"></p>
                           
                            <div class="mb-3">
                                <input type="text" name="studentID" id="text" placeholder="Scan ID Number" class="form-control">
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="card col-xl-12 col-lg-12 col-md-12" style="height: 150px;">
                        <button id="visitorBTN" class="col form-horizontal bg-danger border-0 fw-bold" data-bs-toggle="modal" data-bs-target="#visitorModal"  data-bs-toggle="tooltip" data-bs-placement="top" title="Visitor Time In & Time Out">
                            <i class="col fa-solid fa-user-group"></i> Are you a Visitor?
                        </button>
                    </div>
                    <script>
                        window.addEventListener('DOMContentLoaded', function() {
                            var inputField = document.getElementById('text');
                            
                            // Define time ranges when the input field should be enabled
                            var morningStartHour = 8;
                            var morningEndHour = 13;
                            var afternoonStartHour = 13; // 1 PM
                            var afternoonEndHour = 23;   // 4 PM

                            var currentTime = new Date();
                            var currentHour = currentTime.getHours();

                            // Check if current hour is within the allowed ranges
                            var isMorning = currentHour >= morningStartHour && currentHour < morningEndHour;
                            var isAfternoon = currentHour >= afternoonStartHour && currentHour < afternoonEndHour;

                            // Disable input field if it's not within allowed ranges
                            if (!isMorning && !isAfternoon) {
                                inputField.disabled = true;
                            }
                        });
                        window.addEventListener('DOMContentLoaded', function() {
                            var button = document.getElementById('visitorBTN');
                            
                            // Define time ranges when the button should be enabled
                            var morningStartHour = 8;
                            var morningEndHour = 13;
                            var afternoonStartHour = 13; // 1 PM
                            var afternoonEndHour = 23;   // 4 PM

                            var currentTime = new Date();
                            var currentHour = currentTime.getHours();

                            // Check if current hour is within the allowed ranges
                            var isMorning = currentHour >= morningStartHour && currentHour < morningEndHour;
                            var isAfternoon = currentHour >= afternoonStartHour && currentHour < afternoonEndHour;

                            // Disable button if it's not within allowed ranges
                            if (!isMorning && !isAfternoon) {
                                button.disabled = true;
                            }
                        });
                        window.addEventListener('DOMContentLoaded', function() {
                            var button = document.getElementById('SCANID');
                            
                            // Define time ranges when the button should be enabled
                            var morningStartHour = 8;
                            var morningEndHour = 13;
                            var afternoonStartHour = 13; // 1 PM
                            var afternoonEndHour = 23;   // 4 PM

                            var currentTime = new Date();
                            var currentHour = currentTime.getHours();

                            // Check if current hour is within the allowed ranges
                            var isMorning = currentHour >= morningStartHour && currentHour < morningEndHour;
                            var isAfternoon = currentHour >= afternoonStartHour && currentHour < afternoonEndHour;

                            // Disable button if it's not within allowed ranges
                            if (!isMorning && !isAfternoon) {
                                button.disabled = true;
                            }
                        });
                    </script>
                    
                </div>
            </div>
            <!-- end of Right Section -->           
            <div class="bottom">
                <div class="col-xl-12 col-lg-12 col-md-12 position-relative">
                    <div class="card attendanceToday">
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                Attendance Today -- <?= date('F d, Y', strtotime($date)) ?>
                            </h5>
                        </div>
                        <?php if (mysqli_num_rows($attendance_result) > 0 || mysqli_num_rows($visitor_result) > 0): ?>
                        <div class="card-body table-responsive">
                            <table id="attendanceNow" class="table table-striped " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID Number</th>
                                        <th>Name</th>
                                        <th>AM Time In</th>
                                        <th>AM Time Out</th>
                                        <th>PM Time In</th>
                                        <th>PM Time Out</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($attendance = mysqli_fetch_assoc($attendance_result)) : ?>
                                        <tr>
                                            <td><?= $attendance['id_number']; ?></td>
                                            <td>******************</td>
                                            <td><?= ($attendance['period'] == 'AM') ? $attendance['time_in'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'AM') ? $attendance['time_out'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'PM') ? $attendance['time_in'] : ''; ?></td>
                                            <td><?= ($attendance['period'] == 'PM') ? $attendance['time_out'] : ''; ?></td>
                                            <td><?= $attendance['date']; ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                    <?php while ($visitor = mysqli_fetch_assoc($visitor_result)) : ?>
                                        <tr>
                                            <td><?= $visitor['id_number']; ?></td>
                                            <td class="text-capitalize"> <?= $visitor['last_name']; ?>, <?= $visitor['first_name']; ?> <?= $visitor['middle_name']; ?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'AM') ? $visitor['time_out'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_in'] : ''; ?></td>
                                            <td><?= ($visitor['period'] == 'PM') ? $visitor['time_out'] : ''; ?></td>
                                            <td><?= $visitor['date']; ?></td>
                                        </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <h5 class="text-center p-4 alert-danger mb-0">No attendance recorded for today.</h2>
                        <?php endif ?>
                    </div>
                    <button class="col-xl-12 col-lg-12 col-md-12 btn btn-overlay text-white fs-1 fw-bold p-0 border-0"  data-bs-toggle="modal" data-bs-target="#attendanceModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Attendance"><i class="fa-solid fa-chevron-up bg-dark rounded-circle p-2"></i> Attendance</button>
                </div>
            </div>
        </div>
    </main>                 
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal']) : ?>
                var myModal = new bootstrap.Modal(document.getElementById('visitorTimeInModal'));
                myModal.show();
                <?php unset($_SESSION['show_modal']); // Clear the session variable ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['show_modal1']) && $_SESSION['show_modal1']) : ?>
                var myModal = new bootstrap.Modal(document.getElementById('TimeInModal'));
                myModal.show();
                <?php unset($_SESSION['show_modal1']); // Clear the session variable ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['show_modal2']) && $_SESSION['show_modal2']) : ?>
                var myModal = new bootstrap.Modal(document.getElementById('TimeOutModal'));
                myModal.show();
                <?php unset($_SESSION['show_modal2']); // Clear the session variable ?>
            <?php endif; ?>
        });
    </script>
<?php
    include 'includes/footer.php';
?>
