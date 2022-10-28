<link rel="icon" type="img/png" href="img/logs.png">
<?php
require 'authentication.php'; 

if(!isset($_SESSION['admin_id'])){
  header('Location: ../index.php');
}
?>
<div class="wrapper">
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php
  if(isset($_POST['approve'])){
  $id = $_POST['admin_id'];
  $sql = "BEGIN TRANSACTION;
  UPDATE [atYourService].[dbo].[user_masterinfos] SET user_status = 'Approved' WHERE user_id = '$id'
  UPDATE [OneTUC].[dbo].[user_masterinfos] SET user_status = 'Approved' WHERE user_id = '$id'
  COMMIT;";
  $info = $obj_admin->manage_all_info($sql);

echo "<script>      
      Swal.fire({
      icon: 'success',
      title: 'User Account',
      text: 'Successfully Approved!',
      showConfirmButton: true,
      confirmButtonText:'Confirm ',
      confirmButtonColor:'#1E90FF ',
      closeOnConfirm: false
      });
      </script>";
}

  if(isset($_POST['deny'])){
  $id = $_POST['admin_id'];
  $sql = "DELETE FROM [dbo].[user_masterinfos] WHERE user_id = '$id'";
  $info = $obj_admin->manage_all_info($sql);

  echo "<script> 
        Swal.fire({
        icon: 'success',
        title: 'User Account',
        text: 'Successfully Deny!',
        showConfirmButton: true,
        confirmButtonText:'Okay ',
        confirmButtonColor:'#1E90FF ',
        closeOnConfirm: false
        })
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
                  <th class="text-center">User status</th>
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
                WHERE main.user_status = 'Waiting for Approval'
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
                  <td style="text-align: center;">
			              <?php
                    if($row['user_status'] == 'Approved'){
                    echo "<span class='badge badge-success'>Approved</span>"; 
			                    }elseif($row['user_status'] == 'Waiting for Approval'){
									  echo "<span class='badge badge-danger'>Waiting for Approval</span>";
                          }
			              ?>
                  </td>
                  <td style="text-align: center;">
                    <form  method ="POST">
                      <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                    Action
		                  </button>
		                  <div class="dropdown-menu">
                      <input type = "hidden" name="admin_id" value = "<?php echo $row['user_id'];?>"/>
		                  <input type = "submit" name  ="approve" class="dropdown-item" value = "Approve"/>
		                  <div class="dropdown-divider"></div>
                      <input type = "submit" name  ="deny" class="dropdown-item" value = "Deny"/>
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

<?php include 'footer.php' ?>

<script>
// datatables
$(document).ready(function () {
    $('#list').DataTable();
});
</script>