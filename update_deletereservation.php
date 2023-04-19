<!DOCTYPE html>
<?php
	session_start();
    if (!isset($_SESSION['username'])) {
    echo '<script>
        window.location.href = "index.php";
        alert("Kindly login first.");
    </script>';
	}


	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		unset($_SESSION['category']);
  	}
?>

<?php include('server.php') ?>

<html>
	<head>
		<title>Update or Delete Reservation</title>
		<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
		<style>
			body{
				background-color: #9c948c;
			}
		</style>
	</head>

	<body>

  		<!-- Navbar Section -->

		<nav>
			<div class="nav-container">
				<a href="index.php" class="logo">Daily Driven Exotics</a>
				<ul class="dropdown-ul">	
				<li class="dropdown-li"><a href="index.php" class="nav-elements">Home</a></li>
				<li class="dropdown-li"><a class="nav-elements">Cars</a>
					<div class="dropdown">
						<a href="caravailability.php" target="_blank">Check Car Availability</a>
						<a href="newreservation.php">New Reservation</a>
						<a href="update_deletereservation.php">Update/Delete Reservation</a>
					</div>
				</li>
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
						<a class="in" href="allreservations.php" target="_blank"> All Reservations </a> </a>
						<?php endif ?>

						<?php if($_SESSION['category'] === 'Customer') : ?>
						<a class="in" href="myreservations.php" target="_blank"> My Reservations </a> </a>
						<?php endif ?>

						<a href="index.php?logout='1'" class="in"> Logout</a>
					</div>	
				</li>
				<?php endif ?>
				</ul>
			</div>
		</nav>

		<div class="new-update-delete-reservation-page-content">

            <!-- Update Reservation -->
			<div class="customform" id="form3">
				
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="customform" method ="POST" onsubmit="return validateForm()">
				<h2 class="customform-h2" id="form3">Click to Update a Reservation</h2>

				<div class="input-box-customform" id="form3">
						<input type="text" name="reservation_id_update" id="reservation_id_update" required>
						<label for="reservation_id">Reservation ID:</label><br><br>
					</div>
				
				<div class="input-box-customform" id="form3">
					<input type="date" name="pickup_date" id="pickup_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $pickup_date; ?>" required><br><br>
					<label for="pickup_date">Pickup Date:</label>
				</div>

				<div class="input-box-customform" id="form3">
					<input type="date" name="return_date" id="return_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $return_date; ?>" required><br><br>
					<label for="return_date">Return Date:</label>
				</div>
				
				<div class="input-box-customform" id="form3">
				<h3 class="customform-h3" id="form1">Payment Details</h3>
				</div>

				<div class="input-box-customform" id="form3">
					<input type="text" id="card-number" name="card-number" maxlength="16" required>
					<label>Card Number:</label>
				</div>
				
				<?php $nextMonth = date('Y-m', strtotime('+1 month'));?>
				<div class="input-box-customform" id="form3">
					<input type="month" id="expiry-date" name="expiry-date" min="<?php echo $nextMonth; ?>" value="<?php echo $nextMonth; ?>" required>
					<label>Expiry Date:</label>
				</div>

				<div class="input-box-customform" id="form3">
					<input type="password" id="cvv" name="cvv" maxlength="4" required>
					<label>CVV:</label>
				</div>
				
				<div class="btncontainer" id="form3">
				<input type="submit" class="btnform" name="update" value="Update Booking">
				</div>
				
				</form>

			</div>

				<br><br>

			<!-- Delete Reservation -->
			<div class="customform" id="form4">
				<h2 class="customform-h2" id="form4">Click to Delete a Reservation</h2>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					
					<div class="input-box-customform" id="form4">
						<input type="text" name="reservation_id_delete" id="reservation_id_delete" required>
						<label for="reservation_id">Reservation ID:</label><br><br>
					</div>

					<div class="btncontainer" id="form4">
						<input type="submit" class = "btnform" name="delete" value="Delete Booking">
					</div>
				</form>
			</div>

			<br><br>

			<a class="back-to-top">
				<img src="Assets/Images/backtotop.png" alt="Back to top button">
				<span class="back-to-top-text">Back to top</span>
			</a>

		</div>


        
		<!-- Footer Section -->
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

	</body>
</html>