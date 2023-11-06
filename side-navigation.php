<?php
	if(empty($_SESSION['role']))
		header('Location: login.php');

?>
<link href="stylesheet.css" rel="stylesheet">
<br>
<nav class="side-navbar">
	<div class="navbar-top"> 

</div>
	
          <ul>  
            <div></div></div>    
            <li>
             <a href="userDashboard.php" data-active="0">Home</a>
            </li>
            <li>
             <a href="editUser.php" data-active="0">edit profile</a>
            </li> 
            <li >
            	<?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'user'){ 
	        		echo '<a href="registerhouse.php" data active="1">Register</a>';
	      	 	} ?>   
                
            </li>
            <li >
	        	<a href="list.php">Details/Update</a>
            </li>

            <li>
              <?php if($_SESSION['role'] == 'admin'){ 
                echo '<a href="sms.php">Send SMS</a>';
              } ?>
            </li>

            <li>
              <?php if($_SESSION['role'] == 'admin'){ 
                echo '<a href="cmplist.php">Complaint List</a>';
              } ?>
            </li>
          </ul>
        </span>
    </div>
