<?php
  include 'nav_home.php';
	if(!isset($_SESSION)) { 
        session_start(); 
    } 
	$uid = $_SESSION['user_id'];
	$cart_id = $_GET['cart_id'];
	$total_amount= $_GET['amt'];
	
	$conn = new mysqli('localhost','root','root','onlinebookstore');
	if (mysqli_connect_error()) {
		die("Database connection failed:" . mysqli_connect_error());
	}
	$sql = "SELECT name,phonenum,email,address FROM user where user_id=$uid";
	$result = $conn->query($sql);	
			
		if(!empty ($uid)) { 
		echo "<table class='table'>";
		while($row = $result->fetch_assoc()) {			
			echo "<tr><td> Name: ".$row['name']."</td></tr>";
			echo "<tr><td> Email id: ".$row['email']."</td></tr>";
			echo "<tr><td> Phone number: ".$row['phonenum']."</td></tr>";
			$user_email = $row['email'];
			$name = $row['name'];
			$address1=$row['address'];
		} 
		echo "</table>";
		
	}	
?>
<form method="post" action="" enctype="multipart/form-data">
		<table class="table2">
			<tr>
				<th> Enter address</th>
				<td><input type="text" name="address" class="address" size="100" required value=<?php echo $address1 ?> ></td>
			</tr>
			<tr>
				<th>Amount payable (&#8377):</th>
				<td><input type="text" name="amount" class="amount" value=<?php echo $total_amount?>  size="10" disabled></td>
			</tr>
		</table>
		<script>
			document.write("Date: ")
			var currentDate = new Date(),
      day = currentDate.getDate(),
      month = currentDate.getMonth() + 1,
      year = currentDate.getFullYear();
	var d = document.write(day + "/" + month + "/" + year);
		</script><br>
	<center></center>
<input type="submit" name="order" value="Confirm order" class="btn btn-info">
</form><br>

<?php
	$address = $_POST['address'];
	if(!empty($_POST['order'])) {
		$sql1 = "UPDATE cart SET status=1 WHERE user_id=$uid";
		$conn->query($sql1);
		$sql7 = "UPDATE user SET address='$address' WHERE	user_id=$uid";
		$conn->query($sql7);	
		$sql2 = "INSERT INTO order_table (cart_id, address, amount) VALUES ($cart_id,'$address',$total_amount)";
		$result2 =$conn->query($sql2);
		$sql6 = "SELECT order_id FROM order_table ORDER BY order_id DESC LIMIT 1"; 
		$result6 =$conn->query($sql6);
		$order_id = $result6->fetch_assoc();		
		$sql3="SELECT book_id,quantity from cart_data where cart_id=$cart_id";
		$result3 =$conn->query($sql3);		
		while($row = $result3->fetch_assoc()) {
			$book[] = $row['book_id'];
			$bidquan[$row['book_id']] = $row['quantity'];
		}			
		$ids = join("','",$book);
		$sql4="SELECT book_id, book_name, book_price from books where book_id IN ('$ids')";
		$result4 =$conn->query($sql4);		
		$mess .= null;
		$mess .= "<table class='table'><tr><th>Book Name</th><th>Price</th><th>Quantity</th><th>OrderID</th><th>Order Date</th><th>Amount</th></tr>";
		while($row = $result4->fetch_assoc()) {
			$odate = date("Y/m/d");
			$bname=$row['book_name'];
			$bprice=$row['book_price'];
			$bid=$row['book_id'];
			$quant = $bidquan[$bid];			
			$mess .= "<tr><td>$bname</td><td>$bprice</td><td>$quant</td><td>".$order_id['order_id']."</td><td>$odate</td><td>".$bprice*$quant."</td></tr>";
		}
		$mess .= "<tr><th>Total Amount</th><td></td><td></td><td></td><td></td><td>$total_amount</td></tr></table>"; 
		//~ print_r($mess); exit;
		header("Location: order.php");
	}
?>
<?php
if(!empty($_POST['order'])) {
		include 'nav_home.php';
		$to = $user_email;
		$subject = "Invoice";
		$message = "
		<html>
		<head>
		<title>HTML email</title>
		</head>
		<body>
		<p> Hello $name, </p>
		<p>Thank you for shopping with us, here is your invoice</p>
		<table class='table'>
		<tr><td>$mess</td></tr>
		</table>
		<br>
		<br>
		<p>Regards,</p>
		<p>TheBookStore.com</p>
		</body>
		</html>";
		$headers  = 'From: TheBookStore.com' . "\r\n" .
								'Reply-To: Do Not Reply' . "\r\n" .
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
		mail($to,$subject,$message,$headers);
}	
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
include 'footer.php';
?>




