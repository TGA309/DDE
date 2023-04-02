<?php
	session_start();
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		unset($_SESSION['category']);
  }
?>

<?php include('server.php') ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Daily Driven Exotics</title>
		<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
	</head>

	<body>

  		<!-- Navbar Section -->

		<nav>
			<div class="nav-container">
				<a href="index.php" class="logo">Daily Driven Exotics</a>
				<ul class="dropdown-ul">
				<li class="dropdown-li"><a href="index.php" class="nav-elements" >Home</a></li>
				<li class="dropdown-li"><a class="nav-elements" id="aboutus">About Us</a></li>

				<?php  if (!isset($_SESSION['username'])) : ?>
				<li class="profile_icon">
					<img src="Assets/Images/account.png"></img>
					<div class="dropdown">
					<a class="btnLogin-popup">Log In</a>
					<a class="btnRegister-popup">Register</a>
					</div>
				</li>
				<?php endif ?>
				
				<?php  if (isset($_SESSION['username'])) : ?>
				<li class="nav-element-welcome">
					<a>Welcome: <?php echo $_SESSION['name']; ?></a>
					<div class="dropdown">
						<a class="in-cat"> <?php echo $_SESSION['category'] ?> </a>

						<?php if($_SESSION['category'] === 'Employee') : ?>
						<a class="in"> All Bookings </a> </a>
						<?php endif ?>

						<?php if($_SESSION['category'] === 'Customer') : ?>
						<a class="in"> My Bookings </a> </a>
						<?php endif ?>

						<a href="index.php?logout='1'" class="in"> Logout</a>
					</div>	
				</li>
				<?php endif ?>
				</ul>
			</div>
		</nav>

        <!-- New Booking / Update Booking / Delete Booking-->
		
		<!-- New Booking -->
		<h2>Book a Car</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method ="POST">
		<label for="car_sr_no">Car:</label>
		<select name="car_sr_no" id="car_sr_no">
		<option value="1">Rolls Royce Phantom</option>
		<option value="2">Bentley Continental Flying Spur</option>
		<option value="3">Mercedes Benz CLS 350</option>
		<option value="4">Jaguar S Type</option>
		<option value="5">Ferrari F430 Scuderia</option>
		<option value="6">Lamborghini Murcielago LP640</option>
		<option value="7">Porsche Boxster</option>
		<option value="8">Lexus SC430</option>
		<option value="9">Jaguar MK 2</option>
		<option value="10">Rolls Royce Silver Spirit Limousine</option>
		<option value="11">MG TD</option>
		</select><br><br>
		<label for="pickup_date">Pickup Date:</label>
		<input type="date" name="pickup_date" id="pickup_date" min="<?php echo date('Y-m-d'); ?>" required><br><br>
		<label for="return_date">Return Date:</label>
		<input type="date" name="return_date" id="return_date" min="<?php echo date('Y-m-d'); ?>" required><br><br>
		<input type="submit" name="submit" value="Book">
		</form>

		<br><br>

		<!-- Add Booking via Reservation ID -->
		<?php if($_SESSION['category'] === 'Customer') : ?>
		<h2>Add a Booking using Reservation ID</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<label for="id">Reservation ID:</label>
			<input type="text" name="id" id="id" required><br><br>
			<input type="submit" name="add" value="Add Booking">
		</form>
		<?php endif ?>

		<br><br>

		<!-- Update Booking -->
		<h2>Update a Booking</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<label for="id">Reservation ID:</label>
			<input type="text" name="id" id="id" required><br><br>
			<label for="pickup_date">Pickup Date:</label>
			<input type="date" name="pickup_date" id="pickup_date" min="<?php echo date('Y-m-d'); ?>" required><br><br>
			<label for="return_date">Return Date:</label>
			<input type="date" name="return_date" id="return_date" min="<?php echo date('Y-m-d'); ?>" required><br><br>
			<input type="submit" name="update" value="Update">
		</form>

		<br><br>

		<!-- Delete Booking -->
		<h2>Delete a Booking</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<label for="id">Reservation ID:</label>
			<input type="text" name="id" id="id" required><br><br>
			<input type="submit" name="delete" value="Delete">
		</form>


        <!-- Footer Section -->

				<a class="back-to-top">
					<img src="Assets/Images/backtotop.png" alt="Back to top button">
					<span class="back-to-top-text">Back to top</span>
				</a>

                <footer id="aboutusfooter">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <h4>About Us</h4>
                                <p>Group Project for Group 29 by:</p>
                                <p>Siddharth Parthasarathi Ray &emsp; Student ID: 20490487</p>
                                <p>Lee Xin Yee &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; Student ID: 20489266</p></li>
                                <p>Hamad Youssef &emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Student ID: 20303493</p></li>
                                <p>Abdul Aziz Abdul Haiqal &emsp;&emsp; Student ID: 20409381</p></li>
                            </div>

                            <div class="col-md-4">
                                <br>
                                <h4>Website and Database Design</h4>
                                <p>Siddharth Parthasarathi Ray</p>
                            </div>

                            <div class="col-md-4">
                                <br>
                                <h4>Contact Us</h4>
                                <p>Email: hcysr3@nottingham.edu.my</p>
                            </div>
                        </div>
                    </div>
                </footer>

        <script type="text/javascript" src="index.js"></script>
		<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

	</body>
</html>