<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
		  <style>
	

			h1 {
				text-align: center;
				color: #333;
			}
			p {
				margin-bottom: 20px;
			}
			form {
				margin-top: 20px;
			}
			label {
				font-weight: bold;
			}
			input, textarea {
				width: 100%;
				padding: 10px;
				margin-bottom: 10px;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-sizing: border-box;
			}
			input[type="submit"] {
				background-color: #4CAF50;
				color: white;
				border: none;
				cursor: pointer;
			}
			input[type="submit"]:hover {
				background-color: #45a049;
			}
		</style>
		  <div class="container">
				<h1>Contact Us</h1>
				<p>We'd love to hear from you! Please fill out the form below and we'll get back to you as soon as possible.</p>
				<form action="#" method="post">
					<div>
						<label for="name">Your Name</label><br>
						<input type="text" id="name" name="name" required>
					</div>
					<div>
						<label for="email">Your Email</label><br>
						<input type="email" id="email" name="email" required>
					</div>
					<div>
						<label for="message">Message</label><br>
						<textarea id="message" name="message" rows="6" required></textarea>
					</div>
					<div>
						<input type="submit" value="Submit">
					</div>
				</form>
			</div>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>