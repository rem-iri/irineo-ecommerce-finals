<?php
	if($_SERVER['HTTPS'] != 'on') {
		header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>

	<?php require_once('view-comp/css.php'); ?>
</head>
<body>
	<?php
		require_once('view-comp/nav.php');
		if($sessionUsername) {
			header('Location: index.php');
		}
		displayNav($sessionUsername);
	?>

	<div class="container login main-content my-4">
		<div class="card" >
			<div class="card-body">
				<h3 class="card-title">Login</h3>

				<form action="service/service-login.php" method="post">
					<?php
						if(isset($_GET['error'])) {
							echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
						}
						if(isset($_GET['promptLogin'])) {
							echo '<div class="alert alert-danger">' . 'You must login first.' . '</div>';
						}
						if(isset($_GET['success'])) {
							echo '<div class="alert alert-success">' . 'Successfully created an account. Please log in.' . '</div>';
						}
					?>

					<div class="form-group">
						<label for="username">Username</label>
						<input class="form-control" type="text" id="username" name="username" placeholder="" required>
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" id="password" name="password" placeholder="" required>
					</div>


					<div class="form-group">
						<button class="btn btn-primary" type="submit">Sign in</button><br>
					</div>

					<div class="">
						<span>No account yet? </span><a href="register.php" style="text-decoration: underline;">Register here</a>
					</div>
				</form>

			</div>
		</div>
	</div>

	<?php require_once('view-comp/footer.php'); ?>

	<?php require_once('view-comp/scripts.php'); ?>
</body>
</html>