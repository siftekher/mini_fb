<?php
	session_start();

  if(isset($_POST['user_id']) && isset($_POST['first_name'])) {
	  $user = $_POST['usr'];
	  $pwd = $_POST['pwd'];
	  
      $username = '';
      $password = '';
      $servername = '';
      $servicename = '';
      $connection = $servername."/".$servicename;

      $conn = oci_connect($username, $password, $connection);
      if(!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      else
      {
		  $user_id = $_POST["user_id"];
		  $first_name = $_POST["first_name"];
		  $last_name = $_POST["last_name"];
		  $ped = $_POST['pwd'];
		  $status = $_POST["status"];
		  $gender = $_POST["gender"];
		  $visibility = $_POST["visibility"];
		  
          $query =  "UPDATE fb_users SET FIRST_NAME='".$first_name."', PASSWORD = '".$pwd."' , LAST_NAME='".$last_name."', GENDER='".$gender."', STATUS='".$status."', VISIBILITY='".$visibility."' WHERE user_id = '" . $user_id . "'";
		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
		  
		  $message = "Profile information has been updated successfully.";
      }
  }
  
                $user_id = "";
				$first_name = "";
				$last_name = "";
				$email = "";
				$dob = "";
				$status = "";
				$gender = "";
				$location = "";
				$visibility = "";
				
  if(isset($_SESSION['user_id'])){
	  $userId = $_SESSION['user_id'];
      $username = '';
      $password = '';
      $servername = '';
      $servicename = '';
      $connection = $servername."/".$servicename;

      $conn = oci_connect($username, $password, $connection);
      if(!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      else
      {
	      $query =  "SELECT * FROM fb_users WHERE user_id = '" . $userId . "'";
$message = "";
		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
		  
		  while (($row = oci_fetch_assoc($stid)) != false) {
                $user_id = $row['USER_ID'];
				$first_name = $row['FIRST_NAME'];
				$last_name = $row['LAST_NAME'];
				$email = $row['EMAIL'];
				$dob = $row['DOB'];
				$status = $row['STATUS'];
				$gender = $row['GENDER'];
				$location = $row['LOCATION'];
				$visibility = $row['VISIBILITY'];
          }
 

      }
  } 
?>

<html>
<head>
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
          <p><?php echo $_SESSION['usr'];?> </p>
          <p>| </p>
		  <p><a href="show_members.php" style="color:white;text-decoration: none;">Directory</a></p>
          <p>| </p>
		  <p><a href="save_post.php" style="color:white;text-decoration: none;">Post</a></p>
          <p>| </p>
		  <p><a href="friend_list.php" style="color:white;text-decoration: none;">Friends</a></p>
          <p>| </p>
		  <p><a href="message_inbox.php" style="color:white;text-decoration: none;">Inbox</a></p>
          <p>| </p>
          <p><a href="news_feed.php" style="color:white;text-decoration: none;">News</a></p>
          <p>| </p>
          <p><a href="home11.php" style="color:white;text-decoration: none;">Home</a></p>
		  <p>| </p>
		  <p><a href="edit_profile.php" style="color:white;text-decoration: none;">Edit Profile</a></p>
		  <p>| </p>
		  <p><a href="logout.php" style="color:white;text-decoration: none;">Logout</a></p>
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
<h2><?php echo $message; ?></h2>
<h2>Edit Profile</h2>
<form action="edit_profile.php" method="POST">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
<table>
<tr>
<td>Email: </td><td><input type="text" name="usr" id="usr" value="<?php echo $email; ?>"></td>
</tr>
<tr>
<td>Password: </td><td><input type="password" name="pwd" id="pwd"></td>
</tr>

<tr>
<td>First Name: </td><td><input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>"></td>
</tr>
<tr>
<td>Last Name: </td><td><input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>"></td>
</tr>
<tr>
<td>Status: </td>
<td>
<select name="status">
  <option value="married" <?php if($status == 'married') echo 'selected';?>>Married</option>
  <option value="single" <?php if($status == 'single') echo 'selected';?>>Single</option>
</select>
</td>
</tr>
<tr>
<td>Gender: </td><td><select name="gender">
  <option value="male" <?php if($gender == 'male') echo 'selected';?>>Male</option>
  <option value="female" <?php if($gender == 'female') echo 'selected';?>>Female</option>
</select></td>
</tr>
<tr>
<td>Visibility: </td><td><select name="visibility">
  <option value="1" <?php if($visibility == '1') echo 'selected';?>>Private</option>
  <option value="2" <?php if($visibility == '2') echo 'selected';?>>Friends</option>
  <option value="3" <?php if($visibility == '3') echo 'selected';?>>Everyone</option>
</select></td>
</tr>
<tr style="height:20px;"></tr>
<tr>
<td></td>
<td><button type="submit">Update Profile</button></td>
<tr>
<table>
</form>

</div>
</body>
</html>
