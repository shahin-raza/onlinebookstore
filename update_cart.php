<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_home.php';
	}else{
		header("Location: index.php");
		}
	$cart_id = $_GET['cart_id'];

	$conn = new mysqli('localhost','root','root','onlinebookstore');
	if (mysqli_connect_error()) {
		die("Database connection failed:" . mysqli_connect_error());
	}
	foreach($_POST as $key => $value) {
		$sql = "UPDATE cart_data SET quantity= $value WHERE cart_id = $cart_id and book_id = $key";
		$result = $conn->query($sql);		
	}
	$total_amount = 0;
	  echo "<div class='container'>";
		echo "<table class='table'>";
		echo "<tr class='info'><th>Book</th><th>Name</th><th>Price (&#8377)</th><th>Quantity</th><th>Amount (&#8377)</th></tr>"; 
		foreach($_POST as $key => $value){
		$sql1= "SELECT book_name,book_img,book_price from books where book_id =$key";
		$result = $conn->query($sql1);
		
		if(!empty(book_id )) {
	while($row = $result->fetch_assoc()) {
		$bookid=$row['book_id'];
		echo "<tr><td><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='100px' height='150px'></td>";
    #echo "<tr><td><tr><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='100px' height='150px'></tr>";
		echo "<td>".$row['book_name']."</td>";
		echo "<td>".$row['book_price']."</td>";
		echo "<td>".$value."</td>";
		$amount= $value * $row['book_price'];		
		$total_amount = $total_amount + $value * $row['book_price'];
		echo "<td>" .$amount. "</td></tr>";
	}
}	
}
  echo "<tr><th>Total Amount (&#8377)</th><td></td><td></td><td></td><td>$total_amount</td></tr>";
	echo "</table>";
	echo "</div>";
?>
<span class="checkout"></span><a href="checkout.php?amt=<?php echo $total_amount ?> && cart_id= <?php echo $cart_id ?>" class="btn btn-info" role="button">CHECKOUT</a></span>
<?php include 'footer.php';?>
