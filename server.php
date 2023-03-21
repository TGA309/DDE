<?php

// initializing variables
$name = "";
$username = "";
$email    = "";
$response = "";
$errors_login = array();
$errors_register = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'comp1044_database');

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
  }

  else {
    echo '<script type="text/javascript">
            function boxregister() {
              wrapper.classList.add("active-register");
              wrapper.classList.add("active-registerpopup");
              formBoxLogin.classList.add("inactive");
              wrapper.classList.remove("active-login");
              wrapper.classList.remove("active-loginpopup");
              formBoxRegister.classList.remove("inactive");
            }
            window.onload = boxregister;
          </script>';
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

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
    $name = mysqli_query($db, $name_query);
    $row = mysqli_fetch_assoc($name);

    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $row['name'];

      // $_SESSION['response'] = "Login Successful";
      // echo json_encode(array("response" => $_SESSION['response']));  //for testing
    } 
    
    else {
      // $_SESSION['response'] = "Login failed, kindly relogin.";
      // echo json_encode(array("response" => $_SESSION['response'], "errors" => $errors));  //for testing
    
      echo '<script type="text/javascript">
              function boxlogin() {
                wrapper.classList.add("active-login");
                wrapper.classList.add("active-loginpopup");
                formBoxRegister.classList.add("inactive");
                wrapper.classList.remove("active-register");
                wrapper.classList.remove("active-registerpopup");
                formBoxLogin.classList.remove("inactive");
              }
              window.onload = boxlogin;
            </script>';

      array_push($errors_login, "Wrong username/password combination entered.");
    }
    
  }
}

?>