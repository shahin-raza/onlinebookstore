<?php
session_start();
if (isset($_SESSION['user_id']) && ($_SESSION['user_id']=='admin')) {
	 include 'nav_admin.php';
  }
  else{
    header("Location: index.php");
  }
?>
<div class="container">
<center><h1>Welcome to Admin panel</h1></center>
<div class="admin-wel">
     <div class="admin-box"><a href="admin_view.php"><img src="resources/viewbook.png" height="190px" width="190px"/></a></div>
     <div class="admin-box"><a href="add_book.php"><img src="resources/addbook.png" height="190px" width="190px"/></a></div>
     <div class="admin-box"><a href="order_admin.php"><img src="resources/orders.jpeg" height="190px" width="190px"/></a></div>
     <div class="admin-box"><a href="add_cat.php"><img src="resources/category.png" height="190px" width="190px"/></a></div>
</div>
</div>
<?php include 'footer.php'; ?>
