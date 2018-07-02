<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
		} else{
				header("Location: index.php");
			}

		if(isset($_POST['add'])) {
						
			$name       = $_POST['name'];
			$author     = $_POST['author'];
			$language   = $_POST['language'];
			$publisher  = $_POST['publisher'];
			$category   = $_POST['category'];
			$price 	    = $_POST['price'];
			$db_path    = $_FILES['imagefile']['name'];
			$uploaddir  = "/var/www/onlinebookstore/book_img/";
			$oldumask   = umask(0);
			$uploadfile = $uploaddir . basename($_FILES["imagefile"]["name"]);
			move_uploaded_file($_FILES['imagefile']['tmp_name'], $uploadfile);
			umask($oldumask);

			if(!empty($name) && !empty($author) && !empty($language)) {
				require('db.php');
				$query = "INSERT INTO books(book_name,book_author,book_language,book_publisher,book_category,book_price,book_img) VALUES ('$name','$author','$language','$publisher','$category',$price,'$db_path')";
				$conn->query($sql);
				$result = mysqli_query($conn, $query);
			}
			if(empty($result)) {
				echo "Can't add new data " . mysqli_error($conn);
				exit;
			} else {
				 header('Location: admin_view.php');
				}
	}
	
	require('db.php');
	$sql1 = "SELECT * FROM categories";
	$result1 = $conn->query($sql1);

	?>
<div class="container">
<form method="post" action="" enctype="multipart/form-data">
	<table class="table">
		<tr>
			<th>Name</th>
			<td><input type="text" name="name" required></td>
		</tr>
		<tr>
			<th>Author</th>
			<td><input type="text" name="author" required></td>
		</tr>
		<tr>
			<th>Language</th>
			<td><input type="text" name="language" required></td>
		</tr>
		<tr>
			<th>Publisher</th>
			<td><input type="text" name="publisher" required></td>
		</tr>
		<tr>
			<th>Category</th>
				<td>
					<select name="category">
						<?php while($row = $result1->fetch_assoc()) { ?>
						<option value="<?php print($row['book_category'])?>"><?php print($row['book_category'])?></option>
						<?php  }  ?>
					</select>
				</td>
		</tr>
		<tr>
			<th>Price(&#8377)</th>
			<td><input type="text" name="price" required></td>
		</tr>
		<tr>
			<th>Image</th>
			<td><input type="file" name="imagefile"></td>
		</tr>
	</table>
	<input type="submit" name="add" value="Save" class="btn btn-primary">
	<input type="reset" value="Cancel" onclick="history.back()" class="btn btn-default">
</form>
</div>
