<?php 
	if($_SERVER['HTTPS'] != 'on') {
		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit;
	}


	session_start();

	if(@!$_SESSION['username']) {
		header('login.php?promptLogin=true');
	}

	if(@!$_SESSION['productId'] || @!$_SESSION['quantity'] || @!$_POST['address'] || @!$_POST['paymentMethod']) {
		header('Location: result-checkout.php');
	}

	$paymentMethod = $_POST['paymentMethod'];
	if(strcmp($paymentMethod, "Credit/Debit Card") == 0 && (@!$_POST['cc-number'] || @!$_POST['cc-expiration'] || @!$_POST['cc-cvv'])) {
		header('Location: index.php');
	}

	require_once('model/ModelProduct.php');

	$username = $_SESSION['username'];
	$productId = $_SESSION['productId'];
	$quantity = $_SESSION['quantity'];

	$address = $_POST['address'];
	$_SESSION['address'] = $_POST['address'];

	$paymentMethod = $_POST['paymentMethod'];
	$_SESSION['paymentMethod'] = $_POST['paymentMethod'];

	$_SESSION['cc-number'] = $_POST['cc-number'];
	$_SESSION['cc-expiration'] = $_POST['cc-expiration'];
	$_SESSION['cc-cvv'] = $_POST['cc-cvv'];

	try {
		// create connection
		$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

		$dbError = mysqli_connect_errno();
		if($dbError) {
			throw new Exception('Cannot connect to database. Try again later.');
		}

		$queryProduct = 
		"
			SELECT * FROM products 
				WHERE product_id = ?
				 LIMIT 1;
		";

		$stmt = $db->prepare($queryProduct);
		$stmt->bind_param("s", $productId);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0) {
			$productData = $result->fetch_array();
			$productObj = new Product($productData['product_id'], $productData['name'], $productData['price'], $productData['previewImgURL']);

			$totalPrice = $productObj->price * $quantity;
			$_SESSION['totalPrice'] = $totalPrice;
		}
		else {
			throw new Exception('ID does not match any records.');
		}
	}
	catch(Exception $e) {
		header('Location: index.php?productFetchFailure=true');
		error_log($e->getMessage());
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>
	<?php
		require_once('view-comp/nav.php');
		displayNav($sessionUsername);
	?>

	<div class="container confirm main-content my-4">

		<div class="row">
			<div class="col-md-8">
				<h4 class="card-title">Order Summary</h4>
				<div class="card">
					<div class="card-header">
						<div class="row">
								<div class="col-3 d-flex align-items-center">
									<p class="card-text font-weight-bold"></p>
								</div>

								<div class="col-4 d-flex align-items-center justify-content-center">
									<p class="card-text font-weight-bold">Product Name</p>
								</div>

								<div class="col-3 d-flex align-items-center justify-content-center">
									<p class="card-text font-weight-bold">Item Price</p>
								</div>

								<div class="col-2 d-flex align-items-center justify-content-center">
									<p class="card-text font-weight-bold">Quantity</p>
								</div>
							</div>
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="row">
								<div class="col-3 text-center">
									<img class="img-fluid" src="https://i.imgur.com/rQTN5g9.jpg">
								</div>

								<div class="col-4 d-flex align-items-center justify-content-center">
									<p class="card-text"><?php echo $productObj->name; ?></p>
								</div>

								<div class="col-3 d-flex align-items-center justify-content-center">
									<p class="card-text"><?php echo "Php " . number_format($productObj->price); ?></p>
								</div>

								<div class="col-2 d-flex align-items-center justify-content-center">
									<p class="card-text "><?php echo 'x' . $quantity; ?></p>
								</div>
							</div>
						</li>
						
					</ul>
				</div>

			</div>

			<div class="col-md-4">
				<div class="card mb-4">
					<div class="card-body">
						<h4 class="card-title mb-4">Billing Information</h4>
						<hr>

						<h6 class="">Address</h6>
						<p class="card-text"><?php echo $address; ?></p>


						<h6 class="">Payment Method</h6>
						<p class="card-text"><?php echo $paymentMethod; ?></p>
					</div>
					
				</div>
				
				<div class="card">
					<div class="card-body">
						<h4 class="card-title mb-4">Total</h4>
						<hr>

						<div class="d-flex justify-content-between">
							<h6>Order Total</h6>
							<p><?php echo "Php " . number_format($totalPrice); ?></p>
						</div>

						<div class="d-flex justify-content-between">
							<h6>Delivery Fee</h6>
							<p>Free</p>
						</div>
						
						<hr>
						<div class="d-flex justify-content-between">
							<h5 class="font-weight-bold">Grand Total</h5>
							<h5 class="font-weight-regular"><u><?php echo "Php " . number_format($totalPrice); ?></u></h5>
						</div>

						<div class="d-flex justify-content-between">
							<a href="javascript:history.go(-1)" class="mt-4 btn btn-lg cancel">Cancel</a>
							<a href="result-checkout.php" class="mt-4 btn btn-lg purchase">Place Order</a>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>