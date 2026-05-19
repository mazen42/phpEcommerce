<?php
session_start();
include __DIR__ . "../../Data/dbConnection.php";
$obj = [
	'email' => $_POST["email"],
	'password' => $_POST["password"]
];

if (isset($obj["email"])) {
	$email = $obj["email"];
	$password = $obj["password"];
	if (empty($email) || empty($password)) {
		echo "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
			</div>";
	} else {
		$sql = "SELECT * FROM users where email = '$email' and ROLE = 'admin' LIMIT 1";
		$query_run = mysqli_query($conn, $sql);
		if ($row = mysqli_fetch_assoc($query_run)) {
			$dbpass = $row["Pass"];
			if (password_verify($password, $dbpass)) {
				$userId = $row["userId"];
				$adminidsql = "SELECT * FROM admins where USERID = '$userId'";
				$adminid_query = mysqli_query($conn, $adminidsql);
				if ($adminrow = mysqli_fetch_assoc($adminid_query)) {
					$_SESSION["uid"] = $row["userId"];
					$_SESSION["email"] = $row["Email"];
					$_SESSION["adminid"] = $adminrow["ID"];
					echo "authorized";
					exit;
				}
			}
		} else {
			echo "<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invalid email or password</b>
			</div>";
			exit;
		}
	}
}