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
	<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

	<link href="css/bootstrap.min.css" rel="stylesheet">

	<title><?= $pageTitle ?></title>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 20px; font-size: 20px">
		<a class="navbar-brand" href="/newecommerce/customer/index.php">Home</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" style="margin-left: 77%;" id="navbarNav">
			<ul class="navbar-nav">

				<?php
				if (isset($_SESSION["customerid"]) && !empty($_SESSION["customerid"])) {
					echo "<li class='nav-item'>
						<a class='nav-link' style='color:red;' href=
						 '/newecommerce/customer/common/logout.php'
	
						>Logout</a>
					</li>";
				} else {
					echo "<li class='nav-item'>
					<a class='nav-link' href='/newecommerce/customer/login.php'>Login</a>
				</li>
				<li class='nav-item'>
					<a class='nav-link' href='/newecommerce/customer/register.php'>Register</a>
				</li>";
				}

				?>
			</ul>
		</div>
	</nav>