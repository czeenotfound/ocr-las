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
    session_start();
    
    define('ROOT_URL', 'http://localhost/OCR-LAS (SE) test/public/');
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','ocrlasdb1');

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Check if any admin user (status = 2) exists
    $check_admin = $conn->query("SELECT id FROM users WHERE status = 2 LIMIT 1");

    if ($check_admin && $check_admin->num_rows === 0) {
        // No admin found — create one
        $first_name = 'Admin';
        $middle_name = '';
        $last_name = 'User';
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $mobile = '';
        $date_created = date('Y-m-d H:i:s');
        $status = 2;

        // Use prepared statement to insert admin user
        $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, username, password, mobile, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('sssssssi', $first_name, $middle_name, $last_name, $username, $password, $mobile, $date_created, $status);
            $stmt->close();
        } else {
        }
    } else {
    }

    $conn->close();