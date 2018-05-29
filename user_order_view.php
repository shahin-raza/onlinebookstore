<?php
session_start();
if (isset($_SESSION['user_id'])) {
	include 'nav_home.php';
}else{
    header("Location: index.php");
  }

if (!empty ($_GET['uid'])) { 
	$uid = $_GET['uid'];
}
else {
	$uid = $_SESSION['user_id'];
}

require('db.php');
$sql2 = "SELECT cart_id FROM cart WHERE user_id = $uid AND status=1";
$result1 = $conn->query($sql2);
while ($row = $result1->fetch_assoc()) {			
	$cart_id[] = $row['cart_id'];
}
$empty_order = 0;
$bid = array();
echo "<table class='table'>";
echo "<tr class='info'><th>Book</th><th>Name</th><th>Price</th><th>Quantity</th><th>OrderID</th><th>Total Amount</th><th>Order Date</th></tr>"; 
foreach($cart_id as $id) {
	echo "<div class='container'>";
	$sql = "SELECT book_id FROM cart_data where cart_id = $id ";
	$result = $conn->query($sql);
	
	if (!empty($result->num_rows > 0)) {
		while($row = $result->fetch_assoc()) {			
		$bookid=$row['book_id'];		
		$sqlb = "SELECT * FROM books WHERE book_id IN ('$bookid')";
		$results = $conn->query($sqlb);	

		$sql2 = "SELECT quantity FROM cart_data WHERE cart_id=$id and book_id=".$row['book_id']."";
		$result2 = $conn->query($sql2);

		$sql3 = "SELECT * from order_table where cart_id=$id";
		$result3 = $conn->query($sql3);
		 
		if(!empty ($bookid)) { 
			while($row = $results->fetch_assoc()) {
				#echo "<tr><td><img src='http://192.168.2.126/onlinebookstore/book_img/{$row['book_img']}' width='75px' height='100px'></td>";
				echo "<tr><td><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='75px' height='100px'></td>";
				echo "<td>".$row['book_name']."</td>";
				echo "<td>".$row['book_price']."</td>";
			while($row = $result2->fetch_assoc()) {
			echo "<td>".$row['quantity']."</td>";
		}
			}
		}
		else{
			echo"you have not ordered anything";
			exit();
		 }
		}
		while($row = $result3->fetch_assoc()) {
			echo "<td>".$row['order_id']."</td>";
			echo "<td>".$row['amount']."</td>";
			echo "<td>".$row['odate']."</td>";
		}	
		}
		else {
			$empty_order = 1;
			
		}
	}
	
	if ($empty_order == 1) {
		echo 'No order found';
	}
		echo "</table>";
	echo "</div>";
?>
<?php include 'footer.php'; ?>
