<?php 

session_start();
require_once('send-code.php');

  $for_email = $_SESSION['verification_email_forgot']; 
  // Generate a new 6-digit code
  $for_code = rand(111111, 999999);

  // Send the verification code via email using the send_email function
  forgotCode($for_email, $for_code);

  // If the email was sent successfully, update the verification code in the session
  $_SESSION['verification_code_forgot'] = $for_code;

  // Redirect to the verification page
  header('Location: ../pages/forgot_code.php');
  exit;

?>