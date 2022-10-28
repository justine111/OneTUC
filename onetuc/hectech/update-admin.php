<link rel="icon" type="img/png" href="img/logs.png">
<?php
require 'authentication.php';
$admin_id = $_GET['admin_id'];

              $sql = "SELECT 
              main.user_id,
              main.username,
              main.full_name,
              main.contact_number,
              main.address,
              main.gender,
              main.domain_account,
              main.employee_id,
              b.description,
              c.code,
              d.department_name,
              d.department_id
            FROM [dbo].[user_masterinfos] main
            LEFT JOIN [dbo].[user_rolemap] a ON a.user_id = main.user_id
            LEFT JOIN [admin].[roles] b ON b.role_id = a.role_id
            LEFT JOIN [admin].[companies] c ON c.company_id = a.company_id
            LEFT JOIN [admin].[departments] d ON d.department_id = a.department_id
            WHERE main.user_id = '$admin_id' ORDER BY main.user_id DESC";
            $info = $obj_admin->manage_all_info($sql);
            $row = $info->fetch(PDO::FETCH_ASSOC);
?>
<div class="wrapper">
  <?php
    include("include/topbar.php");
    include("include/sidebar.php");
  ?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <?php
    if(isset($_POST['update_current_employee'])){
    $obj_admin->update_admin_data($_POST,$admin_id);

        echo "<script>           
                  Swal.fire({
                      icon: 'success',
                      title: 'User Account',
                      text: 'Successfully Updated!',
                      showConfirmButton: true,
                      confirmButtonText:'Confirm ',
                      confirmButtonColor:'#1E90FF ',
                      closeOnConfirm: false
                  });
              </script>";
          }
  ?>

<br>
 <section class="content">
  <div class="container-fluid">     
   <div class="content-wrapper">
    <div class="col-lg-12">
	   <div class="card card-outline card-danger">
		  <div class="card-header">
	     <div class="row">
        <!-- change password side -->
         <div class="col-md-3">
           <div class="text-center">
            <img src="img/logs.png" class="avatar img-circle img-thumbnail" alt="avatar">
             <br>
             <br>
           <div class="col-md-12" >
            <a href="admin-password-change.php?admin_id=<?php echo $row['user_id'];?>">Change Password</a>
             </div>
           </div>
         </div>
      <div class="col-md-9 personal-info">
        <div class="alert alert-info">
          <center><h3>Personal info</h3></center>
        </div>
      <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">
        <div class="row">
          <div class="col-md-6 border-right">
            <div class="form-group">
              <label class="control-label col-sm-7">Fullname</label>
                <div class="col-sm-12">
                  <input type="text" value="<?php echo $row['full_name']; ?>" placeholder="Enter Employee Name" name="ad_fullname" list="expense" class="form-control input-custom" id="default" required>
               </div>
             </div>

            <div class="form-group">
              <label class="control-label col-sm-7">Contact</label>
               <div class="col-sm-12">
                 <input type="text" value="<?php echo $row['contact_number']; ?>" placeholder="Contact no.." name="ad_contact" class="form-control input-custom">
              </div>
            </div>

          <div class="form-group">
            <label class="control-label col-sm-7">Address</label>
              <div class="col-sm-12">
                <input type="text" value="<?php echo $row['address']; ?>" placeholder="Address.." name="ad_add" class="form-control input-custom">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-7">Gender</label>
              <div class="col-sm-12">
                <input type="text" value="<?php echo $row['gender']; ?>" placeholder="Gender.." name="ad_gender" class="form-control input-custom">
             </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label col-sm-7">Username</label>
                <div class="col-sm-12">
                  <input type="text" value="<?php echo $row['username']; ?>" placeholder="username" name="ad_user" class="form-control input-custom">
              </div>
          </div>
           
          <div class="form-group">
            <label class="control-label col-sm-7">Employee ID</label>
              <div class="col-sm-12">
                <input type="text" value="<?php echo $row['employee_id']; ?>" placeholder="Domain account" name="ad_employeid" class="form-control input-custom">
             </div>
          </div>

					<div class="form-group">
						<label class="control-label col-sm-7">Department</label>
              <div class="col-sm-12">
						    <select class="form-control" name="ad_department" id="ad_department">
                  <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php 
                        $sql = "SELECT * FROM [admin].[departments] ";
                        $info = $obj_admin->manage_all_info($sql);  ?>
                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php } ?>
                </select>
					    </div>
          </div>

          <div class="form-group">
						<label class="control-label col-sm-7">Company</label>
                      <?php
                      $sql = "SELECT 
                      main.user_id,
                      main.username,
                      main.full_name,
                      main.contact_number,
                      main.address,
                      main.gender,
                      main.domain_account,
                      main.employee_id,
                      b.description,
                      c.code,
                      d.department_name,
                      c.company_id
                      FROM [dbo].[user_masterinfos] main
                      LEFT JOIN [dbo].[user_rolemap] a ON a.user_id = main.user_id
                      LEFT JOIN [admin].[roles] b ON b.role_id = a.role_id
                      LEFT JOIN [admin].[companies] c ON c.company_id = a.company_id
                      LEFT JOIN [admin].[departments] d ON d.department_id = a.department_id
                      WHERE main.user_id = '$admin_id' ORDER BY main.user_id DESC";
                      $info = $obj_admin->manage_all_info($sql);
                      $row = $info->fetch(PDO::FETCH_ASSOC);
                      ?>
               <div class="col-sm-12">
						     <select class="form-control" name="ad_company" id="ad_company">
                   <option value="<?php echo $row['company_id']; ?>"><?php echo $row['code']; ?></option>
                        <?php 
                        $sql = "SELECT * FROM [admin].[companies] ";
                        $info = $obj_admin->manage_all_info($sql);  ?>
                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?php echo $row['company_id']; ?>"><?php echo $row['code']; ?></option>
                        <?php } ?>
                 </select>
					      </div>
              </div>

          <div class="form-group">
            <div class="col-sm-offset-8">
              <button type="submit" name="update_current_employee" class="btn btn-primary">Update Now</button>
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
</section>

  <?php include 'footer.php' ?>
 <script type="text/javascript">
 $('#emlpoyee_pass_btn').click(function(){
    $('#employee_pass_cng').toggle('slow');
 });
 </script>