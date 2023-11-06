<?php
	require 'config.php';
	if(empty($_SESSION['username']))
		header('Location: login.php');

	if(isset($_POST['register_individuals'])) {
			$errMsg = '';
			// Get data from FROM
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$alternat_mobile = $_POST['alternat_mobile'];
			$plot_number = $_POST['plot_number'];
			$country = $_POST['country'];
			$state = $_POST['state'];
			$city = $_POST['city'];
			$address = $_POST['address'];
			
			$landmark = $_POST['landmark'];
			$rent = $_POST['rent'];
			$deposit = $_POST['deposit'];
			$description = $_POST['description'];
			//$open_for_sharing = $_POST['open_for_sharing'];
			$user_id = $_SESSION['id'];
			$accommodation = $_POST['accommodation'];
			//$image = $_POST['image']?$_POST['image']:NULL;
			//$other = $_POST['other'];			
			$rooms = $_POST['rooms'];
			$vacant = $_POST['vacant'];
			$sale = $_POST['sale'];
			  $latitude = $_POST['latitude']; // Add this line to retrieve latitude
    $longitude = $_POST['longitude'];


			//upload an images
			$target_file = "";
			if (isset($_FILES["image"]["name"])) {
				$target_file = "uploads/".basename($_FILES["image"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if image file is a actual image or fake image
			    $check = getimagesize($_FILES["image"]["tmp_name"]);			
			    if($check !== false) {
			    	move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			//end of image upload


			try {
					$stmt = $connect->prepare('INSERT INTO room_rental_registrations (fullname, email, mobile, alternat_mobile, plot_number, rooms, country, state, city, address ,landmark, rent, sale, deposit, description, image, accommodation, vacant, user_id,latitude, longitude) VALUES (:fullname, :email, :mobile, :alternat_mobile, :plot_number, :rooms, :country, :state, :city, :address, :landmark, :rent, :sale, :deposit, :description, :image, :accommodation, :vacant, :user_id, :latitude, :longitude)');
					$stmt->execute(array(
						':fullname' => $fullname,
						':email' => $email,
						':mobile' => $mobile,
						':alternat_mobile' => $alternat_mobile,
						':plot_number' => $plot_number,
						//':ap_number_of_plats' => $ap_number_of_plats,
						':rooms' => $rooms,
						':country' => $country,
						':state' => $state,
						':city' => $city,
						':address' => $address,
						
						
						':landmark' => $landmark,
						':rent' => $rent,
						':sale' => $sale,
						':deposit' => $deposit,
						':description' => $description,
						':accommodation' => $accommodation,
						':image' => $target_file,
						//':other' => $other,
						':vacant' => $vacant,
						':user_id' => $user_id,
						':latitude' => $latitude, // Bind latitude
                       ':longitude' => $longitude, 
						));				

				header('Location: registerhouse.php?action=reg');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
	}


	if(isset($_POST['register_apartment'])) {
			$errMsg = '';
			// Get data from FROM
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$alternat_mobile = $_POST['alternat_mobile'];
			$plot_number = $_POST['plot_number'];
			$country = $_POST['country'];
			$state = $_POST['state'];
			$city = $_POST['city'];
			$address = $_POST['address'];
			
			$landmark = $_POST['landmark'];
			$rent = $_POST['rent'];
			$deposit = $_POST['deposit'];
			$description = $_POST['description'];			
			//$open_for_sharing = $_POST['open_for_sharing'];
			$user_id = $_SESSION['id'];
			$accommodation = $_POST['accommodation'];
			$apartment_name = $_POST['apartment_name'];
			$image = $_FILES['image']['name'];
			//$other = $_POST['other'];	

			//upload an images
			$target_file = "";
			if (isset($image)) {
				# code...
				$target_file = "uploads/".basename($_FILES["image"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if image file is a actual image or fake image
			    //$check = getimagesize($_FILES["image"]["tmp_name"]);			
			    //if($check !== false) {
			    	move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES["image"]["name"]);
			        $uploadOk = 1;
			   // } else {
			       // echo "File is not an image.";
			        //$uploadOk = 0;
			   // }
			}			
			//end of image upload		
			
			try {
				$stmt = $connect->prepare('INSERT INTO room_rental_registrations_apartment (fullname, email, mobile, alternat_mobile, plot_number, apartment_name, ap_number_of_plats, rooms, floor, purpose, own, area, country, state, city, address, landmark, rent, deposit, description, image, accommodation,  vacant, user_id) VALUES (:fullname, :email, :mobile, :alternat_mobile, :plot_number, :apartment_name, :ap_number_of_plats, :rooms, :floor, :purpose, :own, :area, :country, :state, :city, :address, :landmark, :rent, :deposit, :description, :image, :accommodation, :vacant, :user_id)');
				
				foreach ($_POST['ap_number_of_plats'] as $key => $value) {
					# code...					
					$stmt->execute(array(
						':fullname' =>  $_POST['fullname'][$key],
						':email' => $email,
						':mobile' => $mobile,
						':alternat_mobile' => $alternat_mobile,
						':plot_number' => $plot_number,
						':apartment_name' => $apartment_name,
						':ap_number_of_plats' => $value,
						':rooms' => $_POST['rooms'][$key],
						':floor' => $_POST['floor'][$key],
						':purpose' => $_POST['purpose'][$key],
						':own' => $_POST['own'][$key],
						':area' => $_POST['area'][$key],						
						':country' => $country,
						':state' => $state,
						':city' => $city,
						':address' => $_POST['address'],
						':landmark' => $_POST['landmark'],
						':rent' => $_POST['rent'][$key],
						':deposit' => $_POST['deposit'][$key],
						':description' => $_POST['description'][$key],
						':image' => $target_file,
						':accommodation' => $_POST['accommodation'][$key],
						//':other' => $_POST['other'][$key],
						':vacant' => $_POST['vacant'][$key],
						':user_id' => $user_id
					));
				}				
				header('Location: registerhouse.php?action=reg');
				exit;
			}catch(PDOException $e) {
				echo $e->getMessage();
			}
	}

	if(isset($_GET['action']) && $_GET['action'] == 'reg') {
		$errMsg = 'Registration successfull. Thank you';
	}
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
			<li> <a href="logout.php">Logout</a></li>
			<li><a href="#"><?php echo $_SESSION['fullname']; ?> <?php if($_SESSION['role'] == 'admin'){ echo "(Admin)"; } ?></a></li>
            
            </div>
            </ul>
        </nav>

    </header>
	
	
	<!-- end header nav -->
<section class="wrapper1">
	<!-- Nav tabs -->

	<div class="tab-content">
	<div class="toggle-buttons">
    <button id="show-individual" class="toggle-button active">Individual</button>
    <button id="show-apartment" class="toggle-button">Apartment</button>
</div>

	<!-- Single room -->
	  <div class="tab-pane active" id="individual-section" role="tabpanel"><br>
	  		<?php include 'housesData/individaul.php';?>
	  </div>

	<!-- Apartment -->
	  <div class="tab-pane" id="apartment-section" role="tabpanel">
	  		<?php include 'housesData/apartment.php';?>	  	
	  </div>
	</div>	

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to the buttons and content sections
        const showIndividualButton = document.getElementById("show-individual");
        const showApartmentButton = document.getElementById("show-apartment");
        const individualSection = document.getElementById("individual-section");
        const apartmentSection = document.getElementById("apartment-section");

        // Add event listeners to the buttons
        showIndividualButton.addEventListener("click", function () {
            showIndividualButton.classList.add("active");
            showApartmentButton.classList.remove("active");
            individualSection.style.display = "block";
            apartmentSection.style.display = "none";
        });

        showApartmentButton.addEventListener("click", function () {
            showApartmentButton.classList.add("active");
            showIndividualButton.classList.remove("active");
            apartmentSection.style.display = "block";
            individualSection.style.display = "none";
        });

        // Initially show the "individual" section and hide the "apartment" section
        showIndividualButton.classList.add("active");
        individualSection.style.display = "block";
        apartmentSection.style.display = "none";
    });
</script>
</section>
