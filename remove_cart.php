<?php
$cart_id = $_GET['cid'];
$book_id = $_GET['bid'];

  $conn = new mysqli('localhost','root','root','onlinebookstore');
  if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
  }
  $sql="DELETE FROM cart_data WHERE cart_id=$cart_id AND book_id=$book_id";

  $result = $conn->query($sql);
  header("Location: cart_view.php");
  die();
?>
