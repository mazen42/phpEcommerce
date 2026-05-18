let submitcreateProductbtn = $("#submitAddProduct");
let categorySelection = $("#category");
$(function () {
	$.ajax({
		url: "AddNewProduct.php",
		method: "POST",
		dataType: "json",
		data: { getcategories: "categories" },
		success: function (result) {
			if (result.status == true) {
				result.data.forEach((element) => {
					categorySelection.append(
						$("<option>")
							.text(element["NAME"])
							.attr("value", `${element["ID"]}`),
					);
				});
			}
		},
	});
});
submitcreateProductbtn.click(function (e) {
	e.preventDefault();
	let fromdata = new FormData();
	fromdata.append("name", $("#name").val());
	fromdata.append("description", $("#Description").val());
	fromdata.append("author", $("#Author").val());
	fromdata.append("price", $("#price").val());
	fromdata.append("listPrice", $("#listPrice").val());
	fromdata.append("price50", $("#price50").val());
	fromdata.append("price100", $("#price100").val());
	fromdata.append("category", $("#category").val());
	fromdata.append("image", $("#Image")[0].files[0]);
	$.ajax({
		url: "AddNewProduct.php",
		method: "POST",
		data: fromdata,
		processData: false,
		contentType: false,
		success: function (resultinserted) {
			if (resultinserted == "added_successfully") {
				// console.log("success");
				window.location.href = "Dashboard.php";
			} else {
				console.log(resultinserted);
				$("#toasteAddProduct").append(resultinserted);
				setTimeout(() => {
					$("#toasteAddProduct").html("");
				}, 5000);
			}
		},
	});
});
function previewFile(event) {
	document.getElementById("previewImage").src = URL.createObjectURL(
		event.target.files[0],
	);
}
