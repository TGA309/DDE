<!DOCTYPE html>
<?php
  session_start();
  if (!isset($_SESSION['username'])) {
  echo '<script>
      window.location.href = "index.php";
      alert("Kindly login first.");
  </script>';
  }

  if ($_SESSION['category'] === "Employee") {
    echo '<script>
      window.location.href = "index.php";
      alert("Your are not logged in with a Customer Account.");
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
		<title>My Reservations</title>
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

						<?php if($_SESSION['category'] === 'Customer') : ?>
						<a class="in" href="myreservations.php"> My Reservations </a> </a>
						<?php endif ?>

						<a href="index.php?logout='1'" class="in"> Logout</a>
					</div>	
				</li>
				<?php endif ?>
				</ul>
			</div>
		</nav>

        <!-- Body Section for My Reservations -->
        <div class="wrapper-customtable">

            <div class="wrapper-customtable-h2">
                <h2>Your Reservations</h2>
            </div>

            <?php
            
                // connect to the database
                $db = mysqli_connect('localhost', 'root', '', 'comp1044_database');

                // check for errors
                if (!$db) {
                    die('Error: ' . mysqli_connect_error());
                }

                $username = $_SESSION['username'];

                $query = "SELECT * FROM reservations where username = '$username'";
                $result = mysqli_query($db, $query);
    
                if(mysqli_num_rows($result) > 0) {
                    $serial_no = 1;
                    echo '<table class="customtable">
                        <tr><th>Serial No.</th><th>Car Name</th><th>Reservation ID</th><th>Pickup Date</th><th>Return Date</th><th>No. of Days</th><th>Rate Per Day</th><th>Total Cost</th></th><th>Update/Delete Reservation</th></tr>';
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr><td>' . $serial_no . '</td><td>' . $row['car_name'] . '</td><td>' . $row['reservation_id'] . '</td><td>' . $row['pickup_date'] . '</td><td>' . $row['return_date'] . '</td><td>' . $row['no_of_days'] . '</td><td>' . intval($row['total_cost']) / intval($row['no_of_days']) . '</td><td>' . $row['total_cost'] . '</td><td><button class="customtable-btn">Update/Delete Reservation</button></td></tr>';
                            $serial_no++;
                        }
                    echo '</table>';
                }

                else{
                    echo '<div>You have not made any reservations yet.</div>';
                }


                // close the database connection
                mysqli_close($db);
            ?>

        </div>

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    
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