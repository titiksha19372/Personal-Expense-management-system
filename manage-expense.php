<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $rowid = intval($_GET['delid']);
        $query = mysqli_query($con, "delete from tblexpense where ID='$rowid'");
        if ($query) {
            echo "<script>alert('Record successfully deleted');</script>";
            echo "<script>window.location.href='manage-expense.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Expense Tracker || Manage Expense</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]>
</head>
<body>
    
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="dashboard.php"><span>Personal Expense Mangement system</span></a>
                
            </div>
            
        </div>
        <!-- /.container-fluid -->
        </nav>
    <header>
        <?php include_once('includes/header.php'); ?>
    </header>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><em class="fa fa-home"></em></a></li>
                <li class="active">Expense</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Expense</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="sort">Sort Expenses by Amount:</label>
                                        <select class="form-control" id="sort" name="sort">
                                            <option value="desc">Descending</option>
                                            <option value="asc">Ascending</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary" name="sort_expenses">Sort</button>
                                    </div>
                                </form>
                                <table class="table table-bordered mg-b-0">
                                    <thead>
                                        <tr>
                                            <th>S.NO</th>
                                            <th>Expense Item</th>
                                            <th>Expense Cost</th>
                                            <th>Expense Date</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $userid = $_SESSION['detsuid'];
                                    $sortOption = isset($_POST['sort']) ? $_POST['sort'] : 'desc';

                                    if (isset($_POST['sort_expenses'])) {
                                        $query = "SELECT * FROM tblexpense WHERE UserId='$userid' ORDER BY ExpenseCost $sortOption";
                                    } else {
                                        $query = "SELECT * FROM tblexpense WHERE UserId='$userid'";
                                    }

                                    $ret = mysqli_query($con, $query);
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['ExpenseItem']; ?></td>
                                            <td><?php echo $row['ExpenseCost']; ?></td>
                                            <td><?php echo $row['ExpenseDate']; ?></td>
                                            <td><?php echo $row['Category']; ?></td>
                                            <td><a href="manage-expense.php?delid=<?php echo $row['ID']; ?>">Delete</a></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                        $cnt = $cnt + 1;
                                    } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div><!-- /.panel-->
            </div><!-- /.col-->
            <?php include_once('includes/footer.php'); ?>
        </div><!-- /.row -->
    </div><!--/.main-->
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

