// 
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
// 

$(document).ready(function() {
    // Initialize DataTable for #attendanceNow
    $('#attendanceNow').DataTable({
        "ordering": false,
        "orderable": false, 
        "targets": [1],
        "paging": true,
        "pageLength": 2, // Set the number of rows per page
        "searching": false // Disable search
    });

    // Initialize DataTable for #attendanceModal
    $('#attendanceNowModal').DataTable({
        "ordering": false,
        "paging": true,
        "orderable": false, 
        "targets": [1],
    });
});

$(document).ready(function() {
    // Close the alert when the close button is clicked
    $('.btn-close').click(function() {
        $('#alert').alert('close');
    });

    // Automatically close the alert after a certain duration
    const duration = 5000; // Adjust the duration as needed
    setTimeout(function() {
        $('#alert').alert('close');
    }, duration);
});
