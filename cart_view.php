<?php
  session_start();
  if (isset($_SESSION['user_id'])) {
    include 'nav_home.php';
  }else{
    header("Location: index.php");
    }

  $uid = $_SESSION['user_id'];
  require('db.php');
  $sql2 = "SELECT cart_id FROM cart WHERE user_id = $uid AND status=0";
  $result1 = $conn->query($sql2);
  $cart_id1 = $result1->fetch_assoc();
  $cart_id =$cart_id1['cart_id'];
  if (empty($cart_id)) {
    print('Your cart is empty');
    return;
  }

  $sql = "SELECT book_id FROM cart_data where cart_id=$cart_id";
  $result = $conn->query($sql);
  //print_r ($result);exit;
  while($row = $result->fetch_assoc()) {
    $bookid=$row['book_id'];
    $bid[] = $bookid;
  }
  $ids = join("','",$bid);

  $sqlb = "SELECT * FROM books WHERE book_id IN ('$ids')";
  $results = $conn->query($sqlb);

  $sql1 = "SELECT cart_id FROM cart WHERE user_id = $uid";
  $result1 = $conn->query($sql1);
  $cart_id2 = $result1->fetch_assoc();
  $i = 1;

  if(!empty ($bid)) {
    	echo "<div class='book_container'>
    <form action='update_cart.php?cart_id=$cart_id' method='POST'>";
    while($row = $results->fetch_assoc()) {
			echo "<div class='book_img'>";
      #echo "<tr><td><tr><img src='http://192.168.2.126/onlinebookstore/book_img/{$row['book_img']}' width='100px' height='150px'></tr>";
      echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='170px'>";
      echo 	$row['book_name'];
      echo "<br> Price : &#8377 ".$row['book_price']."<br><a href='remove_cart.php?cid=$cart_id && bid=".$row['book_id']."'role='button'>Remove</a><br>";
      echo "
            Quantity :
            <input type='number' name=".$row['book_id']." value='1' min='1' max='50'>";
              $i++;
                echo "</div>";
    }
    echo "</div>";
    echo "<input type='submit' value='Buy now' class='buy'></form>";
         
  }
  else {
    echo"your cart is empty";
  }
 
//~ include('footer.php');
?>
