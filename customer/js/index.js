let carticon = $("#carticon");

$(function () {
	loadLocalCartIcon();
	cartCount();
	$(".card").on("click", ".addtocartbtnlocal", function () {
		addToCartLocal($(this).data("id"));
	});
	$(".card").on("click", ".addtocartbtnDB", function () {
		addToCartDB($(this).data("id"));
	});
});

// addtocartbtn.click(function () {
// 	let productid = $(this).data("id");
// 	$.ajax({
// 		url: "../dbqueries.php",
// 		method: "GET",
// 		data: { addtocart: productid },
// 		success: function (result) {},
// 	});
// });

function addToCartLocal(id) {
	let productid = id;
	if (!localStorage.getItem("products")) {
		let products = [];
		localStorage.setItem("products", JSON.stringify(products));
	}
	let cart = JSON.parse(localStorage.getItem("products")) || [];
	let check_product_exists = cart.find((element) => element.id == productid);
	if (!check_product_exists) {
		cart.push({
			id: productid,
			count: 1,
		});
		toaster(`<div class="alert alert-primary" role="alert">
					Product added to cart
				</div>`);
	} else {
		cart.forEach((element) => {
			if (element.id == productid) {
				element.count++;
			}
		});
		toaster(`<div class="alert alert-primary" role="alert">
					Product increamented into cart
				</div>`);
	}
	localStorage.setItem("products", JSON.stringify(cart));
	loadLocalCartIcon();
}
function addToCartDB(id) {
	let productid = id;
	console.log(productid);
	$.ajax({
		url: "dbqueries.php",
		datatype: "json",
		method: "GET",
		data: { productId: id },
		success: function (result) {
			toaster(result.data);
		},
	});
	cartCount();
}
function toaster(text) {
	$("#toastee").html(text);
	setTimeout(() => {
		$("#toastee").html("");
	}, 5000);
}
export function cartCount() {
	$.ajax({
		url: "dbqueries.php",
		method: "GET",
		datatype: "json",
		data: { cartCount: "" },
		success: function (result) {
			if (result.status == true) {
				carticon.text(result.data);
			}
		},
	});
}
export function loadLocalCartIcon() {
	if (localStorage.getItem("products")) {
		let cart = JSON.parse(localStorage.getItem("products")) || [];
		let count = cart.reduce((sum, item) => {
			return sum + item.count;
		}, 0);
		carticon.text(count);
	} else {
		carticon.text("0");
	}
}