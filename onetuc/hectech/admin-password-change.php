<!---------- authenticate and function for header display name/ID --------->
<?php
  require 'authentication.php'; 
  $admin_id = $_GET['admin_id'];
?>
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>

<?php
  if(isset($_POST['btn_admin_password'])){
  $error =  $obj_admin->admin_password_change($_POST,$admin_id);
  }
?>
<!---------- admin change password --------->
<script>
  function validate(admin_new_password,admin_cnew_password){
      var a = document.getElementById(admin_new_password).value;
      var b = document.getElementById(admin_cnew_password).value;
      if (a!=b) {
          alert("Passwords do not match");      
      }
      return false;
  }
</script>

<!---------- Manage admin --------->
<br>  
  <section class="content">
    <div class="container-fluid">     
      <div class="content-wrapper">
        <div class="col-lg-12">
	        <div class="card card-outline card-danger">
            <div class="card-header">
              <h3 class="text-center">Change Password</h3><br>
                <div class="row">
                  <div class="col-md-3">
                    <div class="text-center">
                      <img src="img/logs.png" class="avatar img-circle img-thumbnail" alt="avatar">
                      <br>
                      <br>
                      <div class="col-md-12" >
                        <i>Change Password</i>
                    </div>
                  </div>
                </div>
    
                <div class="col-md-8 col-md-offset-2">
                  <?php  if(isset($error)){ ?>
                    <div class="alert alert-danger">
                      <strong>Oopps!!</strong> <?php echo $error; ?>
                    </div>
                  <?php } ?> 
                <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
                  <div class="row">
                    <div class="col-md-6 border-right">
                      <div class="form-group">
                        <label class="control-label col-sm-7">Old Password</label>
                          <div class="col-sm-12">
                             <input type="password" placeholder="Enter Old Password" name="admin_old_password" id="admin_old_password" list="expense" class="form-control input-custom" required>
                            </div>
                          </div>
                        </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label col-sm-7">New Password</label>
                            <div class="col-sm-12">
                              <input type="password" placeholder="Enter New Password" name="admin_new_password" id="admin_new_password" class="form-control input-custom" min="8" required>
                            </div>
                         </div>
                        <div class="form-group">
                          <label class="control-label col-sm-7">Confirm New Password</label>
                            <div class="col-sm-12">
                              <input type="password" placeholder="Confirm New Password" name="admin_cnew_password" id="admin_cnew_password" list="expense" min="8" class="form-control input-custom" required>
                            </div>
                        </div>
                        <div class="col-lg-12 text-right justify-content-center d-flex">
                            <button type="submit" name="btn_admin_password" class="btn btn-warning">Change</button>
                            <button class="btn btn-danger" name="cancel" type="button" onclick="location.href = 'manage-admin.php' ">Cancel</button>    
                        </div>
                      </div>
                    </form> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php include 'footer.php' ?>
<!---------- end of manage admin --------->
<?php
if(isset($_SESSION['update_user_pass'])){
  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
?>
