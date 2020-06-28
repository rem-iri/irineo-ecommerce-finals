<?php
	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
		if(!$username || !$password) {
			throw new Exception('Registration data not complete. Please try again.');
		}

		$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

		$dbError = mysqli_connect_errno();
		if($dbError) {
			throw new Exception('Cannot connect to database. Try again later.');
		}

		$query = 
		'
		SELECT * FROM user_info
			WHERE username = ? AND password = ?;
		';

		$stmt = $db->prepare($query);
		$hashedPassword = hash('sha512', $password);
		$stmt->bind_param("ss", $username, $hashedPassword);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->fetch_assoc()) {
			require_once('service-log.php');
			loginLog($username);
			session_start();
			$_SESSION['username'] = $username;
			header('Location: ../index.php');
		} else {
			throw new Exception('Invalid credentials.');
		}

	} catch(Exception $e) {
		header('Location: ../login.php?error=' . $e->getMessage());
		error_log($e->getMessage());
	}
?>