<?php
session_start();
include __DIR__ . "/../Data/dbConnection.php";
include __DIR__ . "/../Functions/phpNoReturn.php";

if (isset($_GET["cartCount"])) {
	$userid = $_SESSION["uid"];
	$customerid = $_SESSION["customerid"];
	header('Content-Type: application/json');
	if (!isset($userid, $customerid) && empty($userid) && empty($customerid)) {
		echo json_encode([
			"status" => false,
			"data" => "unauthorized"
		]);
		exit;
	} else {
		$sql_get_cart_count = "SELECT SUM(PCOUNT) as count FROM shoppingcarts where USERID = '$userid' and DONE = 0";
		$sql_get_cart_count_run = mysqli_query($conn, $sql_get_cart_count);
		$row_count = mysqli_fetch_assoc($sql_get_cart_count_run);
		echo json_encode([
			"status" => true,
			"data" => $row_count["count"] ?? 0
		]);
		exit;
	}

}

if (isset($_POST["localProductsids"])) {
	$ids = json_decode($_POST["localProductsids"]);
	$imploaded = implode(",", $ids);
	$sql_check = "select ID from products where ID in ($imploaded)";
	$sql_check_run = mysqli_query($conn, $sql_check);
	$data = mysqli_fetch_all($sql_check_run, MYSQLI_ASSOC);
	header("Content-Type: application/json");
	echo json_encode([
		"data" => $data
	]);

}


if (isset($_GET["productId"]) && !empty($_GET["productId"])) {
	header('Content-Type: application/json');
	$productid = $_GET["productId"];
	$count = $_GET["count"];
	$customerid = $_SESSION["customerid"];
	$userId = $_SESSION["uid"];
	if (empty($customerid)) {
		echo json_encode([
			"status" => false,
			"data" => ' <div class="alert alert-primary" role="alert">
							something went wrong
						</div>'
		]);
		exit;
	} else {
		$sql_check_exists_product = "SELECT ID FROM shoppingcarts where PRODUCTID = '$productid' && USERID = '$userId' and DONE = 0";
		$sql_check_exists_product_run = mysqli_query($conn, $sql_check_exists_product);
		$row_cart_check = mysqli_fetch_assoc($sql_check_exists_product_run);
		$curDate = date('Y-m-d H:i');
		if (!$row_cart_check) {
			$sql_create_cart = "INSERT INTO shoppingcarts (`CREATEDAT`,`PCOUNT`,`PRODUCTID`,`USERID`) VALUES ('$curDate','$count','$productid','$userId')";
			$sql_create_cart_run = mysqli_query($conn, $sql_create_cart);
			if ($sql_create_cart_run) {
				echo json_encode([
					"status" => true,
					"data" => ' <div class="alert alert-primary" role="alert">
									Product added to cart
								</div>'
				]);
				exit;
			} else {
				echo json_encode([
					"status" => false,
					"data" => ' <div class="alert alert-primary" role="alert">
								something went wrong
								</div>'
				]);
				exit;
			}
		} else {
			$sql_update_cart = "update shoppingcarts set PCOUNT = PCOUNT + $count where userid = '$userId' and productid = '$productid' and DONE = 0";
			$sql_update_cart_run = mysqli_query($conn, $sql_update_cart);
			echo json_encode([
				"status" => true,
				"data" => ' <div class="alert alert-primary" role="alert">
								Product increamentd into cart
							</div>'
			]);
			exit;
		}

	}
}

