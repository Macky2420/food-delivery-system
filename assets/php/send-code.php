<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

function sendCode($email,$code){
global $mail;
    try {
        //Server setting
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'laconmarkie@gmail.com';                     //SMTP username
        $mail->Password   = 'kjedujcnlfkqaqxz';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('laconmarkie@gmail.com', 'Food Delivery System');    //Add a recipient
        $mail->addAddress($email);               //Name is optional
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Verify Your Email";
        $mailContent = '<html>
                            <head>
                                <style>
                                    /* CSS styles for the email body */
                                    body {
                                        background-color: #f7f7f7;
                                        font-family: Arial, sans-serif;
                                        background-color: darkgreen;    
                                    }
                                    .container {
                                        background-color: #fff;
                                        border: 1px solid #ddd;
                                        border-radius: 5px;
                                        box-shadow: 0 0 5px #ddd;
                                        margin: 20px auto;
                                        max-width: 600px;
                                        padding: 20px;
                                        
                                    }
                                    img {
                                        display: block;
                                        margin: 0 auto;
                                        width: 100px;
                                    }
                                    h1 {
                                        color: #064e3b;
                                        font-size: 24px;
                                        margin-top: 0;
                                        text-align: center;
                                    }
                                    p {
                                        
                                        font-size: 16px;
                                        line-height: 1.5;
                                        margin: 20px 0;
                                
                                    }
                                    .code {
                                        background-color: #f5f5f5;
                                        color: #064e3b;
                                        border: 1px solid #ddd;
                                        border-radius: 5px;
                                        font-size: 24px;
                                        font-weight: bold;
                                        margin: 20px auto;
                                        max-width: 200px;
                                        padding: 10px;
                                        text-align: center;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    <img src="https://i.ibb.co/YBRmfdZ/icon-logo.png" alt="Nwssu Foodcourt Reservation System">
                                    <h1>Nwssu Food Reservation System</h1>
                                    <p>Hi Users,</p>
                                    <p>Welcome to Food Delivery System!</p>
                                    <p>Thank you for signing up for our food reservation system.</p>
                                    <p style="text-align: center; color: #666;">Please use the following code to verify your email address:</p>
                                    <div class="code">' . $code . '</div>
                                    <p style="text-align: center; color: #666;">If you did not request this verification code, please ignore this email.</p>
                                    <p>Regards,</p>
                                    <p>Food Delivery System Team</p>
                                </div>
                            </body>
                        </html>';
        $mail->Body = $mailContent;
        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
}

function forgotCode($for_email,$for_code){
    global $mail;
        try {
            //Server setting
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'laconmarkie@gmail.com';                     //SMTP username
            $mail->Password   = 'kjedujcnlfkqaqxz';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('laconmarkie@gmail.com', 'Food Delivery System');    //Add a recipient
            $mail->addAddress($for_email);               //Name is optional
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Forgot Password?";
            $mailContent = '<html>
                                <head>
                                    <style>
                                        /* CSS styles for the email body */
                                        body {
                                            background-color: #f7f7f7;
                                            font-family: Arial, sans-serif;
                                            background-color: darkgreen;    
                                        }
                                        .container {
                                            background-color: #fff;
                                            border: 1px solid #ddd;
                                            border-radius: 5px;
                                            box-shadow: 0 0 5px #ddd;
                                            margin: 20px auto;
                                            max-width: 600px;
                                            padding: 20px;
                                            
                                        }
                                        img {
                                            display: block;
                                            margin: 0 auto;
                                            width: 100px;
                                        }
                                        h1 {
                                            color: #064e3b;
                                            font-size: 24px;
                                            margin-top: 0;
                                            text-align: center;
                                        }
                                        p {
                                            
                                            font-size: 16px;
                                            line-height: 1.5;
                                            margin: 20px 0;
                                    
                                        }
                                        .code {
                                            background-color: #f5f5f5;
                                            color: #064e3b;
                                            border: 1px solid #ddd;
                                            border-radius: 5px;
                                            font-size: 24px;
                                            font-weight: bold;
                                            margin: 20px auto;
                                            max-width: 200px;
                                            padding: 10px;
                                            text-align: center;
                                        }
                                    </style>
                                </head>
                                <body>
                                  <div class="container">
                                      <img src="https://i.ibb.co/YBRmfdZ/icon-logo.png" alt="Nwssu Foodcourt Reservation System">
                                      <h1>Nwssu Food Reservation System</h1>
                                      <p>Hi User,</p>
                                      <p>Welcome to the Food Delivery System System!</p>
                                      <p>We have received a request to reset your password. Please use the following code to reset your password:</p>
                                      <div class="code">' . $for_code . '</div>
                                      <p>If you did not request a password reset, you can safely ignore this email.</p>
                                      <p>Regards,</p>
                                      <p>The Food Delivery System System Team</p>
                                  </div>
                            
                                </body>
                            </html>';
            $mail->Body = $mailContent;
            $mail->send();
            
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    }
