<?php 

session_start();
require_once 'connection.php';
require_once 'function.php';
require_once 'send-code.php';

/* GENERAL WHICH MEANS ALL USERS*/

// For signup form
if (isset($_POST['signup'], $_SESSION['token'])) {
    
    $date = date('Y-m-d');
    $time = date('h:i:s');
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $query = "SELECT role_id FROM roles WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $role);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // handle error
        $error = "Please select user.";
        $_SESSION['roleError'] = $error;
        $_SESSION['error'] = $error;
        header("Location: ../pages/signup.php?error=emptyRole");
        exit();
    }
    
    $row = $result->fetch_assoc();
    $role_id = $row['role_id'];

    if ($role == 'staff') {
        $stationName = $_POST['stationName'];

        // Validate station name input
        if (!validateStaffInput($stationName, $conn)) {

            $_SESSION['error'] = "Station name should not be empty or invalid";
            header("Location: ../pages/signup.php?error=invalidStationName");
            exit();
        }

        // Validate email input
        if (!validateEmail($email, $conn)) {
            $_SESSION['error'] = "Email should not be empty or invalid";
            header("Location: ../pages/signup.php?error=invalidEmail");
            exit();
        }

        // Validate password input
        if (!validatePassword($password)) {
            $_SESSION['error'] = "Password should not be empty or invalid";
            header("Location: ../pages/signup.php?error=emptyPasswordorInvalid");
            exit();
        }
          

        $query = "INSERT INTO users (name, email, password, role_id, date_updated, time_updated) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $stationName, $email, $password, $role_id, $date, $time);

        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Signup successful";
        header("Location: ../pages/verify.php");
        exit();

    } elseif ($role == 'customer') {
        $userName = $_POST['userName'];

        // Validate user name input
        if (!validateCustomerInput($userName, $conn)) {
            $_SESSION['error'] = "Username should not be empty or invalid";
            header("Location: ../pages/signup.php?error=invalidUserName");
            exit();
        }

        // Validate email input
        if (!validateEmail($email, $conn)) {
            $_SESSION['error'] = "Email should not be empty or invalid";
            header("Location: ../pages/signup.php?error=invalidEmail");
            exit();
        }

        // Validate password input
        if (!validatePassword($password)) {
            $_SESSION['error'] = "Password should not be empty or invalid";
            header("Location: ../pages/signup.php?error=emptyPasswordorInvalid");
            exit();
        }
          

        $query = "INSERT INTO users (name, email, password, role_id, date_updated, time_updated) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $userName, $email, $password, $role_id, $date, $time);

        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Signup successful";
        header("Location: ../pages/verify.php");
        exit();

        
    } else {
        header("Location: ../pages/signup.php?error=0");
        exit();
    }
   
    unset($_POST['signup']);

}

// For verify form
if (isset($_POST['verify'], $_SESSION['token'])) {

    // Get the email from the form data
    $email = $_POST['email'];

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the email exists, send the verification code
    if ($result->num_rows > 0) {
        // Generate a 6-digit code
        $code = rand(111111, 999999);

        // Send the verification code via email using the send_email function
            sendCode($email,$code);

                // If the email was sent successfully, store the verification code in the session

                $_SESSION['verification_code'] = $code;
                $_SESSION['verification_email'] = $email;

                // Redirect to the verification page
                $_SESSION['success'] = 'Verify successful.';
                header('Location: ../pages/code.php');
                exit;
                
            
    
    }  else {
        // If the email doesn't exist in the database, display an error message
        $_SESSION['error'] = "This email is not registered. Please enter a registered email.";
        $_SESSION['sendError'] = 'This email is not registered. Please enter a registered email.';
        header('Location: ../pages/verify.php?error=emailError');
        exit;
    }
    unset($_POST['verify.php']);   

}