if (isset($_GET["cart"]) && !empty($_GET["cart"])) {
	$userid = @$_SESSION["uid"];
	header("Content-Type = application/json");
	if (!isset($userid)) {
		echo json_encode([
			"status" => false,
			"data" => "load locally"
		]);
		exit;

	} else {
		$cart_function = getUserCart($userid, 0);
		$totally = $cart_function['totally'];
		$data = $cart_function['data'];
		echo json_encode([
			"status" => true,
			"totally" => $totally,
			"data" => $data
		]);
		exit;
	}
}
if (isset($_POST["productsinfo"]) && !empty($_POST["productsinfo"])) {
	$data = json_decode($_POST["productsinfo"], true);
	function productsids($arr)
	{
		return $arr["id"];
	}
	$idsArray = array_map('productsids', $data);
	$imploaded = implode(",", $idsArray);
	if (strlen($imploaded) < 1) {
		$imploaded = "0";
	}
	$sql_get_products = "SELECT ID, IMAGEURL AS img, LISTPRICE, PRICE, PRICE50, PRICE100, NAME as name,DESCRIPTION as description from products where ID in ($imploaded)";
	$sql_get_products_run = mysqli_query($conn, $sql_get_products);
	$result = [];
	$totally = 0;
	while ($row_product = mysqli_fetch_assoc($sql_get_products_run)) {
		foreach ($data as $item) {
			if ($item["id"] == $row_product["ID"]) {
				$total = $row_product["PRICE"] * $item["count"];
				if ($item["count"] > 50) {
					$total = $item["count"] * $row_product["PRICE50"];
				}
				if ($item["count"] > 100) {
					$total = $item["count"] * $row_product["PRICE100"];
				}
				$totally += $total;
				$temp = [
					"total" => $total,
					"img" => $row_product["img"],
					"listprice" => $row_product["LISTPRICE"],
					"price" => $row_product["PRICE"],
					"price50" => $row_product["PRICE50"],
					"price100" => $row_product["PRICE100"],
					"name" => $row_product["name"],
					"count" => $item["count"],
					"id" => $row_product["ID"]
				];
				$result[] = $temp;
			}

		}
	}
	header('Content-Type: application/json');
	echo json_encode([
		"status" => true,
		"totally" => $totally,
		"data" => $result
	]);
	exit;

}
if (!empty($_GET["minus"])) {
	$userid = @$_SESSION["uid"];
	$productid = $_GET["minus"];
	header('Content-Type: application/json');
	if (empty($userid)) {
		echo json_encode([
			"status" => "unauthorized",
		]);
		exit;
	} else {
		$sql_minus = "SELECT PCOUNT as count from shoppingcarts where PRODUCTID = $productid and USERID = $userid and DONE = 0";
		$sql_minus_run = mysqli_query($conn, $sql_minus);
		if ($row = mysqli_fetch_assoc($sql_minus_run)) {
			if ($row["count"] > 1) {
				$sql_update_count = "UPDATE shoppingcarts set PCOUNT = PCOUNT - 1 where USERID = $userid and PRODUCTID = $productid and DONE = 0";
				$sql_update_count_run = mysqli_query($conn, $sql_update_count);
				if ($sql_update_count_run) {
					echo json_encode([
						"status" => true,
						"data" => "updated"
					]);
					exit;
				}
			} else {
				$sql_delete_cart = "DELETE from shoppingcarts where USERID = $userid AND PRODUCTID = $productid and DONE = 0";
				$sql_delete_cart_run = mysqli_query($conn, $sql_delete_cart);
				if ($sql_delete_cart_run) {
					echo json_encode([
						"status" => true,
						"data" => "deleted"
					]);
					exit;
				}
			}

		}
	}
}
if (!empty($_GET["plus"])) {
	$userid = @$_SESSION["uid"];
	$productid = $_GET["plus"];
	header('Content-Type: application/json');
	if (empty($userid)) {
		echo json_encode([
			"status" => "unauthorized",
		]);
		exit;
	} else {
		$sql_update_count = "UPDATE shoppingcarts set PCOUNT = PCOUNT + 1 where USERID = $userid and PRODUCTID = $productid and DONE = 0";
		$sql_update_count_run = mysqli_query($conn, $sql_update_count);
		if ($sql_update_count_run) {
			echo json_encode([
				"status" => true,
				"data" => "increamented"
			]);
			exit;
		}
	}

}
if (!empty($_GET["delete"])) {
	$userid = @$_SESSION["uid"];
	$productid = $_GET["delete"];
	if (empty($userid)) {
		echo json_encode([
			"status" => "unauthorized",
		]);
		exit;
	} else {
		$sql_delete_cart = "DELETE from shoppingcarts where USERID = $userid AND PRODUCTID = $productid and DONE = 0";
		$sql_delete_cart_run = mysqli_query($conn, $sql_delete_cart);
		if ($sql_delete_cart_run) {
			echo json_encode([
				"status" => true,
				"data" => "deleted"
			]);
			exit;
		}
	}
}
?>