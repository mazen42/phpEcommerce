let carticon = $("#carticon");
let addtocartbtnlocaldetails = $(".addtocartbtnlocaldetails");
let addtocartbtnDBdetails = $(".addtocartbtnDBdetails");
let minusbtndetails = $(".minusbtndetails");
let plusbtndetails = $(".plusbtndetails");
let countToAdd = $(".count");
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
addtocartbtnlocaldetails.click(function () {
	addToCartLocal($(this).data("id"), countToAdd.val());
});

addtocartbtnDBdetails.click(function () {
	addToCartDB($(this).data("id"), countToAdd.val());
});
minusbtndetails.click(function () {
	if (Number(countToAdd.val()) == 1) return;

	countToAdd.val(Number(countToAdd.val()) - 1);
});
plusbtndetails.click(function () {
	countToAdd.val(Number(countToAdd.val()) + 1);
});

function addToCartLocal(id, countToAdd = 1) {
	let productid = id;
	let countparam = Number(countToAdd);
	if (!localStorage.getItem("products")) {
		let products = [];
		localStorage.setItem("products", JSON.stringify(products));
	}
	let cart = JSON.parse(localStorage.getItem("products")) || [];
	let check_product_exists = cart.find((element) => element.id == productid);
	if (!check_product_exists) {
		cart.push({
			id: productid,
			count: countparam,
		});
		toaster(`<div class="alert alert-primary" role="alert">
					Product added to cart
				</div>`);
	} else {
		cart.forEach((element) => {
			if (element.id == productid) {
				element.count = countparam + Number(element.count);
			}
		});
		toaster(`<div class="alert alert-primary" role="alert">
					Product increamented into cart
				</div>`);
	}
	localStorage.setItem("products", JSON.stringify(cart));
	loadLocalCartIcon();
}
function addToCartDB(id, countparam = 1) {
	let productid = id;
	console.log(productid);
	$.ajax({
		url: "dbqueries.php",
		datatype: "json",
		method: "GET",
		data: { productId: id, count: countparam },
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
		let ids = cart.map((element) => element.id);
		$.ajax({
			url: "dbqueries.php",
			method: "POST",
			dataType: "json",
			data: { localProductsids: JSON.stringify(ids) },
			success: function (result) {
				let counter = 0;
				let cartMap = new Map();
				cart.forEach((element) => {
					cartMap.set(Number(element.id), element.count);
				});
				let newcart = [];
				result.data.forEach((element) => {
					let eid = Number(element.ID);
					if (cartMap.has(eid)) {
						counter += cartMap.get(eid);
						newcart.push({ id: eid, count: cartMap.get(eid) });
					}
				});
				localStorage.setItem("products", JSON.stringify(newcart));
				carticon.text(counter);
			},
		});
	}
}
