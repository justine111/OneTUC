<!---------- authenticate and function for header display name/ID --------->
<?php
require 'authentication.php'; 
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$employee = $_SESSION['employee'];
$user_role = $_SESSION['user_role'];
if($user_role != 2){
  header('Location: task-info.php');
}
if(isset($_GET['delete_user'])){
  $action_id = $_GET['admin_id'];
  $sql = "DELETE FROM [dbo].[user_masterinfos] WHERE user_id = :id";
  $sent_po = "admin-manage-user.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}
if(isset($_POST['add_new_employee'])){
  $error = $obj_admin->add_new_user($_POST);
}
$sql = "SELECT * FROM [admin].[companies]";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);
?>

<div class="wrapper">
<?php
include("include/topbar.php");
include("include/sidebar.php");
?>

<!--display employee table-->
<br>  
<section class="content">
<div class="container-fluid">     
<div class="content-wrapper">
 <div class="col-lg-12">
	<div class="card card-outline card-danger">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="new_user.php"><i class="fa fa-plus"></i> Add New User</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
              <thead>
              <tr>
                  <th>Serial No.</th>
                  <th>Fullname</th>
                  <th>Domain Account</th>
                  <th>Gender.</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Username</th>
                  <th>Employee ID</th>
                  <th>Company</th>
                  <th>Temp Password</th>
                  <th>Details</th>
                </tr>
              </thead>
              <tbody>

              <!--display employee table query-->
              <?php 
                $sql = "SELECT * FROM [dbo].[user_masterinfos] main
                LEFT JOIN [dbo].[user_rolemap] a ON a.user_id = main.user_id
                LEFT JOIN [admin].[companies] b ON b.company_id = a.company_id
                WHERE role_id = 1 ";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td><?php echo $serial; $serial++; ?></td>
                  <td><?php echo $row['full_name']; ?></td>
                  <td><?php echo $row['domain_account']; ?></td>
                  <td><?php echo $row['gender']; ?></td>
                  <td><?php echo $row['contact_number']; ?></td>
                  <td><?php echo $row['address']; ?></td>
                  <td><?php echo $row['username']; ?></td> 
                  <td><?php echo $row['employee_id']; ?></td>
                  <td><?php echo $row['code']; ?></td>                              
                  <td><?php echo $row['temporary_password']; ?></td>
                  <td>
							           <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick=" return check_delete();">Delete</a>
		                    </div>
						    </td>
              </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
<!--end display employee table query-->

<!--link cdn for datatables-->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

<?php include 'footer.php' ?>
<!--change password for user function-->
<?php
if(isset($_SESSION['update_user_pass'])){
  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
?>

<!--script for datatables-->
<script>
$(document).ready(function () {
    $('#list').DataTable();
});
</script>
<script>
function myFunction() {
  alert("Added Successfuly");
}
</script>
