<?php

// initializing variables
$name = "";
$username = "";
$email    = "";
$category = "";
$response = "";
$errors_login = array();
$errors_register = array();

date_default_timezone_set('Asia/Kuala_Lumpur');

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
  	$password = md5($password);  // encrypt the password before saving in the database

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
    $name_colname = mysqli_query($db, $name_query);
    $name = mysqli_fetch_assoc($name_colname);

    $category_query = "SELECT category FROM login_details WHERE BINARY username='$username'";
    $category_colname = mysqli_query($db, $category_query);
    $category_row = mysqli_fetch_assoc($category_colname);

    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $name['name'];
      $_SESSION['category'] = $category_row['category'];
    } 
    
    else {
      array_push($errors_login, "Wrong Username & Password Combination Entered.");

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

// NEW RESERVATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

  // get the form data
  $car_sr_no = $_POST['car_sr_no'];
  $pickup_date = $_POST['pickup_date'];
  $return_date = $_POST['return_date'];

  // car name retrieval
  $carnamesql_query = "SELECT car_name FROM cars WHERE BINARY sr_no = $car_sr_no";  //replace with SELECT * FROM cars like queries check chatgpt for more info.
  $car_name_colname = mysqli_query($db, $carnamesql_query);
  $car_name_row = mysqli_fetch_assoc($car_name_colname);
  $car_name = $car_name_row['car_name'];

  // reservation id creation
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

  // check for invalid date ranges
  if (strtotime($pickup_date) > strtotime($return_date)) {

    echo '<script type="text/javascript">
                function alertfunc() {
                  alert("Error: Invalid date range entered.");
                }

              window.onload=alertfunc;
          </script>';
  }

  else {

    // check for conflicting date ranges
    $sql = "SELECT * FROM reservations WHERE BINARY car_sr_no = $car_sr_no AND ((pickup_date >= STR_TO_DATE('$pickup_date', '%Y-%m-%d') AND pickup_date <= STR_TO_DATE('$return_date', '%Y-%m-%d')) OR (return_date >= STR_TO_DATE('$pickup_date', '%Y-%m-%d') AND return_date <= STR_TO_DATE('$return_date', '%Y-%m-%d')))";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {

      echo '<script type="text/javascript">
                function alertfunc() {
                  alert("Error: This car is already reserved for that time period.");
                }

                window.onload=alertfunc;
            </script>';
    } 
    
    else {

      // insert the reservation into the database
      $sql = "INSERT INTO reservations (car_name, car_sr_no, category, username, reservation_id, pickup_date, return_date, no_of_days, total_cost) VALUES ('$car_name', $car_sr_no, '$category', '$username', '$reservation_id', '$pickup_date', '$return_date', $no_of_days, $total_cost)";
      if(mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

        if ($category === "Employee") {
        echo '<script type="text/javascript">
    
        var reservation_id = ' . json_encode($reservation_id) . ';
        var total_cost = ' . json_encode($total_cost) . ';
          function alertfunc() {
            alert("Reservation created successfully. You and the customer can view it under your respective profile sections.\nThe customer\'s Reservation ID is: " + reservation_id + " \nThe customer will be charged: " + total_cost + " for this reservation.");
          }
    
        window.onload=alertfunc;
      
        </script>';
        }

        if ($category === "Customer") {
          echo '<script type="text/javascript">
      
          var reservation_id = ' . json_encode($reservation_id) . ';
          var total_cost = ' . json_encode($total_cost) . ';
            function alertfunc() {
              alert("Reservation created successfully. You can view it under your profile section.\nYour Reservation ID is: " + reservation_id + " \nYou will be charged: " + total_cost + " for this reservation.");
            }
      
          window.onload=alertfunc;
        
          </script>';
          }
      }

      // freeing up the variables used in the SQL queries.
      unset($car_name, $car_sr_no, $category, $username, $reservation_id, $pickup_date, $return_date, $no_of_days, $rate_per_day, $total_cost);
         
    }
  }
}



