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
				<span class="text-muted">Your cart</span>
				<span class="badge bg-secondary rounded-pill"><?= count($data) ?></span>
			</h4>
			<?php
			foreach ($data as $item) {
				echo '<ul class="list-group mb-3">
				<li class="list-group-item d-flex justify-content-between lh-sm">
					<div>
						<h6 class="my-0">' . $item["name"] . ' </h6>
						<small class="text-muted">' . $item["description"] . '</small>
					</div>
					<span class="text-muted"> ' . $item["count"] . ' * $' . $item["usedprice"] . ' = ' . $item["total"] . '</span>
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
			<form>
				<div class="row g-3">
					<div class="col-sm-6">
						<label for="firstName" class="form-label">First name</label>
						<input type="text" class="form-control" value="<?= $row_user["firstname"] ?>" id="firstName"
							required>
					</div>
					<div class="col-sm-6">
						<label for="lastName" class="form-label">Last name</label>
						<input type="text" class="form-control" value="<?= $row_user["lastname"] ?>" id="lastName"
							required>
					</div>
					<div class="col-sm-6">
						<label for="phonenumber" class="form-label">Phone Number</label>
						<input type="text" class="form-control" value="<?= $row_user["mobile"] ?>" id="phonenumber"
							required>
					</div>

					<div class="col-sm-6">
						<label for="email" class="form-label">Email <span class="text-muted"></span></label>
						<input type="email" class="form-control" id="email" value="<?= $row_user["email"] ?>"
							placeholder="you@example.com">
					</div>

					<div class="col-md-4">
						<label for="state" class="form-label">Country</label>
						<select class="form-select" id="state" required>
							<option value="">Choose...</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="state" class="form-label">City</label>
						<select class="form-select" id="city" required>
							<option value="">Choose...</option>
						</select>
					</div>

					<div class="col-md-3">
						<label for="zip" class="form-label">Postal Code</label>
						<input type="text" class="form-control" id="postalcode" required>
					</div>
					<div class="col-sm-6">
						<label for="email" class="form-label">Street Address <span class="text-muted"></span></label>
						<input type="email" class="form-control" id="streetaddress"
							placeholder="apartment | street name ">
					</div>
				</div>

				<hr class="my-4">

				<h4 class="mb-3">Payment</h4>
				<div class="my-3">
					<div class="form-check">
						<input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
						<label class="form-check-label" for="credit">Credit card</label>
					</div>
					<div class="form-check">
						<input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
						<label class="form-check-label" for="debit">Debit card</label>
					</div>
					<div class="form-check">
						<input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
						<label class="form-check-label" for="paypal">PayPal</label>
					</div>
				</div>

				<div class="row gy-3">
					<div class="col-md-6">
						<label for="cc-name" class="form-label">Name on card</label>
						<input type="text" class="form-control" id="cc-name" required>
						<small class="text-muted">Full name as displayed on card</small>
					</div>

					<div class="col-md-6">
						<label for="cc-number" class="form-label">Credit card number</label>
						<input type="text" class="form-control" id="cc-number" required>
					</div>

					<div class="col-md-3">
						<label for="cc-expiration" class="form-label">Expiration</label>
						<input type="text" class="form-control" id="cc-expiration" required>
					</div>

					<div class="col-md-3">
						<label for="cc-cvv" class="form-label">CVV</label>
						<input type="text" class="form-control" id="cc-cvv" required>
					</div>
				</div>

				<hr class="my-4">
				<button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
			</form>
		</div>
	</div>
</div>
<?php
include "common/footer.php";
?>