$(function () {
	if (localStorage.getItem("products")) {
		let products = localStorage.getItem("products");
		$.ajax({
			url: "mergeCartQuery.php",
			method: "POST",
			contentType: "application/json; charset=utf-8",
			data: products,
			success: function (result) {
				if (result == "done") {
					window.localStorage.removeItem("products");
					window.location.href = "index.php";
				} else {
					console.log("result");
				}
			},
		});
	} else {
		window.location.href = "index.php";
	}
});
