<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
    header("Location: index.php");
		}
	$cat_id = $_GET['cid'];
	require('db.php');
	$sqlb = "SELECT book_category FROM categories where cat_id=$cat_id";
	$resultb = $conn->query($sqlb);
	while($row  =$resultb->fetch_assoc()) {
		$category=$row['book_category'];
	}
?>

<form action="" method="POST">
  <input type="text" value="<?php echo $category?>" name="category" size="15" required></br> 
	<input type="submit" name="add" value="Update" class="btn btn-primary">
</form>
<?php
	if(isset($_POST['add'])) {				
		$Ecategory  = $_POST['category'];
		if(!empty($Ecategory)) {
			require('db.php');
			$sql="UPDATE categories SET book_category='$Ecategory' WHERE cat_id=$cat_id";
			$result = $conn->query($sql);
			header('Location: add_cat.php');
		}
		?>	
		<div class="foo">
		<?php echo "Category $category is updated"; ?>
		</div> <?php
	}	
