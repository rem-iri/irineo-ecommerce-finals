<?php
	require_once('service/service-checkout.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>
	<?php
		require_once('view-comp/nav.php');
		displayNav($sessionUsername);
	?>

	<div class="container main-content my-4">
		<?php if($success) { ?>
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">Order Placed!</h4>
			<p>Thank you for shopping at Adithus.</p>
			<hr>
			<a href="index.php" class="mb-0">Back to home</a>
		</div>

		<?php } else {?>

		<div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Checkout failed</h4>
			<p>Your request cannot be processed at this time.</p>
			<hr>
			<a href="index.php" class="mb-0">Back to home</a>
		</div>
		
		<?php } ?>
	</div>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>