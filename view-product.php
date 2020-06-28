<?php
	if(!$_GET['product-id']) {
		header('Location: index.php');
	}

	$productId = $_GET['product-id'];

	try {
		// create connection
		$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

		$dbError = mysqli_connect_errno();
		if($dbError) {
			throw new Exception('Cannot connect to database. Try again later.');
		}

		//check if author already exists
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
		$dataResult = $result->fetch_array();
	}
	catch(Exception $e) {
		header('Location: index.php?productFetchFailure=true');
		error_log($e->getMessage());
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>View</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>
	<?php
		require_once('view-comp/nav.php');
		displayNav($sessionUsername);
	?>

	<div class="container main-content my-4">
		<div class="row">
			<div class="col-md-7 text-center">
				<img class="img-fluid" src="<?php echo $dataResult['imgURL']; ?>">
			</div>
			
			<div class="col-md-5">

				<h1 class="my-3"><?php echo $dataResult['name'] ?></h1>

				<h6>Description</h6>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat.</p>

				<h6>Colors</h6>
				<div class="btn-group mb-3">
					<button type="button" class="btn btn-sm btn-outline-secondary btnColors">&nbsp;&nbsp;&nbsp;&nbsp;</button>
					<button type="button" class="btn btn-sm btn-outline-secondary btnColors">&nbsp;&nbsp;&nbsp;&nbsp;</button>
				</div>



				<h6>Quantity</h6>
				<form action="checkout.php" method="POST">
					<input type="text" id="productId" name="productId" value="<?php echo $productId; ?>" hidden>
					<input class="form-control w-50" type="number" id="quantity" name="quantity" min="1" value="1">

					<h4 class="d-block font-weight-bold text-right my-5">Php <?php echo number_format($dataResult['price']); ?></h4>

					<?php 
						echo @!$_SESSION['username'] ?
						'<a class="btn btn-lg btn-block my-5 purchase" href="login.php?promptLogin=true;">Purchase</a>'
						:
						'<button class="btn btn-lg btn-block my-5 purchase">Purchase</button>';
					?>	
				</form>


			</div>
		</div>
		
	</div>

	<script type="text/javascript">
		(function myColors () {
		    let productColors = document.querySelectorAll('.btnColors');

		    for(let element of productColors) {
		        element.style.backgroundColor = `rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)})`;
		    }
		})();
	</script>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>