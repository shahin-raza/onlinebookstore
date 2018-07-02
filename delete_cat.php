<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else {
			header("Location: index.php");
	  }
	$cat_id = $_GET['cid'];
	require('db.php');
	$sql="SELECT book_category FROM categories where cat_id ={$cat_id}";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$category=$row['book_category'];
	}
	$sql1="SELECT book_category FROM books WHERE book_category  LIKE '%".$category."%'";
	$result1 = $conn->query($sql1);
	$rows = mysqli_fetch_array($result1);
	if ($rows[0]==$category) {
		$Color = "red";
		$Text="Category $category is in use, cant be deleted";		
    echo '<div style="Color:'.$Color.'">'.$Text.'</div>';?> <br>
    <input type="reset" value="Back" onclick="history.back()" class="btn btn-primary">
		<?php
		return;
	} else {
			$sql2="DELETE FROM categories WHERE cat_id={$cat_id}";
			$result2 = $conn->query($sql2);
		}
	header("Location: add_cat.php");
	die();
?>
