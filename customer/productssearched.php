<?php
include "common/Header.php";
if (!empty($_GET["searchedname"])) {
	$word = $_GET["searchedname"];
	$sql_get_products = "SELECT p.ID, p.price, p.name as productname, p.imageurl,c.name as categoryname,p.description FROM products p join categories c on p.categoryid = c.id where p.name LIKE '%$word%'";
	$sql_get_products_run = mysqli_query($conn, $sql_get_products);
}

?>
<div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
	<div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
		<?php
		while ($row = mysqli_fetch_assoc($sql_get_products_run)) {
			$image = $row["imageurl"];
			$name = $row["productname"];
			$price = $row["price"];
			$id = $row["ID"];
			$description = $row["description"];
			$cuttedDescription = substr($description, 0, 15);
			echo '<div class="col hp">
			<div class="card h-100 shadow-sm">
				<a target="_blank" href="https://amzn.to/3qeS1Fe">
					<img src="http://localhost:8080/newecommerce/uploads/' . $image . '" class="card-img-top"
						alt="product.title" />
				</a>
				<div class="card-body">
					<div class="clearfix mb-3">
						<span class="float-start badge rounded-pill bg-success">' . $price . '</span>

						<span class="float-end"><a href="#"
								class="small text-muted text-uppercase aff-link">reviews</a></span>
					</div>
					<div style="width:100px; color:black; fontsize:9px; font-weight:bold; margin-bottom:10px">' . $name . '</div>
					<h5 class="card-title">
						' . $cuttedDescription . '
					</h5>

					<div class="d-grid gap-2 my-4">

						<a href="productDetails.php?id=' . $id . '" class="btn btn-warning bold-btn">Details</a>

					</div>
					<div class="clearfix mb-1">

						<span class="float-start"><a href="#"><i class="fas fa-question-circle"></i></a></span>

						<span class="float-end">
							<i class="far fa-heart" style="cursor: pointer"></i>

						</span>
					</div>
				</div>
			</div>
		</div>';
		}
		?>

	</div>
</div>

<?php
include "common/footer.php";
?>