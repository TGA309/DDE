<?php
	session_start();
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		unset($_SESSION['name']);
		unset($_SESSION['category']);
		header("Location: index.php");
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
				<li class="dropdown-li"><a class="nav-elements" id="cars">Cars</a>
					<div class="dropdown">
					<?php  if (!isset($_SESSION['username'])) : ?>
					<a class="nin">New Booking</a>
					<?php
					echo '<script type="text/javascript">
					const nbnin = document.querySelector(".nin");
					nbnin.addEventListener("click", function(e) {
						e.preventDefault();
						wrapper.classList.add("active-login");
						wrapper.classList.add("active-loginpopup");
						formBoxRegister.classList.add("inactive");
						wrapper.classList.remove("active-register");
						wrapper.classList.remove("active-registerpopup");
						formBoxLogin.classList.remove("inactive");

						window.scrollTo({
							top: 0,
							behavior: "smooth"
						});
					});
				  </script>';
					?>
					<?php endif ?>

					<?php  if (isset($_SESSION['username'])) : ?>
					<a href="newbooking.php">New Booking</a>
					<?php endif ?>
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

		<!-- Background and Login/Register Section -->

		<div class="bg-img-home">
			<h1 class="bg-img-text-home">WHERE ADVENTURE MEETS LUXURY</h1>

			<div class="wrapper">
				<span class="icon-close">
					<ion-icon name="close-sharp"></ion-icon>
				</span>

				<div class="form-boxlogin">
					<h2>Login</h2>
					<form method="post" action="index.php">
					<?php include('errorslogin.php'); ?>
						<div class="input-box">
							<span class="icon"><ion-icon name="mail-sharp"></ion-icon></span>
								<input type = "text" name="username" value="<?php echo $username; ?>" required>
								<label>Username</label>
						</div>
						<div class="input-box">
							<span class="icon"><ion-icon name="lock-closed-sharp"></ion-icon></span>
								<input type = "password" name="password" required>
								<label>Password</label>
						</div>
						<button type="submit" class="btn" name="login_user">Login</button>
						<div class="login-register">
							<p>Don't have an account? <a href="#" class="register-link">Register</a></p>
						</div>
					</form>
				</div>

				<div class="form-boxregister">
					<h2>Registration</h2><br>
					
					<form method="post" action="index.php">
					<?php include('errorsregister.php'); ?>
						<div class="input-box">
							<input type = "text" name="name" value="<?php echo $name; ?>" required>
							<label>Name</label>
						</div>
						<div class="input-box">
						<span class="icon"><ion-icon name="person-sharp"></ion-icon></span>
							<input type = "text" name="username" value="<?php echo $username; ?>" required>
							<label>Username</label>
						</div>
						<div class="input-box">
						<span class="icon"><ion-icon name="mail-sharp"></ion-icon></span>
							<input type = "text/email" name="email" value="<?php echo $email; ?>" required>
							<label>Email</label>
						</div>
						<div class="input-box">
						<span class="icon"><ion-icon name="lock-closed-sharp"></ion-icon></span>
							<input type = "password" name="password" required>
							<label>Password</label>
						</div>
						<button type="submit" class="btn" name="reg_user">Register</button>
						<div class="login-register">
							<p>Already have an account? <a href="#" class="login-link">Login</a></p>
						</div>
					</form>
				</div>

			</div>

		</div>


		<!-- Cars Section -->

		<h1 id="our-cars" class = "heading-cars">OUR CARS</h1>

        	<div class="category">

        		<h2 class="category-headings">Luxurious Cars</h2>

        		<div class="car-tiles">

              		<div class="car-tile">
                		<img src="Assets/Cars/Luxurious/RRPB.png" alt="Luxurious Car 1">
                		<h3>Rolls Royce Phantom</h3>
                		<h3>Blue</h3>
                		<h3>RM 9800 per day</h3>
              		</div>

              		<div class="car-tile">
						<img src="Assets/Cars/Luxurious/BCFS.png" alt="Luxurious Car 2">
						<h3>Bentley Continental Flying Spur</h3>
						<h3>White</h3>
						<h3>RM 4800 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Luxurious/MBCLS350.jpg" alt="Luxurious Car 3">
						<h3>Mercedes Benz CLS 350</h3>
						<h3>Sliver</h3>
						<h3>RM 1350 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Luxurious/JST.jpg" alt="Luxurious Car 4">
						<h3>Jaguar S Type</h3>
						<h3>Champagne</h3>
						<h3>RM 1350 per day</h3>
					</div>

				</div>

            </div>

        	<div class="category">

        		<h2 class="category-headings">Sports Cars</h2>

				<div class="car-tiles">

					<div class="car-tile">
						<img src="Assets/Cars/Sports/F430SCD.jpg" alt="Sports Car 1">
						<h3>Ferrari F430 Scuderia</h3>
						<h3>Red</h3>
						<h3>RM 6000 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Sports/LP640.jpg" alt="Sports Car 2">
						<h3>Lamborghini Murcielago LP640</h3>
						<h3>Matte Black</h3>
						<h3>RM 7000 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Sports/PORSCHE.png" alt="Sports Car 3">
						<h3>Porsche Boxster</h3>
						<h3>White</h3>
						<h3>RM 2800 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Sports/LEXUS.png" alt="Sports Car 4">
						<h3>Lexus SC430</h3>
						<h3>Black</h3>
						<h3>RM 1600 per day</h3>
					</div>

            	</div>
            	
          	</div>

        	<div class="category">

        		<h2 class="category-headings">Classic Cars</h2>

            	<div class="car-tiles">

					<div class="car-tile">
						<img src="Assets/Cars/Classics/JaguarMK2.jpeg" alt="Classic Car 1">
						<h3>Jaguar MK 2</h3>
                		<h3>White</h3>
                		<h3>RM 2200 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Classics/RRSSL.jpg" alt="Classic Car 2">
						<h3>Rolls Royce Silver Spirit Limousine</h3>
						<h3>Georgian Silver</h3>
						<h3>RM 3200 per day</h3>
					</div>

					<div class="car-tile">
						<img src="Assets/Cars/Classics/MG.png" alt="Classic Car 3">
						<h3>MG TD</h3>
						<h3>Red</h3>
						<h3>RM 2500 per day</h3>
					</div>

            	</div>

          	</div>

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