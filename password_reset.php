<?php
session_start();
include('config/dbconnection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


function send_password_reset($get_name, $get_email, $token)
{

   $mail = new PHPMailer(true);
   $mail->isSMTP();

   $mail->SMTPAuth = true;
   $mail->Host = 'sandbox.smtp.mailtrap.io';
   $mail->Username = '2232a8a5f711f7';
   $mail->Password = 'd237109b971933';

   $mail->SMTPSecure = 'tls';
   $mail->Port = 2525;

   $mail->setFrom('hellogm2525@gmail.com', $get_name);
   $mail->addAddress($get_email);

   $mail->isHTML(true);
   $mail->Subject = 'Password Reset';

   $email_template = "
    <h2>Hello</h2>
    <h3>You are receiving this email because we received a password reset request for your account.</h3><br><br>
    <a href='http://localhost/php/basic.php/password_change.php?token=$token&email=$get_email'>Click Here</a>
    ";

   $mail->Body = $email_template;
   $mail->send();

}


if (isset($_POST['password_reset_link'])) {

   $email = mysqli_real_escape_string($con, $_POST['email']);
   $token = md5(rand());

   $email_exe = mysqli_query($con, "SELECT * FROM user WHERE `email`='$email' LIMIT 1");

   if (mysqli_num_rows($email_exe) > 0) {

      $row = mysqli_fetch_array($email_exe);
      $get_name = $row['name'];
      $get_email = $row['email'];

      $update_token = "UPDATE user SET `token`='$token' WHERE `email`='$get_email' LIMIT 1";
      $update_token_exe = mysqli_query($con, $update_token);

      if ($update_token_exe) {
         send_password_reset($get_name, $get_email, $token);
         $_SESSION['status'] = "sent email password reset link";
         header('refresh:1;url=resetpassword.php');
         exit(0);
      } else {
         $_SESSION['status'] = "something went wrong";
         header('localtion:resetpassword.php');
         exit(0);
      }
   } else {
      $_SESSION['status'] = "no email found";
      header('localtion:resetpassword.php');
      exit(0);
   }
}

if (isset($_POST['update_password'])) {
   $email = mysqli_real_escape_string($con, $_POST['email']);
   $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
   $confirm = mysqli_real_escape_string($con, $_POST['confirm']);
   $token = mysqli_real_escape_string($con, $_POST['token']);

   if (!empty($token)) {
      if (!empty($email) && !empty($new_password) && !empty($confirm)) {
         $token_exe = mysqli_query($con, "SELECT token FROM user WHERE `token`='$token' LIMIT 1");
         if (mysqli_num_rows($token_exe) > 0) {
            if ($new_password == $confirm) {
               $update_password = mysqli_query($con,"UPDATE user SET `password`='$new_password' WHERE `token`='$token' LIMIT 1");
               if($update_password){
                  $_SESSION['status'] = "password update successfully";
                  header("localtion:login.php");
                  exit(0);
               }else{
                  $_SESSION['status'] = "something went wronge";
                  header("localtion:password_change.php?token=$token&email=$email");
                  exit(0); 
               }
            } else {
               $_SESSION['status'] = "password and confirm password does not match";
               header("localtion:password_change.php?token=$token&email=$email");
               exit(0);
            }
         } else {
            $_SESSION['status'] = "invalid token";
            header("localtion:password_change.php?token=$token&email=$email");
            exit(0);
         }

      } else {
         $_SESSION['status'] = "all field are required";
         header("localtion:password_change.php?token=$token&email=$email");
         exit(0);
      }

   } else {
      $_SESSION['status'] = "no token available";
      header("localtion:password_change.php");
      exit(0);
   }

}


?>