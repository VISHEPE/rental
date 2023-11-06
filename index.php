<?php
  require 'config.php';
  $data = [];
  
  if(isset($_POST['search'])) {
    // Get data from FORM
    $keywords = $_POST['keywords'];
    $location = $_POST['location'];

    //keywords based search
    $keyword = explode(',', $keywords);
    $concats = "(";
    $numItems = count($keyword);
    $i = 0;
    foreach ($keyword as $key => $value) {
      # code...
      if(++$i === $numItems){
         $concats .= "'".$value."'";
      }else{
        $concats .= "'".$value."',";
      }
    }
    $concats .= ")";
  //end of keywords based search
  
  //location based search
    $locations = explode(',', $location);
    $loc = "(";
    $numItems = count($locations);
    $i = 0;
    foreach ($locations as $key => $value) {
      # code...
      if(++$i === $numItems){
         $loc .= "'".$value."'";
      }else{
        $loc .= "'".$value."',";
      }
    }
    $loc .= ")";

  //end of location based search
    
    try {
      //foreach ($keyword as $key => $value) {
        # code...

        $stmt = $connect->prepare("SELECT * FROM room_rental_registrations_apartment WHERE country IN $concats OR country IN $loc OR state IN $concats OR state IN $loc OR city IN $concats OR city IN $loc OR address IN $concats OR address IN $loc OR rooms IN $concats OR landmark IN $concats OR landmark IN $loc OR rent IN $concats OR deposit IN $concats");
        $stmt->execute();
        $data2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $connect->prepare("SELECT * FROM room_rental_registrations WHERE country IN $concats OR country IN $loc OR state IN $concats OR state IN $loc OR city IN $concats OR city IN $loc OR rooms IN $concats OR address IN $concats OR address IN $loc OR landmark IN $concats OR rent IN $concats OR deposit IN $concats");
        $stmt->execute();
        $data8 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = array_merge($data2, $data8);

    }catch(PDOException $e) {
      $errMsg = $e->getMessage();
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rental Mapping</title>
   
    <link href="stylesheet.css" rel="stylesheet">
    <link href="individual.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
  
  </head>

  <body>
    <header>
      
        <nav class="navbar">
        <div class="logo"><a href="#">Icon</a></div>
            <ul class="nav-links">
              <div class="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Search</a></li>
           
            <li><a href="mapper.php">Map</a></li>
            <li><a href="login.php">Login</a></li>
            </div>
            </ul>
        </nav>

    </header> 
    
    <div class="detail-body">
              <h1>
                Search for <br>
                Your next HOME
              </h1>
              <p>
                This platform will provide you to means to.............<br>
                and give you a place to ...............................
              </p>
            </div>
            
            <div class="search-form">
            <form method="POST" action="">
            <input id="keywords" name="keywords" type="text" class="form-search" placeholder="keyword">
            <input id="location" name="location" type="text" class="form-search" placeholder="location">
            <input id="location" type="text" class="form-search">
            <button id="" class="btn btn-success btn-md text-uppercase" name="search" value="search" type="submit">Search</button>
            </form>
</div> 


<h2>rental House</h2>
<div class="container-display">
<div class="apartment">
<div id="appart1">
  <img src="app/uploads/kenya.png">
  <h2>rental</h2>
  <p2>850$</p2>
  <p2>
  <a href="map.php?address=Appart1">View on Map</a>

</p2>
</div>
<div id="appart2">
  <img src="app/uploads/city.png">
  <h2>appartment</h2>
  <p2>851$</p2>
  <p2>
  <a href="map.php?address=Appart2">View on Map</a>
</p2>
</div>
<div id="appart3">
  <img src="app/uploads/keny.png">
  <h2>appartment</h2>
  <p2>852$</p2>
  <p2>
  <a href="map.php?address=Appart3">View on Map</a>
</p2>
</div>
<div id="appart4">
  <img src="app/uploads/kenya.png">
  <h2>appartment</h2>
  <p2>853$</p2>
  <p2>
  <a href="map.php?address=Appart4">View on Map</a>
</p2> 
</div>
<div id="appart5">
  <img src="app/uploads/kenya.png">
  <h2>appartment</h2>
  <p2>854$</p2>
  <p2>
  <a href="map.php?address=Appart5">View on Map</a>
</p2>
</div>
<div id="appart6">
  <img src="app/uploads/keny.png">
  <h2>appartment</h2>
  <p2>855$</p2>
  <p2>
  <a href="map.php?address=Appart6">View on Map</a>
</p2>
</div>
</div>   


     </div>
          <script src=housesData/javascript.js></script>  
      
    
</body>

</html>