// For send form
if (isset($_POST['code'], $_SESSION['token'])) { 
    $user_input = $_POST['inputCode']; // Get the user input from the form
    $token = $_SESSION['token'];
    $sent_code = $_SESSION['verification_code']; // Get the verification code from the session
    $anEmail = $_SESSION['verification_email'];
    
    if($user_input == $sent_code) { // Compare the user input to the stored code
        // Update the "verified" and "token" columns in the database
        $stmt = $conn->prepare("UPDATE users SET verified = 1, status = 1, token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $anEmail);
        $stmt->execute();

        // Retrieve the user's credentials from the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $anEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

            if ($row) { // If the user's credentials are valid
                // Retrieve the user's role from the database
                $role_id = $row['role_id'];
                $query = "SELECT name FROM roles WHERE role_id = ?";
                $stmt1 = $conn->prepare($query);
                $stmt1->bind_param("s", $role_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $row = $result1->fetch_assoc();
                $role_name = $row['name'];

                // Redirect the user based on their role
                if ($role_name == 'admin') {
                    $_SESSION['success'] = 'Registered successful.';
                    header('Location: ../pages/admin_home.php?token=' . urlencode($token));
                    exit;
                } elseif ($role_name == 'staff') {
                    $_SESSION['success'] = 'Registered successful.';
                    header('Location: ../pages/staff_home.php?token=' . urlencode($token));
                    exit;
                } elseif ($role_name == 'customer') {
                    $_SESSION['success'] = 'Registered successful.';
                    header('Location: ../pages/cus_home.php?token=' . urlencode($token));
                    exit;
                } else {
                    $_SESSION["codeError"] = "Invalid role.";
                    header('Location: ../pages/code.php');
                    exit;
                }
            } else { // If the user's credentials are invalid
                $_SESSION['error'] = "Invalid email or password.";
                $_SESSION["codeError"] = "Invalid email or password.";
                header('Location: ../pages/code.php');
                exit;
            }
        
    } else {
        $_SESSION['error'] = "Invalid code.";
        $_SESSION["codeError"] = "Invalid code."; // If the codes don't match, show an error message
        header('Location: ../pages/code.php');
        exit;
    }
    unset($_POST['code']);
}

// For forgot password
if (isset($_POST['forgot'], $_SESSION['token'])) {

    // Get the email from the form data
    $for_email = $_POST['email'];

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $for_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the email exists, send the verification code
    if ($result->num_rows > 0) {
        // Generate a 6-digit code
        $for_code = rand(111111, 999999);

        // Send the verification code via email using the send_email function
        forgotCode($for_email, $for_code);

        // If the email was sent successfully, store the verification code in the session
        $_SESSION['verification_code_forgot'] = $for_code;
        $_SESSION['verification_email_forgot'] = $for_email;

        // Redirect to the verification page
        $_SESSION['success'] = 'Verify successful.';
        header('Location: ../pages/forgot_code.php');
        exit;
    } else {
        // If the email doesn't exist in the database, display an error message
        $_SESSION['error'] = "This email is not registered. Please enter a registered email.";
        $_SESSION['sendError'] = 'This email is not registered. Please enter a registered email.';
        header('Location: ../pages/verify.php?error=emailError');
        exit;
    }
}

// For sending the code for forgot password
if (isset($_POST['forgot_code'], $_SESSION['token'])) {
    $user_input = $_POST['for_code']; // Get the user input from the form
    $for_sent_code = $_SESSION['verification_code_forgot']; // Get the verification code from the session
    $forEmail = $_SESSION['verification_email_forgot'];

    if ($user_input == $for_sent_code) { // Compare the user input to the stored code

            // If the user's credentials are valid
            $_SESSION['success'] = 'Change password successful.';
            header('Location: ../pages/new_password.php');
            exit;

        
    } else {
        $_SESSION['error'] = "Invalid code.";
        $_SESSION["codeError"] = "Invalid code."; // If the codes don't match, show an error message
        header('Location: ../pages/forgot_code.php');
        exit;
    }
}

// For changing a password
if (isset($_POST['new_pass'])) {
    $email = $_SESSION['verification_email_forgot'];
    $new_pass = $_POST['password'];
    $password = password_hash($new_pass, PASSWORD_DEFAULT);

    $stmt1 = $conn->prepare('UPDATE users SET password = ? WHERE email = ?');
    $stmt1->bind_param('ss', $password, $email);
    $stmt1->execute();

    if ($stmt1->affected_rows > 0) {
        $_SESSION['success'] = 'Password changed.';
        header('Location: ../pages/login.php');
        exit;
    } else {
        $_SESSION['error'] = 'Password not changed.';
        header('Location: ../pages/new_password.php');
        exit;
    }
}


// For login form
if (isset($_POST['login'])) {
    
    $log_Email = $_POST['logEmail']; // Get the user input from the form

    // Prepare and execute the SQL statement to retrieve the user's credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $log_Email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($result->num_rows == 0) {
        $_SESSION["loginEmail"] = "Email not registered.";
        header('Location: ../pages/login.php?error=invalidEmail');
        exit;

        
    }

    // Verify the password using password_verify function
    if (password_verify($_POST['logPass'], $row['password'])) { // If the user's credentials are valid

        if ($row['verified'] == 0) {
    
            $email = $log_Email;
    
            // Generate a 6-digit code
            $code = rand(111111, 999999);
    
            // Send the verification code via email using the send_email function
            sendCode($email, $code);
    
                // If the email was sent successfully, store the verification code in the session
                $_SESSION['verification_email'] = $log_Email;
                $_SESSION['verification_code'] = $code;
    
                // Redirect to the verification page
                $_SESSION['success'] = 'Verify successful.';
                header('Location: ../pages/code.php');
                exit;
        }else{
                // Update the user's status to 1
                $email = $row['email'];
                $stmt2 = $conn->prepare("UPDATE users SET status = 1 WHERE email = ?");
                $stmt2->bind_param("s", $email);
                $stmt2->execute();

                // Retrieve the user's role from the database
                $token = $row['token'];
                $role_id = $row['role_id'];
                $stmt1 = $conn->prepare("SELECT name FROM roles WHERE role_id = ?");
                $stmt1->bind_param("s", $role_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                $row = $result1->fetch_assoc();
                $role_name = $row['name'];

                // Redirect the user based on their role
                if ($role_name == 'admin') {
                    $_SESSION['success'] = 'Login successful.';
                header('Location: ../pages/admin_home.php?token='. urlencode($token));
                exit;
                } elseif ($role_name == 'staff') {
                    $_SESSION['success'] = 'Login successful.';
                    header('Location: ../pages/staff_home.php?token='. urlencode($token));
                    exit;
                } elseif ($role_name == 'customer') {
                    $_SESSION['success'] = 'Login successful.';
                    header('Location: ../pages/cus_home.php?token='. urlencode($token));
                    exit;
                } else {
                    $_SESSION['error'] = 'Invalid role.';
                    $_SESSION["loginError"] = "Invalid role.";
                    header('Location: ../pages/login.php');
                    exit;
                }
            }
    } else { // If the user's credentials are invalid
        $_SESSION["loginPass"] = "Invalid password.";
        $_SESSION["error"] = "Invalid password.";

        header('Location: ../pages/login.php');
        exit;
    }
    
    unset($_POST['login']);
}
    
// For logging out
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if the logout button was clicked
    if (isset($_POST['logout'])) {

      $user_id = $_POST['userId'];

      $stmt = $conn->prepare("UPDATE users SET status = 0 WHERE id= ?");
      $stmt->bind_param("s", $user_id);
        if($stmt->execute()){

        // destroy the session
        session_start();
        session_destroy();
    
        // redirect to the login page
        header('Location: ../pages/login.php');
        exit;
    }
  }
}

// For rating
if (isset($_POST['save'])) {
    $cus_token = $_POST['token'];
    $rating = $_POST['rating'];
    $name = $_POST['name'];
    $message = $_POST['message'];

    $stmt1 = $conn->prepare('INSERT INTO feedback (user_name, user_feedback, rating) VALUES (?, ?, ?)');
    $stmt1->bind_param('sss', $name, $message, $rating);
    $stmt1->execute();

    if ($stmt1->affected_rows > 0) {
        $_SESSION["success"] = "Feedback submitted successfully.";
        header('Location: ../pages/cus_help.php?token=' . urlencode($cus_token));
        exit();
    } else {
        $_SESSION["error"] = "Feedback submission failed.";
        header('Location: ../pages/cus_help.php?token=' . urlencode($cus_token));
        exit();
    }
}




/* FOR ROLE 3 -----> CUSTOMERS */

// Customer Displaying all station
if (isset($_POST['cus_menu'])) {
        $cus_token = $_POST['cus_token'];
        $_SESSION['staff'] = $_POST['station_token'];

        $stmt2 = $conn->prepare('SELECT * FROM users WHERE token = ?');
        $stmt2->bind_param('s', $_SESSION['staff']);
        $stmt2->execute();
        $result = $stmt2->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($row['verified'] == 1) {
                // staff member is fully verified, redirect to staff_menu.php
                header("Location: ../pages/cus_menu.php?token=" . urlencode($cus_token));
                exit();
            } else {
                // staff member is not fully verified, set error message
                $_SESSION['error'] = "Sorry, not verified staff yet.";
            }
        } else {
            // staff member ID not found, set error message
            $_SESSION['error'] = "Sorry, staff member ID not found.";
        }
    
}

