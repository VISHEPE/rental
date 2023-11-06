
<?php
	require 'config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');

	if($_SESSION['role'] == 'admin'){
		$stmt = $connect->prepare('SELECT count(*) as register_user FROM users');
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_ASSOC);


		$stmt = $connect->prepare('SELECT count(*) as total_rent FROM room_rental_registrations');
		$stmt->execute();
		$total_rent = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $connect->prepare('SELECT count(*) as total_rent_apartment FROM room_rental_registrations_apartment');
		$stmt->execute();
		$total_rent_apartment = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	$stmt = $connect->prepare('SELECT count(*) as total_auth_user_rent FROM room_rental_registrations WHERE user_id = :user_id');
	$stmt->execute(array(
		':user_id' => $_SESSION['id']
		));
	$total_auth_user_rent = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $connect->prepare('SELECT count(*) as total_auth_user_rent_ap FROM room_rental_registrations_apartment WHERE user_id = :user_id');
	$stmt->execute(array(
		':user_id' => $_SESSION['id']
		));
	$total_auth_user_rent_ap = $stmt->fetch(PDO::FETCH_ASSOC);
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
			<li> <a href="logout.php" class="nav-link">Logout</a></li>
			<li><a href="#"><?php echo $_SESSION['fullname']; ?> <?php if($_SESSION['role'] == 'admin'){ echo "(Admin)"; } ?></a></li>
            
            </div>
            </ul>
        </nav>

    </header>
	

					<h1>user panel</h1>
											
						<?php 
							if($_SESSION['role'] == 'admin'){ 
								echo '<div class="col-md-3">';
								echo '<a href="users.php"><div class="alert alert-warning" role="alert">';
								echo '<b>Users: <span class="badge badge-pill badge-success">'.$count['register_user'].'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>	
						<?php 
							if($_SESSION['role'] == 'admin'){ 
								echo '<div class="col-md-3">';
								echo '<a href="list.php"><div class="alert alert-warning" role="alert">';
								echo '<b>Available  Rental: <span class="badge badge-pill badge-success">'.(intval($total_rent['total_rent'])+intval($total_rent_apartment['total_rent_apartment'])).'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>
						<?php 
							if($_SESSION['role'] == 'user'){ 
								echo '<div class="col-md-3">';
								echo '<a href="list.php"><div class="alert alert-warning" role="alert">';
								echo '<b>users Rooms: <span class="badge badge-pill badge-success">'.$total_auth_user_rent['total_auth_user_rent'].'</span></b>';
								echo '</div></a>';
								echo '</div>';
							} 
						?>
						<?php include 'side-navigation.php' ?>
						
					