<?php
	if($_SERVER['HTTPS'] != 'on') {
		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit;
	}
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

	<div class="container register main-content my-4">
		<div class="card" >
			<div class="card-body">
				<div class="container">
		  <h2 class="mb-3">Sign up</h2>
		  <h5 class="mb-3">Please fill out the following details.</h5>
			<?php
				if(isset($_GET['error'])) {
					echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
				}
			?>

		  <form class="needs-validation" method="POST" action="service/service-register.php">
			<div class="row">
			  <div class="col-md-6 mb-3">
				<label for="firstName">First name</label>
				<input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="" required="">
				<div class="invalid-feedback">
				  Valid first name is required.
				</div>
			  </div>
			  <div class="col-md-6 mb-3">
				<label for="lastName">Last name</label>
				<input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="" required="">
				<div class="invalid-feedback">
				  Valid last name is required.
				</div>
			  </div>
			</div>

			<div class="mb-3">
			  <label for="username">Username</label>
			  <div class="input-group">
				<div class="input-group-prepend">
				  <span class="input-group-text">@</span>
				</div>
				<input type="text" class="form-control" id="username" name="username" placeholder="Username" required="">
				<div class="invalid-feedback" style="width: 100%;">
				  Your username is required.
				</div>
			  </div>
			</div>

			<div class="mb-3">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
				<div class="invalid-feedback" style="width: 100%;">
				  Your password is required.
				</div>
			</div>

			<div class="mb-3">
				<label for="confirmPassword">Confirm Password</label>
				<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required="">
				<div class="invalid-feedback" style="width: 100%;">
				  Please confirm your password.
				</div>
			</div>
			<hr class="mb-4">
			<button class="btn btn-primary btn-lg btn-block" type="submit">Create an Account</button>
		  </form>
		</div>

			</div>
		</div>
	</div>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>