// Retrieve the form data
if (isset($_POST['add_to_cart'])) {
    $staffId = $_POST['staff_id'];
    $cusToken = $_POST['cus_token'];
    $menuId = $_POST['menu_id'];
    $menuOptionId = $_POST['menu_option_id'];
    $quantity = 1;
    $currentTime = date('H:i:s');
    $currentDate = date('Y-m-d');

    // Check if the same menu and menu option already exist in the cart for the specific user
$stmtCheck = $conn->prepare('SELECT id, quantity FROM temporary_orders WHERE user_id = ? AND menu_id = ? AND menu_option_id = ? AND users_token = ?');
$stmtCheck->bind_param('ssss', $staffId, $menuId, $menuOptionId, $cusToken);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // The same menu and menu option already exist in the cart for the specific user
    // Update the quantity and total_cost of the existing menu in the cart
    $rowCheck = $resultCheck->fetch_assoc();
    $existingId = $rowCheck['id'];
    $existingQuantity = $rowCheck['quantity'];

    $stmt = $conn->prepare('SELECT cost FROM menu_options WHERE id = ?');
    $stmt->bind_param('s', $menuOptionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the cost of the menu option
        $row = $result->fetch_assoc();
        $cost = $row['cost'];

        $newQuantity = $existingQuantity + $quantity;
        $totalCost = $cost * $newQuantity;

        // Update the quantity and total_cost of the existing menu in the cart
        $stmtUpdate = $conn->prepare('UPDATE temporary_orders SET quantity = ?, total_cost = ? WHERE id = ?');
        $stmtUpdate->bind_param('iii', $newQuantity, $totalCost, $existingId);
        $stmtUpdate->execute();

        if ($stmtUpdate->affected_rows > 0) {
            $_SESSION['success'] = "Successfully added to cart.";
        } else {
            $_SESSION['error'] = "Sorry, the cart could not be updated.";
        }
    } else {
        $_SESSION['error'] = "Invalid menu option.";
    }
} else {
    // The same menu and menu option do not exist in the cart for the specific user
    // Fetch the cost of the menu option from menu_options table
    $stmt0 = $conn->prepare('SELECT cost FROM menu_options WHERE id = ?');
    $stmt0->bind_param('i', $menuOptionId);
    $stmt0->execute();
    $result0 = $stmt0->get_result();

    if ($result0->num_rows > 0) {
        // Fetch the cost of the menu option
        $row0 = $result0->fetch_assoc();
        $totalCost = $row0['cost'] * $quantity;

        // Prepare and execute the database query to add a new menu to the cart
        $stmt = $conn->prepare('INSERT INTO temporary_orders (user_id, menu_id, menu_option_id, quantity, total_cost, created_at, updated_at, users_token) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssssss', $staffId, $menuId, $menuOptionId, $quantity, $totalCost, $currentTime, $currentDate, $cusToken);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Successfully added to cart.";
        } else {
            $_SESSION['error'] = "Sorry, the cart could not be added.";
        }
    } else {
        $_SESSION['error'] = "Invalid menu";
    }
}
// Redirect to the appropriate page
header('Location:../pages/cus_menu.php?token=' . urlencode($cusToken));
exit;
}

