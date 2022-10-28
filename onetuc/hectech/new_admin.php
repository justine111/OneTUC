<link rel="icon" type="img/png" href="img/logs.png">
<?php
	require 'authentication.php'; 
	$user_role = $_SESSION['user_role'];
?>
<div class="wrapper">
<?php
	include("include/topbar.php");
	include("include/sidebar.php");
?>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php

   	if(isset($_POST['add_new_admin'])){
    $error = $obj_admin->add_new_admin($_POST);

	if($user_role == 4){
		$sql = "UPDATE [atYourService].[dbo].[user_masterinfos] SET user_status = 'Approved' WHERE user_id = (SELECT top 1 user_id FROM [atYourService].[dbo].[user_masterinfos] ORDER BY user_id DESC)";
		$obj_admin->manage_all_info($sql);
		$sql = "UPDATE [OneTUC].[dbo].[user_masterinfos] SET user_status = 'Approved' WHERE user_id = (SELECT top 1 user_id FROM [OneTUC].[dbo].[user_masterinfos] ORDER BY user_id DESC)";
		$obj_admin->manage_all_info($sql);
		}

	}
?>
<br>
	<section class="content">
   		<div class="container-fluid">     
     		<div class="content-wrapper">
       			<div class="col-lg-12">
	     			<div class="card">
		   				<div class="card-body">
             			<form role="form" action="" method="post" autocomplete="off">
                 		<?php if(isset($error)){ ?>
                 		<h5 class="alert alert-danger"><?php echo $error; ?></h5>
                 		<?php } ?>
					<div class="row">
						<div class="col-md-6 border-right">
							<div class="form-group">
							<label for="" class="control-label">Fullname</label>
							<input type="text" placeholder="Enter Employee Name" name="ad_fullname" list="expense" class="form-control input-custom" id="default" required>
						</div>

						<div class="form-group">
							<label for="" class="control-label">Username</label>
							<input type="text" placeholder="Enter Employee username" name="ad_username" class="form-control input-custom" required>
						</div>

						<div class="form-group">
							<label for="" class="control-label">Contact no.</label>
							<input type="text" placeholder="Contact no.." name="ad_contact" class="form-control input-custom" required>
						</div>

                        <div class="form-group">
							<label class="control-label">Address</label>
							<input type="text" placeholder="Address.." name="ad_add" class="form-control input-custom" required>
							<small id="#msg"></small>
						</div>
					
						<div class="form-group">
						  </div>
						  <div class="form-group d-flex justify-content-center align-items-center">
						  </div>
					    </div>

					   <div class="col-md-6">
							<div class="form-group">
						   		<label class="label control-label">Department</label>
						   		<select multiple class="form-control form-control-sm select2" name="ad_department" id="ad_department">
                           		<?php 
                           		$sql = "SELECT * FROM [admin].[departments] ";
                           		$info = $obj_admin->manage_all_info($sql);  ?>
                           		<option value="">Select Company...</option>
                           		<?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                           		<option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                          		<?php } ?>
                        	</select>
					 	</div>

						<div class="form-group">
							<label class="label control-label">Domain account</label>
							<input type="text" placeholder="Domain account" name="ad_account" class="form-control input-custom" required>
							<small id="pass_match" data-status=''></small>
						</div>

                        <div class="form-group">
							<label class="label control-label">Employee ID</label>
							<input type="text" placeholder="Employee ID" name="ad_employeeID" class="form-control input-custom" required>
							<small id="pass_match" data-status=''></small>
						</div>

                        <div class="form-group">
							<label class="label control-label">Company</label>
							<select class="form-control" name="ad_company" id="ad_company" required>
                      		<?php 
                        	$sql = "SELECT * FROM [admin].[companies] ";
                        	$info = $obj_admin->manage_all_info($sql);   
                        	?>
                        	<option value="">Select Company...</option>
                        	<?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        	<option value="<?php echo $row['company_id']; ?>"><?php echo $row['code']; ?></option>
                        	<?php } ?>
                          </select>
					    </div>
				      </div>

				    <div class="col-md-6">
				       <div class="form-group">
							<label class="control-label">Gender</label>
							<select class="form-control" name="ad_gender" id="ad_gender">
                            <option value=Unknown >Unknown</option>
			                <option value=Male >Male</option>
			                <option value=Female >Female</option>
			                </select>
						</div>
					</div>

					<div class="col-md-6">
					  <div class="form-group">
							<label class="label control-label">Account role</label>
							<select class="form-control" name="account_role" id="account_role" required>
                    		<?php 
                        	$sql = "SELECT * FROM [admin].[roles] ";
                        	$info = $obj_admin->manage_all_info($sql);   
                      		?>
                        	<option value="">Select Role...</option>
                        	<?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        	<option value="<?php echo $row['role_id']; ?>"><?php echo $row['description']; ?></option>
                        	<?php } ?>
                         </select>
					   </div>
				    </div>

				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" type="submit" name="add_new_admin" onclick="location.href = 'manage-admin.php'">Add</button>
					<button class="btn btn-danger" type="button" onclick="location.href = 'manage-admin.php'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php include 'footer.php' ?>