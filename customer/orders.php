<?php
$pageTitle = "orders";
include "common/Header.php";
$uid = $_SESSION["uid"];
if (empty($uid)) {
	header("Location: Login.php");
}
$sql_get_orders = "SELECT id, streetaddress,orderdate,orderstatus,ordertotal,name,city,shippingdate from orderheader where userid = $uid";
$sql_get_orders_run = mysqli_query($conn, $sql_get_orders);
?>
<div style="display:flex; justify-content: center;">
	<h2>Orders</h2>
</div>
<table class="table" id="ProductsTable" style="width: 70%; border: solid black 2px; margin: auto; margin-top:30px;">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Name</th>
			<th scope="col">City</th>
			<th scope="col">Street</th>
			<th scope="col">Order Date</th>
			<th scope="col">Shipping Date</th>
			<th scope="col">Order Status</th>
			<th scope="col">Order Total</th>
			<th scope="col">Details</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$count = 1;
		while ($row = mysqli_fetch_assoc($sql_get_orders_run)) {
			$name = $row["name"];
			$city = $row["city"];
			$street = $row["streetaddress"];
			$id = $row["id"];
			$orderDate = date("Y-m-d H:i", strtotime($row["orderdate"]));
			$shippingDate = date("Y-m-d H:i", strtotime($row["shippingdate"]));
			$orderStatus = date("Y-m-d H:i", strtotime($row["orderstatus"]));
			$orderTotal = $row["ordertotal"];
			echo
				'<tr>
      <th scope="row">' . $count . '</th>
      <td>' . $name . '</td>
      <td>' . $city . '</td>
      <td>' . $street . '</td>
      <td>' . $orderDate . '</td>
      <td>' . $shippingDate . '</td>
      <td>' . $orderStatus . '</td>
      <td>' . $orderTotal . '</td>
      <td><a style="text-decoration:none;" href="orderDetails.php?OrderId=' . $id . '"><button type="button" class="btn btn-primary">Details</button></a>
</td>
    </tr>';
			$count++;
		}
		?>

	</tbody>
</table>
</div>
<?php
include "common/footer.php";
?>