// Sending feedback
if (isset($_POST['send_message'])) {
    $cusToken = $_POST['token']; // Corrected the variable name
    $name = $_POST['name'];
    $message = $_POST['message'];
    $timestamp = date('Y-m-d H:i:s');

    $stmt1 = $conn->prepare('INSERT INTO feedback (user_name, user_feedback, timestamp) VALUES (?,?,?)');
    $stmt1->bind_param('sss', $name, $message, $timestamp);
    $stmt1->execute();
    if ($stmt1->affected_rows > 0) {

        $_SESSION['success'] = 'Sent successfully.';
        header('Location: ../pages/cus_help.php?token=' . urlencode($cusToken)); // Corrected the URL
        exit(); // Added exit() to stop further execution
    } else {
        $_SESSION['error'] = 'Sorry, the feedback could not be sent.';
        header('Location: ../pages/cus_help.php?token=' . urlencode($cusToken)); // Corrected the URL
        exit(); // Added exit() to stop further execution
    }
}


// For submitting the order
if (isset($_POST['submit'])) {
    $customer_token = $_POST['cus_token'];
    $staff_id = $_POST['staff_id'];
    $request = $_POST['request'];
    $meal_time = $_POST['meal_time'];
    $order_type = $_POST['order_type'];
    $payment = $_POST['payment'];
    $time = date('H:i:s');
    $date = date('Y-m-d');
    $reserve_id = generateReserveId();
    $total = $_POST['total'];

    $stmt9 = $conn->prepare('SELECT * FROM temporary_orders WHERE user_id = ? AND users_token = ?');
    $stmt9->bind_param('ss', $staff_id, $customer_token);
    $stmt9->execute();
    $result9 = $stmt9->get_result();

    if ($result9->num_rows > 0) {
        $stmt11 = $conn->prepare('INSERT INTO reserve_orders (reserve_id, total, user_id, cus_token) VALUES (?,?,?,?)');
        $stmt11->bind_param('ssss', $reserve_id, $total, $staff_id, $customer_token);
        $stmt11->execute();
        
        if ($stmt11->affected_rows > 0) {
            $order_id = $stmt11->insert_id;

            $stmt10 = $conn->prepare('INSERT INTO transactions (user_id, menu_id, menu_option_id, quantity, remarks, created_at, updated_at, users_token, total_cost, payment_method, meal_time, order_id, order_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            while ($temp_order = $result9->fetch_assoc()) {
                $stmt10->bind_param('sssssssssssss', $temp_order['user_id'], $temp_order['menu_id'], $temp_order['menu_option_id'], $temp_order['quantity'], $request, $time, $date, $temp_order['users_token'], $temp_order['total_cost'], $payment, $meal_time, $order_id, $order_type);
                $stmt10->execute();

                if ($stmt10->affected_rows <= 0) {
                    $_SESSION['error'] = "Sorry, there was an error submitting the transaction.";
                    header('Location: ../pages/cus_menu.php?token=' . urlencode($customer_token));
                    exit();
                }
            }

            $stmt11 = $conn->prepare('DELETE FROM temporary_orders WHERE user_id = ? AND users_token = ?');
            $stmt11->bind_param('ss', $staff_id, $customer_token);
            $stmt11->execute();

            $_SESSION['success'] = "Successfully submitted.";
            header('Location: ../pages/cus_menu.php?token=' . urlencode($customer_token));
            exit();
        }
    }
}
    

/* FOR ROLE 2 ----- > STAFF */

