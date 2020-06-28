<?php
	session_start();

	if(@!$_SESSION['username']) {
		header('login.php?promptLogin=true');
	}

	$username = $_SESSION['username'];

	if(@$_POST['productId'] || @$_POST['quantity']) {
		$_SESSION['productId'] = @$_POST['productId'];
		$_SESSION['quantity'] = @$_POST['quantity'];
	}

	if(@!$_SESSION['productId'] || @!$_SESSION['quantity']) {
		header('Location: index.php');
	}

	try {
		// create connection
		$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

		$dbError = mysqli_connect_errno();
		if($dbError) {
			throw new Exception('Cannot connect to database. Try again later.');
		}

		$queryUser = 
		"
			SELECT * FROM user_info 
				WHERE username = ?
				 LIMIT 1;
		";

		$stmt = $db->prepare($queryUser);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0) {
			$userData = $result->fetch_array();

			$_SESSION['address'] = $userData['address'];
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
	<title>Order Form</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>

	<?php
		require_once('view-comp/nav.php');
		displayNav($sessionUsername);
	?>

<div class="container main-content checkout mt-5">
	<div class="card" >
		<div class="card-body">
			<div class="container">
				<h4 class="mb-3">Billing Information</h4>
				<form class="" action="confirm-checkout.php" method="POST">

					<div class="mb-3">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required="" value="<?php echo (@$_SESSION['address']) ? $_SESSION['address'] : "" ?>">
						<div class="invalid-feedback">
							Please enter your shipping address.
						</div>
					</div>

					<hr class="mb-4">

					<h4 class="mb-3">Payment</h4>

					<div class="d-block my-3">
						<div class="custom-control custom-radio">
							<input id="card" name="paymentMethod" type="radio" class="custom-control-input" checked required="" value="Credit/Debit Card">
							<label class="custom-control-label" for="card">Debit/Credit card</label>
						</div>

						<div class="custom-control custom-radio">
							<input id="cod" name="paymentMethod" type="radio" class="custom-control-input" required="" value="Cash On Delivery">
							<label class="custom-control-label" for="cod">Cash on Delivery</label>
						</div>

					</div>

					<div id="card-form">
						<div class="row">
							<div class="col mb-3">
								<label for="cc-number">Credit card number</label>
								<input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required="" value="<?php echo (@$_SESSION['cc-number'] && strcmp(@$_SESSION['paymentMethod'], "Credit/Debit Card") == 0) ? $_SESSION['cc-number'] : "" ?>">
								<div class="invalid-feedback">
									Credit card number is required
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col mb-3">
								<label for="cc-expiration">Expiration</label>
								<input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="DD-MM-YY" required="" value="<?php echo (@$_SESSION['cc-expiration'] && strcmp(@$_SESSION['paymentMethod'], "Credit/Debit Card") == 0) ? $_SESSION['cc-expiration'] : "" ?>">
								<div class="invalid-feedback">
									Expiration date required
								</div>
							</div>
							<div class="col mb-3">
								<label for="cc-expiration">CVV</label>
								<input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required="" value="<?php echo (@$_SESSION['cc-cvv'] && strcmp(@$_SESSION['paymentMethod'], "Credit/Debit Card") == 0) ? $_SESSION['cc-cvv'] : "" ?>">
								<div class="invalid-feedback">
									Security code required
								</div>
							</div>
						</div>
					</div>
					<hr class="mb-4">
					<div class="d-flex justify-content-between">
						<a href="javascript:history.go(-1)" class="mt-4 btn btn-lg cancel">Cancel</a>
						<button class="mt-4 btn btn-primary btn-lg" type="submit">Proceed to Review Order</button>
					</div>
					
				</form>

			</div>

		</div>
	</div>

</div>

	<script type="text/javascript">
		let radioElements = document.querySelectorAll('input[type=radio]');
		for(let e of radioElements) {
			e.addEventListener('click', showCardForm);
		}

		function showCardForm(event) {

			console.log("w" + event.currentTarget);
			if(cod.checked) {
				document.getElementById('card-form').style.display = 'none';
				document.getElementById('cc-number').required = false;
				document.getElementById('cc-expiration').required = false;
				document.getElementById('cc-cvv').required = false;
			}
			else {
				document.getElementById('card-form').style.display = '';
			}
		}
	</script>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>