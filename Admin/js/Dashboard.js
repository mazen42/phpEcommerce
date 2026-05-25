let ptable = $("#ProductsTable tbody");

$(function () {
	loadProducts();
});
function loadProducts() {
	setTimeout(() => {
		$("#toastee").html("");
	}, 5000);
	$(document).on("click", "#deletebtn", function () {
		deleteProduct(this);
	});
	$.ajax({
		url: "dbQueries.php",
		method: "POST",
		data: { GetAllProduct: "Get" },
		success: function (result) {
			ptable.html("");
			if (result.status == true) {
				result.data.forEach((element, index) => {
					let actions = $("<td>")
						.append(
							$("<button>")
								.attr({
									type: "button",
									"data-id": element.ProductId,
									id: "detailsbtn",
								})
								.addClass("btn btn-info")
								.html(
									`<a style="text-decoration: none; color: aliceblue;" href="ProductDetails.php?id=${element.ProductId}">Details</a>`,
								),
							$("<button>")
								.attr({
									type: "button",
									"data-id": element.ProductId,
									id: "deletebtn",
								})
								.addClass("btn btn-danger")
								.text("Delete"),
							$("<button>")
								.attr({
									type: "button",
									"data-id": element.ProductId,
									id: "Updatebtn",
								})
								.addClass("btn btn-success")
								.html(
									`<a style="text-decoration: none; color: aliceblue;" href="UpdateProduct.php?id=${element.ProductId}">Update</a>`,
								),
						)
						.css({
							display: "flex",
							gap: "4px",
						});
					ptable.append(
						$("<tr>").append(
							$("<th>")
								.attr("scope", "row")
								.text(index + 1),
							$("<td>").text(element.productName),
							$("<td>").text(element.categoryName),
							$("<td>").text(element.author),
							actions,
						),
					);
				});
			}
		},
	});
}

function deleteProduct(element) {
	let productId = $(element).attr("data-id");
	$.ajax({
		url: "dbQueries.php",
		method: "POST",
		data: { deleteProduct: productId },
		success: function (data) {
			if (data == "deleted") {
				loadProducts();
				toaster("deleted");
			} else {
				toaster(data);
			}
		},
	});
}

function toaster(text) {
	$("#toastee").html(`<div class="alert alert-success" role="alert">
  <a href="#" class="alert-link"> ${text}
</div>`);
	setTimeout(() => {
		$("#toastee").html("");
	}, 5000);
}
