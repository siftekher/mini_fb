<?php
	session_start();
      $username = '';
      $password = '';
      $servername = '';
      $servicename = '';
      $connection = $servername."/".$servicename;
	  
if(isset($_REQUEST['AJAX'])) {
    if(isset($_REQUEST['like_post'])){
		$post_id = $_REQUEST['post_id'];
		$user_id = $_SESSION['user_id'];
		
      $conn = oci_connect($username, $password, $connection);
      if(!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      else
      {
	      $query =  "INSERT INTO fb_post_like VALUES('".$post_id."', '".$user_id."')";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);

      }
	  
	  exit(0);
	}
	
	
    if(isset($_REQUEST['comment_post'])){
		$post_id = $_REQUEST['post_id'];
		$user_id = $_SESSION['user_id'];
		
        $comment_post = $_REQUEST['post_comment'];
		
		$commentTime = date('d-m-Y h:i:s');  
		
      $conn = oci_connect($username, $password, $connection);
      if(!$conn){
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
      }
      else
      {
	      $query =  "INSERT INTO fb_post_comment(post_id, user_id, comment_text, comment_time) 
					 VALUES(".$post_id.", ".$user_id.",'".$comment_post."', to_date('".$commentTime."','dd-mm-yy hh24:mi:ss'))";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);

      }
	  
	  exit(0);
	}
}	
?>
<html>
<head>
<style>
.center {
  margin: auto;
  width: 80%;
  border: 3px solid green;
  padding: 10px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
   function likePost(POST_ID){
   	$.ajax({
       method: "POST",
       url: "/news_feed.php?AJAX=1&like_post=1",
       data: { post_id: POST_ID }
    }).done(function( msg ) {
       location.reload(); 
    });
   }
   
   function commentPost(POST_ID){
	   if($('#div_post_'+POST_ID).is(":hidden"))
	      $('#div_post_'+POST_ID).show();
      else 
	      $('#div_post_'+POST_ID).hide();
   }
   
   function SaveComment(POST_ID){
   	$.ajax({
       method: "POST",
       url: "/news_feed.php?AJAX=1&comment_post=1",
       data: { post_id: POST_ID, post_comment: $('#comment_post_'+POST_ID).val() }
    }).done(function( msg ) {
       location.reload(); 
    });
   }
   
   function showAllComment(POST_ID){
	   if($('#all_comment_'+POST_ID).is(":hidden"))
	      $('#all_comment_'+POST_ID).show();
       else $('#all_comment_'+POST_ID).hide();
   }

</script>

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
<h2>News feed</h2>
<form action="news_feed.php" method="POST">
<table>


<?php
	//session_start();

  //if(isset($_POST['usr']) && isset($_POST['pwd'])) {
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
		  $userId = $_SESSION['user_id'];
		  $queryN =  "SELECT * FROM fb_friends WHERE user_id = ".$userId;
		  
		  $stidN = oci_parse($conn, $queryN);
          oci_execute($stidN);
		  
		  $friendIds = array($userId);
		  while (($rowN = oci_fetch_assoc($stidN))) {
			  array_push($friendIds, $rowN['FRIEND_ID']);
		  }
		  
	      $query =  "SELECT fb_post.*, fb_users.first_name, fb_users.last_name,
                    (SELECT COUNT(*) FROM fb_post_like WHERE fb_post.post_id = fb_post_like.post_id) AS post_like,
					(SELECT COUNT(*) FROM fb_post_comment WHERE fb_post.post_id = fb_post_comment.post_id) AS post_comment
		            FROM fb_post LEFT JOIN fb_users ON(fb_users.user_id = fb_post.user_id)
					WHERE fb_post.user_id IN (".implode(",",$friendIds).")";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
		
		  while (($row = oci_fetch_assoc($stid))) {
                $user_id = $row['USER_ID'];
				$name = (string)$row['FIRST_NAME'] ."  ". (string)$row['LAST_NAME'];
				$post_context = (string)$row['POST_CONTEXT'];
				$post_like = (string)$row['POST_LIKE'];
				$post_comment = (string)$row['POST_COMMENT'];
				
				
                $query1 =  "SELECT * FROM fb_post_comment LEFT JOIN fb_users ON (fb_post_comment.user_id = fb_users.user_id) 
				           WHERE post_id = ".$row['POST_ID'] ;

		        $stid1 = oci_parse($conn, $query1);
                oci_execute($stid1);
				
				$all_Comments = '';
				while (($row1 = oci_fetch_assoc($stid1))) {
				   $name1 = (string)$row1['FIRST_NAME'] ."  ". (string)$row1['LAST_NAME'];
				   $all_Comments .= "<div style='border: 1px solid green; margin-bottom:5px;'><span>".$row1['COMMENT_TEXT']."</span> By <span> ".$name1."</span></div>";	
				}

				
				echo "<tr><td><h4>". $name . "</h4><div>".$post_context."</div> <div><span style='border: 1px solid green; cursor:pointer; margin-right:5px;' onClick='likePost(\"".$row['POST_ID']."\")';>".$post_like." 
				      like </span> <span style='border: 1px solid green; cursor:pointer; margin-right:5px;' onClick='commentPost(\"".$row['POST_ID']."\")';>".$post_comment."Comment</span> 
					  <span style='border: 1px solid green; cursor:pointer;' onClick='showAllComment(\"".$row['POST_ID']."\")';>All Comments</span></div> 
					  <div id=\"div_post_".$row['POST_ID']."\" style='display:none;'>
                      <textarea rows='4' cols='30' id='comment_post_".$row['POST_ID']."' name='comment_post_".$row['POST_ID']."'></textarea>
					  <input type='button' value='Save Comment' onClick='SaveComment(\"".$row['POST_ID']."\")'>
					  </div>
					  
					  <div id='all_comment_".$row['POST_ID']."' style='display:none; padding-left:100px;'>".$all_Comments." </div>
					  </td></tr>";
				
          }
		
       }
  //}
?>



<table>
</form>

</div>
</body>
</html>
