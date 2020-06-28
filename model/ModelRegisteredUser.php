<?php 
	class RegisteredUser {
		private $id;
		private $firstName;
		private $lastName;
		private $username;
		private $password;
		private $address;

		public function __construct($idValue, $firstNameValue, $lastNameValue, $usernameValue, $passwordValue, $addressValue) {
			$this->id = $idValue;
			$this->firstName = $firstNameValue;
			$this->lastName = $lastNameValue;
			$this->username = $usernameValue;
			$this->password = $passwordValue;
			$this->address = $addressValue;
		}

		public function __get($property) {
			return $this->$property;
		}

		public function __set($property, $value) {
			$this->$property = $value;
		}
	}
?>