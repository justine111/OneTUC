<link rel="icon" type="img/png" href="img/logs.png">
<?php
  require 'authentication.php'; 
  $user_role = $_SESSION['user_role'];
  $department = $_SESSION['department'];

  if(!isset($_SESSION['admin_id'])){
  header('Location: index.php');
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
<!---- link and cdn for datatables ----->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

<!------ add task form and querys----->
<body onkeydown="return (event.keyCode != 116)">
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
        <!--------master-admin-table------>
           <?php if($user_role == 4){ ?>
				   <thead>
					   <tr>
						  <th class="text-center">#</th>
						  <th class="text-center">Ticket code</th>
						  <th class="text-center">Title</th>
						  <th class="text-center">Department</th>
						  <th class="text-center">Date request</th>
              <th class="text-center">Priority level</th>
              <th class="text-center">Raised by</th>
              <th class="text-center">Assign to</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
					   </tr>
				   </thead>
            <?php } ?>
        <!--------engineer-table------>
            <?php if($user_role == 3){ ?>
				   <thead>
				     <tr>
              <th class="text-center">#</th>
						  <th class="text-center">Ticket code</th>
						  <th class="text-center">Title</th>
						  <th class="text-center">Department</th>
						  <th class="text-center">Date request</th>
              <th class="text-center">Priority level</th>
              <th class="text-center">Raised by</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
					   </tr>
				   </thead>
            <?php } ?>
        <!--------lead-table------>
            <?php if($user_role == 2){ ?>
				   <thead>
				     <tr>
              <th class="text-center">#</th>
						  <th class="text-center">Ticket code</th>
						  <th class="text-center">Title</th>
						  <th class="text-center">Department</th>
						  <th class="text-center">Date request</th>
              <th class="text-center">Priority level</th>
              <th class="text-center">Raised by</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
					   </tr>
				   </thead>
            <?php } ?>
        <!--------user-table------>
            <?php if($user_role == 1){ ?>
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
            <?php } ?>

          <!--------master-admin-table------>
            <?php if($user_role == 4){ ?>
              <tbody>
                <?php 
                $sql="EXEC [dbo].[Display_Tickets_SP] @param_intUserrole =$user_role, @param_intUserid = $user_id, @param_intDepartmentid = $department"; 
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
                <td style="text-align: center;"><b><?php echo $row['title']; ?></b></td>
                <td style="text-align: center;"><?php echo $row['department']; ?></td>
                <td style="text-align: center;"><?php echo $row['startdate']; ?></td>
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
                <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                <td style="text-align: center;"><?php echo   $row['fullname']; ?></td>
                <td style="text-align: center;">
			            <?php
                  if($row['status'] == 'New'){
                  echo "<span class='badge badge-primary'>New</span>"; 
			                  }elseif($row['status'] == 'Open'){
									echo "<span class='badge badge-success'>Open</span>";
			                  }elseif($row['status'] == 'Close'){
									echo "<span class='badge badge-danger'>Close</span>";
			                  }
			            ?>
			          </td>
                <td>
                  <form  method ="POST">
							        <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                    Action
		                  </button>
		                  <div class="dropdown-menu">
		                  <a class="dropdown-item" href="edit-task.php?task_id=<?php echo $row['entry_service_id'];?>">Edit</a>
		                  <div class="dropdown-divider"></div>
                      <input type = "hidden" name  ="admin_id" value = "<?php echo $row['entry_service_id'];?>"/>
                      <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>
		                </div>
                  </form>      
						    </td>          
                <?php } ?>   
                </tbody>
                <?php } ?>

               <!--------engineer-table------>
              <?php if($user_role == 3){ ?>
                <tbody>
                  <?php 
                  $sql="EXEC [dbo].[Display_Tickets_SP] @param_intUserrole =$user_role, @param_intUserid = $user_id, @param_intDepartmentid = $department"; 
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
                  <td style="text-align: center;"><b><?php echo $row['title']; ?><b></td>
                  <td style="text-align: center;"><?php echo   $row['department']; ?></td>
                  <td style="text-align: center;"><?php echo   $row['startdate']; ?></td>
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
                  <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                  <td style="text-align: center;">
                    <?php
                    if($row['status'] == 'New'){
                    echo "<span class='badge badge-primary'>New</span>"; 
			                    }elseif($row['status'] == 'Open'){
									  echo "<span class='badge badge-success'>Open</span>";
			                    }elseif($row['status'] == 'Close'){
									  echo "<span class='badge badge-danger'>Close</span>";
			                    }
			              ?>
			            </td>
                  <td style="text-align: center;">
                    <form  method ="POST">
							          <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>">View</a>
		                    <div class="dropdown-divider"></div>
                        <input type = "hidden" name  ="admin_id" value = "<?php echo $row['entry_service_id'];?>"/>
                        <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>
		                  </div>
                    </form>      
						      </td>          
                  <?php } ?>   
                  </tbody>
                  <?php } ?>

                <!--------lead-table------>
                <?php if($user_role == 2){ ?>
                      <tbody>
                        <?php 
                        $sql="EXEC [dbo].[Display_Tickets_SP] @param_intUserrole =$user_role, @param_intUserid = $user_id, @param_intDepartmentid = $department"; 
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
                        <td style="text-align: center;"><b><?php echo $row['title']; ?><b></td>
                        <td style="text-align: center;"><?php echo $row['department_name']; ?></td>
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
                        <td style="text-align: center;"><?php echo $row['createduser']; ?></td>
                        <td style="text-align: center;">
                            <?php
                            if($row['status'] == 'New'){
                            echo "<span class='badge badge-primary'>New</span>"; 
			                        	  }elseif($row['status'] == 'Open'){
									  		    echo "<span class='badge badge-success'>Open</span>";
			                          	}elseif($row['status'] == 'Close'){
									  		    echo "<span class='badge badge-danger'>Close</span>";
			                        	  }
			                        	  ?>
			                  </td>
                        <td style="text-align: center;">
                          <form  method ="POST">
							                <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                            Action
		                          </button>
		                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>">View</a>
                              <?php if($row ['ticket_status'] == 'Waiting for Approval'){ ?>
                              <div class="dropdown-divider"></div>
		                          <a class="dropdown-item" href="edit-task.php?task_id=<?php echo $row['entry_service_id'];?>">Edit</a> 
                              <?php } ?>
		                          <div class="dropdown-divider"></div>
                              <input type = "hidden" name  ="admin_id" value = "<?php echo $row['entry_service_id'];?>"/>
                              <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>
		                        </div>
                          </form>      
						            </td>         
                      <?php } ?>   
                      </tbody>
                      <?php } ?>

                    <!--------user-table------>
                    <?php if($user_role == 1){ ?>
                      <tbody>
                        <?php 
                        $sql="EXEC [dbo].[Display_Tickets_SP] @param_intUserrole =$user_role, @param_intUserid = $user_id, @param_intDepartmentid = $department"; 
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
                        <td style="text-align: center;"><b><?php echo $row['title']; ?><b></td>
                        <td style="text-align: center;"><?php echo $row['department']; ?></td>
                        <td style="text-align: center;"><?php echo $row['startdate']; ?></td>
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
                        <td style="text-align: center;">
                            <?php
                            if($row['ticket_status'] == 'Waiting for Approval'){
                            echo "<span class='badge badge-danger'>Waiting for Approval</span>";
                            }elseif($row['status'] == 'New'){
                            echo "<span class='badge badge-primary'>New</span>"; 
			                        	  }elseif($row['status'] == 'Open'){
									  		    echo "<span class='badge badge-success'>Open</span>";
			                          	}elseif($row['status'] == 'Close'){
									  		    echo "<span class='badge badge-danger'>Close</span>";
			                        	  }
			                        	  ?>
			                  </td>
                        <td style="text-align: center;">
                          <form  method ="POST">
							                <button type="button" class="btn btn-default btn-sm btn-flat border-danger wave-effect text-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                            Action
		                          </button>
		                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>">View</a>
                              <?php if($row ['ticket_status'] == 'Waiting for Approval'){ ?>
                              <div class="dropdown-divider"></div>
		                          <a class="dropdown-item" href="edit-task.php?task_id=<?php echo $row['entry_service_id'];?>">Edit</a> 
                              <?php } ?>                             
		                          <div class="dropdown-divider"></div>
                              <input type = "hidden" name  ="admin_id" value = "<?php echo $row['entry_service_id'];?>"/>
                              <input type = "submit" name  ="delete" class="dropdown-item"  value = "Delete"/>                          
		                        </div>
                          </form>      
						            </td>          
                        <?php } ?>   
                        </tbody>
                        <?php } ?>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section> 
      </body>

<?php include 'footer.php' ?>
<!---- link and cdn for datatables ----->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>


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