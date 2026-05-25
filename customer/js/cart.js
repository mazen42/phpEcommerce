import { cartCount, loadLocalCartIcon } from "./index.js";
let cardslist = $("#colToAppend");
let total = $("#totally");

$(function () {
	loadCartTotally();
});

function loadCartData(data) {
	let products = data;
	cardslist.text("");
	products.forEach((product) => {
		let card = `<div class="card shadow-sm mb-3 border-0 p-3 rounded-4">
    <div class="row align-items-center">
        <!-- IMAGE -->
        <div class="col-md-2 text-center">
            <img src="http://localhost:8080/newecommerce/uploads/${product.img}" 
                 class="img-fluid rounded-4"
                 style="height:120px;width:120px;object-fit:cover;">
        </div>

        <!-- PRODUCT INFO -->
        <div class="col-md-4">
            <h3 class="fw-bold mb-3">${product.name}</h3>

            <div class="d-flex justify-content-between">
                <span class="text-muted">List Price:</span>
                <span>${product.listprice} EGP</span>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-muted">Price:</span>
                <span class="text-success fw-bold">${product.price} EGP</span>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-muted">Price (50+):</span>
                <span class="text-primary fw-bold">${product.price50} EGP</span>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-muted">Price (100+):</span>
                <span class="text-purple fw-bold">${product.price100} EGP</span>
            </div>
        </div>

        <!-- QUANTITY -->
        <div class="col-md-3 text-center">
            <h5 class="mb-3">Quantity</h5>

            <div class="d-flex justify-content-center align-items-center">

                <button class="btn btn-outline-secondary minusbtn"
                        data-id="${product.id}">
                    -
                </button>

                <input type="text"
                       value="${product.count}"
                       class="form-control text-center mx-2" readonly
                       style="width:70px;">

                <button class="btn btn-outline-secondary plusbtn"
                        data-id="${product.id}">
                    +
                </button>

            </div>

            <div class="mt-3">
                <span class="badge bg-primary p-2 fs-6">
                    Subtotal: ${product.total} EGP
                </span>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="col-md-3 text-center">

            <h4 class="text-muted">Total</h4>

            <h1 class="fw-bold">
                ${product.total} EGP
            </h1>

            <button class="btn btn-danger mt-3 deletebtn"
                    data-id="${product.id}">

                <i class="fa-solid fa-trash"></i>

            </button>

        </div>

    </div>
</div>`;
		cardslist.append(card);
	});
	cardslist.on("click", ".plusbtn", function (e) {
		e.stopImmediatePropagation();
		let elementid = $(this).data("id");
		console.log(elementid);
		$.ajax({
			url: "dbqueries.php",
			method: "GET",
			dataType: "json",
			data: { plus: elementid },
			success: function (result) {
				if (result.status == "unauthorized") {
					increamentLocally(elementid);
				}
				loadCartTotally();
			},
		});
	});
	cardslist.on("click", ".minusbtn", function (e) {
		e.stopImmediatePropagation();
		let elementid = $(this).data("id");
		$.ajax({
			url: "dbqueries.php",
			method: "GET",
			dataType: "json",
			data: { minus: elementid },
			success: function (result) {
				console.log(result);
				if (result.status == "unauthorized") {
					decreamentLocally(elementid);
				}
				loadCartTotally();
			},
			error: function (data) {
				console.log(data);
			},
		});
	});
	cardslist.on("click", ".deletebtn", function (e) {
		e.stopImmediatePropagation();
		let elementid = $(this).data("id");
		$.ajax({
			url: "dbqueries.php",
			method: "GET",
			dataType: "json",
			data: { delete: elementid },
			success: function (result) {
				console.log(result);
				if (result.status == "unauthorized") {
					deleteLocally(elementid);
				}
				loadCartTotally();
			},
			error: function (data) {
				console.log(data);
			},
		});
	});
}

function loadCartTotally() {
	$.ajax({
		url: "dbqueries.php",
		method: "GET",
		dataType: "json",
		data: { cart: "get" },
		success: function (result) {
			if (result.status == true) {
				loadCartData(result.data);
				cartCount();

				total.find("strong").text(result.totally);
			} else {
				if (localStorage.getItem("products")) {
					loadLocalCartIcon();
					let products = localStorage.getItem("products");
					$.ajax({
						url: "dbqueries.php",
						dataType: "json",
						method: "POST",
						data: { productsinfo: products },
						success: function (result) {
							if (result.status == true) {
								loadCartData(result.data);
								total.find("strong").text(result.totally);
							}
						},
						error: function (data) {
							console.log(data);
						},
					});
				}
			}
		},
		error: function (data) {
			console.log("result");
			console.log(data);
		},
	});
}
function increamentLocally(id) {
	if (localStorage.getItem("products")) {
		let products = JSON.parse(localStorage.getItem("products")) || [];
		products.forEach((element) => {
			if (element.id == id) {
				element.count++;
			}
		});
		localStorage.setItem("products", JSON.stringify(products));
	}
}
function decreamentLocally(id) {
	if (localStorage.getItem("products")) {
		let products = JSON.parse(localStorage.getItem("products")) || [];
		products.forEach((element, index) => {
			if (element.id == id) {
				if (element.count > 1) {
					element.count--;
				} else {
					products.splice(index, 1);
				}
			}
		});
		localStorage.setItem("products", JSON.stringify(products));
	}
}
export function deleteLocally(id) {
	if (localStorage.getItem("products")) {
		let products = JSON.parse(localStorage.getItem("products")) || [];
		products.forEach((element, index) => {
			if (element.id == id) {
				products.splice(index, 1);
			}
		});
		localStorage.setItem("products", JSON.stringify(products));
	}
}
