<html>
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
                                        
                                    }
                                    .code {
                                        background-color: #f5f5f5;
                                        color: #064e3b;
                                        border: 1px solid #ddd;
                                        border-radius: 5px;
                                        font-size: 30px;
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
                                    <p>Welcome to Nwssu Food Reservation System!</p>
                                    <p>Thank you for signing up for our food reservation system.</p>
                                    <p style="text-align: center; color: #666;">Please use the following code to verify your email address:</p>
                                    <div class="code">' . $code . '</div>
                                    <p style="text-align: center; color: #666;">If you did not request this verification code, please ignore this email.</p>
                                    <p>Regards,</p>
                                    <p>JAMF-ROSE Team</p>
                                </div>
                            </body>
                        </html>