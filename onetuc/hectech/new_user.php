<?php
require 'authentication.php'; 

if(!isset($_SESSION['admin_id'])){
    header('Location: index.php');
}

if(isset($_POST['add_new_employee'])){
  $error = $obj_admin->add_new_user($_POST);
}
?>
<div class="wrapper">
<?php
include("include/topbar.php");
include("include/sidebar.php");
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
							<input type="text" placeholder="Enter Employee Name" name="em_fullname" list="expense" class="form-control input-custom" id="default" required>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Username</label>
							<input type="text" placeholder="Enter Employee username" name="em_username" class="form-control input-custom" required>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Contact no.</label>
							<input type="text" placeholder="Contact no.." name="em_contact" class="form-control input-custom" required>
						</div>
                        <div class="form-group">
							<label class="control-label">Address</label>
							<input type="text" placeholder="Address.." name="em_add" class="form-control input-custom" required>
							<small id="#msg"></small>
						</div>
					
						<div class="form-group">
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Gender</label>
							<select class="form-control" name="em_gender" id="em_gender">
                            <option value=Unknown >Unknown</option>
			                      <option value=Male >Male</option>
			                      <option value=Female >Female</option>
			                      </select>
						</div>
						<div class="form-group">
							<label class="label control-label">Domain account</label>
							<input type="text" placeholder="Domain account" name="em_account" class="form-control input-custom" required>
							<small id="pass_match" data-status=''></small>
						</div>
                        <div class="form-group">
							<label class="label control-label">Employee ID</label>
							<input type="text" placeholder="Employee ID" name="em_employeeID" class="form-control input-custom" required>
							<small id="pass_match" data-status=''></small>
						</div>
                        <div class="form-group">
							<label class="label control-label">Company</label>
							<select class="form-control" name="em_company" id="em_company" required>
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
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary  mr-2" type="submit" name="add_new_employee">Add</button>
					<button class="btn btn-danger " type="button" onclick="location.href = 'manage-admin.php'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include 'footer.php' ?>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
