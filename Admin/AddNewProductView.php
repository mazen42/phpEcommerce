<?php
$pageTitle = "Add New Product";
include "../Views/Header.php";

?>

<div class="container mt-5">
	<div class="row">
		<!-- Product Image Upload -->
		<div class="col-md-6 mb-4">
			<img src="#" alt="Preview" class="img-fluid rounded mb-3" id="previewImage">
			<input type="file" id="Image" class="form-control" onchange="previewFile(event)">
		</div>
		<!-- Product Details Form -->
		<div class="col-md-6">
			<h2 class="mb-3">Add New Product</h2>
			<form>
				<div class="mb-3">
					<label class="form-label">Product Title</label>
					<input type="text" id="name" class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">Author</label>
					<input type="text" id="Author" class="form-control" placeholder="Enter product name">
				</div>
				<div class="mb-3">
					<label class="form-label">List Price</label>
					<input type="number" id="listPrice" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price</label>
					<input type="number" id="price" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price50</label>
					<input type="number" id="price50" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Price100</label>
					<input type="number" id="price100" class="form-control" placeholder="$0.00">
				</div>
				<div class="mb-3">
					<label class="form-label">Category</label>
					<select class="form-select" id="category" aria-label="Default select example">
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label">Description</label>
					<textarea class="form-control" id="Description" rows="3"></textarea>
				</div>
				<button type="submit" id="submitAddProduct" style="width: 300px; margin-bottom:10px;"
					class="btn btn-primary"><i class="bi bi-cart-plus"></i> Save Product</button>

				<div id="toasteAddProduct" class="toast-container position-fixed top-0 end-0 p-3">
				</div>

		</div>
		</form>
	</div>
</div>
</div>

<?php
include "../Views/footer.php";
?>