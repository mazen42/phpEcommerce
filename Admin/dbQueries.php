<?php
session_start();
include __DIR__ . "../../Data/dbConnection.php";
include __DIR__ . "../../Functions/phpNoReturn.php";

if (isset($_POST["GetAllProduct"]) && !empty($_POST["GetAllProduct"])) {
	$data = [];
	$sql = "SELECT P.ID AS ProductId,P.NAME AS productName ,C.NAME AS categoryName,P.AUTHOR AS author FROM products P join categories C ON P.CATEGORYID = C.ID";
	$query_run = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($query_run)) {
		$data[] = $row;
	}
	if (count($data) < 1) {
		header('Content-Type: application/json');
		echo json_encode([
			"status" => false,
			"data" => []
		]);
		exit();
	} else {
		header('Content-Type: application/json');
		echo json_encode([
			"status" => true,
			"data" => $data
		]);
		exit();
	}

}

if (isset($_POST["deleteProduct"]) && !empty($_POST["deleteProduct"])) {
	$productId = $_POST["deleteProduct"];
	$sql_check_orders = "select COUNT(*) as count from orderdetails where productid = $productId";
	$sql_check_orders_run = mysqli_query($conn, $sql_check_orders);
	$check = mysqli_fetch_assoc($sql_check_orders_run);
	if ($check["count"] > 0) {
		echo "some one orderd that cannot be deleted";
		exit();
	}
	$sql_delete_shopping_carts = "delete from shoppingcarts where productid = $productId ";
	$sql_delete_shopping_carts_run = mysqli_query($conn, $sql_delete_shopping_carts);
	$image_url = "SELECT IMAGEURL FROM products where id = '$productId'";
	$image_query = mysqli_query($conn, $image_url);
	$row = mysqli_fetch_assoc($image_query);
	$image_name = $row["IMAGEURL"];
	$deleteImageResult = deleteImageFromServer("C:/xampp/htdocs/NewEcommerce/uploads/$image_name");
	if ($deleteImageResult['status'] == true) {
		$sql = "DELETE FROM products where ID = '$productId'";
		$query_run = mysqli_query($conn, $sql);
		if ($query_run) {
			echo "deleted";
			exit();
		}
	} else {
		echo 'image not found';
		exit;
	}
}


?>