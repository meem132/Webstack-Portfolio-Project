<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
	        		?>
	        		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		                <ol class="carousel-indicators">
		                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
		                </ol>
		                <div class="carousel-inner">
		                  <div class="item active">
		                    <img src="images/banner1.jpg" alt="First slide">
		                  </div>
		                </div>
		                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		                  <span class="fa fa-angle-left"></span>
		                </a>
		                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		                  <span class="fa fa-angle-right"></span>
		                </a>
		            </div>
		            <h2>Monthly Top Sellers</h2>
		       		<?php
// Database connection
$host = getenv('MYSQL_HOST');
$port = getenv('MYSQL_PORT');
$db = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USERNAME');
$pass = getenv('MYSQL_PASSWORD');

// Set DSN for PDO
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";

// Attempt to create PDO connection
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    // Output error if connection fails
    echo "Connection failed: " . $e->getMessage();
}


					$month = date('m');
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
						    $stmt->execute();
						    foreach ($stmt as $row) {
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       								</div>
		       								<div class='box-footer'>
		       									<b>&#36; ".number_format($row['price'], 2)."</b>
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

		       		?> 
					<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    .laptop-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        grid-gap: 20px;
    }
    .laptop {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .laptop img {
        width: 100%;
        height: auto;
    }
    .laptop-info {
        padding: 15px;
    }
    .laptop-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0 0 10px;
    }
    .laptop-price {
        font-size: 16px;
        color: #666;
        margin: 0;
    }
    @media (max-width: 767px) {
        .container {
            padding: 10px;
        }
    }
</style>
					<div class="container">
    <h1>Best-selling Laptops</h1>
    <div class="laptop-list">
        <div class="laptop" style="background-color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
            <img src="images/laptop2.jpg" alt="Laptop 1" style="width: 100%; height: auto;">
            <div class="laptop-info" style="padding: 15px;">
                <h2 class="laptop-title" style="font-size: 18px; font-weight: bold; color: #333; margin: 0 0 10px;">HP Envy</h2>
                <p class="laptop-price" style="font-size: 16px; color: #666; margin: 0;">$999.99</p>
            </div>
        </div>
        <div class="laptop" style="background-color: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
            <img src="images/laptop3.jpg" alt="Laptop 2" style="width: 100%; height: auto;">
            <div class="laptop-info" style="padding: 15px;">
                <h2 class="laptop-title" style="font-size: 18px; font-weight: bold; color: #333; margin: 0 0 10px;">Hp Spectre</h2>
                <p class="laptop-price" style="font-size: 16px; color: #666; margin: 0;">$899.99</p>
            </div>
        </div>
        <!-- Add more laptops as needed -->
    </div>
</div>
					<!---->
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>