// Staff for uploading menus
if (isset($_POST['confirm_create'])) {

    // Get the form data
    $token = $_POST['token'];
    $category_id = $_POST['category'];
    $name = $_POST['name'];
    $disable = 'no';
    $image = $_FILES['image']['name'];
    $option_names = $_POST['optionName'];
    $option_prices = $_POST['optionPrice'];

    // Upload the image file
    if (!empty($image)) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    // Insert the menu item data into the database
    $query = "INSERT INTO menus (name, category_id, disable, thumbnail, users_token) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $name, $category_id, $disable, $image, $token);
    $stmt->execute();

    // Get the last inserted ID
    $menu_id = $stmt->insert_id;

    // Insert the option data into the database
    if ($option_names && $option_prices) {
        $max_options = max(count($option_names), count($option_prices));
        for ($i = 0; $i < $max_options; $i++) {
            $option_name = isset($option_names[$i]) ? $option_names[$i] : '';
            $option_price = isset($option_prices[$i]) ? $option_prices[$i] : '';

            $query1 = "INSERT INTO menu_options (menu_id, name, cost) VALUES (?, ?, ?)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param("sss", $menu_id, $option_name, $option_price);
            $stmt1->execute();
        }
    }


    $_SESSION['success'] = 'Menus added successfully.';
    // Redirect to the menu page
    header("Location: ../pages/staff_menu.php?token=" . urlencode($token));
    exit();
}

// Staff displaying all menus 
if(isset($_POST['edit'])){
    $token = $_POST['token'];
    $menus_id = $_POST['menu_id'];
    $stmt5 = $conn->prepare('SELECT id, name, category_id, thumbnail FROM menus WHERE users_token = ? AND id = ?');
    $stmt5->bind_param('si', $token, $menus_id);
    $stmt5->execute();
    $result5 = $stmt5->get_result();

    if($row2 = $result5->fetch_assoc()){
        $_SESSION['menu_name'] = $row2['name'];
        $_SESSION['category'] = $row2['category_id'];
        $_SESSION['thumbnail'] = $row2['thumbnail'];
        $_SESSION['menus_id'] = $row2['id'];

        $stmt6 = $conn->prepare('SELECT name, cost FROM menu_options WHERE menu_id = ?');
        $stmt6->bind_param('i', $menus_id);
        $stmt6->execute();
        $result6 = $stmt6->get_result();

        if($row3 = $result6->fetch_assoc()){
            $_SESSION['option_name'] = $row3['name'];
            $_SESSION['option_cost'] = $row3['cost'];

            // Redirect to the menu page with menu ID in query parameter
            header("Location:../pages/staff_edit.php?token=". urlencode($token));
            exit();
        }
    }
}

// Staff editing menus (WARNING: its not finish at all because the update is not working properly)
if (isset($_POST['edit_create'])) {
    $menus_id = $_POST['menusId'];
    $token = $_POST['token'];
    $category_id = $_POST['category'];
    $name = $_POST['name'];
    $thumbnail = '';
    $option_names = $_POST['optionName'];
    $option_prices = $_POST['optionPrice'];

    // Upload the image file if it exists
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $thumbnail = basename($_FILES['image']['name']);
    }

    $stmt7 = $conn->prepare('UPDATE menus SET name = ?, category_id = ?' . (!empty($thumbnail) ? ', thumbnail = ?' : '') . ' WHERE id = ? AND users_token = ?');
    if (!empty($thumbnail)) {
        $stmt7->bind_param('sssss', $name, $category_id, $thumbnail, $menus_id, $token);
    } else {
        $stmt7->bind_param('ssss', $name, $category_id, $menus_id, $token);
    }
    $stmt7->execute();
    if ($stmt7->affected_rows > 0) {

        // First check if any options were submitted
        $has_options = false;
        if ($option_names && $option_prices) {
            $max_options = max(count($option_names), count($option_prices));
            for ($i = 0; $i < $max_options; $i++) {
                $option_name = isset($option_names[$i]) ? $option_names[$i] : '';
                $option_price = isset($option_prices[$i]) ? $option_prices[$i] : '';
                if (!empty($option_name) || !empty($option_price)) {
                    $has_options = true;
                    break;
                }
            }
        }

        if ($has_options) {
            // If there are new options, delete all existing options for the given menu ID
            $stmt1 = $conn->prepare('DELETE FROM menu_options WHERE menu_id = ?');
            $stmt1->bind_param('s', $menus_id);
            $stmt1->execute();

            // Then insert new options
            for ($i = 0; $i < $max_options; $i++) {
                $option_name = isset($option_names[$i]) ? $option_names[$i] : '';
                $option_price = isset($option_prices[$i]) ? $option_prices[$i] : '';

                $stmt2 = $conn->prepare('INSERT INTO menu_options (menu_id, name, cost) VALUES (?, ?, ?)');
                $stmt2->bind_param('sss', $menus_id, $option_name, $option_price);
                $stmt2->execute();
            }
        } else {
            // If there are no new options, do nothing
            return;
        }


    }
    $_SESSION['success'] = 'Edit menus successful.';
    header('Location: ../pages/staff_menu.php?token=' . urlencode($token));
    exit();
}

