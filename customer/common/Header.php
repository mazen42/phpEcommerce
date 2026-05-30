<?php
session_start();
include __DIR__ . "/../../Data/dbConnection.php";
include __DIR__ . "/../../Functions/phpNoReturn.php";
if (!isset($pageTitle)) {
	$pageTitle = "Default";
}
$cartLink = '<a href="/newecommerce/customer/cart.php"><i class="bi bi-cart" id="carticon"></i></a>';
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
	<div id="overlay" style="position: fixed;
	inset: 0;
	background: rgba(0, 0, 0, 0.4);
	display: none;
	z-index: 1000;"></div>
	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 20px; font-size: 20px">
		<a class="navbar-brand" href="/newecommerce/customer/index.php">Home</a>
		<a href="/newecommerce/customer/cart.php"><i class="bi bi-cart" id="carticon"></i></a>
		<?php
		if ($_SERVER['SCRIPT_NAME'] == "/newecommerce/customer/cart.php") {
			echo '<button type="button" id="totally" disabled class="btn btn-outline-primary" style="margin-left:6px;"> Total: $ <strong> </strong> </button>';
		}
		?>
		<div class="dropdown" style="margin-left: 20px;">
			<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
				aria-expanded="false">
				info
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="orders.php">orders</a>
			</div>
		</div>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" style="margin-left: 15%; position: relative;
	z-index: 1001;" id="navbarNav">
			<div class="search-container" style="display:flex">
				<input type="text" class="form-control search-input" style=" width:500px; margin-left: 200px;"
					placeholder="Search...">
				<i class="fas fa-search search-icon" style="margin-top: 10px; margin-left: 5px;"></i>

				<div id="searchResults" class="list-group position-absolute z-3"
					style="top:95%; left: 20.5%; width: 510px;">
				</div>
			</div>
			<ul class="navbar-nav" style="margin-left:150px;">

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