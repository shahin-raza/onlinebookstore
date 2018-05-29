<?php
    include 'nav_home.php';
  if(!isset($_SESSION)) {
    session_start();
  }
  $uid = $_SESSION['user_id'];
  if(!empty($uid)) {
    if (!empty($_POST['term'])) {
      $term = $_POST['term'];
      require('db.php');
      $sql1 = "SELECT * FROM books WHERE book_name LIKE '%".$term."%' OR book_author LIKE '%".$term."%' OR book_language LIKE '%".$term."%' OR book_category  LIKE '%".$term."%' OR book_publisher  LIKE '%".$term."%'";
      $result3 = $conn->query($sql1);
            echo "<div class='container-fluid'>";
          echo "<div class='row'>";
      while($row = $result3->fetch_assoc())  {
        echo "<div class='book_img'>";
        $bookid=$row['book_id'];
        #echo "<img src='http://192.168.2.126/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        echo $row['book_name'];
        echo "<br> Price : Rs.".$row['book_price']."<br><button type='button' class='btn btn-info'><a href='cart.php?bid=$bookid'role='button'>Add to Cart</a></button>";
        echo "</div>";
      }
      echo "</div>";
        echo "</div>";
    }
  }
  include 'footer.php';
?>
