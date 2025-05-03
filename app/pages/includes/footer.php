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

   <div class="modal fade" id="SCANIDModal" tabindex="-1" aria-labelledby="ScanIdLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ScanIdLabel"> Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card">
                    <div class="p-3" id="divvideo">
                        <section id="demos">
                            <div id="liveView">
                                <canvas id="canvas" class="bg-danger"></canvas>
                                <video id="webcam" class="bg-primary" playsinline crossorigin="anonymous" width="100%" height="50%"></video>
                            </div>
                        </section>
                        <br>
                        <div class="text-center">
                            <button id="webcamButton" class="invisible fw-bold">Loading...</button>
                        </div>
                    </div>
                </div>
                <form action="<?= ROOT_URL ?>verify" method="POST">
                    <input type="text" name="studentID" id="inputField" value="">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Visitor -->
    <div class="modal fade" id="visitorModal" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitorModalLabel">Visitor Time In & Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 col-sm-6">
                            <button name="submit" class="btn btn-primary w-100 py-4" data-bs-toggle="modal" data-bs-target="#visitorTimeInModal">Time In</button>
                        </div>
                        <div class="col-4 col-sm-6">
                            <button name="submit" class="btn btn-primary w-100 py-4" data-bs-toggle="modal" data-bs-target="#visitorTimeOutModal">Time Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Time In -->
    <div class="modal fade" id="visitorTimeInModal" tabindex="-1" aria-labelledby="visitorTimeInLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitorTimeInLabel">Visitor Time In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php
                    $first_name = $_SESSION['add_visitor_data']['first_name'] ?? null;
                    $middle_name = $_SESSION['add_visitor_data']['middle_name'] ?? null;
                    $last_name = $_SESSION['add_visitor_data']['last_name'] ?? null;
                    $gender = $_SESSION['add_visitor_data']['gender'] ?? null;
                    $mobile = $_SESSION['add_visitor_data']['mobile'] ?? null;

                    unset($_SESSION['add_visitor_data']);
                ?>
                <div class="modal-body">
                    <?php if (isset($_SESSION ['add_visitor'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['add_visitor'];
                                unset($_SESSION['add_visitor']);
                            ?>
                        </div>
                    <?php endif ?>
                    <form action="<?= ROOT_URL ?>visitorTimein-method" method="POST">
                        <div class="row">
                           
                            <div class="mb-3 col">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= $middle_name ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Prefer not to say</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="mobile" class="form-label">Mobile Number <small class="text-muted">(ex. 09xxxxxxxxx)</small></label>
                            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $mobile ?>">
                        </div>
                        <div class="mb-3">
                            <label for="purpose_id" class="form-label">(Time In) Purpose</label>
                            <select class="form-select" id="purpose_id" name="purpose_id" required>
                                    <?php while($purpose = mysqli_fetch_assoc($visitors_purposes)) : ?>
                                        <option value="<?= $purpose['id'] ?>"><?= $purpose['description']; ?></option>
                                    <?php endwhile ?>
                            </select> 
                            <input type="hidden" name="schoolyear" value="<?= currentschoolyear() ?>">
                            <input type="hidden" name="semester" value="<?= currentSemester() ?>">            
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                            <button type="submit" name="submit" class="btn btn-primary">Time In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Time In -->

    <!-- Time Out -->
    <div class="modal fade" id="visitorTimeOutModal" tabindex="-1" aria-labelledby="visitorTimeOutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitorTimeOutLabel">Visitor Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>visitorTimeout-method" method="POST">
                    <div class="mb-3">
                            <label for="visitor_name_out" class="form-label">Name</label>
                            <select class="form-select" id="visitor_name_out" name="visitor_name_out" required>
                            <?php while($visitor = mysqli_fetch_assoc($visitors)) : ?>
                                <option value="<?= $visitor['id'] ?>"><?= $visitor['last_name']; ?>, <?= $visitor['first_name']; ?> <?= $visitor['middle_name']; ?></option>
                            <?php endwhile ?>
                            </select>
                        </div>
                        <hr>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                            <button type="submit" name="submit" class="btn btn-primary">Time Out</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of Time Out -->
    <div class="modal fade" id="TimeInModal" tabindex="-1" aria-labelledby="TimeInLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TimeInLabel"><?= isset($_SESSION['table']) ? $_SESSION['table'] : '' ?> Time In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_SESSION['time_in'])): ?>
                        <div class="alert alert-danger messages w-100 n">
                            <?= $_SESSION['time_in'];
                                unset($_SESSION['time_in']);
                            ?>
                        </div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card mb-2 profilehead">
                                <div class="card-body text-center shadow">
                                    <img src="<?= ROOT_URL ?>../public/assets/images/user_8647311.png" alt="avatar"
                                    class="img-fluid" style="width: 150px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">ID Number</p>
                                </div>
                                <div class="col-sm-9">
                                   <div class="text-muted mb-0"><?= isset($_SESSION['matched_student_id']) ? $_SESSION['matched_student_id'] : '' ?></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '' ?></p>
                                </div>
                            </div>
                            <hr>
                            <?php if ($_SESSION['table'] === 'Student') : ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Year</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= $display_year ?> Year</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Section</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= isset($_SESSION['section']) ? $_SESSION['section'] : '' ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0 fw-bold">Course</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?= isset($_SESSION['course_name']) ? $_SESSION['course_name'] : '' ?></p>
                                    </div>
                                </div>
                                <hr>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0 fw-bold">Department</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= isset($_SESSION['department_name']) ? $_SESSION['department_name'] : '' ?></p>
                                </div>
                            </div>
                            <hr>
                            <form action="<?= ROOT_URL ?>time_in_process" method="POST">
                                <input type="hidden" class="form-control" name="id_number" value="<?= isset($_SESSION['matched_student_id']) ? $_SESSION['matched_student_id'] : '' ?>">
                                <input type="hidden" name="schoolyear" value="<?= currentschoolyear() ?>">
                                <input type="hidden" name="semester" value="<?= currentSemester() ?>">
                                <label for="purpose_id" class="form-label text-center fw-bold">(Time In) Purpose</label>
                                <select class="form-select" id="purpose_id" name="purpose_id" required>
                                    <?php while($purpose = mysqli_fetch_assoc($student_faculty_purposes)) : ?>
                                        <option value="<?= $purpose['id'] ?>"><?= $purpose['description']; ?></option>
                                    <?php endwhile ?>
                                </select>

                                <div class="mt-5 float-end">
                                    <a href="<?= ROOT_URL ?>home" type="button" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary" name="submit" id="submitBtn"> Time In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="TimeOutModal" tabindex="-1" aria-labelledby="TimeOutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TimeOutLabel"> Time Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= ROOT_URL ?>time_out_process" method="POST">
                        <div class="mb-3">
                            <input type="text" readonly class="form-control" name="id_number" value="<?= isset($_SESSION['matched_student_id']) ? $_SESSION['matched_student_id'] : '' ?>">
                        </div>                
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100 py-4" data-bs-dismiss="modal">Back</button>
                            </div>
                            <div class="col">
                                <button type="submit" name="submit" class="btn btn-primary w-100 py-4">Time Out</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel"> Attendance Today -- <?= date('F d, Y', strtotime($date)) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card attendanceToday1">
                            <?php if (mysqli_num_rows($attendance_result1) > 0 || mysqli_num_rows($visitor_result1) > 0): ?>
                            <div class="card-body table-responsive">
                                <table id="attendanceNowModal" class="table table-striped " style="width:100%" onmousedown="return false" onselectstart="return false">
                                    <thead>
                                        <tr>
                                            <th>ID Number</th>
                                            <th>Name</th>
                                            <th>AM Time In</th>
                                            <th>AM Time Out</th>
                                            <th>PM Time In</th>
                                            <th>PM Time Out</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php while ($attendance = mysqli_fetch_assoc($attendance_result1)) : ?>
                                            <tr>
                                                <td><?= $attendance['id_number']; ?></td>
                                                <td>******************</td>
                                                <td><?= ($attendance['period'] == 'AM') ? $attendance['time_in'] : ''; ?></td>
                                                <td><?= ($attendance['period'] == 'AM') ? $attendance['time_out'] : ''; ?></td>
                                                <td><?= ($attendance['period'] == 'PM') ? $attendance['time_in'] : ''; ?></td>
                                                <td><?= ($attendance['period'] == 'PM') ? $attendance['time_out'] : ''; ?></td>
                                                <td><?= $attendance['status'] ? 'Time Out' : 'Time In' ; ?></td>
                                                <td><?= $attendance['date']; ?></td>
                                            </tr>
                                        <?php endwhile ?>
                                        <?php while ($visitor = mysqli_fetch_assoc($visitor_result1)) : ?>
                                            <!-- Display visitors -->
                                            <tr>
                                                <td><?= $visitor['id_number']; ?></td>
                                                <td class="text-capitalize"> <?= $visitor['last_name']; ?>, <?= $visitor['first_name']; ?> <?= $visitor['middle_name']; ?></td>
                                                <td><?= ($visitor['period'] == 'AM') ? $visitor['time_in'] : ''; ?></td>
                                                <td><?= ($visitor['period'] == 'AM') ? $visitor['time_out'] : ''; ?></td>
                                                <td><?= ($visitor['period'] == 'PM') ? $visitor['time_in'] : ''; ?></td>
                                                <td><?= ($visitor['period'] == 'PM') ? $visitor['time_out'] : ''; ?></td>
                                                <td><?= $visitor['status']  ? 'Time Out' : 'Time In'  ; ?></td>
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
                    </div>

                </div>
            </div>
        </div>
    </div>                    
    <!-- end of Visitor -->
    <script src="<?= ROOT_URL ?>/assets/JS/jquery-3.7.1.js"></script>
    <script src="<?= ROOT_URL ?>/assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>/assets/JS/datatables/dataTables.js"></script>
    <script src="<?= ROOT_URL ?>/assets/JS/index.js"></script>
    <!-- Import Tesseract.js library -->
    <script src="<?= ROOT_URL ?>/assets/JS/tesseract.min.js"></script>

    <!-- Import webworker code -->
    <script src="<?= ROOT_URL ?>/assets/JS/ocr.js"></script> 

    <!-- Import rectangle point code -->
    <script src="<?= ROOT_URL ?>/assets/JS/scan.js"></script>
    <script src="<?= ROOT_URL ?>/assets/JS/clock.js"></script>

    
</body>
</html>