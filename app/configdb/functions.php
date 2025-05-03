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
function redirect($page){
    header('location: '. ROOT_URL . '/' .$page);
    die();
}
function currentschoolyear(){
    $currentYear = date('Y');
    return (in_array(date('n'),array(7,8,9,10,11,12))) ? $currentYear . "-" . ($currentYear + 1) : ($currentYear - 1) . "-" . $currentYear;
}
function currentSemester(){
		return (in_array(date('n'),array(6,7,8,9,10))) ? 1 : 2;
}

function old_value($key, $default = ''){
    if(!empty($_POST[$key]))
        return $_POST[$key];

    return $default;
}

function str_to_url($url){
    $url = str_replace ("'", "", $url);
    $url = preg_replace ('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim ($url, "-");
    $url = iconv ("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower ($url);
    $url = preg_replace ('~[^-a-z0-9_]+~', '', $url);

    return $url;
}

function calculateExpectedGraduationYear($currentYear) {
    // Assuming a standard 4-year bachelor's degree program
    $standardDuration = 4;

    // Calculate the expected graduation year
    $expectedGraduationYear = date('Y') + ($standardDuration - $currentYear);

    return $expectedGraduationYear;
}

// Example usage:
$currentYear = 3; // Assuming the student is in the first year
$expectedGraduationYear = calculateExpectedGraduationYear($currentYear);
echo "Expected Graduation Year: $expectedGraduationYear";