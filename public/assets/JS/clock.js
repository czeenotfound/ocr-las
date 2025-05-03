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
// Calling showTime function at every second
setInterval(showTime, 1000);

// Defining showTime function
function showTime() {
    // Getting current time and date
    let time = new Date();
    let hour = time.getHours();
    let min = time.getMinutes();
    let sec = time.getSeconds();
    let month = time.toLocaleString('default', { month: 'long' });
    let day = time.getDate();
    let year = time.getFullYear();
    let am_pm = "AM";

    // Adjusting hour to start at 12 instead of 0 (midnight)
    if (hour >= 12) {
        am_pm = "PM";
    }
    if (hour > 12) {
        hour -= 12;
    } else if (hour === 0) {
        hour = 12;
    }

    hour = hour < 10 ? "0" + hour : hour;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;

    let currentTime =
        hour +
        ":" +
        min +
        ":" +
        sec +
        " " +
        am_pm +
        "<br>" +
        month +
        " " +
        day +
        ", " +
        year;

    // Displaying the time and date
    document.getElementById(
        "clock"
    ).innerHTML = currentTime;
}

// Call the function once to display the time initially
showTime();