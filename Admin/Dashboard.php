<?php
$pageTitle = "Dashboard";
include "./common/Header.php";
if (!isset($_SESSION["adminid"]) && empty($_SESSION["adminid"])) {
	header("Location: LoginView.php");
}


?>
<div style="display:flex; justify-content: center;">
	<h2>Products List</h2>
</div>
<button type="button" class="btn btn-success"
	style="background-color:#182D2E; border-radius:20px; margin-left:220px; text-decoration:none;padding:5px;"> <a
		style="text-decoration: none; color: aliceblue;" href="AddNewProductView.php"><i class="bi bi-plus-circle"></i>
		Add New Product</a></button>
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
include "./common/footer.php";

?>