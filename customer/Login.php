<?php
$pageTitle = "Login";
include "common/Header.php";
if (isset($_SESSION["customerid"]) && !empty($_SESSION["customerid"])) {
	header("Location: index.php");
	exit;
}
$obj = [
	"email" => @$_POST["email"],
	"password" => @$_POST["password"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $obj["email"];
	$password = $obj["password"];
	if (empty($email) || empty($password)) {
		echo "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
			</div>";
	} else {
		$sql = "SELECT * FROM users where email = '$email' and ROLE = 'customer' LIMIT 1";
		$query_run = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($query_run)) {
			$dbpass = $row["Pass"];
			if (password_verify($password, $dbpass)) {
				$userId = $row["userId"];
				$adminidsql = "SELECT * FROM customers where USERID = '$userId'";
				$adminid_query = mysqli_query($conn, $adminidsql);
				if ($adminrow = mysqli_fetch_assoc($adminid_query)) {
					$_SESSION["uid"] = $row["userId"];
					$_SESSION["email"] = $row["Email"];
					$_SESSION["customerid"] = $adminrow["ID"];
					header("Location: index.php");
					exit;
				}
			}
		}
		$_SESSION["userLoginNotfication"] = "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invalid email or password</b>
			</div>";
		header("Location: Login.php");
		exit;
	}
}
?>
<form style="width: 600px; margin: auto; padding-bottom: 120px;" class="mt-5" method="post">
	<!-- Error message -->
	<div id="toasteeLogincustomer"><?php
	if (isset($_SESSION["userLoginNotfication"]) && !empty(($_SESSION["userLoginNotfication"]))) {
		echo $_SESSION["userLoginNotfication"];
	}
	unset($_SESSION["userLoginNotfication"]);
	?></div>

	<!-- Email input -->
	<div data-mdb-input-init class="form-outline mb-4">
		<input type="email" name="email" id="form2Example1" class="form-control" />
		<label class="form-label" for="form2Example1">Email address</label>
	</div>

	<!-- Password input -->
	<div data-mdb-input-init class="form-outline mb-4">
		<input type="password" name="password" id="form2Example2" class="form-control" />
		<label class="form-label" for="form2Example2">Password</label>
	</div>

	<!-- 2 column grid layout for inline styling -->
	<div class="row mb-4">
		<div class="col d-flex justify-content-center">
			<!-- Checkbox -->
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
				<label class="form-check-label" for="form2Example31"> Remember me </label>
			</div>
		</div>

		<div class="col">
			<!-- Simple link -->
			<a href="#!">Forgot password?</a>
		</div>
	</div>

	<!-- Submit button -->
	<button type="submit" id="loginbtn" data-mdb-button-init data-mdb-ripple-init
		class="btn btn-primary btn-block mb-4">Sign
		in</button>

	<!-- Register buttons -->
	<div class="text-center">
		<p>Not a member? <a href="Register.php">Register</a></p>
	</div>
</form>
<?php
include "common/footer.php";
?>