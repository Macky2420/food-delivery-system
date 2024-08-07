<?php
session_start();
require_once('send-code.php');

  $email = $_SESSION['verification_email']; 
  // Generate a new 6-digit code
  $code = rand(111111, 999999);

  // Send the verification code via email using the send_email function
  sendCode($email, $code);

  // If the email was sent successfully, update the verification code in the session
  $_SESSION['verification_code'] = $code;

  // Redirect to the verification page
  header('Location: ../pages/code.php');
  exit;

?>
