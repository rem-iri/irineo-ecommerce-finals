<?php
	class Order {
		private $userId;
		private $productId;
		private $quantity;
		private $totalPrice;
		private $shippingAddress

		public function __construct($idValue, $productIdValue, $quantityValue, $totalPriceValue, $shippingAddressValue) {
			$this->userId = $idValue;
			$this->productId = $productIdValue;
			$this->quantity = $quantityValue;
			$this->totalPrice = $totalPriceValue;
			$this->shippingAddress = $shippingAddressValue;
		}

		public function __get($property) {
			return $this->$property;
		}

		public function __set($property, $value) {
			$this->$property = $value;
		}
	}
?>