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
		foreach($_POST as $key => $value){
		$sql1= "SELECT book_name,book_img,book_price from books where book_id =$key";
		$result = $conn->query($sql1);
		//~ print_r($result); exit;
		
		if(!empty(book_id )) {
		echo "<table>";
	while($row = $result->fetch_assoc()) {
		$bookid=$row['book_id'];
		#echo "<tr><td><tr><img src='http://192.168.2.126/onlinebookstore/book_img/{$row['book_img']}' width='100px' height='150px'></tr>";
        echo "<tr><td><tr><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='100px' height='150px'></tr>";
		echo "<tr>".$row['book_name']."</tr>";
		echo "<tr>".$row['book_price']."</tr>";
		$amount= $value * $row['book_price'];		
		$total_amount = $total_amount + $value * $row['book_price'];
		echo "<tr>" .$amount. "</tr></td></tr>";
	}
	echo "</table>";
}	
}
echo $total_amount;
?>
<form action="" method="post"><a href="checkout.php?amt=<?php echo $total_amount ?> && cart_id= <?php echo $cart_id ?>" role="button">Checkout</a>
<?php include 'footer.php';?>