// Staff deleting menus
if (isset($_POST['delete'])) {
    $menu_id = $_POST['menu_id'];
    $token = $_POST['token'];

    // Delete associated transactions first
    $stmt1 = $conn->prepare('DELETE FROM transactions WHERE menu_option_id IN (SELECT id FROM menu_options WHERE menu_id = ?)');
    $stmt1->bind_param('i', $menu_id);
    $stmt1->execute();

    if ($stmt1->error) {
        echo "Error deleting associated transactions: " . $stmt1->error;
    } else {
        // Delete the menu options
        $stmt2 = $conn->prepare('DELETE FROM menu_options WHERE menu_id = ?');
        $stmt2->bind_param('i', $menu_id);
        $stmt2->execute();

        if ($stmt2->error) {
            echo "Error deleting menu options: " . $stmt2->error;
        } else {
            // Delete the menu
            $stmt3 = $conn->prepare('DELETE FROM menus WHERE id = ?');
            $stmt3->bind_param('i', $menu_id);
            $stmt3->execute();

            if ($stmt3->error) {
                $_SESSION['error'] = "Error deleting menu: " . $stmt3->error;
            } else {
                // Redirect to staff_menu.php with sanitized token
                $_SESSION['success'] = 'Deleted successfully.';
                header('Location: ../pages/staff_menu.php?token=' . urlencode($token));
                exit();
            }
        }
    }
}


// Staff for disable 
if (isset($_POST['disable'])) {
    $menu_id = $_POST['menu_id'];
    $disable = $_POST['disabled'];

    $stmt3 = $conn->prepare('UPDATE menus SET disable =? WHERE id =?');
    $stmt3->bind_param('ss', $disable, $menu_id);
    if($stmt3->execute()){

        $stmt4 = $conn->prepare('SELECT users_token FROM menus WHERE id = ?');
        $stmt4->bind_param('i', $menu_id);
        $stmt4->execute();
        $result = $stmt4->get_result();
        if ($result->num_rows > 0) {
            if ($disable == "yes") {
                $_SESSION['error'] = "Menu disabled successfully.";
            } else {
                $_SESSION['success'] = "Menu enabled successfully.";
                
            }

        // Redirect to staff_menu.php with sanitized token
        header('Location:../pages/staff_menu.php?token='. urlencode($token = $result->fetch_assoc()['users_token']));
        exit();
        }
        
    }
}

// Staff for completing the customer order
if (isset($_POST['complete'])) {
    $staff_token = $_POST['staff_token'];
    $order_id = $_POST['order_id'];

    $stmt2 = $conn->prepare('SELECT completion_status FROM transactions WHERE order_id = ? AND (completion_status IS NULL OR completion_status = "")');
    $stmt2->bind_param('s', $order_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        $stmt3 = $conn->prepare('UPDATE transactions SET completion_status = "yes" WHERE order_id = ? AND (completion_status IS NULL OR completion_status = "")');
        $stmt3->bind_param('s', $order_id);
        $stmt3->execute();
        $stmt3->store_result();

        if ($stmt3->affected_rows > 0) {
            $_SESSION['success'] = "Completed menus successfully.";
        }
    }

    header('Location: ../pages/staff_home.php?token=' . urlencode($staff_token));
    exit();  // Terminate the script after redirection
}


// Staff for conpleting the payment 
if (isset($_POST['payment'])) {
    $staff_token = $_POST['staff_token'];
    $order_id = $_POST['order_id'];

    $stmt2 = $conn->prepare('SELECT payment_status FROM transactions WHERE order_id = ? AND (payment_status IS NULL OR payment_status = "")');
    $stmt2->bind_param('s', $order_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        $stmt3 = $conn->prepare('UPDATE transactions SET payment_status = "yes" WHERE order_id = ? AND (payment_status IS NULL OR payment_status = "")');
        $stmt3->bind_param('s', $order_id);
        $stmt3->execute();
        $stmt3->store_result();

        if ($stmt3->affected_rows > 0) {
            $_SESSION['success'] = "Paid menus successfully.";
        }
    }

    header('Location: ../pages/staff_home.php?token=' . urlencode($staff_token));
    exit();  // Terminate the script after redirection
}


// Staff for reserve orders
if (isset($_POST['reserve_order'])) {
    $staff_token = $_POST['token'];
    $order_id = $_POST['order_id'];
    $_SESSION['order_id'] = $order_id;

    $stmt1 = $conn->prepare('SELECT * FROM transactions WHERE order_id = ?');
    $stmt1->bind_param('s', $order_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $row1 = $result1->fetch_assoc();

        header('Location: ../pages/staff_order.php?token=' . urlencode($staff_token));
        exit();
    } else {
        $_SESSION['error'] = 'Something went wrong while accessing the customer order.';
        header('Location: ../pages/staff_home.php?token=' . urlencode($staff_token));
        exit();
    }
}

// for checking order menus
if (isset($_POST['check'])) {
    $staff_token = $_POST['token'];
    $trans_id = $_POST['trans_id'];
    $order_id = $_POST['order_id'];

    $stmt2 = $conn->prepare('UPDATE transactions SET completion_status = ? WHERE id = ? AND order_id = ?');
    $completion_status = 'yes'; // Assuming 'yes' is the desired value
    $stmt2->bind_param('sss', $completion_status, $trans_id, $order_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2) {
        $_SESSION['error'] = 'Error';
        header('Location: ../pages/staff_order.php?token=' . urlencode($staff_token));
        exit();
    } else {
        $_SESSION['success'] = 'Success';
        header('Location: ../pages/staff_order.php?token=' . urlencode($staff_token));
        exit();
    }
}

