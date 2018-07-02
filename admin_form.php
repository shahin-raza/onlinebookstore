<?php 
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	}	else{
    header("Location: index.php");
  }		
   ?> <form action="admin_form.php" method="post">
	Search book: <input type="text" name="term" placeholder="Search by name, category, language, author, publisher"  size="75"/>
	<input type="submit" value="Search" /> 
	</form> <?php 
			if (!empty($_POST['term'])) {
      $term = $_POST['term'];
      require('db.php');
      $sql1 = "SELECT * FROM books WHERE book_name LIKE '%".$term."%' OR book_author LIKE '%".$term."%' OR book_language LIKE '%".$term."%' OR book_category  LIKE '%".$term."%' OR book_publisher  LIKE '%".$term."%'";
      $result1 = $conn->query($sql1);
      echo "<div class='container'>";
			echo "<table class='table table-hover'>";
			echo " <thead><tr class='info'><th>Image</th><th>Name</th><th>Author</th><th>Language</th><th>Publisher</th><th>Category</th><th>Price</th><th></th><th></th></tr> </thead>";
			while($row = $result1->fetch_assoc()) {
				echo "<tbody><tr><td><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='150px' height='200px'></td>";
				echo "<td>".$row['book_name']."</td>";
				echo "<td>".$row['book_author']."</td>";
				echo "<td>".$row['book_language']."</td>";
				echo "<td>".$row['book_publisher']."</td>";
				echo "<td>".$row['book_category']."</td>";
				$id = $row['book_id'];
				echo "<td>".$row['book_price']."</td><td><a href='edit_book.php?bid=$id'role='button'>Edit</a></td><td><a href='delete_book.php?bid=$id'>Delete</a></td></tr></tbody>";
			}
			echo "</table>";
			echo "</div>";
	}
?>
