<link rel="icon" type="img/png" href="img/logs.png">
<?php
    require 'authentication.php'; 
    $user_id = $_SESSION['admin_id'];
    $user_name = $_SESSION['name'];
    $user_role = $_SESSION['user_role'];
    $department = $_SESSION['department'];

    if(!isset($_SESSION['admin_id'])){
    header('Location: ../index.php');
}
    $sql = "SELECT * FROM [dbo].[entry_services]";
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
    if(isset($_POST['approve'])){
    $id = $_POST['entry_service_id'];
    $sql = "UPDATE [dbo].[entry_services] SET ticket_status = 'Approved', supervisor_id = '$user_id', datime_approve = (getdate()) WHERE entry_service_id = '$id'";
    $info = $obj_admin->manage_all_info($sql);

    echo "<script>      
          Swal.fire({
          icon: 'success',
          title: 'Job Order Form',
          text: 'Successfully Approved!',
          showConfirmButton: true,
          confirmButtonText:'Confirm ',
          confirmButtonColor:'#1E90FF ',
          closeOnConfirm: false
          });
         </script>";
}
    if(isset($_POST['deny'])){
    $id = $_POST['entry_service_id'];
    $sql = "DELETE FROM [dbo].[entry_services] WHERE entry_service_id = '$id'";
    $info = $obj_admin->manage_all_info($sql);

    echo "<script> 
          Swal.fire({
          icon: 'success',
          title: 'JRF Deny',
          text: 'JRF Successfully Deny!',
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
					            <th class="text-center">Ticket code</th>
                      <th class="text-center">Raised by</th>
					            <th class="text-center">Title</th>
					            <th class="text-center">Department</th>
					            <th class="text-center">Date request</th>
                      <th class="text-center">Priority level</th>
                      <th class="text-center">Ticket status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>

                  <?php if($user_role == 2){ ?>  
                  <tbody>                            
                    <?php
                    $sql = "SELECT
                            main.entry_service_id,
                            main.reference_id,
                            b.full_name,
                            main.title,
                            main.description,
                            main.created_userid,
                            main.created_date,
                            c.department_name,
                            d.description AS priority,
                            main.ticket_status,
                            e.full_name AS createduser
                            FROM [dbo].[entry_services] AS main
                            LEFT JOIN [dbo].[user_rolemap] AS a ON a.user_id = main.department
                            LEFT JOIN [dbo].[user_masterinfos] AS b ON b.user_id = a.user_id AND b.user_id = main.created_userid
                            LEFT JOIN [admin].[departments] AS c ON c.department_id = main.department
                            LEFT JOIN [admin].[priority_levels] AS d ON d.priority_id = main.priority_id
                            LEFT JOIN [dbo].[user_masterinfos] AS e ON e.user_id = main.created_userid
                            WHERE main.department = '$department' AND ticket_status = 'Waiting for Approval' 
                            ORDER BY main.entry_service_id DESC";
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
                    <td style="text-align: center;"><a href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>"><?php echo $row['reference_id']; ?><a/></td>
                    <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                    <td style="text-align: center;">
                        <b><?php echo ucwords($row['title']) ?></b>
                        <p class="truncate"><?php echo  $row['description']; ?></p>
                    </td>
                    <td style="text-align: center;"><?php echo   $row['department_name']; ?></td>
                    <td style="text-align: center;"><?php echo $row['created_date']; ?></td>
                    <td style="text-align: center;">
                    <?php
                  if($row['priority'] == 'Very High'){
                    echo "<span class='badge badge-danger'>Very High</span>"; 
                          }elseif($row['priority'] == 'High'){
                    echo "<span class='badge' style='background-color: #EC5800'>High</span>";
                          }elseif($row['priority'] == 'Medium'){
                    echo "<span class='badge badge-warning'>Medium</span>";
                          }elseif($row['priority'] == 'Low'){
                    echo "<span class='badge badge-success'>Low</span>";
                          }
			            ?>
                    </td>
                    <td style="text-align: center;">
			              <?php
                    if($row['ticket_status'] == 'Approved'){
                    echo "<span class='badge badge-success'>Approved</span>"; 
			                    }elseif($row['ticket_status'] == 'Waiting for Approval'){
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
                        <input type = "hidden" name  ="entry_service_id" value = "<?php echo $row['entry_service_id'];?>"/>
		                    <input type = "submit" name  ="approve" class="dropdown-item" value = "Approve"/>
		                    <div class="dropdown-divider"></div>
                        <input type = "submit" name  ="deny" class="dropdown-item" value = "Deny"/>
		                    </div>
                      </form>
                   </td>
                 </tr>
                <?php } ?>   
              </tbody>
            <?php } ?>
                  <?php if($user_role == 3){ ?>  
                  <tbody>                            
                    <?php
                    $sql = "SELECT
                            main.entry_service_id,
                            main.reference_id,
                            b.full_name,
                            main.title,
                            main.description,
                            main.created_userid,
                            main.created_date,
                            c.department_name,
                            d.description AS priority,
                            main.ticket_status,
                            e.full_name AS createduser
                            FROM [dbo].[entry_services] AS main
                            LEFT JOIN [dbo].[user_rolemap] AS a ON a.user_id = main.department
                            LEFT JOIN [dbo].[user_masterinfos] AS b ON b.user_id = a.user_id AND b.user_id = main.created_userid
                            LEFT JOIN [admin].[departments] AS c ON c.department_id = main.department
                            LEFT JOIN [admin].[priority_levels] AS d ON d.priority_id = main.priority_id
                            LEFT JOIN [dbo].[user_masterinfos] AS e ON e.user_id = main.created_userid
                            WHERE main.department = '$department' AND ticket_status = 'Waiting for Approval' 
                            ORDER BY main.entry_service_id DESC";
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
                    <td style="text-align: center;"><a href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>"><?php echo $row['reference_id']; ?><a/></td>
                    <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                    <td style="text-align: center;">
                        <b><?php echo ucwords($row['title']) ?></b>
                        <p class="truncate"><?php echo  $row['description']; ?></p>
                    </td>
                    <td style="text-align: center;"><?php echo   $row['department_name']; ?></td>
                    <td style="text-align: center;"><?php echo $row['created_date']; ?></td>
                    <td style="text-align: center;">
                    <?php
                  if($row['priority'] == 'Very High'){
                    echo "<span class='badge badge-danger'>Very High</span>"; 
                          }elseif($row['priority'] == 'High'){
                    echo "<span class='badge' style='background-color: #EC5800'>High</span>";
                          }elseif($row['priority'] == 'Medium'){
                    echo "<span class='badge badge-warning'>Medium</span>";
                          }elseif($row['priority'] == 'Low'){
                    echo "<span class='badge badge-success'>Low</span>";
                          }
			            ?>
                    </td>
                    <td style="text-align: center;">
			              <?php
                    if($row['ticket_status'] == 'Approved'){
                    echo "<span class='badge badge-success'>Approved</span>"; 
			                    }elseif($row['ticket_status'] == 'Waiting for Approval'){
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
                        <input type = "hidden" name  ="entry_service_id" value = "<?php echo $row['entry_service_id'];?>"/>
		                    <input type = "submit" name  ="approve" class="dropdown-item" value = "Approve"/>
		                    <div class="dropdown-divider"></div>
                        <input type = "submit" name  ="deny" class="dropdown-item" value = "Deny"/>
		                    </div>
                      </form>
                   </td>
                 </tr>
                <?php } ?>   
              </tbody>
            <?php } ?>

                <?php if($user_role == 4){ ?>  
                  <tbody>                            
                    <?php
                    $sql = "SELECT
                          main.entry_service_id,
                          main.reference_id,
                          b.full_name,
                          main.title,
                          main.description,
                          main.created_userid,
                          main.created_date,
                          c.department_name,
                          d.description AS priority,
                          main.ticket_status,
                          e.full_name AS createduser
                          FROM [dbo].[entry_services] AS main
                          LEFT JOIN [dbo].[user_rolemap] AS a ON a.user_id = main.department
                          LEFT JOIN [dbo].[user_masterinfos] AS b ON b.user_id = a.user_id AND b.user_id = main.created_userid
                          LEFT JOIN [admin].[departments] AS c ON c.department_id = main.department
                          LEFT JOIN [admin].[priority_levels] AS d ON d.priority_id = main.priority_id
                          LEFT JOIN [dbo].[user_masterinfos] AS e ON e.user_id = main.created_userid
                          WHERE main.ticket_status = 'Waiting for Approval' 
                          ORDER BY main.entry_service_id DESC";
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
                    <td style="text-align: center;"><a href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>"><?php echo $row['reference_id']; ?><a/></td>
                    <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                    <td style="text-align: center;">
                        <b><?php echo ucwords($row['title']) ?></b>
                        <p class="truncate"><?php echo  $row['description']; ?></p>
                    </td>
                    <td style="text-align: center;"><?php echo   $row['department_name']; ?></td>
                    <td style="text-align: center;"><?php echo $row['created_date']; ?></td>
                    <td style="text-align: center;">
                    <?php
                  if($row['priority'] == 'Very High'){
                    echo "<span class='badge badge-danger'>Very High</span>"; 
                          }elseif($row['priority'] == 'High'){
                    echo "<span class='badge' style='background-color: #EC5800'>High</span>";
                          }elseif($row['priority'] == 'Medium'){
                    echo "<span class='badge badge-warning'>Medium</span>";
                          }elseif($row['priority'] == 'Low'){
                    echo "<span class='badge badge-success'>Low</span>";
                          }
			            ?>
                    </td>
                    <td style="text-align: center;">
			              <?php
                    if($row['ticket_status'] == 'Approved'){
                    echo "<span class='badge badge-success'>Approved</span>"; 
			                    }elseif($row['ticket_status'] == 'Waiting for Approval'){
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
                        <input type = "hidden" name  ="entry_service_id" value = "<?php echo $row['entry_service_id'];?>"/>
		                    <input type = "submit" name  ="approve" class="dropdown-item" value = "Approve"/>
		                    <div class="dropdown-divider"></div>
                        <input type = "submit" name  ="deny" class="dropdown-item" value = "Deny"/>
		                    </div>
                     </form>
                   </td>
                 </tr>
                <?php } ?>   
              </tbody>
            <?php } ?>
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