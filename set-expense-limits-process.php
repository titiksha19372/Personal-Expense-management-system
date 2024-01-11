<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['set-limits'])) {
    $userid = $_SESSION['detsuid'];
    $dailyLimit = $_POST['daily-limit'];
    $monthlyLimit = $_POST['monthly-limit'];

    // Validate the input as numbers
    if (!is_numeric($dailyLimit)||!is_numeric($monthlyLimit)) {
        echo "Invalid input. Please enter valid numbers for daily and monthly limits.";
    } else {
        // Store the limits in the database
        $query = mysqli_query($con, "INSERT INTO tblexpense (UserId, DailyLimit, MonthlyLimit) VALUES ('$userid', '$dailyLimit', '$monthlyLimit')");
        if ($query) {
            echo "Expense limits set successfully!";
        } else {
            echo "Error setting expense limits. Please try again.";
        }
    }
}
?>
