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

	        		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		                <ol class="carousel-indicators">
		                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
		                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
		                </ol>
		                <div class="carousel-inner">
		                  <div class="item active">
		                    <img src="images/aboutus.jpg" alt="About Us Image">
		                  </div>
		                </div>
		                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		                  <span class="fa fa-angle-left"></span>
		                </a>
		                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		                  <span class="fa fa-angle-right"></span>
		                </a>
		            </div>
		            <h2><b>About Us</b></h2>
					<h4><b>Welcome to Evansite - Where Your Shopping Experience Begins!</b></h4>
					
					<p>At Evansite, we're passionate about revolutionizing the way you shop online. Founded by Evans himself, our platform is more than just an ecommerce website – it's a destination where convenience, quality, and innovation converge.</p>
					<br>
					<h4>Our Story</h4>
					<p>Evansite was born out of a simple yet powerful idea: to create an online shopping experience that exceeds expectations. Frustrated by the limitations of existing platforms, Evans embarked on a journey to build a solution that puts customers first. With a vision to blend cutting-edge technology with exceptional customer service, Evansite came to life.</p>
					<br>
					<h4>Our Mission</h4>
					<p>At Evansite, our mission is clear: to empower customers to discover, shop, and connect with ease. We're committed to offering a diverse range of products curated to meet your every need. Whether you're searching for the latest fashion trends, high-tech gadgets, or everyday essentials, Evansite is your one-stop destination.</p>
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