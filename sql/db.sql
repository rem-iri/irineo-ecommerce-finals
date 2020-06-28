CREATE DATABASE IF NOT EXISTS adithus_db;

USE adithus_db;

CREATE TABLE IF NOT EXISTS products ( 
	product_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(255), 
	price DOUBLE, 
	imgURL VARCHAR(255), 
	previewImgURL VARCHAR(255));

CREATE TABLE IF NOT EXISTS user_info (
	id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	password VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	address VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS orders ( 
	order_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	address VARCHAR(255), 
	payment_method VARCHAR(255),
	total DOUBLE,
	quantity INT(4), 
	order_user_id INT(6) UNSIGNED, 
	order_product_id INT(10) UNSIGNED, 
	FOREIGN KEY (order_user_id) REFERENCES user_info(id), 
	FOREIGN KEY (order_product_id) REFERENCES products(product_id) 
)


INSERT INTO `products` (`product_id`, `name`, `price`, `imgURL`, `previewImgURL`) VALUES
(5, 'DURAMO 9 SHOES', 2500, 'https://i.imgur.com/bBTZjRp.jpg', 'https://i.imgur.com/rQTN5g9.jpg'),
(6, 'SUPERSTAR SHOES', 2600, 'https://i.imgur.com/fWK2pfe.jpg', 'https://i.imgur.com/8yXKvY5.jpg'),
(7, 'SUPERSTAR 360 SHOES', 2800, 'https://i.imgur.com/Lh3FEFJ.jpg', 'https://i.imgur.com/rbLFR8a.jpg'),
(8, 'SENSEBOOST GO SHOES', 4200, 'https://i.imgur.com/jOVEOi4.jpg', 'https://i.imgur.com/wfuN3T1.jpg'),
(9, 'CONTINENTAL 80 SHOES', 4000, 'https://i.imgur.com/7rD9pjj.jpg', 'https://i.imgur.com/XyRCMYa.jpg'),
(10, 'HARDEN VOL. 4 SHOES', 7000, 'https://i.imgur.com/C3PhNyN.jpg', 'https://i.imgur.com/yCWQtkW.jpg'),
(11, 'PUSHA T OZWEEGO', 8000, 'https://i.imgur.com/CQVKV9v.jpg', 'https://i.imgur.com/AjjFFp2.jpg'),
(12, 'X_PLR SHOES', 5300, 'https://i.imgur.com/MLB1Nv3.jpg', 'https://i.imgur.com/akBGRqk.jpg'),
(13, 'PULSEBOOST HD WINTER SHOES', 5500, 'https://i.imgur.com/FFevMND.jpg', 'https://i.imgur.com/eghbsvK.jpg'),
(14, 'SUPERCOURT SHOES', 5500, 'https://i.imgur.com/tHFu8Tk.jpg', 'https://i.imgur.com/0H4Rv87.jpg'),
(15, 'CONTINENTAL 80 SHOES', 5300, 'https://i.imgur.com/FwT6WIv.jpg', 'https://i.imgur.com/FxoKlWp.jpg'),
(16, 'FALCON SHOES', 5500, 'https://i.imgur.com/V1nIhsd.jpg', 'https://i.imgur.com/3H1ACti.jpg');