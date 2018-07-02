<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		include 'nav_admin.php';
	} else{
			header("Location: index.php");
		}

	if (!empty ($_GET['uid'])) { 
		$uid = $_GET['uid'];
	} else {
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

	foreach($cart_id as $id) {
		echo "<div class='container'>";
		$sql = "SELECT book_id FROM cart_data where cart_id = $id ";
		$result = $conn->query($sql);
	
		if (!empty($result->num_rows > 0)) {
			while($row = $result->fetch_assoc()) {			
				$bookid=$row['book_id'];		
				$sqlb = "SELECT user_id,book_img,`book_name`,`book_price`,quantity,order_id,amount,odate,order_table.cart_id FROM books JOIN cart_data ON books.book_id = cart_data.book_id JOIN order_table ON cart_data.cart_id = order_table.cart_id JOIN cart ON cart_data.cart_id = cart.cart_id where cart.user_id = $uid and cart.status =1 order by `order_id` DESC";
				$results = $conn->query($sqlb);	
				$total_amount = 0;
				$odate = '';
				$order_id = array();
				if(!empty ($bookid)) { 
					while($row = $results->fetch_assoc()) {
						$sqlc = "SELECT `order_id`,`amount`,odate from order_table where cart_id = $row[cart_id]";					
						$resultc = $conn->query($sqlc);
						$total_amount = $row['amount'];
						$odate = $row['odate'];
						if (!in_array($row['order_id'],$order_id['order_details'])) {
							$order_id['order_details']['order_id'] = $row['order_id'];
							$order_id['order_details']['odate'] = $row['odate'];
							$order_id['order_details']['total_amount'] = $row['amount'];
							print_total($order_id);
						}					
						echo "<tr><td><img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='75px' height='100px'></td>";
						echo "<td>".$row['book_name']."</td>";
						echo "<td>".$row['book_price']."</td>";
						echo "<td>".$row['quantity']."</td>";
					}
				}
					$order_date = array();
					while($row = $result3->fetch_assoc()) {
						echo "<td>".$row['order_id']."</td>";;
					}	
			}
		}
	}	
	function print_total($row) {
		echo "<tr><td>Order ID: ".$row['order_details']['order_id']."</td>";
		echo "<td>Order Date: ".$row['order_details']['odate']."</td>";
		echo "<td>Total Amount: ".$row['order_details']['total_amount']."</td></tr>";
		echo "<tr class='info'><th>Book</th><th>Name</th><th>Price</th><th>Quantity</th></tr>"; 
	}	
	echo "</table>";
	echo "</div>";
?>
<?php include 'footer.php'; ?>