// ADD RESERVATION (Only for Customers)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {

  $username = $_SESSION['username'];
  $current_category = $_SESSION['category'];

  // getting the form data
  $reservation_id = $_POST['reservation_id'];

  $previous_category_query = "SELECT category FROM reservations WHERE BINARY reservation_id='$reservation_id'";

  // checking if entered reservation id exists in the table.
  if(mysqli_num_rows(mysqli_query($db, $previous_category_query)) <= 0) {
    echo '<script type="text/javascript">
              function alertfunc() {
                alert("Error: Reservation ID not found.");
              }

              window.onload=alertfunc;
            </script>';
  }

  else {

    $previous_category_colname = mysqli_query($db, $previous_category_query);
    $previous_category_row = mysqli_fetch_assoc($previous_category_colname);
    $previous_category = $previous_category_row['category'];


    if($previous_category === $current_category) {

      echo '<script type="text/javascript">
              function alertfunc() {
                alert("Error: This Reservation ID has already been added by another user.");
              }

              window.onload=alertfunc;
            </script>';
    }

    else {

      $sql = "UPDATE reservations SET category = '$current_category', username = '$username' WHERE BINARY reservation_id='$reservation_id'";
    
    
      if (mysqli_query($db, $sql)) {

        echo '<script type="text/javascript">
                function alertfunc() {
                  alert("Reservation added successfully.");
                }

                window.onload=alertfunc;
              </script>';
      }
    }
  }

  // freeing up the variables used in the SQL queries.
  unset($current_category, $previous_category, $username, $reservation_id);
  
}


