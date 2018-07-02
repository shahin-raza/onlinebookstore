<?php
    session_start();
  if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $bookid = $_GET['bid'];
  }
  else{
    header("Location: login.php");
  }
    if(!empty($uid) && !empty($bookid)) {
      $conn = new mysqli('localhost','root','root','onlinebookstore');
      if (mysqli_connect_error()) {
        die("Database connection failed:" . mysqli_connect_error());
      }
      $sql = "SELECT cart_id FROM cart WHERE user_id = $uid and status = 0";
      $result = $conn->query($sql);
      $cart_id = $result->fetch_assoc();
      $sql1 = "SELECT user_id FROM `cart` where status = 0 and user_id = $uid";
      $result1 = $conn->query($sql1);
      if ($result1->num_rows > 0) {
        $sql2 = "INSERT INTO cart_data (cart_id, book_id, quantity) VALUES (".$cart_id['cart_id'].",$bookid,1)";
        $result2 =$conn->query($sql2);
      }
      else {
        $sql2 = "INSERT INTO cart(user_id,status) VALUES ($uid,0)";
        $conn->query($sql2);

        $sql3 = "SELECT cart_id FROM cart WHERE user_id = $uid and status = 0";
        $result3= $conn->query($sql3);
        $cart_id3 = $result3->fetch_assoc();
        $sql4 = "INSERT INTO cart_data (cart_id, book_id, quantity) VALUES (".$cart_id3['cart_id'].",$bookid,1)";
        $result4 =$conn->query($sql4);
      }
      session_start();
			$_SESSION['x'] =  1;
      header("Location: view_book.php?");
    }
?>
