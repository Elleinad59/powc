// public/js/alerts.js

document.addEventListener('DOMContentLoaded', function () {
    // Select all alerts with the class 'alert-dismissible'
    var alerts = document.querySelectorAll('.alert-dismissible');
    
    alerts.forEach(function (alert) {
        // If an alert is found, set a timeout to fade it out after 3 seconds
        setTimeout(function () {
            alert.classList.add('fade-out');
        }, 3000); // 3000 milliseconds = 3 seconds
    });
});
