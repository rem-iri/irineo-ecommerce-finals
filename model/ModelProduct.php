<?php
	class Product {
		private $id;
		private $name;
		private $price;
		private $previewImgURL;

		public function __construct($idValue, $nameValue, $priceValue, $previewImgValue) {
			$this->id = $idValue;
			$this->name = $nameValue;
			$this->price = $priceValue;
			$this->previewImgURL = $previewImgValue;
		}

		public function __get($property) {
			return $this->$property;
		}

		public function __set($property, $value) {
			$this->$property = $value;
		}
	}
?>