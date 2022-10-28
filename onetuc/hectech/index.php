<!---------- authenticate and function for header display name/ID --------->
<?php
	require 'authentication.php';
//****to prevent dicrect access****//
	if(isset($_SESSION['admin_id'])){
	$user_id = $_SESSION['admin_id'];
	$user_name = $_SESSION['admin_name'];
	$security_key = $_SESSION['security_key'];
	if ($user_id != NULL && $security_key != NULL) {
	  header('Location: task-info.php');
	}
  }

	if(isset($_POST['login_btn'])){
 	$info = $obj_admin->admin_login_check($_POST);
	}
?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>HecTech Ticketing System</title>
    	<link rel="icon" type="img/png" href="img/logs.png"/>
    	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	</head>
	<body>
	<div class="container">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
				<div class="card-body">
            		<form method="post" id="login-form">
             			<?php if(isset($info)){ ?>
             			<h5 class="alert alert-danger"><?php echo $info; ?></h5>
             			<?php } ?>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
							<input type="text" name="username" id="user" class="form-control" placeholder="Username" required/>	
						</div>
						<div class="input-group form-group">
							<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						 </div>
							<input type="password" name="admin_password" class="form-control" id="id_password"  placeholder="Password" required/>
						 </div>
					     <div class="form-group">
						 	<input type="submit" value="Login" name="login_btn" style='width:70px;margin:0 50%;position:relative;left:-35px;' class="btn float-left login_btn">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

html,body{
background-image: url('img/tuc.jpg');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Poppins',sans-serif;
}
.container{
height: 100%;
align-content: center;
}
.card{
height: 200px;
margin-top: auto;
margin-bottom: auto;
width: 350px;
background-color: transparent; !important;
}
.card-header h3{
color: white;
}
.input-group-prepend span{
width: 40px;
background-color: #fff500;
color: black;
border:0 !important;
}
input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}
.login_btn{
color: black;
background-color: #fff500;
width: 80px;
}
.login_btn:hover{
color: black;
background-color: #fff500;
}
</style>
