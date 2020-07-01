<?php
session_start();
if(!isset($_SESSION['user_id']) ) {
    header('Location: index.php');
    exit;
}
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
					WHERE fb_post.user_id IN (".implode(",",$friendIds).") ORDER BY fb_post.post_time DESC";

		  $stid = oci_parse($conn, $query);
          oci_execute($stid);
/*
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
*/

		  $query =  "SELECT fb_friends_request.*, fb_users.first_name, fb_users.last_name FROM fb_friends_request LEFT JOIN fb_users ON(fb_users.user_id = fb_friends_request.user_id) WHERE fb_friends_request.recipient_id='".$_SESSION['user_id']."'";

		  $stid1 = oci_parse($conn, $query);
          oci_execute($stid1);
          $friend_request = '';
    	  while (($row = oci_fetch_assoc($stid1))) {
                //$user_id = $row['USER_ID'];
				$name = $row['FIRST_NAME'] ."  ". $row['LAST_NAME'];
				//$friend_request .= "<tr><td><h2>". $name . "</h2></td><td><input type='button' value='Accept' onClick='AcceptFriend(".$row['USER_ID'].")'> <input type='button' value='Reject' onClick='RejectFriend(".$row['USER_ID'].")'> </td>";
				$friend_request .= "<img src='prof.png' id='profpic'/>". $name . "<br><input type='button' value='Accept' onClick='AcceptFriend(".$row['USER_ID'].")'> <input type='button' value='Reject' onClick='RejectFriend(".$row['USER_ID'].")'> <br>";
          }

		  $query =  "SELECT fb_friends.*, fb_users.first_name, fb_users.last_name FROM fb_friends LEFT JOIN fb_users ON(fb_users.user_id = fb_friends.friend_id) WHERE fb_friends.user_id='".$_SESSION['user_id']."'";

		  $stid2 = oci_parse($conn, $query);
          oci_execute($stid2);
          $friend_list = '';
    	  while (($row = oci_fetch_assoc($stid2))) {
                //$user_id = $row['USER_ID'];
				$name = $row['FIRST_NAME'] ."  ". $row['LAST_NAME'];
				$friend_list .= "<img src='prof.png' id='profpic'/>". $name . "<br>";
          }
       }

?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="ust.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
   function savePost(){
   if($('#postbox').val() == '') return;
   	$.ajax({
       method: "POST",
       url: "/save_post.php?AJAX=1&save_post=1",
       data: { post_content: $('#postbox').val() }
    }).done(function( msg ) {
       location.reload();
    });
   }

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

          $("#comment_post_"+POST_ID).focus();
      }

      function SaveComment(obj, POST_ID){
         var key = obj.keyCode;
         if(key == 13)  { // the enter key code
         	  $.ajax({
                 method: "POST",
                 url: "/news_feed.php?AJAX=1&comment_post=1",
                 data: { post_id: POST_ID, post_comment: $('#comment_post_'+POST_ID).val() }
              }).done(function( msg ) {
                 location.reload();
              });
            }
         }


   function showAllComment(POST_ID){
	   if($('#all_comment_'+POST_ID).is(":hidden"))
	      $('#all_comment_'+POST_ID).show();
       else $('#all_comment_'+POST_ID).hide();
   }

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


<div class="header1">
<div id="img3" class="header1"><img src="logo.png" id="img3" /></div>
<div id="searcharea" class="header1"><input placeholder="search here..." type="text" id="searchbox"/></div>
<div id="profilearea" class="header1"><a href="edit_profile.php"><img src="prof.png"id="profpic" /></a></div>
<div id="profilearea1" class="header1"><a href="edit_profile.php">Profile</a></div>
<div id="profilearea3" class="header1">|</div>
<!-- 
<div id="profilearea4" class="header1">Home</div>
<div id="findf" class="header1"><img src="frn.png"height="30"/></div>
<div id="message" class="header1"><img src="chat.png"height="30"/></div>
<div id="notification" class="header1"><img src="noti.png"height="30"/></div>
<div id="profilearea2" class="header1">|</div>
<div id="setting" class="header1"><img src="set.png"height="30"/></div>
-->
<div id="logout" class="header1"><a href="logout.php" ><img src="lo.png"height="30"/></a></div>
</div>


