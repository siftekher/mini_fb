<?php
	session_start();

  if(isset($_POST['usr']) && isset($_POST['pwd'])) {
	  $user = $_POST['usr'];
	  $pwd = $_POST['pwd'];
	  $firstName = $_POST['first_name'];
	  $lastName = $_POST['last_name'];
      $username = 's3706786';
      $password = 'Sa110796';
      $servername = 'talsprddb01.int.its.rmit.edu.au';
      $servicename = 'CSAMPR1.ITS.RMIT.EDU.AU';
      $connection = $servername."/".$servicename;

      $conn = oci_connect($username, $password, $connection);
      if(!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      else
      {
		  $location = $_POST['location'];
	      $status = $_POST['status'];
	  	  $gender = $_POST['gender'];
	      $visibility = $_POST['visibility'];
		  $date_of_birth = $_POST['date_of_birth'];
		  
		  try {
 	      $query =  "INSERT INTO fb_users(first_name, last_name, email, password, location, status, gender, visibility, DOB) 
		           VALUES('".$firstName."', '".$lastName."', '" . $user . "', '" . $pwd . "', '".$location."',
				   '".$status."', '".$gender."', '".$visibility."', '".$date_of_birth."')";
		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
		  $err = oci_error($stid);
		  
		  }catch(Exception $e) {
			  echo 'Something wrong, please try again.';
		  }
		  
		  if($err['code'] == 1) {
			  echo 'Duplicate Email address.';
		  } else {
		      header('Location: login.php');
              exit(0);
		  }
      }
  }
?>

<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.center {
  margin: auto;
  width: 30%;
  border: 3px solid green;
  padding: 10px;
}
</style>
  <style>
  body {
  margin: 0px;
  background-color:#e9ebee;
  font-family: arial;
}

.header {
  background-color: #3b5998;
  padding: 7px 0px 3px 13%;
}

.header *{
  display:inline-block;
}

p {
  margin: 0px;
}

.search {
  background-color: white;
  width: 150px;
  height: 24px;
  position: relative;
  top: -4px;
  border-raduis: 5px;
}

.logo {
  background-image: url('https://www.facebook.com/rsrc.php/v2/ys/r/aVIyzaVqPTE.png');
      background-repeat: no-repeat;
    background-size: auto;
    background-position: 0 -223px;
    height: 24px;
    outline: none;
    overflow: hidden;
    text-indent: -999px;
    white-space: nowrap;
    width: 24px;
  position: relative;
  top: 3px;
}

#inputText {
      width: 100px;
  border-raduis: 5px;
    height: 22px;
    position: relative;
    top: 0px;
  padding-left: 5px;
  font-size: 14px;
  border: 0px;
}

.search-icon {
  background-color: #f6f7f9;
  height: 100%;
  width: 50px;
  text-align: center;
  float: right;
}
.search-icon img {
  height: 15px;
  width:15px;
  margin: 10% 0;
}

.right-side {
  position: relative;
  left: 15%;
}

.leftofright {
  position: relative;
  top: -2px;
}

.leftofright p {
  color: white;
  font-size: 12px;
  position: relative;
  top: -3px;
  font-weight: 700;
}

.leftofright  p:nth-child(3){
  color: black;
  opacity: 0.3;
}

.leftofright img {
  position: relative;
  top: 5px;
}

.right-icon, .fr {
  height: 25px;
  width: 25px;
  background-image: url(https://web.facebook.com/rsrc.php/v2/yL/r/cnjWBJCYDcu.png);
  background-position: 0 -248px;
  opacity: 0.7;
}

.messages {
  background-position: 0 -398px;
}

.notification {
  background-position:0 -348px;
}

.rightofright {
  position: relative;
  top: 3px;
  left: 10%;
}


.privacy {
  background-position:0px -613px;
  width: 17px;
}

.rightofright p {
  position: relative;
  top: -8px;
  opacity: 0.3;
  margin: 0 8px;
}

.down {
  background-position: 0px -600px;
  width: 15px;
  height: 13px;
  position: relative;
  top: -8px;
}

.small-screen {
  opacity: 0;
}

@media screen and (max-width: 1060px) {
    .header {
      opacity: 0;
    }
  
  body {
    background-color: #34495e;
  }
  
  .small-screen {
    opacity: 1;
    color: #bdc3c7;
    text-align: center;
  }
  
}
  </style>
  
  <script>
    $( function() {
       $( "#date_of_birth" ).datepicker();
    } );
  </script>
</head>
<body>

    <div class="header">
      <a href="#"><div class="logo"></div></a>
      <div class="search">
        <input type="text" id="inputText" placeholder="Search">
        <div class="search-icon">
        <img src="http://icons.iconarchive.com/icons/icons8/ios7/256/Very-Basic-Search-icon.png" ></img>
        </div>
      </div>
      <div class="right-side">
        <div class="leftofright">
          <a href="#"></a>
		  <p>| </p>
		  <p><a href="login.php" style="color:white;text-decoration: none;">Login</a></p>
        </div>
		<!--
        <div class="rightofright">
          <div class="right-icon fr"></div>
          <div class="right-icon messages"></div>
          <div class="right-icon notification"></div>
          <p>|</p>
          <div class=" right-icon privacy"></div>             <div class=" right-icon down"></div>
        </div> --> 
      </div>
    </div>

<div class="center">
<h2>DA Assignment Signup</h2>



<form action="signup.php" method="POST">
<table>
<tr>
<td>Email: </td><td><input type="text" name="usr" id="usr"></td>
</tr>
<tr>
<td>Password: </td><td><input type="password" name="pwd" id="pwd"></td>
</tr>
<tr>
<td>First Name: </td><td><input type="text" name="first_name" id="first_name"></td>
</tr>
<tr>
<td>Last Name: </td><td><input type="text" name="last_name" id="last_name"></td>
</tr>
<tr>

<tr>
<td>Date Of Birth: </td><td><input type="text" name="date_of_birth" id="date_of_birth"></td>
</tr>
<tr>
<td>Location: </td><td><input type="text" name="location" id="location"></td>
</tr>
<tr>
<td>Status: </td>
<td>
<select name="status">
  <option value="married">Married</option>
  <option value="single">Single</option>
</select>
</td>
</tr>
<tr>
<td>Gender: </td><td><select name="gender">
  <option value="male">Male</option>
  <option value="female">Female</option>
</select></td>
</tr>
<tr>
<td>Visibility: </td><td><select name="visibility">
  <option value="1">Private</option>
  <option value="2">Friends</option>
  <option value="3">Everyone</option>
</select></td>
</tr>

<tr style="height:20px;"></tr>
<tr>
<td></td>
<td><button type="submit">Register</button></td>
<tr>
<table>
</form>

</div>
</body>
</html>

