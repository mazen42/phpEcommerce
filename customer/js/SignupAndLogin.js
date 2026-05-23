let registerSubmit = $("#registersubmit");
let loginbtn = $("#loginbtn");

registerSubmit.click(function (e) {
	e.preventDefault();
	$.ajax({
		url: "signup.php",
		method: "POST",
		data: $("#registerform").serialize(),
		success: function (data) {
			if (data.trim() == "registerd_successfully") {
				window.location.href = "Login.php";
				$("#desc").html("Registered Successfully");
			} else {
				console.log("reviewData");
				$("#signup_msg").html(data);
			}
		},
	});
});
