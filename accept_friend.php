<?php
	session_start();

  if(isset($_POST['friend_id'])) {
  
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
		  $user_id = $_SESSION["user_id"];
		  $friend_id = $_POST['friend_id'];
          echo $query =  "INSERT INTO fb_friends_request(USER_ID, RECIPIENT_ID, REQUEST_STATUS) VALUES(".$user_id.", ".$friend_id.", 1)";
		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
		  
          header('Location: show_members.php');
          exit;
      }
  }
  
				
  if(isset($_REQUEST['friend_id'])){
	  $userId = $_REQUEST['friend_id'];
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
          <p style="color:white;text-decoration: none;">Home</p>
		  <p>| </p>
		  <p><a href="edit_profile.php" style="color:white;text-decoration: none;">Edit Profile</a></p>
		  <p>| </p>
		  <p><a href="logout.php" style="color:white;text-decoration: none;">Logout</a></p>
        </div>
      </div>
    </div>
<div class="center">
<h2><?php echo $message; ?></h2>
<h2>Member Profile</h2>
<form action="accept_friend.php" method="POST">
<input type="hidden" name="friend_id" id="friend_id" value="<?php echo $user_id; ?>">
<table>

<tr>
<td>First Name: </td><td><label ><?php echo $first_name; ?></label></td>
</tr>
<tr>
<td>Last Name: </td><td><label ><?php echo $last_name; ?></label></td>
</tr>

<tr>
<td>Location: </td><td><label ><?php echo $location; ?></label></td>
</tr>
<tr>
<td>Date of Birth: </td><td><label ><?php echo $dob; ?></label></td>
</tr>

<!--
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
-->
<tr style="height:20px;"></tr>
<tr>
<td></td>
<td><button type="submit">Add Friend</button></td>
<tr>
<table>
</form>

</div>
</body>
</html>
