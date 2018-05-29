<?php
session_start();
if (isset($_SESSION['user_id']) && ($_SESSION['user_id']=='admin')) {
	include 'nav_admin.php';
}else{
    header("Location: index.php");
  }
?>

<form action="" method="POST">
   <input type="text" placeholder="Enter New Category" name="category" size="15" required></br> 
	<input type="submit" name="add" value=" Add new category  " class="btn btn-primary">
</form>
<?php
	if(isset($_POST['add'])) {				
		$category  = $_POST['category'];
		if(!empty($category)){
			$conn = new mysqli('localhost','root','root','onlinebookstore');
			if (mysqli_connect_error()) {
				die("Database connection failed:" . mysqli_connect_error());
			}
			$sql="INSERT INTO categories(book_category) VALUES ('$category')";
			$result = $conn->query($sql);
		}
	}
	
	?>
<?php include 'footer.php'?>
	
