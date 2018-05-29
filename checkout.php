<?php
	session_start();
	$uid = $_SESSION['user_id'];
	$cart_id = $_GET['cart_id'];
	$total_amount= $_GET['amt'];
	
	$conn = new mysqli('localhost','root','root','onlinebookstore');
	if (mysqli_connect_error()) {
		die("Database connection failed:" . mysqli_connect_error());
	}
	$sql = "SELECT name,phonenum FROM user where user_id=$uid";
	$result = $conn->query($sql);	
			
		if(!empty ($uid)) { 
		echo "<table>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td> NAME:".$row['name']."</td></tr>";
			echo "<tr><td> Phone num:".$row['phonenum']."</td></tr>";			
		} 
		echo "</table>";
		
	}
	
?>
<form method="post" action="" enctype="multipart/form-data">
		<table class="table">
			<tr>
				<th>Address</th>
				<td><input type="text" name="address" size="100" required></td>
			</tr>
			<tr>
				<th>Amount Payable:</th>
				<td><input type="text" name="amount" value=<?php echo $total_amount?>  size="10" disabled></td>
			</tr>
		</table>
		<script>
			document.write("Date: ")
			var currentDate = new Date(),
      day = currentDate.getDate(),
      month = currentDate.getMonth() + 1,
      year = currentDate.getFullYear();
	var d = document.write(day + "/" + month + "/" + year);
</script>
	

<a href ="cart_view.php" button type="button" class="cancelbtn">Cancel Order</button>
<input type="submit" name="order" value="Place Order" onclick="location.php = order.php"class="btn btn-primary">
</form><br>

<?php
$address=$_POST['address'];
if(!empty($_POST['order'])){
	$sql1 = "UPDATE cart SET status=1 WHERE user_id=$uid";
	$conn->query($sql1);
	
	$sql2 = "INSERT INTO order_table (cart_id, address, amount) VALUES ($cart_id,'$address',$total_amount)";
	$result2 =$conn->query($sql2);
	if(!empty ($address)){
	header("Location: order.php");
}
}
<?php
	$sql3 = "SELECT order_id FROM order_table where user_id=$uid";
	$result = $conn->query($sql3);		
?>
$to      = $email;
	$subject = "Invoice";
	$message = "Hello '.$name.', Thank you for shopping from buybook.com, your order id is '..' And Password is '.$password.'";
	$headers = 'From: saurabh.kanva@webaccessglobal.com' . "\r\n" .
			'Reply-To: saurabh.kanva@webaccessglobal.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
?>





