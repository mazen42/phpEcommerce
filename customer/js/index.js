let carticon = $("#carticon");
let addtocartbtnlocaldetails = $(".addtocartbtnlocaldetails");
let addtocartbtnDBdetails = $(".addtocartbtnDBdetails");
let minusbtndetails = $(".minusbtndetails");
let plusbtndetails = $(".plusbtndetails");
let countToAdd = $(".count");
let search = $(".search-input");
let mainRow = $(".mainrow");
let searchResults = $("#searchResults");
let addToCartLinkvalue = $("#addToCartLink").attr("value");
$(function () {
	loadLocalCartIcon();
	cartCount();
});
$(".card").on("click", ".addtocartbtnlocal", function () {
	addToCartLocal($(this).data("id"));
});
$(".card").on("click", ".addtocartbtnDB", function () {
	addToCartDB($(this).data("id"));
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
search.on("blur", function () {
	setTimeout(() => {
		searchResults.hide();
	}, 200);
});
search.on("focus", function () {
	searchResults.show();
});
search.on("input", function () {
	clearTimeout(timeout);
	let val = $(this).val().trim();
	var timeout = setTimeout(() => {
		if (val.length >= 3) {
			$.ajax({
				url: "dbqueries.php",
				method: "POST",
				dataType: "json",
				data: { searchnames: val },
				success: function (result) {
					searchResults.html("");
					result.data.forEach((element) => {
						let content = `
						<a href="productssearched.php?searchedname=${element.productname}" class="list-group-item list-group-item-action">
							${element.productname}
						</a>`;
						searchResults.append(content);
					});
				},
			});
		} else {
			searchResults.html("");
		}
	}, 300);
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
			error: function () {
				carticon.text("0");
			},
		});
	}
}

// function loadSearchData(elements) {
// 	elements.forEach((data) => {
// 		let addToCartTag = `<button type="button" data-id = "${data.id}" class="btn btn-primary ${addToCartLinkvalue == 0 ? "addtocartbtnlocal" : "addtocartbtnDB"}">add to cart</button></a>`;
// 		let content = `

// 		<div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
// 				<div class="card"><div class="card">
// 					<img id="productimage" src='/newecommerce/uploads/${data.imageurl}'
// 						class="card-img-top" alt="${data.categoryname}" />
// 					<div class="card-body">
// 						<div class="d-flex justify-content-between">
// 							<p class="small"><a href="#!" id="productcategory" class="text-muted">${data.categoryname}</a></p>
// 							<p class="small text-danger" id="productlistprice"><s>$${data.listprice}</s></p>
// 						</div>

// 						<div class="d-flex justify-content-between mb-3">
// 							<h5 class="mb-0" id="productname">${data.productname}</h5>
// 							<h5 class="text-dark mb-0" id="productprice">${data.price}</h5>
// 						</div>
// 						${addToCartTag}

// 						<a href="productdetails.php?id=${data.id}"><button type="button" id = "detailsbtn" style="margin-left: 200px;" id = "detailsbtn" class="btn btn-info">Details</button></a>
// 					</div>
// 				</div>
// 				</div>
// 				</div>`;
// 	});
// 	searchedrow.html("");
// 	searchedrow.append(content);
// 	searchedrow;
// 	mainRow.hide();
// }