<div class="bodyn">
<div id="side1" class="bodyn"><img src="prof.png"id="profpic"/>Profile</div>
<div id="side2" class="bodyn"><a href="edit_profile.php" style="color:black;">edit profile </a></div>
<div id="side3" class="bodyn"><a href="home11.php" style="color:black;">News feed</a></div>
<div id="side4" class="bodyn"><a href="show_members.php" style="color:black;">Directory</a></div>
<div id="side5" class="bodyn">Message</div>
<div id="side7" class="bodyn"><a href="friend_list.php" style="color:black;">Friends list</a></div>

</div>



<div class="header0001">
</div>
<div class="sideboxxx">
</div>
<div class="sideboxxxx2">
</div>


<div class="post">
<div id="column-1" class="post"><hr><br><br><br><br><br><br><hr></div>
<div id="postpos" class="post"><input type="button" id="buttonpost" value="post status" onClick="savePost();"/></div>
<div id="postboxpos" class="post"><textarea placeholder="What's in your mind" id="postbox" name="postbox" type="text"></textarea></div>
</div>

<?php
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
				$name1 = '';
				while (($row1 = oci_fetch_assoc($stid1))) {
				   $name1 = (string)$row1['FIRST_NAME'] ."  ". (string)$row1['LAST_NAME'];
				   $all_Comments .= "<div style='border: 1px solid green; margin-bottom:5px;'><span>".$row1['COMMENT_TEXT']."</span> By <span> ".$name1."</span></div>";
				}

?>
<div class="post1"><img src="prof.png"id="profpic"/> <p3><?php echo $name;?></p3><br><br>
<div><?php echo $post_context;?></div><br><br>
<p6><span style='border: 1px solid green; cursor:pointer; margin-right:5px;' onClick='likePost(<?php echo $row['POST_ID'];?>)';><?php echo $post_like; ?>like </span>
   <span style='border: 1px solid green; cursor:pointer; margin-right:5px;' onClick='commentPost(<?php echo $row['POST_ID'];?>)';><?php echo $post_comment ?>Comment</span>
    <span style='border: 1px solid green; cursor:pointer;' onClick='showAllComment("<?php echo $row['POST_ID']; ?>")';>All Comments</span>
    </p6><br>
<hr>
<div><img src="prof.png"id="profpic"/> <input type="textarea" placeholder="comment" class="commentbox" id="comment_post_<?php echo $row['POST_ID'];?>" onKeyUp="SaveComment(event, <?php echo $row['POST_ID']; ?>)" /> </div>

<div id='all_comment_<?php echo $row['POST_ID']?>' style='display:none; padding-left:100px;'><?php echo $all_Comments; ?> </div>
<hr>
<br>
</div>

<?php } ?>





<div class="sidebox">
<div id="sidebox1" class="sidebox">
<div id="sideboxx1">FRIENDS LIST</div>
<!--<img src="prof.png"id="profpic"/> <br> -->
<?php echo $friend_request;?>
<?php echo $friend_list;?>
<hr><br><br><br><a href="friend_list.php" style="color:black;">See all</a><hr>


<!--
<div id="sideboxx3">Recent Posts</div><br><br><br>See more<hr>
<div id="sideboxx4">You havent posted in this days</div><br><br><br><br><br><br>See all
</div>
<div id="post1pos" class="sidebox"><input type="submit" id="buttonpost1" value="write a post"/></div>
</div>
-->

<!--
<div class="sideboxxx2">
<div id="sidebox2" class="sideboxxx2">
<br>
<hr>
<div id="sideboxx21">Trending</div>
<br><br><br>See more<hr>
<div id="sideboxx22">Suggested Pages</div><br><br><br>See all<hr>
<div id="sideboxx23">People you may know</div><br><br><br><br><br><br>See all
</div>

</div>

-->
<!--
<div class="chat-sidebarx">
</div>
<div class="chat-sidebar"><div id="chatnamebox" class="chat-sidebar">jb</div>
<div id="chatnamebox1" class="chat-sidebar">jb</div>
<div id="chatnamebox2" class="chat-sidebar">jb</div>
<div id="chatnamebox3" class="chat-sidebar">jb</div>
<div id="chatnamebox4" class="chat-sidebar">jb</div>
<div id="chatnamebox5" class="chat-sidebar">jb</div>
<div id="chatnamebox6" class="chat-sidebar">jb</div>
<div id="chatnameboxp1" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp2" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp3" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp4" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp5" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp6" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
<div id="chatnameboxp7" class="chat-sidebar"><img src="prof.png"id="profpic"/></div>
</div>
-->
<div class="header10"></div>


</body>
</html>