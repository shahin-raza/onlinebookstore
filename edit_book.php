<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
		header("Location: index.php");
		}
	$book_id = $_GET['bid'];
	require('db.php');
	$sql="SELECT * FROM books WHERE book_id={$book_id}";
	$result = $conn->query($sql);
	while($row  =$result->fetch_assoc()) {
		$name     =$row["book_name"];
		$author   =$row["book_author"];
		$language =$row["book_language"];
		$publisher=$row["book_publisher"];
		$category =$row["book_category"];
		$price		=$row["book_price"];
		$image    =$row["book_img"];
	}
	$sql1 = "SELECT * FROM categories";
	$result1 = $conn->query($sql1);
	$var_holding_img = "<img src=http://localhost/onlinebookstore/book_img/$image height=75px width=50px/>";
	//~ print_r($var_holding_img); 
?>
<div class="container">
<form method="post" action="" enctype="multipart/form-data">
<table class="table">
	<tr>
		<th>Name</th>
		<td><input type="text" value="<?php echo $name?>" name="Ename" required></td>
	</tr>
	<tr>
		<th>Author</th>
		<td><input type="text" value="<?php echo $author?>" name="Eauthor" required></td>
	</tr>
	<tr>
		<th>Language</th>
		<td><input type="text" value="<?php echo $language?>" name="Elanguage" required></td>
	</tr>
	<tr>
		<th>Publisher</th>
		<td><input type="text" value="<?php echo $publisher?>" name="Epublisher" required></td>
	</tr>
	<tr>
	<th>Category</th>
	<td>
	<select name="category">
		<?php while($row = $result1->fetch_assoc()) { 
			if ($row['book_category'] == $category) {	
		?>
			<option value="<?php print($row['book_category']) ?>" selected="selected"><?php print($row['book_category'])?></option>
		<?php  
			}
			else { ?>
				<option value="<?php print($row['book_category']) ?>" ><?php print($row['book_category'])?></option>
			<?php }  
		}?>
	</select>
	</td>
</tr>
	<tr>
		<th>Price(&#8377)</th>
		<td><input type="text" value= "<?php echo $price;?>" name="Eprice" required></td>
	</tr>
	<tr>
		<th>Image</th>
		<td><input type="file" value=" <?php echo $var_holding_img;?>" name="imagefile" required></td>
	</tr>
</table>
		<input type="submit" name="add" value="Save" class="btn btn-primary">
		<input type="reset" value="Cancel" onclick="history.back()" class="btn btn-default">
	</form>
	<br/>
</div>
<?php
	if(isset($_POST['add'])) {					
		$Ename      = $_POST['Ename'];
		$Eauthor    = $_POST['Eauthor'];
		$Elanguage  = $_POST['Elanguage'];
		$Epublisher = $_POST['Epublisher'];
		$Ecategory  = $_POST['category'];
		$Eprice 		 = $_POST['Eprice'];
		$db_path 		 = $_FILES['imagefile']['name'];
		$uploaddir = "/var/www/onlinebookstore/book_img/";
		$oldumask = umask(0);
		$uploadfile = $uploaddir . basename($_FILES["imagefile"]["name"]);
		move_uploaded_file($_FILES['imagefile']['tmp_name'], $uploadfile);
		umask($oldumask);
		if(!empty($name) && !empty($author) && !empty($language)) {
			require('db.php');
			$sql2 = "UPDATE books SET book_name='$Ename',book_author='$Eauthor',book_language='$Elanguage',book_publisher='$Epublisher',book_category='$Ecategory',book_price='$Eprice',book_img ='$db_path' WHERE book_id={$book_id}";
			$conn->query($sql2);
			header('Location: admin_view.php');
		}
	}
?>
<?php include 'footer.php';?>


