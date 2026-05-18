<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

	<title>Admin Dashboard</title>
</head>

<body>
	<?php
	include "../Views/NavBar.php";
	?>
	<div style="display:flex; justify-content: center;">
		<h2>Products List</h2>
	</div>
	<button type="button" class="btn btn-success"
		style="background-color:#182D2E; border-radius:20px; margin-left:220px; text-decoration:none;padding:5px;"> <a
			style="text-decoration: none; color: aliceblue;" href="AddNewProductView.php"><i
				class="bi bi-plus-circle"></i> Add New Product</a></button>
	<table class="table" id="ProductsTable" style="width: 70%; border: solid black 2px; margin: auto; margin-top:30px;">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Category</th>
				<th scope="col">Author</th>
				<th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<div id="toastee" class="toast-container position-fixed top-0 end-0 p-3"><?php if (isset($_SESSION["notification"])) {
			echo '<div class="alert alert-success" role="alert">
  <a href="#" class="alert-link">' . $_SESSION["notification"] . '
</div>';
			unset($_SESSION["notification"]);
		} ?></div>

	</table>
	<?php
	include "../Views/footer.php";

	?>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="js/Dashboard.js"></script>
</body>

</html>