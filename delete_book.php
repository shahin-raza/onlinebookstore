<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
			header("Location: index.php");
	  }
	$book_id = $_GET['bid'];
	require('db.php');
	$sql="DELETE FROM books WHERE book_id={$book_id}";
	$result = $conn->query($sql);
	header("Location: admin_view.php");
	die();
?>
