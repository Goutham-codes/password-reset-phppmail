<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php';

function sendemail($pass,$usern){
  $mail= new PHPMailer(true);
  $mail->IsSMTP(); 
  $mail->SMTPDebug = 1; 
  $mail->SMTPAuth = true; 
  $mail->SMTPSecure = 'ssl'; 
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;
  $mail->IsHTML(true);
  $mail->Username = "your gmail address";
  $mail->Password = "your secret";
  $mail->SetFrom("your gmail address");
  $mail->Subject = "Reset Password for YOUR website";
  $mail->Body = "<h1>Dear User,</h1><div><h4>You have requested for password reset.</h4><br><h3>Welcome to YOUR website!</h3>
      <p>Your password has changed...</p>
      <h4>Your New Password:</h4>".$pass."
      <h3>Regards,</h3><h4>YOUR website</h4>
      </div>";
  $mail->AddAddress($usern);
  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    return 0;
  } else {
    echo "Message has been sent";
    return 1;
  }
}

?>