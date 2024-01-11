<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$query = "SELECT ExpenseDate, ExpenseCost FROM tblexpense";
$result = mysqli_query($con, $query);

// Initialize arrays to store data
$dates = array();
$amounts = array();

// Fetch and format the data
while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row['ExpenseDate'];
    $amounts[] = $row['ExpenseCost'];
}

// Find the date with the highest and lowest expenses
$maxExpense = max($amounts);
$minExpense = min($amounts);
$maxExpenseDate = $dates[array_search($maxExpense, $amounts)];
$minExpenseDate = $dates[array_search($minExpense, $amounts)];

// Create an array for the chart data
$chartData = array(
    'labels' => $dates,
    'datasets' => array(
        array(
            'label' => 'Expenses',
            'data' => $amounts,
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 2,
            'fill' => false,
        ),
    ),
);
?>
<!-- Include the Chart.js library and HTML structure for the chart -->
<!DOCTYPE html>
<html>
<head>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Your other head content -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Tracker</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]
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
<?php include_once('includes/header.php');?>
	<?php include_once('includes/sidebar.php');?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
    <!-- HTML structure for the chart -->
    <div class="container">
        <canvas id="line-chart" width="800" height="150"></canvas>
    </div>

    <!-- Display the dates with highest and lowest expenses -->
    <p>Highest Expense Date: <?php echo $maxExpenseDate; ?></p>
    <p>Lowest Expense Date: <?php echo $minExpenseDate; ?></p>

    <!-- JavaScript code to create the chart -->
    <script>
        var lineChartData = <?php echo json_encode($chartData); ?>;

        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1, {
            type: 'line',
            data: lineChartData,
            options: {
                responsive: true,
                scales: {
                    x: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date'
                        }
                    }],
                    y: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Amount'
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
