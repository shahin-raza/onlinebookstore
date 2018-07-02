<?php include 'nav_home.php';?>
<form action="form.php" method="post">
	Search Book: <input type="text" name="term" placeholder="Search by name, category, language, author, publisher"  size= 75/>
	<input type="submit" value="Search" /> 
</form>     
<?PHP
	echo "<div class='container'>";
	
	if (!empty($_POST['term'])) {
		$term = $_POST['term'];
		require('db.php');
		$sql1 = "SELECT * FROM books WHERE book_name LIKE '%".$term."%' OR book_author LIKE '%".$term."%' OR book_language LIKE '%".$term."%' OR book_category  LIKE '%".$term."%' OR book_publisher  LIKE '%".$term."%'";
		$result3 = $conn->query($sql1);	
		echo "<div class='container-fluid'>";
		echo "<div class='row'>";
		while($row = $result3->fetch_assoc()) {
			$bookid=$row['book_id'];
			echo "<div class='col'>";
			echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
			echo $row['book_name'];
			echo "<br> Price : &#8377 ".$row['book_price']."<br><button type='button' class='btn btn-info'><a href='login.php'>Add to cart</a></button>";
			echo "</div>";
		}
		echo "</div>";
	}
	else {
		require('db.php');
		$sqlb = "SELECT * FROM books";
		$results = $conn->query($sqlb);
		echo "<div class='book_container'>";
		if(!isset($_SESSION)) { 
            session_start(); 
        } 
			 $_SESSION['x'];
			if(isset($_SESSION['x'])) {
				?>
				<html>
				<head>
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<style>
				.alert {
						padding: 2px;
						background-color: green;
						color: white;
				}

				.closebtn {
						margin-left: 5px;
						color: white;
						font-weight: bold;
						float: right;
						font-size: 15px;
						line-height: 20px;
						cursor: pointer;
						transition: 0.3s;
				}

				.closebtn:hover {
						color: black;
				}
				</style>
				</head>
				<body>
				<div class="alert">
					<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					Book added to cart
				</div>
				</body>
				</html>
			<?php }
			unset($_SESSION['x']);
		while($row = $results->fetch_assoc()) {		
			$bookid=$row['book_id']; 
			echo "<div class='book_img'>";
			echo "<img src='http://localhost/onlinebookstore/book_img/{$row['book_img']}' width='190px' height='180px'><br>";
			echo $row['book_name'];
			echo "<br> Price : &#8377 ".$row['book_price']."<br><button type='button' id = 'myBtn' class='btn btn-info'><a href='cart.php?bid=$bookid'role='button'>Add to cart</a></button>";
			echo "</div>";
		}
		echo "</div>";
	}
	echo "</div>";
	include 'footer.php';
?>   

