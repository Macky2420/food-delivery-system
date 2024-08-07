<?php 

include_once 'connection.php';

// Validate staff input
function validateStaffInput($stationName, $conn) {
  // Make sure station name is not empty
  if (empty($stationName)) {
      $_SESSION['stationError'] = "Station name cannot be empty.";
      return false;
  }
  
  // Make sure station name only contains letters, numbers, and spaces
  if (!preg_match("/^[a-zA-Z0-9\s]+$/", $stationName) || strlen($stationName) < 7) {
    $_SESSION['stationError'] = "Station name must contain at least 7 characters and can only contain letters, numbers, and spaces.";
    return false;
  }

  // Check if station name already exists in database
  $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
  $stmt->bind_param("s", $stationName);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    if ($row['name'] === $stationName) {
        $_SESSION['stationError'] = "Station name already exists.";
        return false;
    }
  }

  // If all checks pass, return true (no error)
  return true;
}

// Validate customer input
function validateCustomerInput($userName, $conn) {
  if (empty($userName)) {
      $_SESSION['userError'] = "User name cannot be empty.";
      return false;
  }

  // Make sure user name only contains letters, and numbers
  if (!preg_match("/^[a-zA-Z0-9]+$/", $userName) || strlen($userName) < 5) {
    $_SESSION['userError'] = "User name must contain at least 5 characters and can only contain letters, and numbers";
    return false;
  }

  // Check if user name already exists in database
  $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
  $stmt->bind_param("s", $userName);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    if ($row['name'] === $userName) {
        $_SESSION['userError'] = "User name already exists.";
        return false;
    }
  }

  // add any other validation rules for customer input here
  return true;
}

// Validate emails
function validateEmail($email, $conn) {

  if (empty($email)) {
    $_SESSION['emailError'] = "Email cannot be empty.";
    return false;
  }

  // Check if email is a valid format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['emailError'] = "Invalid email format.";
      return false;
  }

  // Check if email already exists in database
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    if ($row['email'] === $email) {
        $_SESSION['emailError'] = "Email already exists.";
        return false;
    }
  }

  // If both checks pass, return true
  return true;
}

// Validate Password
function validatePassword($password) {
  if (empty($password) || $password === '') {
    $_SESSION['passwordError'] = "Password cannot be empty.";
    return false;
  }
 
  return true;

}

// Generate reserve id
function generateReserveId() {
  $timestamp = time(); // Get the current timestamp
  $randomNumber = mt_rand(); // Generate a random number
  $reserveId = $timestamp . '-' . $randomNumber; // Combine timestamp and random number
  
  return $reserveId;
}















  
?>