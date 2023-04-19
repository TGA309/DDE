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


<html>
	<head>
		<title>Check Car Availability</title>
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
						<a href="caravailability.php">Check Car Availability</a>
						<a href="newreservation.php" target="_blank">New Reservation</a>
						<a href="update_deletereservation.php" target="_blank">Update/Delete Reservation</a>
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

   <!-- Car Availability Table-->
   <?php
	// Check if the form has been submitted and the selected option is set
	if (isset($_POST['submit_car_availability']) && isset($_POST['car_sr_no'])) {
		$selected_car_sr_no = $_POST['car_sr_no'];
	} else {
		$selected_car_sr_no = ""; // Default to no selected option
	}
	?>

	<div class="wrapper-customtable">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

			<div class="wrapper-customtable-h2">
				<h2>Select A Car</h2>
			</div>

			<div class="selector-wrapper-customtable">
				<label for="car_sr_no">Car:</label>
				<select name="car_sr_no" id="car_sr_no" required>
					<option value="">Select a car</option>
					<option value="1" <?php if ($selected_car_sr_no == "1") echo "selected"; ?>>Rolls Royce Phantom</option>
					<option value="2" <?php if ($selected_car_sr_no == "2") echo "selected"; ?>>Bentley Continental Flying Spur</option>
					<option value="3" <?php if ($selected_car_sr_no == "3") echo "selected"; ?>>Mercedes Benz CLS 350</option>
					<option value="4" <?php if ($selected_car_sr_no == "4") echo "selected"; ?>>Jaguar S Type</option>
					<option value="5" <?php if ($selected_car_sr_no == "5") echo "selected"; ?>>Ferrari F430 Scuderia</option>
					<option value="6" <?php if ($selected_car_sr_no == "6") echo "selected"; ?>>Lamborghini Murcielago LP640</option>
					<option value="7" <?php if ($selected_car_sr_no == "7") echo "selected"; ?>>Porsche Boxster</option>
					<option value="8" <?php if ($selected_car_sr_no == "8") echo "selected"; ?>>Lexus SC430</option>
					<option value="9" <?php if ($selected_car_sr_no == "9") echo "selected"; ?>>Jaguar MK 2</option>
					<option value="10" <?php if ($selected_car_sr_no == "10") echo "selected"; ?>>Rolls Royce Silver Spirit Limousine</option>
					<option value="11" <?php if ($selected_car_sr_no == "11") echo "selected"; ?>>MG TD</option>
				</select>
				<input type="submit" name="submit_car_availability" value="See Reserved Dates">
			</div>
		</form>

		<?php 
			// connect to the database
			$db = mysqli_connect('localhost', 'root', '', 'comp1044_database');

			// check for errors
			if (!$db) {
				die('Error: ' . mysqli_connect_error());
			}

			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_car_availability'])) {

				// getting the form data
				$car_sr_no = $_POST['car_sr_no'];

				$query = "SELECT * FROM reservations WHERE car_sr_no = $car_sr_no";
				$result = mysqli_query($db, $query);

				if(mysqli_num_rows($result) > 0) {

					$serial_no = 1;
					echo '<table class="customtable">
						<tr><th>Serial No.</th><th>Car Name</th><th>Rate Per Day</th><th>Pickup Date</th><th>Reutrn Date</th></tr>';
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<tr><td>' . $serial_no . '</td><td>' . $row['car_name'] . '</td><td>' . intval($row['total_cost']) / intval($row['no_of_days']) . '</td><td>' . $row['pickup_date'] . '</td><td>' . $row['return_date'] . '</td></tr>';
							$serial_no++;
						}
					echo '</table>';
				}

				else {
					echo '<div>No reservation records found for the selected car.</div>';
				}
			}

			// close the database connection
			mysqli_close($db); 
		?>
	</div>

	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
    <a class="back-to-top">
        <img src="Assets/Images/backtotop.png" alt="Back to top button">
        <span class="back-to-top-text">Back to top</span>
	</a>

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