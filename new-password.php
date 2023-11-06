
<?php
require 'config.php';
$email = $_POST["email"];
$reset_token = $_POST["reset_token"];
$new_password = $_POST["new_password"];

$connection = mysqli_connect("localhost", "root", "", "database");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_object();
    if ($user->reset_token == $reset_token) {
    
        $new_password_md5 = md5($new_password);

        $sql = "UPDATE users SET reset_token='', password=? WHERE email=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $new_password_md5, $email);
        $stmt->execute();

        echo "Password has been changed";
    } else {
        echo "Recovery email has expired";
    }
} else {
    echo "Email does not exist";
}

$stmt->close();
$connection->close();
?>
