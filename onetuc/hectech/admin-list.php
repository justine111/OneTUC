<link rel="icon" type="img/png" href="img/logs.png">
<?php
  require 'authentication.php'; 
  $user_role = $_SESSION['user_role'];
  $department = $_SESSION['department'];

  if(!isset($_SESSION['admin_id'])){
  header('Location: index.php');
}
?>
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<?php
  if(isset($_POST['delete'])){
  $id = $_POST['admin_id'];  
  $sql = "DELETE FROM [dbo].[entry_services] WHERE entry_service_id = '$id'";
  $info = $obj_admin->manage_all_info($sql);

  echo "<script>
        Swal.fire({
          icon: 'success',
          title: 'Job Order',
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
				         <a class="btn btn-block btn-sm btn-default btn-flat border-danger" href="new_project.php"><i class="fa fa-plus"></i> Add New JRF</a>
			       </div>
		      </div>

		      <div class="table-responsive">
		        <table class="table tabe-hover table-condensed" id="list">
              <thead>
		            <tr>
		              <th class="text-center">#</th>
		              <th class="text-center">Ticket code</th>
		              <th class="text-center">Title</th>
     	            <th class="text-center">Department</th>
		              <th class="text-center">Date request</th>
                  <th class="text-center">Priority level</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Action</th>
		            </tr>
	            </thead>

            <tbody>
              <?php
                $sql="WITH ticket_cte
                      AS
                      (SELECT DISTINCT(a.reference_id),
                      (SELECT TOP 1 b.resolution FROM [dbo].[entry_activities] AS b
                      WHERE b.reference_id = a.reference_id ORDER BY b.datetime_updated DESC) AS resolution,
                      (SELECT TOP 1 b.entry_status FROM [dbo].[entry_activities] AS b
                      WHERE b.reference_id = a.reference_id ORDER BY b.datetime_updated DESC) AS entry_status,
                      (SELECT TOP 1 b.assigned_userid FROM [dbo].[entry_activities] AS b
                      WHERE b.reference_id = a.reference_id ORDER BY b.datetime_updated DESC) AS assigned_userid
                      FROM [dbo].[entry_activities] AS a
                      WHERE a.reference_id not in ('')
                      GROUP BY a.reference_id)
 
                      SELECT
                      main.entry_service_id AS entry_service_id,
                      main.reference_id AS reference_id,
                      main.title AS title,
                      main.description AS des,
                      d.full_name AS fullname,
                      g.full_name AS createduser,
                      c.description AS priority,
                      main.category AS category,
                      f.department_name AS department,
                      Format(main.created_date,'yyyy-MM-dd HH:mm tt') AS startdate,
                      Format(main.modified_date,'yyyy-MM-dd HH:mm tt') AS enddate,
                      b.resolution AS resolution,
                      main.render AS render,
                      e.status_name AS status
                      FROM [dbo].[entry_services] AS main
                      LEFT JOIN ticket_cte AS b ON b.reference_id = main.reference_id
                      LEFT JOIN [admin].[priority_levels] AS c ON c.priority_id = main.priority_id
                      LEFT JOIN [dbo].[user_masterinfos] AS d ON d.user_id = b.assigned_userid
                      LEFT JOIN [admin].[statuses] AS e ON e.status_id = b.entry_status
                      LEFT JOIN [admin].[departments] AS f ON f.department_id = main.department
                      LEFT JOIN [dbo].[user_masterinfos] AS g ON g.user_id = main.created_userid
                      WHERE main.created_userid = $user_id    
                      ORDER BY main.entry_service_id DESC ";
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
                  <td style="text-align: center;">
                    <b><?php echo ucwords($row['title']) ?></b>
                    <p class="truncate"><?php echo  $row['des']; ?></p>
                  </td>
                  <td style="text-align: center;"><?php echo   $row['department']; ?></td>
                  <td style="text-align: center;"><?php echo   $row['startdate']; ?></td>
                  <td style="text-align: center;"><?php echo   $row['priority']; ?></td>
                  <td style="text-align: center;">
                      <?php
                          if($row['status'] == 'New'){
                          echo "<span class='badge badge-primary'>New</span>"; 
			                      }elseif($row['status'] == 'Open'){
									  		  echo "<span class='badge badge-success'>Open</span>";
			                      }elseif($row['status'] == 'Close'){
									  		  echo "<span class='badge badge-danger'>Close</span>";
			                }?>
			            </td>
                  <td style="text-align: center;">
                    <form  method ="POST">
							        <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                    Action
		                  </button>
		                    <div class="dropdown-menu">
                          <a class="dropdown-item" href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>">View</a>
		                        <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="edit-task.php?task_id=<?php echo $row['entry_service_id'];?>">Edit</a>
		                        <div class="dropdown-divider"></div>
                          <input type = "hidden" name  ="admin_id" value = "<?php echo $row['entry_service_id'];?>"/>
                          <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>
		                    </div>
                      </form>      
						        </td>          
                  <?php } ?>   
                </tbody>
              </table>
            </div>
          </div>
        </div>
     </div>
   </div>
</div>
</section> 

<?php include 'footer.php' ?>

  <script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true
  });
  flatpickr('#t_end_time', {
    enableTime: true
  });
  </script>

  <script>
  // datatables
  $(document).ready(function () {
    $('#list').DataTable();
  });
  </script>

  <script>
  function myFunction() {
  alert("Added Successfuly"); 
  }
  </script>