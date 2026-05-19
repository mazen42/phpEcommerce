<?php
session_start();
include __DIR__ . "/../../Data/dbConnection.php";
include __DIR__ . "/../../Functions/phpNoReturn.php";

if (!isset($pageTitle)) {
	$pageTitle = "Default";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<!-- <link rel="stylesheet" href="/../../node_modules/bootstrap/dist/css/bootstrap.min.css"> مش عارف اوصله -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
	<title><?= $pageTitle ?></title>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 20px; font-size: 20px">
		<a class="navbar-brand" href="/newecommerce/Admin/Dashboard.php">Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" style="margin-left: 77%;" id="navbarNav">
			<ul class="navbar-nav">
				<?php
				if (!isset($_SESSION["adminid"]) && empty($_SESSION["adminid"])) {
					echo "<li class='nav-item'>
					<a class='nav-link' href='/newecommerce/Admin/LoginView.php'>Login</a>
				</li>
				<li class='nav-item'>
					<a class='nav-link' href='/newecommerce/Admin/RegisterView.php'>Register</a>
				</li>";
				} else {
					echo "<li class='nav-item'>
					<a class='nav-link' style='color:red;' href='./common/logout.php'>Logout</a>
				</li>";
				}

				?>
			</ul>
		</div>
	</nav>