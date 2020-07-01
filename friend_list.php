<?php
	session_start();
      $username = '';
      $password = '';
      $servername = '';
      $servicename = '';
      $connection = $servername."/".$servicename;

  if(isset($_REQUEST['AJAX'])) {

	  if(isset($_REQUEST['accept_friend'])){

		  $friend_id = $_REQUEST['friend_id'];
	  
          $conn = oci_connect($username, $password, $connection);
          if(!$conn){
             $e = oci_error();
             trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
          }
          else
          {
	         $query =  "DELETE FROM fb_friends_request WHERE recipient_id = ".$_SESSION['user_id']." AND USER_ID = ".$friend_id;

		     $stid = oci_parse($conn, $query);
             oci_execute($stid);

    	     $query1 =  "INSERT INTO fb_friends(USER_ID, FRIEND_ID) VALUES( ".$_SESSION['user_id']." , ".$friend_id.")";
             $query2 =  "INSERT INTO fb_friends(USER_ID, FRIEND_ID) VALUES( ".$friend_id.", ".$_SESSION['user_id'].")";
		     $stid = oci_parse($conn, $query1);
             oci_execute($stid);
			 
			 $stid = oci_parse($conn, $query2);
             oci_execute($stid);
		  }
		  
		  exit(0);
	  }
	  
	  if(isset($_REQUEST['reject_friend'])){
		  		  $friend_id = $_REQUEST['friend_id'];
	  
          $conn = oci_connect($username, $password, $connection);
          if(!$conn){
             $e = oci_error();
             trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
          }
          else
          {
	         $query =  "DELETE FROM fb_friends_request WHERE recipient_id = ".$_SESSION['user_id']." AND USER_ID = ".$friend_id;

		     $stid = oci_parse($conn, $query);
             oci_execute($stid);

		  }
		  
		  exit(0);
	  }
  }
  
  $friend_request = '';
  $friend_list = '';
  if(isset($_SESSION['user_id']) ) {
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
		  $query =  "SELECT fb_friends_request.*, fb_users.first_name, fb_users.last_name FROM fb_friends_request LEFT JOIN fb_users ON(fb_users.user_id = fb_friends_request.user_id) WHERE fb_friends_request.recipient_id='".$_SESSION['user_id']."'";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);

    	  while (($row = oci_fetch_assoc($stid))) {
                //$user_id = $row['USER_ID'];
				$name = $row['FIRST_NAME'] ."  ". $row['LAST_NAME'];
				$friend_request .= "<tr><td><h2>". $name . "</h2></td><td><input type='button' value='Accept' onClick='AcceptFriend(".$row['USER_ID'].")'> <input type='button' value='Reject' onClick='RejectFriend(".$row['USER_ID'].")'> </td>";
          }
		  
		  $query =  "SELECT fb_friends.*, fb_users.first_name, fb_users.last_name FROM fb_friends LEFT JOIN fb_users ON(fb_users.user_id = fb_friends.friend_id) WHERE fb_friends.user_id='".$_SESSION['user_id']."'";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);

    	  while (($row = oci_fetch_assoc($stid))) {
                //$user_id = $row['USER_ID'];
				$name = $row['FIRST_NAME'] ."  ". $row['LAST_NAME'];
				$friend_list .= "<tr><td><h2>". $name . "</h2></td><td><input type='button' value='Remove'> </td>";
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
function AcceptFriend(USER_ID) {
	$.ajax({
       method: "POST",
       url: "/friend_list.php?AJAX=1&accept_friend=1",
       data: { friend_id: USER_ID }
    }).done(function( msg ) {
       location.reload(); 
    });
}

function RejectFriend(USER_ID) {
	$.ajax({
       method: "POST",
       url: "/friend_list.php?AJAX=1&reject_friend=1",
       data: { friend_id: USER_ID }
    }).done(function( msg ) {
       location.reload(); 
    });
}
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

<form action="friend_list.php" method="POST">
<h2>Friend Request</h2>
<table>
<?php echo $friend_request;?>
</table>


<h2>Friend list</h2>
<table>
<?php echo $friend_list;?>
</table>


</form>



</div>
</body>
</html>
