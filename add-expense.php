<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('include/sidebar.php');

// Get the user's expense limits from the database
$userid = $_SESSION['detsuid'];
$query = mysqli_query($con, "SELECT DailyLimit, MonthlyLimit FROM expenselimits WHERE UserId = '$userid'");
$row = mysqli_fetch_assoc($query);
$dailyLimit = $row['DailyLimit'];
$monthlyLimit = $row['MonthlyLimit'];

if (isset($_POST['submit'])) {
    $userid = $_SESSION['detsuid'];
    $dateexpense = $_POST['dateexpense'];
    $item = $_POST['item'];
    $costitem = $_POST['costitem'];
    $category = $_POST['category']; // Added to retrieve the selected category

    if ($costitem > $dailyLimit || $costitem > $monthlyLimit) {
        // If the expense exceeds the limit, ask for user confirmation
        echo "<script>
            if (confirm('Expense exceeds the limit. Would you like to allow?')) {
                // Handle allowing the expense
                // Insert the expense into the database
                // You can redirect back to the add-expense page after handling this
            } else {
                // Handle canceling the expense
            }
        </script>";
        $query = mysqli_query($con, "INSERT INTO tblexpense (UserId, ExpenseDate, ExpenseItem, ExpenseCost, Category) VALUES ('$userid', '$dateexpense', '$item', '$costitem', '$category')"); // Added 'Category'

    } else {
        // Insert the expense into the database since it doesn't exceed the limit
        $query = mysqli_query($con, "INSERT INTO tblexpense (UserId, ExpenseDate, ExpenseItem, ExpenseCost, Category) VALUES ('$userid', '$dateexpense', '$item', '$costitem', '$category')"); // Added 'Category'

        if ($query) {
            echo 'Expense has been added';
            // You can redirect back to the add-expense page or any other page after handling this
        } else {
            echo 'Something went wrong. Please try again';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Expense</title>
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
                <li class="active">Add Expense</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Add Expense</div>
                    <div class="panel-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="dateexpense">Date of Expense</label>
                                <input type="date" class="form-control" id="dateexpense" name="dateexpense" required="true">
                            </div>
                            <div class="form-group">
                                <label for="item">Item</label>
                                <input type="text" class="form-control" id="item" name="item" required="true">
                            </div>
                            <div class="form-group">
                                <label for="costitem">Cost of Item</label>
                                <input type="text" class="form-control" id="costitem" name="costitem" required="true">
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category" name="category" required="true">
                                    <option value="">Select a category</option>
                                    <option value="Food">Food</option>
                                    <option value="Transportation">Transportation</option>
                                    <option value="Housing">Housing</option>
                                    <option value="Entertainment">Entertainment</option>
                                    <option value="Utilities">Utilities</option>
                                    <option value="Healthcare">Healthcare</option>
                                    <option value="Education">Education</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group has-success">
                                <button type="submit" class="btn btn-primary" name="submit">Add</button>
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
