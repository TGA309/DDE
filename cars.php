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

		<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

	</body>
</html>