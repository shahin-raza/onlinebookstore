<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
    header("Location: index.php");
		}
?>

<form action="" method="POST">
  <input type="text" placeholder="Enter new category" name="category" size="15" required></br> 
	<input type="submit" name="add" value=" Add category  " class="btn btn-primary">
</form>
<?php
	if(isset($_POST['add'])) {				
		$category  = $_POST['category'];
		if(!empty($category)) {
			$conn = new mysqli('localhost','root','root','onlinebookstore');
			if (mysqli_connect_error()) {
				die("Database connection failed:" . mysqli_connect_error());
			}
			$sql="INSERT INTO categories(book_category) VALUES ('$category')";
			$result = $conn->query($sql);
		}
		?>	
		<div class="foo">
		<?php echo "New Category $category is added"; ?>
		</div> <?php
	}	
	require('db.php');
	$sqlb = "SELECT * FROM categories";
	$resultb = $conn->query($sqlb);
	echo "<div class='container'>";
	echo "<table class='table table-hover'>";
	echo " <thead><tr class='info'><th>Category<td></td><td></td></thead>";
	while($row = $resultb->fetch_assoc()) {
		echo "<tbody><tr><td>".$row['book_category']."</td>";
		$cid = $row['cat_id'];
		echo "<td><a href='edit_cat.php?cid=$cid'role='button'>Edit</a></td><td><a href='delete_cat.php?cid=$cid'>Delete</a></td></tr></tbody>";	
	}
	echo "</table>";
	echo "</div>";
	include 'footer.php';
?>

	
