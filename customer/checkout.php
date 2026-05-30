<?php
$pageTitle = "Checkout";
include "common/Header.php";
if (empty($_SESSION["uid"])) {
	header("Location: login.php");
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	$userid = $_SESSION['uid'];
	$datafunction = getUserCart($userid);
	$data = $datafunction['data'];
	$totally = $datafunction['totally'];
	$sql_user_data = "SELECT email,firstname,lastname,mobile from users where userid = $userid";
	$sql_user_data_run = mysqli_query($conn, $sql_user_data);
	$row_user = mysqli_fetch_assoc($sql_user_data_run);
	$ch = curl_init();
	$url = "https://countriesnow.space/api/v0.1/countries";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	$response = curl_exec($ch);
	if (curl_errno($ch)) {
		echo "error" . curl_errno($ch);
	} else {
		$dataresponse = json_decode($response, true);
		$dataCountries = $dataresponse["data"];

	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$userid = $_SESSION["uid"];
	$cart = getUserCart($userid);
	$orderTotal = $cart['totally'];
	$carts = $cart['data'];
	function cartsids($arr)
	{
		return $arr["cartid"];
	}
	$cartsIdsarray = array_map("cartsids", $carts);
	$cartsImploaded = implode(",", $cartsIdsarray);
	$firstname = $_POST["firstname"];
	$lastName = $_POST["lastName"];
	$phonenumber = $_POST["phonenumber"];
	$country = $_POST["country"];
	$state = $_POST["state"];
	$city = $_POST["city"];
	$zip = $_POST["zip"];
	$street = $_POST["street"];
	$sql_insert_order_header = "insert into orderheader (`USERID`,`ORDERTOTAL`,`NAME`,`PHONENUMBER`,`STREETADDRESS`,`POSTALCODE`,`COUNTRY`,`STATE`,`CITY`)
	VALUES ('$userid','$orderTotal','$firstname $lastName','$phonenumber','$street','$zip','$country','$state','$city')";
	$sql_insert_order_header_run = mysqli_query($conn, $sql_insert_order_header);
	if ($sql_insert_order_header_run) {
		$order_header_id = mysqli_insert_id($conn);
		foreach ($carts as $item) {
			$pid = $item["id"];
			$price = $item["usedprice"];
			$count = $item["count"];
			$sql_create_order_details = "insert into orderdetails (`COUNT`,`ORDERHEADERID`,`PRICE`,`PRODUCTID`) VALUES ('$count','$order_header_id','$price','$pid')";
			$sql_create_order_details_run = mysqli_query($conn, $sql_create_order_details);
		}
		$sql_update_cart_done = "update shoppingcarts set DONE = 1 where ID in ($cartsImploaded)";
		$sql_update_cart_done_run = mysqli_query($conn, $sql_update_cart_done);
		header("Location: index.php");
		exit;
	} else {
		echo "error";
		exit;
	}
}

?>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<div class="container"
	style="max-width: 90%; padding: 30px; margin-bottom: 30px; margin-top: 30px; border-radius: 10px; background-color: #eee;">
	<div class="py-5 text-center">
		<i class="bi bi-credit-card fs-1"></i>
	</div>
	<div class="row">
		<div class="col-md-4 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="text-muted">Your cart</span>
				<span class="badge bg-secondary rounded-pill"><?= count($data) ?></span>
			</h4>
			<?php
			foreach ($data as $item) {
				echo '
<ul class="list-group mb-3">
    <li class="list-group-item d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">
            <img src="../uploads/' . $item["img"] . '" 
                 alt="' . $item["name"] . '" 
                 class="me-3 rounded"
                 style="width:60px;height:60px;object-fit:cover;">

            <div>
                <h6 class="my-0">' . $item["name"] . '</h6>
                <small class="text-muted">' . $item["description"] . '</small>
            </div>
        </div>

        <span class="text-muted">
            ' . $item["count"] . ' × $' . $item["usedprice"] . ' = $' . $item["total"] . '
        </span>

    </li>
</ul>';

			}

			?>
			<form class="card p-2">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Promo code">
					<button type="submit" class="btn btn-secondary">Redeem</button>
				</div>
			</form>
		</div>

		<!-- Billing Column-->
		<div class="col-md-8 order-md-1">
			<h4 class="mb-3">Billing address</h4>
			<form method="post">
				<div class="row g-3">
					<div class="col-sm-6">
						<label for="firstName" class="form-label">First name</label>
						<input type="text" class="form-control" name="firstname" value="<?= $row_user["firstname"] ?>"
							id="firstName" required>
					</div>
					<div class="col-sm-6">
						<label for="lastName" class="form-label">Last name</label>
						<input type="text" name="lastName" class="form-control" value="<?= $row_user["lastname"] ?>"
							id="lastName" required>
					</div>
					<div class="col-sm-6">
						<label for="phonenumber" class="form-label">Phone Number</label>
						<input type="text" name="phonenumber" class="form-control" value="<?= $row_user["mobile"] ?>"
							id="phonenumber" required>
					</div>

					<div class="col-sm-6">
						<label for="email" class="form-label">Email <span class="text-muted"></span></label>
						<input type="email" readonly name="email" class="form-control" id="email"
							value="<?= $row_user["email"] ?>" placeholder="you@example.com">
					</div>

					<div class="col-md-4">
						<label for="country" class="form-label">Country</label>
						<select class="form-select" name="country" id="country" required>
							<option value="">Choose...</option>
							<?php
							foreach ($dataCountries as $item) {
								echo '<option value="' . $item['country'] . '">' . $item['country'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="state" class="form-label">state</label>
						<select class="form-select" name="state" id="state" required>
							<option value="">Choose...</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="city" class="form-label">City</label>
						<select class="form-select" name="city" id="city" required>
							<option value="">Choose...</option>
						</select>
					</div>

					<div class="col-md-3">
						<label for="zip" class="form-label">Postal Code</label>
						<input type="text" name="zip" class="form-control" placeholder="ZIP" id="postalcode" required>
					</div>
					<div class="col-sm-6">
						<label for="email" class="form-label">Street Address <span class="text-muted"></span></label>
						<input type="text" name="street" class="form-control" id="streetaddress"
							placeholder="apartment | street name ">
					</div>
				</div>

				<hr class="my-4">
				<button class="w-100 btn btn-primary btn-lg" <?php
				if (count($data) < 1) {
					echo "disabled";
				}
				?> type="submit">Continue to checkout</button>
			</form>
		</div>
	</div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

<?php
include "common/footer.php";
?>
<script src="js/checkout.js"></script>