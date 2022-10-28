<!---------- authenticate account ID--------->
<?php
	require 'authentication.php'; 
	$user_id = $_SESSION['admin_id'];

	if(isset($_POST['change_password_btn'])){
 	$info = $obj_admin->change_password_for_employee($_POST);
	}
	include("include/login_header.php");
?>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logoo.png" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<form class="form-horizontal form-custom-login" action="" method="POST">
								<?php if(isset($info)){ ?>
			  						<h5 class="alert alert-danger"><?php echo $info; ?></h5>
			  							<?php } ?>
										  <div class="form-heading">
			    							 	<h2 class="text-center">Change your Temporary Password</h2>
			  								</div>
											<div class="form-group">
												<label for="email"><b>Password :<b></label>
												<input type="hidden" class="form-control" name="user_id" value="<?php echo $user_id; ?>" required/>
			    								<input type="password" class="form-control" placeholder="Password" name="password" required/>
											</div>

											<div class="form-group">
												<label for="password"><b>Confrim Password :<b></label>
												<input type="password" class="form-control" placeholder="Retype Password" name="re_password" required/>
											</div>

											<div class="form-group m-2">
												<button type="submit" name="change_password_btn" class="btn btn-primary pull-right" onclick="myFunction()">Change Password</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			<script>
  				function myFunction() {
  				alert("Password Changed!");
				  window.close();
 			 	}
			</script>

			<style>
				html,body{
				background-image: url('img/new.jpg');
				background-size: cover;
				background-repeat: no-repeat;
				min-height: 100vh;
				padding: 0 16px;
				justify-content: center;
				align-items: center;
				font-family: 'Poppins',sans-serif;
				}
				.my-login-page .brand {
				width: 90px;
				height: 90px;
				overflow: hidden;
				border-radius: 50%;
				margin: 40px auto;
				box-shadow: 0 4px 8px rgba(0,0,0,.05);
				position: relative;
				z-index: 1;
				}
				.my-login-page .brand img {
				width: 100%;
    			align-items: center;
				}
				.my-login-page .card-wrapper {
				width: 400px;
				}
			</style>