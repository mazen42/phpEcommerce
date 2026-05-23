<?php
$pageTitle = "Product Details";
include "common/Header.php";

if (!empty($_GET["id"])) {
	$productid = $_GET["id"];
	$sql_get_product = "SELECT p.ID as id, p.IMAGEURL AS img, p.LISTPRICE as listprice, p.PRICE as price, p.PRICE50 as price50, p.PRICE100 as price100, p.NAME as productname,p.DESCRIPTION as description,c.name as categoryname from products p join categories c on p.categoryid = c.id where p.id = $productid";
	$sql_get_product_run = mysqli_query($conn, $sql_get_product);
	$row = mysqli_fetch_assoc($sql_get_product_run);
	$addtocartbtn = '<a><button type="button" data-id = "' . $productid . '" class="btn btn-primary btn-lg px-5 addtocartbtnlocaldetails">add to cart</button></a>';
	if (isset($_SESSION["uid"]) && !empty($_SESSION["uid"])) {
		$addtocartbtn = '<a><button type="button" data-id = "' . $productid . '" class="btn btn-primary btn-lg px-5  addtocartbtnDBdetails">add to cart</button></a>';
	}
}
?>
<div class="container py-5">

	<div class="card border-0 shadow-lg rounded-4 p-4">

		<div class="row g-5">

			<!-- PRODUCT IMAGE -->
			<div class="col-md-5">

				<img src="<?= "/newecommerce/uploads/" . $row["img"] ?>" class="img-fluid rounded-4 w-100"
					style="height:500px; object-fit:cover;">

			</div>

			<!-- PRODUCT DETAILS -->
			<div class="col-md-7 d-flex flex-column justify-content-between">

				<div>

					<!-- TITLE -->
					<h1 class="fw-bold mb-3">
						<?= $row["productname"] ?>
					</h1>

					<!-- DESCRIPTION -->
					<p class="text-muted fs-5 mb-4">
						<?= $row["description"] ?>
					</p>

					<hr>

					<!-- PRICES -->
					<div class="mb-4">

						<div class="d-flex justify-content-between mb-2">
							<span class="text-muted fs-5">
								List Price
							</span>

							<span class="text-decoration-line-through text-danger fs-5">
								<?= $row["listprice"] ?> EGP
							</span>
						</div>

						<div class="d-flex justify-content-between mb-2">
							<span class="text-muted fs-5">
								Price
							</span>

							<span class="fw-bold text-success fs-4">
								<?= $row["price"] ?> EGP
							</span>
						</div>

						<div class="d-flex justify-content-between mb-2">
							<span class="text-muted fs-5">
								Price (50+)
							</span>

							<span class="fw-bold text-primary fs-5">
								<?= $row["price50"] ?> EGP
							</span>
						</div>

						<div class="d-flex justify-content-between">
							<span class="text-muted fs-5">
								Price (100+)
							</span>

							<span class="fw-bold text-purple fs-5">
								<?= $row["price100"] ?> EGP
							</span>
						</div>

					</div>

					<hr>

					<!-- QUANTITY -->
					<div class="mt-4">

						<h5 class="mb-3">
							Quantity
						</h5>

						<div class="d-flex align-items-center">

							<button class="btn btn-outline-secondary minusbtndetails" data-id="<?= $productid ?>">
								-
							</button>

							<input type="text" class="form-control text-center mx-3 count" value="1"
								style="width:80px;">

							<button class="btn btn-outline-secondary plusbtndetails" data-id="<?= $productid ?>">
								+
							</button>

						</div>

					</div>

				</div>

				<!-- BUTTONS -->
				<div class="mt-5 d-flex gap-3">
					<?= $addtocartbtn ?>
				</div>

			</div>

		</div>

	</div>

</div>


<?php

include "common/footer.php";
?>