<?php
require 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

$connection = mysqli_connect("localhost", "root", "", "database");
$email = $_POST["email"];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($connection, $sql);
if (mysqli_num_rows($result) > 0)
{
	$reset_token = time() . md5($email);

	$sql = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";
	mysqli_query($connection, $sql);

	$message = "<p>Please click the link below to reset your password</p>";
	$message = "http://localhost/rental%20mapping/reset-email.php?email=$email&reset_token=$reset_token";
		
	send_mail($email, "Reset password", $message);
}
else
{
	echo "Email not found.";
}

function send_mail($to, $subject, $message)
{
	$mail = new PHPMailer(true);

	try {
	    
	    $mail->SMTPDebug = 0;                                       
	    $mail->isSMTP();                                            
	    $mail->Host       = 'smtp.gmail.com';  
	    $mail->SMTPAuth   = true;                                   
	    $mail->Username   = 'emmanuelv428@gmail.com';                     
	    $mail->Password   = 'yfpw zxkd sgjf sjsm';                               
	    $mail->SMTPSecure = 'tls';                                  
	    $mail->Port       = 587;                                  
        $mail->SMTPDebug = 3;
        $mail->isHTML(true); 
	    $mail->setFrom('emmanuelv428@gmail.com', 'victor emmanuel odhiambo');
	    $mail->addAddress($to);
	    $mail->isHTML(true);                                
	    $mail->Subject = $subject;
	    $mail->Body    = $message;

	    $mail->send();
	    echo 'Message sent!';
	} catch (Exception $e) {
	    echo " Error: {$mail->ErrorInfo}";
	}
}
