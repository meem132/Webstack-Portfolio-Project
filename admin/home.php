<?php
include 'includes/session.php';
include 'includes/format.php';

// Get current date and year
$today = date('Y-m-d');
$year = date('Y');

// Check if a specific year is requested
if(isset($_GET['year'])){
    $year = $_GET['year'];
}

$conn = $pdo->open();

include 'includes/header.php';
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Dashboard</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php
            // Display error/success messages
            include 'includes/messages.php';
            ?>

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <!-- Total Sales -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <?php
                            // Calculate total sales
                            $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id");
                            $stmt->execute();

                            $total = 0;
                            foreach($stmt as $srow){
                                $subtotal = $srow['price'] * $srow['quantity'];
                                $total += $subtotal;
                            }

                            echo "<h3>&#36; ".number_format_short($total, 2)."</h3>";
                            ?>
                            <p>Total Sales</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <a href="book.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Number of Products -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <?php
                            // Count number of products
                            $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products");
                            $stmt->execute();
                            $prow =  $stmt->fetch();

                            echo "<h3>".$prow['numrows']."</h3>";
                            ?>
                            <p>Number of Products</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-barcode"></i>
                        </div>
                        <a href="student.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Number of Users -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <?php
                            // Count number of users
                            $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users");
                            $stmt->execute();
                            $urow =  $stmt->fetch();

                            echo "<h3>".$urow['numrows']."</h3>";
                            ?>
                            <p>Number of Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="return.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Sales Today -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <?php
                            // Calculate sales today
                            $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE sales_date=:sales_date");
                            $stmt->execute(['sales_date'=>$today]);

                            $total = 0;
                            foreach($stmt as $trow){
                                $subtotal = $trow['price'] * $trow['quantity'];
                                $total += $subtotal;
                            }

                            echo "<h3>&#36; ".number_format_short($total, 2)."</h3>";
                            ?>
                            <p>Sales Today</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="borrow.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- Monthly Sales Report -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Monthly Sales Report</h3>
                            <div class="box-tools pull-right">
                                <!-- Select Year -->
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label>Select Year: </label>
                                        <select class="form-control input-sm" id="select_year">
                                            <?php
                                            // Populate year dropdown
                                            for($i=2015; $i<=2065; $i++){
                                                $selected = ($i==$year)?'selected':'';
                                                echo "
                                                    <option value='".$i."' ".$selected.">".$i."</option>
                                                ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <br>
                                <div id="legend" class="text-center"></div>
                                <canvas id="barChart" style="height:350px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- Chart Data -->
<?php
$months = array();
$sales = array();
for( $m = 1; $m <= 12; $m++ ) {
    try{
        // Calculate sales for each month
        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
        $stmt->execute(['month'=>$m, 'year'=>$year]);
        $total = 0;
        foreach($stmt as $srow){
            $subtotal = $srow['price'] * $srow['quantity'];
            $total += $subtotal;
        }
        array_push($sales, round($total, 2));
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
}

$months = json_encode($months);
$sales = json_encode($sales);

?>
<!-- End Chart Data -->

<?php $pdo->close(); ?>
<?php include 'includes/scripts.php'; ?>

<script>
$(function(){
  var barChartCanvas = $('#barChart').get(0).getContext('2d');
  var barChart = new Chart(barChartCanvas);
  var barChartData = {
    labels  : <?php echo $months; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $sales; ?>
      }
    ]
  };

  var barChartOptions = {
    scaleBeginAtZero        : true,
    scaleShowGridLines      : true,
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    scaleGridLineWidth      : 1,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines  : true,
    barShowStroke           : true,
    barStrokeWidth          : 2,
    barValueSpacing         : 5,
    barDatasetSpacing       : 1,
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    responsive              : true,
    maintainAspectRatio     : true
  };

  barChartOptions.datasetFill = false;
  var myChart = barChart.Bar(barChartData, barChartOptions);
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script>

<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'home.php?year='+$(this).val();
  });
});
</script>

</body>
</html>