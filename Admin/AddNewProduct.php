<?php
session_start();
include __DIR__ . "../../Data/dbConnection.php";
include __DIR__ . "../../Functions/phpNoReturn.php";
if (isset($_POST["name"]) && !empty($_POST["name"])) {
	$name = htmlspecialchars($_POST["name"], ENT_QUOTES);
	$description = htmlspecialchars($_POST["description"], ENT_QUOTES);
	$author = htmlspecialchars($_POST["author"], ENT_QUOTES);
	$listPrice = $_POST["listPrice"];
	$price = $_POST["price"];
	$price50 = $_POST["price50"];
	$price100 = $_POST["price100"];
	$categoryid = $_POST["category"];
	if (empty($name) || empty($description) || empty($author) || empty($listPrice) || empty($price) || empty($price50) || empty($price100) || empty($categoryid) || empty($_FILES)) {
		$alertResult = alert("Fill All Fields!");
		echo $alertResult["data"];
		exit;
	}
	$uploadResult = AddImageToserver("C:/xampp/htdocs/NewEcommerce/uploads/", $_FILES["image"]);
	if ($uploadResult["status"] == true) {
		$uploadData = $uploadResult["data"];
		$sql = "INSERT INTO products(`AUTHOR`,`DESCRIPTION`,`IMAGEURL`,`LISTPRICE`,`NAME`,`PRICE`,`PRICE50`,`PRICE100`,`CATEGORYID`) 
            VALUES ('$author','$description','$uploadData','$listPrice','$name','$price','$price50','$price100','$categoryid')";
		$query_run = mysqli_query($conn, $sql);
		if ($query_run) {
			$_SESSION["notification"] = "Product $name created successfully";
			echo "added_successfully";

		}
	} else {
		echo $uploadResult["data"];
	}
}

if (isset($_POST["getcategories"]) && !empty($_POST["getcategories"])) {
	$data = [];
	$sql = "SELECT * FROM categories";
	$query_run = mysqli_query($conn, $sql);
	if (!$query_run) {
		header('Content-Type: application/json');
		echo json_encode([
			"status" => false,
			"message" => mysqli_error($conn)
		]);
		exit();
	}
	while ($row = mysqli_fetch_assoc($query_run)) {
		$data[] = $row;
	}
	header('Content-Type: application/json');
	echo json_encode([
		"status" => true,
		"data" => $data
	]);
	exit();

}

?>