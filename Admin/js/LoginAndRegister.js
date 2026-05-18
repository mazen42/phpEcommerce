let submitbtn = $("#submitbtn");
let loginSubmitbtn = $("#loginSubmitbtn");
submitbtn.click(function (e) {
	e.preventDefault();
	$.ajax({
		url: "Register.php",
		method: "POST",
		data: $("#RegisterForm").serialize(),
		success: function (data) {
			if (data.trim() == "Registered_successfully") {
				console.log("ok");
				window.location.href = "dashboard.php";
			} else {
				console.log(data);
				let toaster = $(data);
				$("#toastee").html(toaster);
				setTimeout(() => {
					$("#toastee").html("");
				}, 5000);
			}
		},
	});
});

loginSubmitbtn.click(function (e) {
	console.log('test');
	e.preventDefault();
	$.ajax({
		url: "Login.php",
		method: "POST",
		data: {
			email: $("[name=email]").val(),
			password: $("[name=password]").val(),
		},
		success: function (data) {
			if (data.trim() == "authorized") {
				window.location.href = "Dashboard.php";
			} else {
				let toaster = $(data);
				$("#toasteeLogin").html(data);
				setTimeout(() => {
					$("#toasteeLogin").html("");
				}, 5000);
			}
		},
	});
});
