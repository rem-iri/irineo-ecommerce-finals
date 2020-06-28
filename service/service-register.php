<?php
	require_once('../model/ModelRegisteredUser.php');

	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];

	try {
		if(!$firstName || !$lastName || !$username || !$password || !$confirmPassword ) {
			throw new Exception('Registration data not complete. Please try again.');
		}

		if($password != $confirmPassword) {
			throw new Exception('Passwords do not match.');
		}

		if(strlen($password) < 8) {
			throw new Exception('Password must be atleast 8 characters long.');
		}

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

		if($result->num_rows > 0) {
			throw new Exception('Username already exists.');
		}
		else {
			$query = 
			'
			INSERT INTO user_info(first_name, last_name, username, password)
				VALUES (?, ?, ?, ?);
			';

			$stmt = $db->prepare($query);
			$hashedPassword = hash('sha512', $password);

			$registeredUser = new RegisteredUser(NULL, $firstName, $lastName, $username, $hashedPassword, NULL);

			$stmt->bind_param("ssss", $registeredUser->firstName, $registeredUser->lastName, $registeredUser->username, $registeredUser->password);
			$stmt->execute();


			$affected_rows = $stmt->affected_rows;
			if($affected_rows > 0) {
				require_once('service-log.php');
				registrationLog($username);
				header('Location: ../login.php?' . 'success=true');
			} else {
				throw new Exception('Could not add user.');
			}
		}

	} catch(Exception $e) {
		header('Location: ../register.php?' . 'error=' . $e->getMessage());
		error_log($e->getMessage());
	} 
?>
