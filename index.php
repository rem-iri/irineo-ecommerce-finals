<?php
	require_once('model/ModelProduct.php');

	@$searchTerm = $_GET['searchTerm'];
	if($searchTerm) {
		$searchTerm = trim($searchTerm);
	}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Adithus - Home</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>

	<?php
		require_once('view-comp/nav.php');
		displayNav($sessionUsername);
	?>

	<div class="browse container main-content mt-5">
		<?php 
			if(strlen($searchTerm) < 2 && $searchTerm) {
				echo '<div class="alert alert-danger">' . 'Please enter atleast 2 characters long' . '</div>';
			}
			else {
		?>

		<?php 
			echo ( @ $searchTerm ? '<h2>Search results for "' . $searchTerm . '"</h2>' : '<h2>New Arrivals</h2>'); 
		?>
		

		<div class="row">
			<?php

				try {
					$db = new mysqli('127.0.0.1:3306', 'root', '', 'adithus_db');

					$dbError = mysqli_connect_errno();
					if($dbError) {
						throw new Exception('Cannot connect to database. Try again later.');
					}

					if($searchTerm) {
						$query = 
						'
							SELECT *
								FROM products
								WHERE name LIKE ?;';

						$stmt = $db->prepare($query);
						$newSearchTerm = '%' . $searchTerm . '%';
						$stmt->bind_param("s", $newSearchTerm);
						$stmt->execute();
						$result = $stmt->get_result();
					}
					else {
						$query = 
						'
							SELECT *
								FROM products
								LIMIT 12' . ";";

						$stmt = $db->prepare($query);
						$stmt->execute();
						$result = $stmt->get_result();
					}
					
					$documentRoot = $_SERVER['DOCUMENT_ROOT'];

					$resultCount = $result->num_rows;

					$productArr = array();

					for($ctr = 0; $ctr < $resultCount; $ctr++) {
						$row = $result -> fetch_assoc();
						array_push($productArr, new Product($row['product_id'], $row['name'], $row['price'], $row['previewImgURL']));
					}
					
					foreach($productArr as $product) {
					?>
						<div class="col-md-3">
							<a href="view-product.php?product-id=<?php echo $product->id; ?>">
								<div class="card mb-3 box-shadow">
									<img class="card-img-top" style=" display: block;" src="<?php echo $product->previewImgURL; ?>">
									<div class="card-body">
										<p class="card-text font-weight-bold"> <?php echo $product->name; ?> </p>
										<div class="d-flex justify-content-between align-items-center">
											<div class="btn-group">
												<button type="button" class="btn btn-sm btn-outline-secondary btnColors">&nbsp&nbsp&nbsp&nbsp</button>
												<button type="button" class="btn btn-sm btn-outline-secondary btnColors">&nbsp&nbsp&nbsp&nbsp</button>
											</div>
											<div class=""> <?php echo "Php " . number_format($product->price); ?> </div>
										</div>
									</div>
								</div>
							</a>
						</div>
					<?php
					}

				} catch(Exception $e) {
					error_log($e->getMessage());
				}
			}
			?>

		</div>
	</div>

	<?php require_once('view-comp/footer.php'); ?>

	<script type="text/javascript">
		(function myColors () {
		    let productColors = document.querySelectorAll('.btnColors');

		    for(let element of productColors) {
		        element.style.backgroundColor = `rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)})`;
		    }
		})();
	</script>
	
	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>

