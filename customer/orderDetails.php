<?php
$pageTitle = "Order Details";
include "common/Header.php";
$uid = $_SESSION["uid"];
if (empty($uid)) {
	header("Location: login.php");
	exit;
}
if (!empty($_GET["OrderId"])) {
	$orderId = $_GET["OrderId"];
	$sql_check_order = "SELECT h.city,h.name,h.phonenumber,h.country,u.email,h.state,h.postalcode,h.streetaddress,h.phonenumber FROM orderheader h join users u on h.userid = u.userid where h.id = $orderId and h.userid = $uid";
	$sql_check_order_run = mysqli_query($conn, $sql_check_order);
	$row_user = mysqli_fetch_assoc($sql_check_order_run);
	if (!$sql_check_order_run) {
		header("Location: orders.php");
		exit;
	}
	$sql_get_order_details = "select p.name, o.price ,o.count, (o.price * o.count) as total, p.imageurl,p.description from orderdetails o join products p on p.id = o.productid where orderheaderid =  $orderId";
	$sql_get_order_details_run = mysqli_query($conn, $sql_get_order_details);
	$sql_orders_details = mysqli_fetch_all($sql_get_order_details_run, MYSQLI_ASSOC);
}

?>
<div class="container"
	style="max-width: 90%; padding: 30px; margin-bottom: 30px; margin-top: 30px; border-radius: 10px; background-color: #eee;">
	<div class="py-5 text-center">
		<i class="bi bi-credit-card fs-1"></i>
	</div>
	<div class="row">
		<div class="col-md-4 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="text-muted">Your products</span>
				<span class="badge bg-secondary rounded-pill"><?= count($sql_orders_details) ?></span>
			</h4>
			<?php
			foreach ($sql_orders_details as $item) {
				echo '
<ul class="list-group mb-3">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        
        <div class="d-flex align-items-center">
            <img src="../uploads/' . $item["imageurl"] . '" 
                 alt="' . $item["name"] . '" 
                 class="me-3 rounded"
                 style="width:60px;height:60px;object-fit:cover;">

            <div>
                <h6 class="my-0">' . $item["name"] . '</h6>
                <small class="text-muted">' . $item["description"] . '</small>
            </div>
        </div>

        <span class="text-muted">
            ' . $item["count"] . ' × $' . $item["price"] . ' = $' . $item["total"] . '
        </span>

    </li>
</ul>';

			}

			?>
		</div>

		<!-- Billing Column-->
		<div class="col-md-8 order-md-1">
			<h4 class="mb-3">Order Details</h4>
			<form method="post">
				<div class="row g-3">
					<div class="col-sm-6">
						<label for="firstName" class="form-label">First name</label>
						<input type="text" readonly class="form-control" value="<?= $row_user["name"] ?>" id="fullName">
					</div>
					<div class="col-sm-6">
						<label for="phonenumber" class="form-label">Phone Number</label>
						<input type="text" readonly class="form-control" value="<?= $row_user["phonenumber"] ?>"
							id="phonenumber">
					</div>

					<div class="col-sm-6">
						<label for="email" class="form-label">Email <span class="text-muted"></span></label>
						<input type="email" readonly class="form-control" id="email" value="<?= $row_user["email"] ?>"
							placeholder="you@example.com">
					</div>
					<div class="col-sm-6">
						<label for="email" class="form-label">Street Address <span class="text-muted"></span></label>
						<input type="text" value="<?= $row_user["streetaddress"] ?>" readonly class="form-control"
							id="streetaddress" placeholder="apartment | street name ">
					</div>
					<div class="col-md-4">
						<label for="country" class="form-label">Country</label>
						<select disabled class="form-select" id="country">
							<option><?= $row_user["country"] ?></option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="state" class="form-label">state</label>
						<select class="form-select" disabled id="state">
							<option>

								<?= $row_user["state"] ?>
							</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="city" class="form-label">City</label>
						<select class="form-select" disabled id="city">
							<option>

								<?= $row_user["city"] ?>

							</option>
						</select>
					</div>

					<div class="col-md-3">
						<label for="zip" class="form-label">Postal Code</label>
						<input type="text" value="<?= $row_user["postalcode"] ?>" readonly class="form-control"
							placeholder="ZIP" id="postalcode" required>
					</div>

				</div>
				<hr class="my-4">
				<button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
			</form>
		</div>
	</div>
</div>
</div>
<?php
include "common/footer.php";
?>