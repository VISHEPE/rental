<?php
require 'config.php';


function isStrongPassword($password) {
    
    $minLength = 8;  
    $hasUppercase = preg_match('/[A-Z]/', $password); 
    $hasLowercase = preg_match('/[a-z]/', $password); 
    $hasNumber = preg_match('/\d/', $password); 

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber;
}

if (isset($_POST['register'])) {
    $errMsg = '';

    $username = $_POST['username'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];

    $stmt = $connect->prepare('SELECT email FROM users WHERE email = :email');
    $stmt->execute(array(':email' => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $errMsg = 'Email is already registered. Please use a different email address.';
    } elseif (!isStrongPassword($password)) {
        $errMsg = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.';
    } else {
        try {
            $stmt = $connect->prepare('INSERT INTO users (fullname, mobile, username, email, password) VALUES (:fullname, :mobile, :username, :email, :password)');
            $stmt->execute(array(
                ':fullname' => $fullname,
                ':username' => $username,
                ':password' => md5($password),
                ':email' => $email,
                ':mobile' => $mobile,
            ));
            header('Location: register.php?action=joined');
            exit;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'joined') {
    $errMsg = 'Registration successful. Now you can login';
}
?>


<?php include 'header.php'?>

	
			  		<?php
						if(isset($errMsg)){
							echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
						}
					?>
                    <link href="housesData/bootstrap.css" rel="stylesheet">
                    <body>
                    <div class="container">
                    <div class="login">
			  		<h3 class=>Register</h3>
				  	<form action="" method="post">
				  		
						<p><input type="text" class="form-control" id="fullname" placeholder="Full Name" name="fullname" required></p>
						<p><input type="text"  class="form-control" placeholder="User Name" name="username" required></p>
						<p><input type="text" class="form-control" pattern="^(\d{10})$" id="mobile" title="10 digit mobile number" placeholder="10 digit mobile number" name="mobile" required></p>
						<p><input type="email" class="form-control" id="email" placeholder="Email" name="email" required></p>
					    <p><input type="password" class="form-control" id="password" placeholder="Password" name="password" required></p>
					    <p><input type="password" class="form-control" id="c_password" placeholder="Confirm Password" name="c_password" required></p>
						
					  <button type="submit"
					  
					   class="btn" name='register' value="register">Submit</button>
                    </form>
                    
                   <div class="login-page">
<p>Login<a href="login.php">click to login</a></p>
</div>
</div>



</body>
</html>
    </body>		


