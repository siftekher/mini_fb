<?php
	session_start();
?>

<html>
<body>

<?php

	unset($_SESSION['usr']);
	header('Location: index.php');
	exit(0);
?>
  
</body>
</html>