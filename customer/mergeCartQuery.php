<?php
session_start();
include __DIR__ . "/../Data/dbConnection.php";
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (count($data) > 0) {
	$userid = $_SESSION["uid"];
	function productsids($arr)
	{
		return $arr["id"];
	}
	$idsArray = array_map('productsids', $data);
	$idsImploaded = implode(",", $idsArray);
	$sql_check_exists_products = "SELECT PRODUCTID FROM shoppingcarts where USERID = '$userid' and PRODUCTID in ($idsImploaded) and DONE = 0";
	$sql_check_exists_products_run = mysqli_query($conn, $sql_check_exists_products);
	$exsists_ids = [];
	while ($row = mysqli_fetch_assoc($sql_check_exists_products_run)) {
		foreach ($data as $item) {
			$pid = $row["PRODUCTID"];
			if ($item['id'] == $pid) {
				$qty = intval($item['count']);
				$sql_update_count = "UPDATE shoppingcarts set PCOUNT = PCOUNT + $qty WHERE USERID = '$userid' and PRODUCTID = '$pid' and DONE = 0";
				$sql_update_count_run = mysqli_query($conn, $sql_update_count);
				array_push($exsists_ids, $pid);
			}
		}
	}
	$not_exsists_ids = array_diff($idsArray, $exsists_ids);
	$curDate = date('Y-m-d H:i');
	if (count($not_exsists_ids) > 0) {
		foreach ($data as $item) {
			$pid = $item['id'];
			if (in_array($pid, $not_exsists_ids)) {
				$count = $item['count'];
				$sql_create_cart = "INSERT INTO shoppingcarts (`CREATEDAT`,`PCOUNT`,`PRODUCTID`,`USERID`) VALUES ('$curDate','$count','$pid','$userid')";
				$sql_create_cart_run = mysqli_query($conn, $sql_create_cart);
			}


		}
		echo "done";
		exit;
	}
	echo "done";
	exit;
}

?>