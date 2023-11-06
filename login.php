<?php
require 'config.php';

if (isset($_POST['login'])) {
    
    $recaptchaSecretKey = '6LdoCcMoAAAAAHm8U-wrlDbX36PV2zPmVkltqewZ'; 
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptchaVerifyData = array(
        'secret' => $recaptchaSecretKey,
        'response' => $recaptchaResponse
    );

    $recaptchaVerifyOptions = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($recaptchaVerifyData)
        )
    );

    $recaptchaVerifyContext = stream_context_create($recaptchaVerifyOptions);
    $recaptchaVerifyResult = json_decode(file_get_contents($recaptchaVerifyUrl, false, $recaptchaVerifyContext));

    if (!$recaptchaVerifyResult->success) {
        $errMsg = "reCAPTCHA verification failed. Please complete the reCAPTCHA.";
    } else {
        
        $username = $_POST['username'];
        $email = $_POST['username'];
        $password = $_POST['password'];

        try {
            $stmt = $connect->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
            $stmt->execute(array(
                ':username' => $username,
                ':email' => $email
            ));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data == false) {
                $errMsg = "User $username not found.";
            } else {
                if (md5($password) == $data['password']) {
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['fullname'] = $data['fullname'];
                    $_SESSION['role'] = $data['role'];
                    header('Location: userDashboard.php');
                    exit;
                } else
                    $errMsg = 'Password does not match.';
            }
        } catch (PDOException $e) {
            $errMsg = $e->getMessage();
        }
    }
}
?>

>

<?php include 'header.php'?>
<link href="housesData/bootstrap.css" rel="stylesheet">
       
    <body>
        <div class="container">
            <div class="login">
    <h3 >Login</h3>
	<form action="" method="post">
		
		<p><input type="text"  placeholder="Email" name="username"  class="form-control" required></p>
	
		<p><input type="password"  placeholder="Password" name="password" class="form-control" required></p>
        <p class="remember-me">
            <label>
                <input type="checkbox" name="remember-me" id="remember-me">
                remember me
            
            </label>
</p>
		<button type="submit"  name='login' value="Login" class="btn">Submit</button>
		<div class="g-recaptcha" data-sitekey="6LdoCcMoAAAAAN-Ex8dltJOhDeSDsjSSHrWUGaAr"></div>
					 
    
	</form>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</div>
<div class="login-page">
<p>create account<a href="register.php">click to register</a></p>
    <p>forgot password <a href="forgot.php">click to reset password?</a></p>
</div>
</div>
    </body>			 
				