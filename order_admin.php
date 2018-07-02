<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
			header("Location: index.php");
		}
	$uid = $_SESSION['user_id'];
	require('db.php');
	$sql    = "SELECT DISTINCT user_id FROM cart where status=1";
	$result =$conn->query($sql);
	echo "<div class='container'>";
	echo "<table class='table'>";
	echo "<tr class='info'><th>UserId</th><th>Name</th></tr>";
	while($row = $result->fetch_assoc()) {			
		$userid = $row['user_id'];	
		$sql2 = "SELECT * from user where user_id IN ('$userid')";
		$result2=$conn->query($sql2);

		if(!empty($result)) {	
			while($row = $result2->fetch_assoc()) {
				echo "<tr><td>".$userid."</td>";
				echo "<td><a href='order_view.php?uid=$userid'role='button'>".$row['name']."</a></td></tr>";
			}
		}
	}
	echo "</table>";
	echo "</div>";
	include 'footer.php';
?>
