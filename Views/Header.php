<?php
session_start();
include __DIR__ . "../../Data/dbConnection.php";
include __DIR__ . "../../Functions/phpNoReturn.php";
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
		<?php
		if (isset($_SESSION["adminid"])) {
			echo '<a class="navbar-brand" href="Dashboard.php">Dashboard</a>';
		} else {
			echo '<a class="navbar-brand" href="../Views/Index.php">Home</a>';
		}
		?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Features</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Pricing</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#">Disabled</a>
				</li>
			</ul>
		</div>
	</nav>