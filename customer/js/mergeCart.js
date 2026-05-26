$(function () {
	if (localStorage.getItem("products")) {
		let products = localStorage.getItem("products");
		$.ajax({
			url: "mergeCartQuery.php",
			method: "POST",
			contentType: "application/json",
			data: products,
			success: function (result) {
				if (result == "done") {
					console.log("hello");
					window.localStorage.removeItem("products");
					window.location.href = "index.php";
				} else {
					window.location.href = "index.php";
				}
			},
		});
	} else {
		window.location.href = "index.php";
	}
});