// UPDATE RESERVATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

  // get the form data
  $current_reservation_id = $_POST['reservation_id_update'];
  $pickup_date = $_POST['pickup_date'];
  $return_date = $_POST['return_date'];

  // check if reservation id exists
  $reservation_id_check_query = "SELECT reservation_id FROM reservations WHERE BINARY reservation_id = '$current_reservation_id'";
  $reservation_id_check_result = mysqli_query($db, $reservation_id_check_query);

  if(mysqli_num_rows($reservation_id_check_result) <= 0) {

    echo '<script type="text/javascript">
            function alertfunc() {
              alert("Error: Reservation ID not found.");
            }
            window.onload=alertfunc;
          </script>';
  }

  else {

    // storing current date
    $current_date = date('Y-m-d');

    // getting current pickup date
    $current_pickup_date_query = "SELECT pickup_date FROM reservations WHERE BINARY reservation_id='$current_reservation_id'";
    $current_pickup_date_colname = mysqli_query($db, $current_pickup_date_query);
    $current_pickup_date_row = mysqli_fetch_assoc($current_pickup_date_colname);
    $current_pickup_date = $current_pickup_date_row['pickup_date'];

    // car sr_no retrieval
    $car_sr_no_query = "SELECT car_sr_no FROM reservations WHERE BINARY reservation_id='$current_reservation_id'";
    $car_sr_no_colname = mysqli_query($db, $car_sr_no_query);
    $car_sr_no_row = mysqli_fetch_assoc($car_sr_no_colname);
    $car_sr_no = $car_sr_no_row['car_sr_no'];

    // updated reservation id creation
    $updated_reservation_id = $car_sr_no.".".$pickup_date.".".$return_date;

    // current total cost retrieval
    $current_total_cost_query = "SELECT total_cost FROM reservations WHERE BINARY reservation_id='$current_reservation_id'";
    $current_total_cost_colname = mysqli_query($db, $current_total_cost_query);
    $current_total_cost_row = mysqli_fetch_assoc($current_total_cost_colname);
    $current_total_cost = $current_total_cost_row['total_cost'];

    // updated no. of days including pickup and return date calculation
    $updated_no_of_days = floor((strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24)) + 1;

    // rate per day retrieval
    $rate_per_day_query = "SELECT rate FROM cars WHERE BINARY sr_no = $car_sr_no";
    $car_rate_colname = mysqli_query($db, $rate_per_day_query);
    $rate_per_day_row = mysqli_fetch_assoc($car_rate_colname);
    $rate_per_day = $rate_per_day_row['rate'];

    // updated total cost calculation
    $updated_total_cost = $rate_per_day * $updated_no_of_days;

    // initialising difference in total cost.
    $difference = 0;

    // check for invalid date ranges

    if (strtotime($pickup_date) > strtotime($return_date)) {

      echo '<script type="text/javascript">
                  function alertfunc() {
                    alert("Error: Invalid date range entered.");
                  }

                window.onload=alertfunc;
            </script>';
    }

    else {
      
      // check for conflicting date ranges
      $sql = "SELECT * FROM reservations WHERE BINARY car_sr_no = $car_sr_no AND (BINARY reservation_id != '$current_reservation_id' AND ((pickup_date >= STR_TO_DATE('$pickup_date', '%Y-%m-%d') AND pickup_date <= STR_TO_DATE('$return_date', '%Y-%m-%d')) OR (return_date >= STR_TO_DATE('$pickup_date', '%Y-%m-%d') AND return_date <= STR_TO_DATE('$return_date', '%Y-%m-%d'))))";
      $result = mysqli_query($db, $sql);
      if (mysqli_num_rows($result) > 0) {

        echo '<script type="text/javascript">
                  function alertfunc() {
                    alert("Error: This car is already reserved for that time period.");
                  }

                  window.onload=alertfunc;
              </script>';
      } 
      
      else {

        // calculating difference in total cost in case of refund
        if($current_total_cost > $updated_total_cost) {

          $difference = $current_total_cost - $updated_total_cost;
        }
        
        else {
      
          $difference = $updated_total_cost - $current_total_cost;
        }


        // update the reservation for the database based on category of user

        // for employees to use the update reservation function
        if ($category === "Employee") {

          $sql = "UPDATE reservations SET reservation_id = '$updated_reservation_id', pickup_date = '$pickup_date', return_date = '$return_date', no_of_days = $updated_no_of_days, total_cost = $updated_total_cost WHERE BINARY reservation_id = '$current_reservation_id'";

          if(strtotime($current_pickup_date) > strtotime($current_date)) {

            if(mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

              if($current_total_cost > $updated_total_cost) {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';

                function alertfunc() {
                  alert("Booking updated successfully. You and the customer can view it under your respective profile sections.\nThe customer\'s updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nRefund: " + difference + ", to be refunded to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';

              }

              else {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You and the customer can view it under your respective profile sections.\nThe customer\'s updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nExtra Charge: " + difference + ", to be charged to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';
              }
            }
          }

          else {

            if(mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

              if($current_total_cost > $updated_total_cost) {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You and the customer can view it under your respective profile sections.\nThe customer\'s updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nRefund: 0, since the booking has already started.");
                }
                window.onload=alertfunc;
                </script>';

              }

              else {
                
                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You and the customer can view it under your respective profile sections.\nThe customer\'s updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nExtra Charge: " + difference + ", to be charged to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';
              }
            
            }
          }  
        }

        // for customers to use the update reservation function
        if ($category === "Customer") {

          $sql = "UPDATE reservations SET reservation_id = '$updated_reservation_id', pickup_date = '$pickup_date', return_date = '$return_date', no_of_days = $updated_no_of_days, total_cost = $updated_total_cost WHERE (BINARY reservation_id = '$current_reservation_id' AND BINARY username = '$username')";
          
          if(strtotime($current_pickup_date) > strtotime($current_date)) {

            if(mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

              if($current_total_cost > $updated_total_cost) {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You can view it under your profile section.\nYour updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nRefund: " + difference + ", to be refunded to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';

              }

              else {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You can view it under your profile section.\nYour updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nExtra Charge: " + difference + ", to be charged to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';
              }
            }

            else {

              echo '<script type="text/javascript">
                      function alertfunc() {
                        alert("Error: Cannot update reservation for entered Reservation ID from your account. Kindly contact a representative or login into the correct account to update this reservation.");
                      }
                      window.onload=alertfunc;
                    </script>';
            }

          }

          else {

            if(mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

              if($current_total_cost > $updated_total_cost) {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You can view it under your profile section.\nYour updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nRefund: 0, since the booking has already started.");
                }
                window.onload=alertfunc;
                </script>';
              }

              else {

                echo '<script type="text/javascript">
                var updated_reservation_id = ' . json_encode($updated_reservation_id) . ';
                var current_total_cost = ' . json_encode($current_total_cost) . ';
                var updated_total_cost = ' . json_encode($updated_total_cost) . ';
                var difference = ' . json_encode($difference) . ';
                function alertfunc() {
                  alert("Booking updated successfully. You can view it under your profile section.\nYour updated Reservation ID is: " + updated_reservation_id + "\nInitial total cost: " + current_total_cost + ".\nUpdated total cost: " + updated_total_cost + ".\nExtra Charge: " + difference + ", to be charged to the entered payment method.");
                }
                window.onload=alertfunc;
                </script>';
              }
            }

            else {

              echo '<script type="text/javascript">
                      function alertfunc() {
                        ("Error: Cannot update reservation for entered Reservation ID from your account. Kindly contact a representative or login into the correct account to update this reservation.");
                      }
                      window.onload=alertfunc;
                    </script>';
            }
          }
        }
        
        // freeing up the variables used in the SQL queries.
        unset($car_name, $car_sr_no, $category, $username, $current_reservation_id, $updated_reservation_id, $pickup_date, $return_date, $current_date, $current_pickup_date, $updated_no_of_days, $rate_per_day, $current_total_cost, $updated_total_cost, $difference);
          
      }
    }
  }
  
}

