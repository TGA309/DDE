<?php

// initializing variables
$name = "";
$username = "";
$email    = "";
$category = "";
$response = "";
$errors_login = array();
$errors_register = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'comp1044_database');

// check for errors
if (!$db) {
  die('Error: ' . mysqli_connect_error());
}

function isValidEmail($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $errors_register = [];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($name)) { array_push($errors_register, "Name is required."); }
  if (empty($username)) { array_push($errors_register, "Username is required."); }
  if (empty($email)) { array_push($errors_register, "Email is required."); }

  if (!isValidEmail($email)) {array_push($errors_register, "Email is invalid in format."); }

  if (empty($password)) { array_push($errors_register, "Password is required."); }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM login_details WHERE BINARY username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors_register, "Username already exists.");
    }

    if ($user['email'] === $email) {
      array_push($errors_register, "Email already exists.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors_register) == 0) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO login_details (category, name, username, email, password)
  			  VALUES('Customer', '$name', '$username', '$email', '$password')";
  	mysqli_query($db, $query);
    $_SESSION['username'] = $username;
  	$_SESSION['name'] = $name;
    $_SESSION['category'] = 'Customer';
  }

  else {
    echo '<script type="text/javascript">
            function boxRegister() {
              wrapper.classList.add("active-register");
              wrapper.classList.add("active-registerpopup");
              formBoxLogin.classList.add("inactive");
              wrapper.classList.remove("active-login");
              wrapper.classList.remove("active-loginpopup");
              formBoxRegister.classList.remove("inactive");
            }

            window.onload=boxRegister;
          </script>';
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $errors_login = [];

  if (empty($username)) {
  	array_push($errors_login, "Username is required.");
  }
  if (empty($password)) {
  	array_push($errors_login, "Password is required.");
  }

  if (count($errors_login) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM login_details WHERE BINARY username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);

    $name_query = "SELECT name FROM login_details WHERE BINARY username='$username'";
    $colname = mysqli_query($db, $name_query);
    $name = mysqli_fetch_assoc($colname);

    $category_query = "SELECT category FROM login_details WHERE BINARY username='$username'";
    $catcolname = mysqli_query($db, $category_query);
    $category = mysqli_fetch_assoc($catcolname);

    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $name['name'];
      $_SESSION['category'] = $category['category'];

      // $_SESSION['response'] = "Login Successful";
      // echo json_encode(array("response" => $_SESSION['response']));  //for testing
    } 
    
    else {
      array_push($errors_login, "Wrong username/password combination entered.");

      // $_SESSION['response'] = "Login failed, kindly relogin.";
      // echo json_encode(array("response" => $_SESSION['response'], "errors" => $errors_login));  //for testing

      echo '<script type="text/javascript">
              function boxLogin() {
                wrapper.classList.add("active-login");
                wrapper.classList.add("active-loginpopup");
                formBoxRegister.classList.add("inactive");
                wrapper.classList.remove("active-register");
                wrapper.classList.remove("active-registerpopup");
                formBoxLogin.classList.remove("inactive");
              }

              window.onload=boxLogin;
            </script>';
    }
    
  }
}

// NEW BOOKING
if (isset($_POST['submit'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

  // get the form data
  $car_sr_no = $_POST['car_sr_no'];

  // car name retrieval
  $carnamesql_query = "SELECT car_name FROM cars WHERE BINARY sr_no = $car_sr_no";
  $car_name_colname = mysqli_query($db, $carnamesql_query);
  $car_name_row = mysqli_fetch_assoc($car_name_colname);
  $car_name = $car_name_row['car_name'];

  $pickup_date = $_POST['pickup_date'];
  $return_date = $_POST['return_date'];
  $reservation_id = $car_sr_no.".".$pickup_date.".".$return_date;

  // no. of days including pickup and return date calculation
  $no_of_days = floor((strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24)) + 1;

  // rate per day retrieval
  $rate_per_day_query = "SELECT rate FROM cars WHERE BINARY sr_no = $car_sr_no";
  $car_rate_colname = mysqli_query($db, $rate_per_day_query);
  $rate_per_day_row = mysqli_fetch_assoc($car_rate_colname);
  $rate_per_day = $rate_per_day_row['rate'];

  // total cost calculation
  $total_cost = $rate_per_day * $no_of_days;

  // check for conflicting dates
  $sql = "SELECT * FROM reservations WHERE BINARY car_sr_no = $car_sr_no AND ((pickup_date >= '$pickup_date' AND pickup_date <= '$return_date') OR (return_date >= '$pickup_date' AND return_date <= '$return_date'))";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo "Error: This car is already booked for that time period";
  } 
  
  else {

    if($_SESSION['category'] === 'Employee') {

      // insert the booking into the database as an Employee Booking
      $sql = "INSERT INTO reservations (car_name, car_sr_no, customer_username, reservation_id, pickup_date, return_date, no_of_days, total_cost) VALUES ('$car_name', $car_sr_no, 'Employee_Reservation', '$reservation_id', '$pickup_date', '$return_date', $no_of_days, $total_cost)";
      
    }
    
    if($_SESSION['category'] === 'Customer') {

      // insert the booking into the database as a Customer Booking
      $sql = "INSERT INTO reservations (car_name, car_sr_no, customer_username, reservation_id, pickup_date, return_date, no_of_days, total_cost) VALUES ('$car_name', $car_sr_no, '$username', '$reservation_id', '$pickup_date', '$return_date', $no_of_days, $total_cost)";
    }
      
    if (mysqli_query($db, $sql)) {
      echo "Booking created successfully";
    } 
      
    else {
      echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
  }
} 

// ADD BOOKING (Only for Customers)

if (isset($_POST['add'])) {


}
  
// UPDATE BOOKING
else if (isset($_POST['update'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

  // get the form data
  $id = $_POST['id'];
  $car_sr_no = $_POST['car_sr_no'];
  $pickup_date = $_POST['pickup_date'];
  $return_date = $_POST['return_date'];

  // check for conflicting dates
  $sql = "SELECT * FROM reservations WHERE car_sr_no=$car_sr_no AND ((pickup_date >= '$pickup_date' AND pickup_date <= '$return_date') OR (return_date >= '$pickup_date' AND return_date <= '$return_date')) AND id != $id";
  $result = mysqli_query($db, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo "Error: This car is already booked for that time period";
  } 
  
  else {
      // update the booking in the database
      $sql = "UPDATE reservations SET car_sr_no='$car_sr_no', pickup_date='$pickup_date', return_date='$return_date' WHERE id=$id";
      if (mysqli_query($db, $sql)) {
        echo "Booking updated successfully";
      } 
      
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
      }
  }
} 

// DELETE BOOKING
else if (isset($_POST['delete'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

    // get the form data
    $id = $_POST['id'];

    // check if the booking exists
    $sql = "SELECT * FROM bookings WHERE id=$id";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        // delete the booking from the database
        $sql = "DELETE FROM bookings WHERE id=$id";
        if (mysqli_query($db, $sql)) {
          echo "Booking deleted successfully";
        } 
        
        else {
          echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    } 
    
    else {
      echo "Error: Booking not found";
    }
  }

  // close the database connection
  mysqli_close($db);
?>