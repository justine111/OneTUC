<link rel="icon" type="img/png" href="img/logs.png">
<?php
require 'authentication.php'; 
?>
<div class="wrapper">
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
  if(isset($_POST['delete'])){
    $id = $_POST['admin_id'];  
    $sql = "DELETE FROM [dbo].[user_masterinfos] WHERE user_id = '$id'";
    $info = $obj_admin->manage_all_info($sql);

    echo "<script>   
             Swal.fire({
                icon: 'success',
                title: 'User Account',
                text: 'Successfully Deleted!',
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
			       <div class="card-tools">
				       <a class="btn btn-block btn-sm btn-default btn-flat border-danger" href="new_admin.php"><i class="fa fa-plus"></i> Add Account</a>
			     </div>
		     </div>

		  <div class="table-responsive">
			  <table class="table tabe-hover table-condensed" id="list">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Fullname</th>
                  <th class="text-center">Username</th>
                  <th class="text-center">Department</th>
                  <th class="text-center">Company</th>
                  <th class="text-center">User role</th>
                  <th class="text-center">Temp Password</th>
                  <th class="text-center">Details</th>
                </tr>
              </thead>
            <tbody>
              <?php 
                $sql = "SELECT * FROM [dbo].[user_masterinfos] main
                LEFT JOIN [dbo].[user_rolemap] a ON a.user_id = main.user_id
                LEFT JOIN [admin].[companies] b ON b.company_id = a.company_id
                LEFT JOIN [admin].[departments] d ON d.department_id = a.department_id
				        LEFT JOIN [admin].[roles] c ON c.role_id = a.role_id
                WHERE user_status = 'Approved'
                ORDER BY  a.role_id DESC ";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $num_row = $info->rowCount();
                  if($num_row==0){
                    echo '<tr><td colspan="7">No Data found</td></tr>';
                  }
                while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
              ?>
                <tr>
                  <td style="text-align: center;"><?php echo $serial; $serial++; ?></td>
                  <td style="text-align: center;"><?php echo $row['full_name']; ?></td>
                  <td style="text-align: center;"><?php echo $row['username']; ?></td> 
                  <td style="text-align: center;"><?php echo $row['department_name']; ?></td>
                  <td style="text-align: center;"><?php echo $row['code']; ?></td> 
                  <td style="text-align: center;"><?php echo $row['description']; ?></td>                              
                  <td style="text-align: center;"><?php echo $row['temporary_password']; ?></td>
                  <td>
                    <form  method ="POST">
                      <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                  </button>
		                    <div class="dropdown-menu">
                          <input type = "hidden" name="admin_id" value = "<?php echo $row['user_id'];?>"/>
		                        <a class="dropdown-item" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>">View</a>
		                      <div class="dropdown-divider"></div>
                        <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>
		                  </div>
                    </form>
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
  
<!---- link cdn for datatables ----->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

<?php include 'footer.php' ?>
<!---- update password---->
<?php
if(isset($_SESSION['update_user_pass'])){
  echo '<script>alert("Password updated successfully");</script>';
  unset($_SESSION['update_user_pass']);
}
?>

<!----- datatables script----->
<script>
$(document).ready(function () {
    $('#list').DataTable();
});
</script>
