<link rel="icon" type="img/png" href="img/logs.png">
<?php
	require 'authentication.php'; 

	if(isset($_SESSION['admin_id'])){
    header('Location: main.php');
	}

    if(isset($_POST['login_btn'])){
    $info = $obj_admin->onetuc_login_check($_POST);
   	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>OneTUC</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logs.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">OneTUC Login</h4>
							<form method="post" id="login-form">
                              	<?php if(isset($info)){ ?>
                                <h5 class="alert alert-danger"><?php echo $info; ?></h5>
                                 <?php } ?>
								<div class="form-group">
									<label for="email"><b>Username<b></label>
									<input id="email" type="text" class="form-control" name="username" value="" placeholder="Username..." required autofocus>
								</div>

								<div class="form-group">
									<label for="password"><b>Password<b></label>
									<input id="password" type="password" class="form-control" name="admin_password" placeholder="Password..." required data-eye>
								</div>

								<div class="form-group m-0">
									<button type="submit" value="Login" name="login_btn" class="btn btn-primary btn-block">
										Sign in
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>