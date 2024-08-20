<?php
require_once 'vendor/autoload.php';
require('connect.php');
try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        extract($_GET);
        // $email = 'm.saadashraf286@gmail.com';
        if (!empty($email)) {
            $stmt = $conn->prepare(
                "SELECT email FROM users WHERE email =:email"
            );
            $stmt->execute(['email' => $email,]);

            if ($stmt->rowCount() > 0) {
                $str = mt_rand(1111, 9999);
                $stmt = $conn->prepare(
                    "INSERT INTO codes (email,code) VALUES (:email,:code)"
                );
                $stmt->execute(['email' => $email, 'code' => $str]);
                $to = $email; // User's email address
                $transport = (new Swift_SmtpTransport('server.techowdy.com', 465, 'ssl')) // Use port 587 for TLS
                    ->setUsername('developer@futureadvisers.co')
                    ->setPassword('FU%$$#s,dser');

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message('Reset Password'))
                    ->setFrom(['developer@futureadvisers.co' => 'Future Advisers'])
                    ->setTo($to)
                    ->setBody('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
           <html xmlns="http://www.w3.org/1999/xhtml">
               <head>
                   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
           
                   <title>OTP Email</title>
                   <meta name="viewport" content="width=device-width">
                   <!-- Favicon icon -->
                   <link rel="icon" href="" type="image/x-icon">
                  <style type="text/css">
                       @media only screen and (max-width: 1240px), screen and (max-device-width: 1240px) {
                           body[yahoo] .buttonwrapper { background-color: transparent !important; }
                           body[yahoo] .button { padding: 0 !important; }
                           body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
                       }
           
                      th{
                        width:82px;
                      }
                   </style>
               </head>
               
           
               <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
           
                   
                   <!--[if (gte mso 9)|(IE)]>
                   <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                     <tr>
                       <td>
                   <![endif]-->
                  
                   <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%;" class="content">
                       
                   <tr>
                   <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 00px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                       <img src=https://futureadvisers.co/wp-content/uploads/2016/06/logo_new.png" alt="OTP Email" width="100"  style="display:block; margin-bottom: 15px;">
                       
                   </td>
               </tr>
               
               <tr>
                   <td align="left" bgcolor="#ffffff" style="padding: 10px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; ">
                       <b>Dear user</b>
                   </td>
               </tr>  
   
               <tr>
                   <td align="left" bgcolor="#ffffff" style="padding: 0px 10px 0px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; ">
                       <span>We have received a password reset request for your account. If you did not initiate this request, kindly disregard this email, and no further action is required.</span>
                   </td>
               </tr> 
              
               <tr>
                   <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; border-bottom: 2px solid #d0cece;">
                       <span >
                       However, if you did request a password reset, please use the following One-Time Password (OTP) code to proceed with the reset process:
                    </span>
                   </td>
               </tr> 
                       
                       <tr>
                         <td align="center" bgcolor="#ffffff" style="padding: 0px 10px 40px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 2px solid #d0cece;">
                               <!--[if (gte mso 9)|(IE)]>
                                 <table width="387" align="left" cellpadding="0" cellspacing="0" border="0">
                                   <tr>
                                     <td>
                               <![endif]-->
                               <br>
                                           <table class="col387" align="center" border="0" cellpadding="0" cellspacing="0" style= "width: auto">
               

                                                   <tr>
                                                   <th style="padding: 0 0 10px 0; color: #5945b2; text-align: left; font-family: Arial, sans-serif; font-size: 24px;width: 150px; line-height: 24px;">OTP CODE :</th>
                                                    <td style="padding: 0 0 10px 0; color: #44ca35; text-align: left; font-family: Arial, sans-serif; font-size: 28px;width: 150px; line-height: 24px;"> <b>' . $str . '</b></td>
                                                    </tr>
                                                   
                                           </table>
                                       </td>
                                   </tr>
                                                  
                         </td>
                       </tr>  
                       <tr>
                   <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; border-bottom: 2px solid #d0cece;">
                       <span>
                       Your security is important to us, and we encourage you to keep your account information confidential.
                    </span>
                   </td>
               </tr> 
               <tr>
               <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; border-bottom: 2px solid #d0cece;">
                   <span>
                   Best regards,
                   <br>
                   <b>Future Advisers</b><br>
                   Customer Support Team
                </span>
               </td>
           </tr> 
                       
                       
                       <tr>
                           <td align="center" bgcolor="#000" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;text-decoration:none">
                               <b><a style="text-decoration:none; color:#fff" href="#">© All Rights Reserved</a></b>
                           </td>
                       </tr>
                   </table>
                   <!--[if (gte mso 9)|(IE)]>
                           </td>
                       </tr>
                   </table>
                   <![endif]-->
               
               </body>
           </html>', 'text/html');

                // Send the message
                $result = $mailer->send($message);
                $response = ['message' => 'User exist'];
                http_response_code(200);
            } else {
                // User login failed
                $response = ['message' => 'User doesnot exist'];
                http_response_code(401);
            }
        } else {
            // Invalid request parameters
            $response = ['message' => 'Invalid request parameters'];
            http_response_code(400);
        }
    } else {
        // Invalid request method
        $response = ['message' => 'Invalid request method'];
        http_response_code(405);
    }

    // Return the response as JSON
    echo json_encode($response);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
