<?php
require 'config.php';

// Initialize error message
$errMsg = '';

// Check if the user is logged in
if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch user's information from the form
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    // You can add more fields for other user information as needed

    // Perform validation on the submitted data if required
    // For example, check if email is unique and validate other fields

    // Update user information in the database
    $stmt = $connect->prepare('UPDATE users SET fullname = :fullname, username = :username, email = :email,mobile= :mobile,password= :password WHERE id = :user_id');
    $stmt->execute(array(
        ':fullname' => $fullname,
        ':username' => $username,
        ':email' => $email,
        ':mobile' => $mobile,
        ':password' => $password,
        ':user_id' => $_SESSION['id']
    ));

    // Redirect to a user panel or another page after updating the information
    header('Location: userDashboard.php');
    exit;
}

// Fetch the user's information from the database to pre-fill the form
$stmt = $connect->prepare('SELECT * FROM users WHERE id = :user_id');
$stmt->execute(array(
    ':user_id' => $_SESSION['id']
));
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>House Mapping</title>
	
    <link href="stylesheet.css" rel="stylesheet">
	
  
  </head>

  <body>
    <header>
      
        <nav class="navbar">
        <div class="logo"><a href="index.php">Icon</a></div>
            <ul class="nav-links">
              <div class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Search</a></li>
            <li><a href="#">Map</a></li>
			<li> <a href="logout.php" >Logout</a></li>
			<li><a href="#"><?php echo $_SESSION['fullname']; ?> <?php if($_SESSION['role'] == 'admin'){ echo "(Admin)"; } ?></a></li>
            
            </div>
            </ul>
        </nav>
        <link href="housesData/bootstrap.css" rel="stylesheet">

    </header>

    <div class="login">
        <h1>Edit Your Profile</h1>
        <?php
        if (!empty($errMsg)) {
            echo '<div style="color:#FF0000;text-align:center;font-size:17px;">' . $errMsg . '</div>';
        }
        ?>
        <form method="post" action="editUser.php">
            <p><input type="text" class="form-control" name="fullname" value="<?php echo $userInfo['fullname']; ?>" placeholder="Full Name" required></p>
            <p><input type="text" class="form-control" name="username" value="<?php echo $userInfo['username']; ?>" placeholder="User Name" required></p>
            <p><input type="email" class="form-control" name="email" value="<?php echo $userInfo['email']; ?>" placeholder="Email" required></p>
            <p><input type="mobile" class="form-control" name="mobile" value="<?php echo $userInfo['mobile']; ?>" placeholder="mobile" required></p>
            <p><input type="password" class="form-control" name="password" value="<?php echo $userInfo['password']; ?>" placeholder="password" required></p>
            

            <button type="submit" class="btn">Save</button>
        </form>
    </div>

    <footer>
        
    </footer>
</body>
</html>
