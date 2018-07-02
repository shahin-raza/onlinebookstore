<?php
  include 'nav_home.php';
  if(!isset($_SESSION)) {
    session_start();
  }
   ?> <form action="admin_form.php" method="post">
	Search book: <input type="text" name="term" placeholder="Search by name, category, language, author, publisher"  size="75"/>
	<input type="submit" value="Search" /> 
	</form> <?php 
  $uid = $_SESSION['user_id'];
  if(!empty($uid)) {
    if (!empty($_POST['term'])) {
      $term = $_POST['term'];
      require('db.php');
      $sql1 = "SELECT * FROM books WHERE book_name LIKE '%".$term."%' OR book_author LIKE '%".$term."%' OR book_language LIKE '%".$term."%' OR book_category  LIKE '%".$term."%' OR book_publisher  LIKE '%".$term."%'";
      $result1 = $conn->query($sql1);
          echo "<div class='container-fluid'>";
          echo "<div class='row'>";
      while($row = $result1->fetch_assoc())  {
        echo "<div class='book_img'>";
        $bookid=$row['book_id'];
        echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        #echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        echo $row['book_name'];
        echo "<br> Price : Rs.".$row['book_price']."<br><button type='button' class='btn btn-info'><a href='cart.php?bid=$bookid'role='button'>Add to Cart</a></button>";
        echo "</div>";
      }
      echo "</div>";
        echo "</div>";
    }
  }
  else{
		if (!empty($_POST['term'])) {
			$term = $_POST['term'];
      require('db.php');
      $sql2 = "SELECT * FROM books WHERE book_name LIKE '%".$term."%' OR book_author LIKE '%".$term."%' OR book_language LIKE '%".$term."%' OR book_category  LIKE '%".$term."%' OR book_publisher  LIKE '%".$term."%'";
      $result2 = $conn->query($sql2);
            echo "<div class='container-fluid'>";
          echo "<div class='row'>";
      while($row = $result2->fetch_assoc())  {
        echo "<div class='book_img'>";
        $bookid=$row['book_id'];
        echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        #echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
        echo $row['book_name'];
        echo "<br> Price : Rs.".$row['book_price']."<br><button type='button' class='btn btn-info'><a href='login.php'role='button'>Add to Cart</a></button>";
        echo "</div>";
      }
      echo "</div>";
        echo "</div>";
	}
		}
  //~ include 'footer.php';
?>
