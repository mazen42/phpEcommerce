<?php
$pageTitle = "Update Product";
include "../Views/Header.php";
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = htmlspecialchars($_POST["name"], ENT_QUOTES);
	$productId = $_POST["ProductId"];
	$description = htmlspecialchars($_POST["description"], ENT_QUOTES);
	$author = htmlspecialchars($_POST["author"], ENT_QUOTES);
	$listPrice = $_POST["listprice"];
	$price = $_POST["price"];
	$price50 = $_POST["price50"];
	$price100 = $_POST["price100"];
	$categoryid = $_POST["category"];
	$previousImageurl = $row["IMAGEURL"];
	if (empty($name) || empty($description) || empty($author) || empty($listPrice) || empty($price) || empty($price50) || empty($price100) || empty($categoryid)) {
		$alertResult = alert("some filed is empty");
		echo $alertResult["data"];
		exit;
	}
	if (empty($_FILES["image"]["tmp_name"])) {
		$sql = "UPDATE products SET AUTHOR = '$author', CATEGORYID = '$categoryid', DESCRIPTION = '$description',LISTPRICE = '$listPrice', NAME = '$name', PRICE = '$price', PRICE50 = '$price50', PRICE100 = '$price100' where ID = '$productId'";
		$sql_run = mysqli_query($conn, $sql);
	} else {
		$imagePath = "C:/xampp/htdocs/NewEcommerce/uploads/" . $previousImageurl;
		$deleteImageResult = deleteImageFromServer($imagePath);
		if ($deleteImageResult['status'] == true) {
			$newImagePath = AddImageToserver("C:/xampp/htdocs/NewEcommerce/uploads/", $_FILES["image"]);
			if ($newImagePath['status'] == true) {
				$newImagename = $newImagePath['data'];
				$sql = "UPDATE products SET AUTHOR = '$author', CATEGORYID = '$categoryid',IMAGEURL = '$newImagename', DESCRIPTION = '$description',LISTPRICE = '$listPrice', NAME = '$name', PRICE = '$price', PRICE50 = '$price50', PRICE100 = '$price100' where ID = '$productId'";
				$sql_run = mysqli_query($conn, $sql);
			}
		}

	}
	$_SESSION["notification"] = "Update";
	header("Location: Dashboard.php");
	exit();
}
?>
<div class="container mt-5">
	<div class="row">
		<!-- Product Image Upload -->
		<div class="col-md-6 mb-4">
			<input type="file" form="myForm" id="Image" name="image" class="form-control mb-2"
				onchange="previewFile(event)">
			<img src="<?= "http://localhost:8080/NewEcommerce/uploads/" . $row["IMAGEURL"] ?>" alt="Preview"
				class="img-fluid rounded mb-3" id="previewImage">
		</div>
		<!-- Product Details Form -->
		<div class="col-md-6">
			<h2 class="mb-3">Update Product</h2>
			<form method="POST" enctype="multipart/form-data" id="myForm">
				<input type="number" name="ProductId" value="<?= $row["ProductId"] ?>" hidden>
				<div class="mb-3">
					<label class="form-label">Product Title</label>
					<input type="text" id="namedetails" name="name" value="<?php echo $row["productName"]; ?>"
						class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">Author</label>
					<input type="text" id="Authordetails" name="author" value="<?php echo $row["author"]; ?>"
						class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">List Price</label>
					<input type="number" id="listPricedetails" name="listprice" value="<?php echo $row["LISTPRICE"]; ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price</label>
					<input type="number" id="pricedetails" name="price" value="<?php echo $row["PRICE"]; ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price50</label>
					<input type="number" id="price50details" name="price50" value="<?php echo $row["PRICE50"]; ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price100</label>
					<input type="number" id="price100details" name="price100" value="<?= $row["PRICE100"] ?>"
						class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Category</label>
					<select class="form-select" name="category" id="categoryDetails"
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
					<textarea class="form-control" id="Descriptiondetails" name="description"
						rows="3"><?= $row["description"] ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary mb-2 w-25">Update</button>
		</div>

	</div>
	</form>
</div>
</div>
</div>
<?php
include "../Views/footer.php";
?>