// for unchecking order menus Note: need to fix the subraction
if (isset($_POST['uncheck'])) {
    $staff_token = $_POST['token'];
    $trans_id = $_POST['trans_id'];
    $order_id = $_POST['order_id'];

    $stmt2 = $conn->prepare('UPDATE transactions SET completion_status = ?, payment_status = ? WHERE id = ? AND order_id = ?');
    $completion_status = 'no'; // Assuming 'no' is the desired value
    $payment_status = 'no';
    $stmt2->bind_param('ssss', $completion_status, $payment_status, $trans_id, $order_id);
    $stmt2->execute();

    if ($stmt2->affected_rows > 0) {
        $stmt3 = $conn->prepare('UPDATE reserve_orders
                                SET total = total - (SELECT total_cost FROM transactions WHERE id = ? AND order_id = ?)
                                WHERE id = ?');
        $stmt3->bind_param('sss', $trans_id, $order_id, $order_id);
        $stmt3->execute();

        $_SESSION['error'] = 'Uncheck';
        header('Location: ../pages/staff_order.php?token=' . urlencode($staff_token));
        exit();
    }
}








/* FOR ROLE 1 ---------> ADMIN */

// Admin for editing users
if (isset($_POST['admin_edit'])){
    $token = $_POST['adminToken'];
    $users_id = $_POST['user_id'];

    // Get the user's information from the database
    $query = $conn->prepare('SELECT * FROM users WHERE id = ?');
    $query->bind_param('i', $users_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    // Save the user's information in session for displaying in the form
    $_SESSION['id'] = $user['id'];
    $_SESSION['edit_user_name'] = $user['name'];
    $_SESSION['edit_user_email'] = $user['email'];
    $_SESSION['edit_user_role'] = $user['role_id'];

    // Redirect to the edit user page
    header('Location: ../pages/admin_edit.php?token='. urlencode($token));
    exit;
}

// Admin update user info
if (isset($_POST['update_info'])) {
    $token = $_POST['token'];
    $user_id = $_POST['user_id'];
    $new_name = ($_SESSION['edit_user_role'] == 2) ? $_POST['station_name'] : $_POST['username'];

    $valid_input = ($_SESSION['edit_user_role'] == 2) ? validateStaffInput($new_name, $conn) : validateCustomerInput($new_name, $conn);

    if (!$valid_input) {
        $_SESSION['error'] = ($_SESSION['edit_user_role'] == 2) ? "Invalid station name" : "Invalid username";
        header("Location: ../pages/admin_edit.php?token=" . urlencode($token));
        exit();
    }

    $stmt1 = $conn->prepare('UPDATE users SET name = ? WHERE id = ?');
    $stmt1->bind_param('ss', $new_name, $user_id);
    $stmt1->execute();

    $_SESSION['success'] = "Edit successful";
    header('Location: ../pages/admin_user.php?token=' . urlencode($token));
    exit();
}

// Admin delete user
if (isset($_POST['user_delete'])){
    $admin_token = $_POST['userToken'];
    $user_id = $_POST['userId'];

    $query = $conn->prepare('DELETE FROM users WHERE id = ?');
    $query->bind_param('s', $user_id);
    $query->execute();

    if ($query->error) {
        // ADD SESSION FOR ERROR
        $_SESSION['error'] = "Error deleting user: " . $query->error;
    } else {
        // ADD SESSION FOR SUCCESSFUL
        $_SESSION['success'] = "User has been deleted successfully.";
    }

    header('Location: ../pages/admin_user.php?token=' . urlencode($admin_token));
    exit();
}

// Admin display all the station 
if (isset($_POST['staff_post'])){
    $admin_token = $_POST['token'];
    $_SESSION['staff_token'] = $_POST['stationToken'];

    $stmt2 = $conn->prepare('SELECT * FROM users WHERE token = ?');
    $stmt2->bind_param('s', $_SESSION['staff_token']);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['verified'] == 1) {
            // staff member is fully verified, redirect to staff_menu.php
            header("Location: ../pages/admin_menu.php?token=" . urlencode($admin_token));
            exit();
        } else {
            // staff member is not fully verified, set error message
            $_SESSION['error'] = "Sorry, not verified staff yet.";
        }
    } else {
        // staff member ID not found, set error message
        $_SESSION['error'] = "Sorry, staff member ID not found.";
    }
}

// Admin deleting station menu
if (isset($_POST['admin_delete'])) {
    $menu_id = $_POST['menu_id'];
    $token = $_POST['token'];

    // Delete menu options first
    $stmt1 = $conn->prepare('DELETE FROM menu_options WHERE menu_id = ?');
    $stmt1->bind_param('i', $menu_id);
    $stmt1->execute();

    if ($stmt1->error) {
        $_SESSION['error'] = "Error deleting menu options: " . $stmt1->error;
    } else {
        // Delete the menu
        $stmt2 = $conn->prepare('DELETE FROM menus WHERE id = ?');
        $stmt2->bind_param('i', $menu_id);
        $stmt2->execute();

        if ($stmt2->error) {
            echo "Error deleting menu: " . $stmt2->error;
        } else {
            // Redirect to staff_menu.php with sanitized token

            $_SESSION['success'] = 'Deleted Successfully.';
            header('Location: ../pages/admin_menu.php?token=' . urlencode($token));
            exit();
        }
    }
}

