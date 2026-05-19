<?php
$pageTitle = "Product Details";
include "common/Header.php";

if (isset($_GET["id"])) {
	$id = $_GET["id"];
	$sql = "SELECT ID AS ProductId, NAME AS productName , AUTHOR AS author, DESCRIPTION AS description,
    LISTPRICE, PRICE, PRICE50, PRICE100, CATEGORYID,IMAGEURL FROM products WHERE ID = '$id' LIMIT 1";
	$sql_run = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($sql_run);
	if (!$row) {
		header("Location: Dashboard.php");
		exit();
	}
	$categorySql = "SELECT * FROM categories";
	$categorySql_run = mysqli_query($conn, $categorySql);
}
?>
<div class="container mt-5">
	<div class="row">
		<!-- Product Image Upload -->
		<div class="col-md-6 mb-4">
			<img src="<?= "http://localhost:8080/NewEcommerce/uploads/" . $row["IMAGEURL"] ?>" alt="Preview"
				class="img-fluid rounded mb-3" id="previewImage">
		</div>
		<!-- Product Details Form -->
		<div class="col-md-6">
			<h2 class="mb-3">Product Details</h2>
			<form method="POST">
				<div class="mb-3">
					<label class="form-label">Product Title</label>
					<input type="text" id="namedetails" disabled name="name" value="<?php echo $row["productName"]; ?>"
						class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">Author</label>
					<input type="text" id="Authordetails" disabled name="author" value="<?php echo $row["author"]; ?>"
						class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">List Price</label>
					<input type="number" id="listPricedetails" disabled name="listprice"
						value="<?php echo $row["LISTPRICE"]; ?>" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price</label>
					<input type="number" id="pricedetails" disabled name="price" value="<?php echo $row["PRICE"]; ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price50</label>
					<input type="number" id="price50details" disabled name="price50"
						value="<?php echo $row["PRICE50"]; ?>" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price100</label>
					<input type="number" id="price100details" disabled name="price100" value="<?= $row["PRICE100"] ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Category</label>
					<select class="form-select" disabled name="category" disabled id="categoryDetails"
						aria-label="Default select example">
						<?php
						while ($Categories_rows = mysqli_fetch_assoc($categorySql_run)) {
							$id = $Categories_rows["ID"];
							$name = $Categories_rows["NAME"];
							if ($id == $row["CATEGORYID"]) {
								echo "<option value = '$id' selected>$name</option>";
							} else {
								echo "<option value = '$id'>$name</option>";
							}


						}

						?>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label">Description</label>
					<textarea disabled class="form-control" id="Descriptiondetails" name="description"
						rows="3"><?= $row["description"] ?></textarea>
				</div>
		</div>

	</div>
	</form>
</div>
</div>
</div>
<?php
include "common/footer.php"
	?>