// DELETE RESERVATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {

  // getting category and username of user
  $category = $_SESSION['category'];
  $username = $_SESSION['username'];

  // get the form data
  $reservation_id = $_POST['reservation_id_delete'];

  // check if the reservation exists
  $sql = "SELECT * FROM reservations WHERE BINARY reservation_id='$reservation_id'";
  $result = mysqli_query($db, $sql);

  if (mysqli_num_rows($result) > 0) {

    // getting pickup_date to check whether cancellation is refundable or not.
    $pickup_date_query = "SELECT pickup_date FROM reservations WHERE BINARY reservation_id='$reservation_id'";
    $pickup_colname = mysqli_query($db, $pickup_date_query);
    $pickup_row = mysqli_fetch_assoc($pickup_colname);
    $pickup_date = $pickup_row['pickup_date'];

    // storing current date
    $current_date = date('Y-m-d');

    if(strtotime($pickup_date) > strtotime($current_date)) {

      $total_cost_query = "SELECT total_cost FROM reservations WHERE BINARY reservation_id='$reservation_id'";
      $total_cost_colname = mysqli_query($db, $total_cost_query);
      $total_cost_row = mysqli_fetch_assoc($total_cost_colname);
      $total_cost = $total_cost_row['total_cost'];
    }
    
    // deleting reservation based on category of user

    // sql to delete the reservation from the database as an employee
    if ($category === "Employee") {
      $sql = "DELETE FROM reservations WHERE BINARY reservation_id='$reservation_id'";

      if (mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

        if(strtotime($pickup_date) > strtotime($current_date)) {
          echo '<script type="text/javascript">
                  var total_cost = ' . json_encode($total_cost) . ';
                  function alertfunc() {
                    alert("Reservation deleted successfully. The customer will be refunded " + total_cost + " back to their original payment method.");
                  }
                  window.onload=alertfunc;
                </script>';
        }
  
        else {
  
          echo '<script type="text/javascript">
                  function alertfunc() {
                    alert("Reservation deleted successfully. The customer will not be refunded anything since the reservation has already started. ");
                  }
                  window.onload=alertfunc;
                </script>';
        }
          
      }
    }

    
    // sql to delete the reservation from the database as a customer
    if ($category === "Customer") {
      $sql = "DELETE FROM reservations WHERE (BINARY reservation_id='$reservation_id' AND BINARY username='$username')";

      if (mysqli_query($db, $sql) && mysqli_affected_rows($db) === 1) {

        if(strtotime($pickup_date) > strtotime($current_date)) {
          echo '<script type="text/javascript">
                  var total_cost = ' . json_encode($total_cost) . ';
                  function alertfunc() {
                    alert("Reservation deleted successfully. You will be refunded " + total_cost + " back to your original payment method.");
                  }
                  window.onload=alertfunc;
                </script>';
        }
  
        else {
  
          echo '<script type="text/javascript">
                  function alertfunc() {
                    alert("Reservation deleted successfully. You will not be refunded anything since the reservation has already started. ");
                  }
                  window.onload=alertfunc;
                </script>';
        }
          
      }

      else {
        echo '<script type="text/javascript">
                function alertfunc() {
                  alert("Error: Cannot delete reservation for entered Reservation ID from your account. Kindly contact a representative or login into the correct account to delete this reservation.");
                }
                window.onload=alertfunc;
              </script>';
      }

    }

  }
  
  else {

    echo '<script type="text/javascript">
            function alertfunc() {
              alert("Error: Reservation ID not found.");
            }

            window.onload=alertfunc;
          </script>';
  }

  // freeing up the variables used in the SQL queries.
  unset($category, $username, $reservation_id, $pickup_date, $current_date, $total_cost);
}

// close the database connection
mysqli_close($db);
?>