// Admin for disable 
if (isset($_POST['admin_disable'])) {
    $menu_id = $_POST['menu_id'];
    $disable = $_POST['disabled'];

    $stmt3 = $conn->prepare('UPDATE menus SET disable =? WHERE id =?');
    $stmt3->bind_param('ss', $disable, $menu_id);
    if($stmt3->execute()){
        if ($disable == "yes") {
            $_SESSION['error'] = "Menu disabled successfully.";
        } else {
            $_SESSION['success'] = "Menu enabled successfully.";
            
        }
        $stmt4 = $conn->prepare('SELECT token FROM users WHERE role_id = 1');
        $stmt4->execute();
        $result = $stmt4->get_result();
        if ($result->num_rows > 0) { 
            // Redirect to staff_menu.php with sanitized token
            header('Location:../pages/admin_menu.php?token='. urlencode($token = $result->fetch_assoc()['token']));
            exit();
        }
    }
}

// Admin click edit button 
if(isset($_POST['admin_menu_edit'])){
    $token = $_POST['token'];
    $staff_token = $_SESSION['staff_token'];
    $menus_id = $_POST['menu_id'];
    $stmt5 = $conn->prepare('SELECT id, name, category_id, thumbnail FROM menus WHERE users_token = ? AND id = ?');
    $stmt5->bind_param('si', $staff_token, $menus_id);
    $stmt5->execute();
    $result5 = $stmt5->get_result();

    if($row2 = $result5->fetch_assoc()){
        $_SESSION['menu_name'] = $row2['name'];
        $_SESSION['category'] = $row2['category_id'];
        $_SESSION['thumbnail'] = $row2['thumbnail'];
        $_SESSION['menus_id'] = $row2['id'];

        $stmt6 = $conn->prepare('SELECT name, cost FROM menu_options WHERE menu_id = ?');
        $stmt6->bind_param('i', $menus_id);
        $stmt6->execute();
        $result6 = $stmt6->get_result();

        if($row3 = $result6->fetch_assoc()){
            $_SESSION['option_name'] = $row3['name'];
            $_SESSION['option_cost'] = $row3['cost'];

            // Redirect to the menu page with menu ID in query parameter
            header("Location:../pages/admin_menu_edit.php?token=". urlencode($token));
            exit();
        }
    }
}

// Admin editing menus (WARNING: its not finish at all because the update is not working properly)
if (isset($_POST['admin_edit_create'])) {
    $menus_id = $_POST['menusId'];
    $token = $_POST['token'];
    $staff_token = $_SESSION['staff_token'];
    $category_id = $_POST['category'];
    $name = $_POST['name'];
    $thumbnail = '';
    $option_names = $_POST['optionName'];
    $option_prices = $_POST['optionPrice'];

    // Upload the image file if it exists
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $thumbnail = basename($_FILES['image']['name']);
    }

    $stmt7 = $conn->prepare('UPDATE menus SET name = ?, category_id = ?' . (!empty($thumbnail) ? ', thumbnail = ?' : '') . ' WHERE id = ? AND users_token = ?');
    if (!empty($thumbnail)) {
        $stmt7->bind_param('sssss', $name, $category_id, $thumbnail, $menus_id, $staff_token);
    } else {
        $stmt7->bind_param('ssss', $name, $category_id, $menus_id, $staff_token);
    }
    $stmt7->execute();
    if ($stmt7->affected_rows > 0) {

        // First check if any options were submitted
        $has_options = false;
        if ($option_names && $option_prices) {
            $max_options = max(count($option_names), count($option_prices));
            for ($i = 0; $i < $max_options; $i++) {
                $option_name = isset($option_names[$i]) ? $option_names[$i] : '';
                $option_price = isset($option_prices[$i]) ? $option_prices[$i] : '';
                if (!empty($option_name) || !empty($option_price)) {
                    $has_options = true;
                    break;
                }
            }
        }

        if ($has_options) {
            // If there are new options, delete all existing options for the given menu ID
            $stmt1 = $conn->prepare('DELETE FROM menu_options WHERE menu_id = ?');
            $stmt1->bind_param('s', $menus_id);
            $stmt1->execute();

            // Then insert new options
            for ($i = 0; $i < $max_options; $i++) {
                $option_name = isset($option_names[$i]) ? $option_names[$i] : '';
                $option_price = isset($option_prices[$i]) ? $option_prices[$i] : '';

                $stmt2 = $conn->prepare('INSERT INTO menu_options (menu_id, name, cost) VALUES (?, ?, ?)');
                $stmt2->bind_param('sss', $menus_id, $option_name, $option_price);
                $stmt2->execute();
            }
        } else {
            // If there are no new options, do nothing
            return;
        }

        $_SESSION['success'] = 'Confirm edit Successful.';
        header('Location: ../pages/admin_menu.php?token=' . urlencode($token));
        exit();
    }else{
        
        $_SESSION['error'] = 'Confirm edit Failed.';
        header('Location: ../pages/admin_menu_edit.php?token=' . urlencode($token));
        exit();
    }
}




?> 













    





  
  
?>