<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['set-limits'])) {
    $userid = $_SESSION['detsuid'];
    $dailyLimit = $_POST['daily-limit'];
    $monthlyLimit = $_POST['monthly-limit'];

    // Store the limits in the database or update them if they already exist for the user
    $query = mysqli_query($con, "INSERT INTO expenselimits (UserId, DailyLimit, MonthlyLimit) VALUES ('$userid', '$dailyLimit', '$monthlyLimit') ON DUPLICATE KEY UPDATE DailyLimit = VALUES(DailyLimit), MonthlyLimit = VALUES(MonthlyLimit)");

    if ($query) {
        echo "Expense limits set successfully!";
    } else {
        echo "Error setting expense limits. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Set Expense Limits</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Set Expense Limits</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Set Expense Limits</div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="daily-limit">Daily Expense Limit</label>
                                <input type="text" class="form-control" id="daily-limit" name="daily-limit" required>
                            </div>
                            <div class="form-group">
                                <label for="monthly-limit">Monthly Expense Limit</label>
                                <input type="text" class="form-control" id="monthly-limit" name="monthly-limit" required>
                            </div>
                            <div class="form-group has-success">
                                <button type="submit" class="btn btn-primary" name="set-limits">Set Limits</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.panel -->
            </div><!-- /.col -->
            <?php include_once('includes/footer.php'); ?>
        </div><!-- /.row -->
    </div><!--/.main>

    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>
