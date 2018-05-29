<?php include 'nav_home.php';?>
<form action="form.php" method="post">
	Search Book: <input type="text" name="term" placeholder="Search by title, name, category"  size= 75/>
	<input type="submit" value="Search" /> 
</form>
 <?PHP
    require('db.php');
	$sqlb = "SELECT * FROM books";
	$results = $conn->query($sqlb);
	echo "<div class='container-fluid'>";
	echo "<div class='row'>";
	while($row = $results->fetch_assoc()) {
		$bookid=$row['book_id'];
		echo "<div class='book_img'>";
		#echo "<img src='http://192.168.2.126/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
		echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
		echo $row['book_name'];
		echo "<br> Price : Rs.".$row['book_price']."<br><button type='button' class='btn btn-info'><a href='cart.php?bid=$bookid'role='button'>Buy Now</a></button>";
		echo "</div>";
	}
	echo "</div>";
	echo "</div>";
?>     
<?php include 'footer.php';?> 
