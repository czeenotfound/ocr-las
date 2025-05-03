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

const sidebarToggle = document.querySelector("#sidebar-toggle");

sidebarToggle.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
});

var studentsTable;

$(document).ready(function() {
    studentsTable = $('#students').DataTable({
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 10, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'students-buttons-pdf',
                title: 'Students Records',
                filename: 'Students Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                customize: function (doc) {
                    // Change font size
                    doc.defaultStyle.fontSize = 10; // Change this value to your desired font size
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'students-buttons-excel',
                title: 'Students Records',
                filename: 'Students Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'students-buttons-csv',
                title: 'Students Records',
                filename: 'Students Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'students-buttons-print',
                title: 'Students Records',
                filename: 'Students Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// students
$('#btn-excel').on('click', function(){
    studentsTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    studentsTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    studentsTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    studentsTable.button('.buttons-print').trigger();
});

var profileTable;

$(document).ready(function() {
    profileTable = $('#profile').DataTable({
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 5, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'profile-buttons-pdf',
                title: 'Profile Records',
                filename: 'Profile Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                customize: function (doc) {
                    // Change font size
                    doc.defaultStyle.fontSize = 10; // Change this value to your desired font size
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'profile-buttons-excel',
                title: 'Profile Records',
                filename: 'Profile Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'profile-buttons-csv',
                title: 'Profile Records',
                filename: 'Profile Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'profile-buttons-print',
                title: 'Profile Records',
                filename: 'Profile Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// profile
$('#btn-excel').on('click', function(){
    profileTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    profileTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    profileTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    profileTable.button('.buttons-print').trigger();
});


var facultyTable;

$(document).ready(function() {
    facultyTable = $('#faculty').DataTable({
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 10, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'faculty-buttons-pdf',
                title: 'Faculty Records',
                filename: 'Faculty Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'faculty-buttons-excel',
                title: 'Faculty Records',
                filename: 'Faculty Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'faculty-buttons-csv',
                title: 'Faculty Records',
                filename: 'Faculty Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'faculty-buttons-print',
                title: 'Faculty Records',
                filename: 'Faculty Records',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// faculty
$('#btn-excel').on('click', function(){
    facultyTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    facultyTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    facultyTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    facultyTable.button('.buttons-print').trigger();
});

var visitorsTable;

$(document).ready(function() {
    visitorsTable = $('#visitors').DataTable({
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 10, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'buttons-pdf',
                title: 'Visitors Records',
                filename: 'Visitors Records',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Visitors Records',
                filename: 'Visitors Records',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Visitors Records',
                filename: 'Visitors Records',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Visitors Records',
                filename: 'Visitors Records',
                exportOptions: {
                    columns: [0, 1, 2, 3] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// visitors
$('#btn-excel').on('click', function(){
    visitorsTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    visitorsTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    visitorsTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    visitorsTable.button('.buttons-print').trigger();
});

var dtrTable;

$(document).ready(function() {
    var currentDate = new Date();
    var formattedDate = currentDate.toLocaleString('default', { month: 'long', day: 'numeric', year: 'numeric' });

    dtrTable = $('#DTR').DataTable({
        "ordering": false,
        "paging": true,
        "orderable": false, 
        "targets": [1],
        lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 5, // Initial page length
        dom: 'Blfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'buttons-pdf',
                title: 'Attendance Today - ' + formattedDate,
                filename: 'Attendance Today - ' + formattedDate,
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Attendance Today - ' + formattedDate,
                filename: 'Attendance Today - ' + formattedDate,
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Attendance Today - ' + formattedDate,
                filename: 'Attendance Today - ' + formattedDate,
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Attendance Today - ' + formattedDate,
                filename: 'Attendance Today - ' + formattedDate,
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// dtr 
$('#btn-excel').on('click', function(){
    dtrTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    dtrTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    dtrTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    dtrTable.button('.buttons-print').trigger();
});

function currentSchoolYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1; // Months are zero based, so January is 0

    if ([7, 8, 9, 10, 11, 12].includes(currentMonth)) {
        return currentYear + "-" + (currentYear + 1);
    } else {
        return (currentYear - 1) + "-" + currentYear;
    }
}

console.log(currentSchoolYear());

var dtrSummaryTable;

$(document).ready(function() {
    var schoolYear = currentSchoolYear();
    dtrSummaryTable = $('#DTRsummary').DataTable({
        "ordering": false,
        "paging": true,
        "orderable": false, 
        "targets": [1],
        lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 10, // Initial page length
        dom: 'Blfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'buttons-pdf',
                title: 'Overall Attendance  (' + schoolYear + ')',
                filename: 'Overall Attendance (' + schoolYear + ')',
                customize: function (doc) {
                    // Check if the table has data
                    if (attendanceReportTable.data().count() === 0) {
                        // Add a message when no data is available
                        doc.content.push({
                            text: 'No data available in table',
                            fontSize: 12,
                            alignment: 'center'
                        });
                    }
                    // Change font size
                    doc.defaultStyle.fontSize = 8; // Change this value to your desired font size
                },
                orientation: 'landscape', // Set orientation to landscape
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Overall Attendance (' + schoolYear + ')',
                filename: 'Overall Attendance (' + schoolYear + ')',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Overall Attendance (' + schoolYear + ')',
                filename: 'Overall Attendance (' + schoolYear + ')',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Overall Attendance (' + schoolYear + ')',
                filename: 'Overall Attendance (' + schoolYear + ')',
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ],
        "columnDefs": [
            {
                // "targets": [10], // Index of the column you want to hide
                "visible": false,
                "searchable": true // Allow searching on this hidden column
            }
        ]
    });
     // Filter event handlers
    $('#filterPurpose, #filterCourse, #filterDepartment').on('change', function() {
        var purpose = $('#filterPurpose').val();
        var course = $('#filterCourse').val();
        var department = $('#filterDepartment').val();

        dtrSummaryTable.columns(6).search(purpose).columns(7).search(course).columns(8).search(department).draw();
    });

    // Print button
    $('#printButton').on('click', function() {
        window.print();
    });
});



// dtr Summary
$('#btn-excel').on('click', function(){
    dtrSummaryTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    dtrSummaryTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    dtrSummaryTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    dtrSummaryTable.button('.buttons-print').trigger();
});

var courseTable;

$(document).ready(function() {
    courseTable = $('#course').DataTable({
        pageLength: 5, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Course',
                filename: 'Course',
                exportOptions: {
                    columns: [0, 1, 2] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Course',
                filename: 'Course',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Course',
                filename: 'Course',
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// dtr Summary
$('#btn-excel').on('click', function(){
    courseTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    courseTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    courseTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    courseTable.button('.buttons-print').trigger();
});


var departmentTable;

$(document).ready(function() {
    departmentTable = $('#department').DataTable({
        pageLength: 5, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Department',
                filename: 'Department',
                exportOptions: {
                    columns: [0, 1] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Department',
                filename: 'Department',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Department',
                filename: 'Department',
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// dtr Summary
$('#btn-excel').on('click', function(){
    departmentTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    departmentTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    departmentTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    departmentTable.button('.buttons-print').trigger();
});


var attendanceReportTable;

$(document).ready(function() {
    attendanceReportTable = $('#AttendanceReport').DataTable({
        "ordering": false,
        "paging": true,
        "orderable": false, 
        "targets": [1],
        lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 10, // Initial page length
        dom: 'Blfrtip',
        language: {
            "emptyTable": "No data available in table", // Customize the message for empty table
            "zeroRecords": "No matching records found", // Customize the message for zero records found
        },
        buttons:[
            {
                extend: 'pdf',
                class: 'buttons-pdf',
                title: 'Overall Attendance',
                filename: 'Overall Attendance',
                customize: function (doc) {
                    // Check if the table has data
                    if (attendanceReportTable.data().count() === 0) {
                        // Add a message when no data is available
                        doc.content.push({
                            text: 'No data available in table',
                            fontSize: 12,
                            alignment: 'center'
                        });
                    }
                    // Change font size
                    doc.defaultStyle.fontSize = 8; // Change this value to your desired font size
                },
                orientation: 'landscape', // Set orientation to landscape
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'Overall Attendance',
                filename: 'Overall Attendance',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'csv',
                class: 'buttons-csv',
                title: 'Overall Attendance',
                filename: 'Overall Attendance',
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'Overall Attendance',
                filename: 'Overall Attendance',
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ],
        "columnDefs": [
            {
                "searchable": true // Allow searching on this hidden column
            }
        ]
    });
     // Filter event handlers
    $('#filterSchoolYear, #filterSchoolSemester, #filterPurpose, #filterYear, #filterCourse, #filterDepartment').on('change', function() {
        var schoolYear = $('#filterSchoolYear').val();
        var schoolSemester = $('#filterSchoolSemester').val();
        var purpose = $('#filterPurpose').val();
        var yearlevel = $('#filterYear').val();
        var course = $('#filterCourse').val();
        var department = $('#filterDepartment').val();

        attendanceReportTable.columns(6).search(purpose).columns(7).search(yearlevel).columns(8).search(course).columns(9).search(department).columns(10).search(schoolYear).columns(11).search(schoolSemester).draw();
    });

    // Print button
    $('#printButton').on('click', function() {
        window.print();
    });

});



// dtr Summary
$('#btn-excel').on('click', function(){
    attendanceReportTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    attendanceReportTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    attendanceReportTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    attendanceReportTable.button('.buttons-print').trigger();
});
$('#btn-print1').on('click', function(){
    attendanceReportTable.button('.buttons-print').trigger();
});
// 


var usersTable;

$(document).ready(function() {
    usersTable = $('#users').DataTable({
        pageLength: 5, // Initial page length
        dom: 'Bfrtip',
        buttons:[
            {
                extend: 'pdf',
                class: 'buttons-pdf',
                title: 'User Accounts',
                filename: 'User Accounts',
                exportOptions: {
                    columns: [0, 1, 2] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'excel',
                class: 'buttons-excel',
                title: 'User Accounts',
                filename: 'User Accounts',
                exportOptions: {
                    columns: [0, 1, 2] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            },
            {
                extend: 'print',
                class: 'buttons-print',
                title: 'User Accounts',
                filename: 'User Accounts',
                exportOptions: {
                    columns: [0, 1, 2] // Exclude the last column
                },
                init: function (api, node, config){
                    $(node).hide();
                }
            }
        ]
    });
});

// dtr Summary
$('#btn-excel').on('click', function(){
    usersTable.button('.buttons-excel').trigger();
});
$('#btn-csv').on('click', function(){
    usersTable.button('.buttons-csv').trigger();
});
$('#btn-pdf').on('click', function(){
    usersTable.button('.buttons-pdf').trigger();
});
$('#btn-print').on('click', function(){
    usersTable.button('.buttons-print').trigger();
});

$(document).ready(function() {
    $('#dashboardDtr').DataTable({
        "ordering": false,
        "paging": true,
        "orderable": false, 
        "targets": [1],
        lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ], // Define the options for the length menu
        pageLength: 5, // Initial page length
    });
    $('#purpose').DataTable({
        "dom": '<"top"f>rt<"bottom"ip><"clear">',
        "ordering": false,
        "orderable": false, 
        "targets": [1],
        "paging": true,
        "pageLength": 2, // Set the number of rows per page
        "searching": false // Disable search
    });
    // $('#DTR').DataTable({
    //     "ordering": false,
    //     "paging": true,
    //     "orderable": false, 
    //     "targets": [1],
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'collection',
    //             text: 'Export',
    //             buttons: [{
    //                     extend: 'pdf',
    //                     title: 'Attendance Today',
    //                     filename: 'Attendance Today',
    //                     classname: 'btn btn-dark'
    //                 }, {
    //                     extend: 'excel',
    //                     title: 'Attendance Today',
    //                     filename: 'Attendance Today'
    //                 }, {
    //                     extend: 'csv',
    //                     filename: 'Attendance Today'
    //                 }, {
    //                     extend: 'print',
    //                     title: 'Attendance Today',
    //                     filename: 'Attendance Today'
    //                 } ,'copy'
                      
    //             ],
    //             className: '' // Specify custom class for the dropdown button
    //         }
    //     ]
    // });

    // $('#DTRsummary').DataTable({
    //     dom: '<"d-flex justify-content-between"fB>rtip',
    //     layout: {
    //         topStart: {
    //             buttons: [{
    //                 extend: 'pdf',
    //                 title: 'Customized PDF Title',
    //                 filename: 'customized_pdf_file_name',
    //                 classname: 'btn btn-dark'
    //             }, {
    //                 extend: 'excel',
    //                 title: 'Customized EXCEL Title',
    //                 filename: 'customized_excel_file_name'
    //             }, {
    //                 extend: 'csv',
    //                 filename: 'customized_csv_file_name'
    //             }, {
    //                 extend: 'print',
    //                 title: 'Customized Title',
    //                 filename: 'customized_csv_file_name'
    //             } ,'copy'
                  
    //             ],
    //         }
    //     },
    //     className: '' // Specify custom class for the dropdown button
    // });
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [{
                        extend: 'pdf',
                        title: 'Customized PDF Title',
                        filename: 'customized_pdf_file_name',
                        classname: 'btn btn-dark'
                    }, {
                        extend: 'excel',
                        title: 'Customized EXCEL Title',
                        filename: 'customized_excel_file_name'
                    }, {
                        extend: 'csv',
                        filename: 'customized_csv_file_name'
                    }, {
                        extend: 'print',
                        title: 'Customized Title',
                        filename: 'customized_csv_file_name'
                    } ,'copy'
                      
                ],
                className: '' // Specify custom class for the dropdown button
            }
        ]
    });
    // $('#students').DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'collection',
    //             text: 'Export',
    //             buttons: [{
    //                     extend: 'pdf',
    //                     title: 'Students Records',
    //                     filename: 'Students Records',
    //                     classname: 'btn btn-dark'
    //                 }, {
    //                     extend: 'excel',
    //                     title: 'Students Records',
    //                     filename: 'Students Records'
    //                 }, {
    //                     extend: 'csv',
    //                     filename: 'Students Records'
    //                 }, {
    //                     extend: 'print',
    //                     title: 'Customized Title',
    //                     filename: 'Students Records'
    //                 } ,'copy'
                      
    //             ],
    //             className: '' // Specify custom class for the dropdown button
    //         }
    //     ]
    // });
    // $('#faculty').DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'collection',
    //             text: 'Export',
    //             buttons: [{
    //                     extend: 'pdf',
    //                     title: 'Faculty Records',
    //                     filename: 'Faculty Records',
    //                     classname: 'btn btn-dark'
    //                 }, {
    //                     extend: 'excel',
    //                     title: 'Faculty Records',
    //                     filename: 'Faculty Records'
    //                 }, {
    //                     extend: 'csv',
    //                     filename: 'Faculty Records'
    //                 }, {
    //                     extend: 'print',
    //                     title: 'Customized Title',
    //                     filename: 'Faculty Records'
    //                 } ,'copy'
                      
    //             ],
    //             className: '' // Specify custom class for the dropdown button
    //         }
    //     ]
    // });
});
