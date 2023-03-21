<!DOCTYPE html>
<?php 
	session_start();
	
	if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location: index.php");
  }
?>

<?php include('server.php') ?>

<html>
	<head>
		<title>Daily Driven Exotics</title>
		<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
	</head>

	<body>

		<nav>
			<div class="nav-container">
				<a href="index.php" class="logo">Daily Driven Exotics</a>
				<ul class="dropdown-ul">
				<li class="dropdown-li"><a class="nav-elements" href = "cars.php" >Cars</a></li>
				<li class="dropdown-li"><a class="nav-elements">About Us</a></li>
				<?php  if (!isset($_SESSION['username'])) : ?>
				<li class="profile_icon">
					<img src="Assets/Images/account.png"></img>
					<div class="dropdown">
					<a class = "btnLogin-popup">Log In</a>
					<a class = "btnRegister-popup">Register</a>
					</div>
				</li>
				<?php endif ?>
				
				<?php  if (isset($_SESSION['username'])) : ?>
				<li class="nav-element-welcome">
					<a>Welcome: <?php echo $_SESSION['name']; ?></a>
					<div class="dropdown">
						<a class = "in"> My Bookings </a> </a>
						<a href="index.php?logout='1'" class = "in"> Logout</a>
					</div>	
				</li>
				<?php endif ?>
				</ul>
			</div>
		</nav>

		<div class="bg-img-home">
			<h1 class="bg-img-text-home">WHERE ADVENTURE MEETS LUXURY</h1>

			<div class="wrapper">
				<span class="icon-close">
					<ion-icon name="close-sharp"></ion-icon>
				</span>

				<div class="form-boxlogin">
					<h2>Login</h2>
					<form method="post" action="index.php">
						<form>
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
	
		<script src="index.js"></script>
		<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

	</body>
</html>