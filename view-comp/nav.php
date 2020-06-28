<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	@$sessionUsername = $_SESSION['username'];
	function displayNav($sessionUsername) {
		if(!$sessionUsername) { ?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light font-weight-bold">

				<div class="container">
					<a class="navbar-brand" href="http://localhost/irineo-ecommerce-finals">
						<img src="https://i.imgur.com/J1z6f04.png">
					</a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarsExample07">
						<form class="form-inline w-50 mx-auto" action="index.php" method="GET">
							<div class="btn-group w-100">
								<input class="form-control w-100" type="text" id="searchTerm" name="searchTerm" placeholder="Search for product name, brand, etc" aria-label="Search">
								<button type="submit" class="btn btn-sm btn-outline-secondary btnSearch">Search</button>
							</div>
						</form>

						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="https://localhost/irineo-ecommerce-finals/login.php">Login<span class="sr-only">(current)</span></a>
							</li>

						</ul>
					</div>
				</div>

			</nav>
		<?php
		} else { ?>

			<nav class="navbar navbar-expand-lg navbar-light bg-light font-weight-bold">

				<div class="container">
					<a class="navbar-brand" href="http://localhost/irineo-ecommerce-finals">
						<img src="https://i.imgur.com/J1z6f04.png">
					</a>
					
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarsExample07">
						<form class="form-inline w-50 mx-auto" action="index.php" method="GET">
							<div class="btn-group w-100">
								<input class="form-control w-100" type="text" id="searchTerm" name="searchTerm" placeholder="Search" aria-label="Search">
								<button type="button" class="btn btn-sm btn-outline-secondary btnSearch">Search</button>
							</div>
						</form>

						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="#">
									My Account
									<span class="sr-only">(current)</span>
								</a>
							</li>

							<li class="nav-item">
								<div class="nav-link" href="#">|</div>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="./service/service-logout.php">Logout</a>
							</li>
	
						</ul>
					</div>
				</div>

			</nav>
		<?php
		}
	}
?>