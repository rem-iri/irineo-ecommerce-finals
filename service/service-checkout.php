<?php 
	session_start();

	if(@!$_SESSION['username']) {
		header('Location: login.php?promptLogin=true');
	}

	$username = $_SESSION['username'];

	try {
		$success = false;

		if(!$_SESSION['productId'] || !$_SESSION['quantity'] || !$_SESSION['address'] || !$_SESSION['paymentMethod'] || !$_SESSION['totalPrice']) {
			header('Location: index.php');
			throw new Exception('Order details not compete.');
		}

		$productId = $_SESSION['productId'];
		$quantity = $_SESSION['quantity'];
		$address = $_SESSION['address'];
		$paymentMethod = $_SESSION['paymentMethod'];
		$totalPrice = $_SESSION['totalPrice'];

		// create connection
		$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

		$dbError = mysqli_connect_errno();
		if($dbError) {
			throw new Exception('Cannot connect to database. Try again later.');
		}

		$queryCheckUsername = 
		"
			SELECT * FROM user_info 
				WHERE username = ?
				LIMIT 1;
		";

		$stmt = $db->prepare($queryCheckUsername);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows == 0) {
			header('Location: result-checkout.php?checkoutFail=true');
		}
		else {
			$row = $result->fetch_assoc();
			$userId = $row['id'];

			$query = 
			'
				INSERT INTO orders(address, payment_method, total, quantity, order_user_id, order_product_id) 
					VALUES (?, ?, ?, ?, ?, ?);
			';

			$stmt = $db->prepare($query);
			$stmt->bind_param("ssdiii", $address, $paymentMethod, $totalPrice, $quantity, $userId, $productId);
			$stmt->execute();

			$affected_rows = $stmt->affected_rows;
			if($affected_rows > 0) {
				$success = true;
			} else {
				$success = false;
				throw new Exception('Insert failed.');
			}

			$updateUserAddress = 
			'
				UPDATE user_info
					SET address = ? 
					WHERE id = ?;
			';

			$stmt = $db->prepare($updateUserAddress);
			$stmt->bind_param("ss", $address, $userId);
			$stmt->execute();

			$affected_rows = $stmt->affected_rows;
		}

	} catch(Exception $e) {
		header('Location: ../index.php');
		error_log($e->getMessage());
	} finally {
		unset($_SESSION['productId']);
		unset($_SESSION['quantity']);
		unset($_SESSION['address']);
		unset($_SESSION['paymentMethod']);
		unset($_SESSION['totalPrice']);
		unset($_SESSION['cc-number']);
		unset($_SESSION['cc-expiration']);
		unset($_SESSION['cc-cvv']);
	}
?>

