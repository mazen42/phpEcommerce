<?php
$pageTitle = "Home";
include "common/Header.php";
$sql_products = "SELECT p.ID, p.listprice, p.price, p.name as productname, p.imageurl,c.name as categoryname FROM products p join categories c on p.categoryid = c.id";
$sql_run = mysqli_query($conn, $sql_products);
?>
<section style="background-color: #eee;">
	<div id="toastee" class="position-fixed bottom-0 end-0 p-3"></div>
	<div class="container py-5">
		<div class="row">
			<!--  -->
			<?php
			while ($row = mysqli_fetch_assoc($sql_run)) {
				$productname = $row["productname"];
				$img = "/newecommerce/uploads/" . $row["imageurl"];
				$listprice = $row["listprice"];
				$price = $row["price"];
				$categoryname = $row["categoryname"];
				$productId = $row["ID"];
				$addtocartbtn = '<button type="button" data-id = "' . $productId . '" class="btn btn-primary addtocartbtnlocal">add to cart</button></a>';
				if (isset($_SESSION["customerid"]) && !empty($_SESSION["customerid"])) {
					$addtocartbtn = '<button type="button" data-id = "' . $productId . '" class="btn btn-primary addtocartbtnDB">add to cart</button></a>';
				}
				echo '<div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
				<div class="card">
					<img id="productimage" src=' . $img . '
						class="card-img-top" alt="' . $categoryname . '" />
					<div class="card-body">
						<div class="d-flex justify-content-between">
							<p class="small"><a href="#!" id="productcategory" class="text-muted">' . $categoryname . '</a></p>
							<p class="small text-danger" id="productlistprice"><s>$' . $listprice . '</s></p>
						</div>

						<div class="d-flex justify-content-between mb-3">
							<h5 class="mb-0" id="productname">' . $productname . '</h5>
							<h5 class="text-dark mb-0" id="productprice">' . $price . '</h5>
						</div>
						' . $addtocartbtn . '
						<button type="button" id = "detailsbtn" style="margin-left: 200px;" id = "detailsbtn" class="btn btn-info">Details</button>
					</div>
				</div>
			</div>
			';
			}

			?>

			<!--  -->
		</div>
	</div>
</section>
<?php
include "common/footer.php";
?>