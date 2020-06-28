<?php 
	define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

	function registrationLog($username) {
		$date = date('H:i, jS F Y');
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		$outputString = $date . ' - ' . $ipAddress . ' registered ' . $username.PHP_EOL;

		try {
			$file = fopen(DOCUMENT_ROOT . '/irineo-ecommerce-finals/logs/registration-log.txt', 'ab');

			if(!$file) {
				throw new Exception("cannot open file");
			} else {
				@ flock($file, 'LOCK_EX');
				fwrite($file, $outputString, strlen($outputString));
				@ flock($file, 'LOCK_UN');

				fclose($file);
			}
		} catch(Exception $e) {
			error_log($e->getMessage());
		}	
	}

	function loginLog($username) {
		$date = date('H:i, jS F Y');
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		$outputString = $date . ' - ' . $ipAddress.PHP_EOL;

		try {
			$file = fopen(DOCUMENT_ROOT . '/irineo-ecommerce-finals/logs/login-log.txt', 'ab');

			if(!$file) {
				throw new Exception("cannot open file");
			} else {
				@ flock($file, 'LOCK_EX');
				fwrite($file, $outputString, strlen($outputString));
				@ flock($file, 'LOCK_UN');

				fclose($file);
			}
		} catch(Exception $e) {
			error_log($e->getMessage());
		}	
	}

?>