<link rel="icon" type="img/png" href="img/logs.png">
<?php
	require 'authentication.php';
	$task_id = $_GET['task_id'];

	if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
	}
	if(isset($_POST['add_comment'])){
	$obj_admin->add_comment($_POST);
	}
	$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id' ";
	$info = $obj_admin->manage_all_info($sql);
	$row = $info->fetch(PDO::FETCH_ASSOC);
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
	   			<div class="row">
        			<div class="col-md-7">
          				<div class="card card-outline card-danger">
		  					<div class="card-header">
		  						<span><b>JRF Request By: <?php echo $row['createduser']; ?></b><p class="truncate"> Date-time Request: <?php echo  $row['startdate']; ?></p></span>
								<span><b>Approved By: <?php echo $row['supervisor_name']; ?></b><p class="truncate"> Date-time Approved: <?php echo  $row['time_approve']; ?></p></span>
							<div class="card-tools">
						</div>
					</div>
	        	<div class="card-body">
	        <form class="form-horizontal" role="form" action="" method="post" autocomplete="off">

		    <div class="row">
			    <div class="col-md-4">
			        <div class="form-group">
			            <label for="" class="control-label">Ticket code: </label>
			        	<input type="text" id="reference_id"  name="reference_id" list="expense" class="form-control" value="<?php echo $row['reference_id']; ?>"  readonly>
		           </div>
	            </div>

	  		<div class="col-md-4">
	    		<div class="form-group">
		  			<label for="" class="control-label">Task title: </label>
		    		<input type="text" placeholder="Your Concern" id="task_title" name="task_title" list="expense" class="form-control" value="<?php echo $row['title']; ?>" readonly>
	      		</div>
       		</div>

			<div class="col-md-4">
	   			<div class="form-group">
	   				<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
		 			<label for="" class="control-label">Requested Date: </label>
		   			<input type="text" name="startdate" id="startdate"  class="form-control" value="<?php echo $row['startdate']; ?>" readonly>
	   			</div>
     		</div>

			<div class="col-md-4">
	   			<div class="form-group">
	   				<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
		 			<label for="" class="control-label">Category: </label>
		   			<input type="text" class="form-control" value="<?php echo $row['category']; ?>" readonly>
	   			</div>
      		</div>

			<div class="col-md-4">
	   			<div class="form-group">
	   				<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
		 			<label for="" class="control-label">Department: </label>
		   			<input type="text" class="form-control" value="<?php echo $row['department']; ?>" readonly>
	   			</div>
      		</div>

			<div class="col-md-4">
	   			<div class="form-group">
	   				<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
		 			<label for="" class="control-label">Ticket Status: </label>
		   			<input type="text" class="form-control" value="<?php echo $row['ticket_status']; ?>" readonly>
	   			</div>
      		</div>

      		<div class="col-md-4">
	  			<div class="form-group">
		  			<label for="" class="control-label">Priority Level: </label>
					<select class="form-control" name="priority" id="priority" require>
					<option value="<?php echo $row['priority_id']; ?>"><?php echo $row['priority']; ?></option>
					<?php 
                    $sql = "SELECT priority_id, description FROM [admin].[priority_levels]";
                    $info = $obj_admin->manage_all_info($sql);   
                    ?>
                    <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                    <option value="<?php echo $row['priority_id']; ?>"><?php echo $row['description']; ?></option>
                    <?php } ?>
                	</select>
	      		</div>
       		</div>
	  
	  		<div class="col-md-4">
	  			<div class="form-group">
	    			<label class="control-label">Assign To:</label>
						<?php 
						$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
						$info = $obj_admin->manage_all_info($sql);
						$row = $info->fetch(PDO::FETCH_ASSOC);   
            			?>
          				<?php if($user_role == 4){ ?>	
	      				<?php 
          				$sql = "SELECT main.user_id, a.role_id, main.full_name FROM [dbo].[user_masterinfos] main
          				LEFT JOIN [dbo].[user_rolemap] a ON a.user_id = main.user_id
          				WHERE role_id = 4 ";
          				$info = $obj_admin->manage_all_info($sql);   
	      				?>
						<select class="form-control" name="assign_to" id="assign_to" >
						<option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
						<?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){ ?>
						<option value="<?php echo $rows['user_id']; ?>" <?php
						if($rows['user_id'] == $row['user_id']){ ?> selected <?php } ?>><?php echo $rows['full_name'];?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
  			</div>

  			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label col-sm-5">Status:</label>
					<select class="form-control" name="status" id="status">
					<option  value="<?php echo $row['status_id']; ?>"><?php echo $row['status']; ?></option>
					<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
				 	<?php 
            		$sql = "SELECT status_id, status_name FROM [admin].[statuses]";
            		$info = $obj_admin->manage_all_info($sql);   
                  	?>
            		<?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
            		<option value="<?php echo $row['status_id']; ?>"><?php echo $row['status_name']; ?></option>
            		<?php } ?>
        			</select>
				</div>
  			</div>

			<div class="col-md-4">
	   			<div class="form-group">
	  				<?php 
					$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
					$info = $obj_admin->manage_all_info($sql);
					$row = $info->fetch(PDO::FETCH_ASSOC);   
            		?>
		 			<label for="" class="control-label">Resolve Date: </label>
		   			<input type="text" name="t_end_time" id="t_end_time" class="form-control" value="<?php echo $row['enddate']; ?>">
	   			</div>
      		</div>

			  <div class="col-md-4">
	  			<div class="form-group">
	  				<?php 
			     	$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
			     	$info = $obj_admin->manage_all_info($sql);
			     	$row = $info->fetch(PDO::FETCH_ASSOC);   
                	?>
					<label for="" class="control-label">Time rendered: </label>
		  			<input name="render" id="render" placeholder="Time renderd.." class="form-control" value="<?php echo $row['render']; ?>"></input>
	  			</div>
    		</div>

		<div class="row">
			<div class="col-md-12">
	  			<div class="form-group">
	  				<?php 
			     	$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id' ";
					$info = $obj_admin->manage_all_info($sql);
				 	$row = $info->fetch(PDO::FETCH_ASSOC);   
                	?>
					<label for="" class="control-label">Resolution: </label>
		  			<textarea name="reso" id="reso" placeholder="Resolution.." class="form-control" rows="3" cols="2" value="<?php echo $row['resolution'];?>"></textarea>
	   			</div>
     		</div>

				<div class="col-md-12">
					<div class="form-group">
						<?php 
			     		$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id'";
			     		$info = $obj_admin->manage_all_info($sql);
			     		$row = $info->fetch(PDO::FETCH_ASSOC);   
                		?>
						<label for="" class="control-label">Description: </label>
						<textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="3" cols="101"><?php echo $row['description']; ?></textarea>
					</div>
				</div>
			</div>
		</div>


    		<div class="card-footer border-top border-danger">
    			<div class="d-flex w-100 justify-content-center align-items-center">
			 		<button type="submit" name="update_task_info" class="btn btn-primary"onclick="myFunction()">Update JRF</button>
    				<button class="btn btn-danger mx-2" type="button" onclick="location.href='task-info.php'">Cancel</button>
    			</div>
    	  	</div>
	    </form>
	</div>
</div>
</div>

			<div class="col-md-5">
				<div class="card card-outline card-danger">
					<div class="card-header">
						<span><b>Task Title: <?php echo $row['title']; ?></b></span>
						<div class="card-tools">
					</div>
				</div>

				<div class="card-body">
					<?php
					$sql ="SELECT
						main.title
				        ,b.comments
				        ,Format(b.comment_datetime,'yyyy-MM-dd HH:mm tt') AS comment_datetime
				        , (SELECT c.full_name FROM [dbo].[user_masterinfos] c where c.user_id = b.user_id) as commect_userid
				        FROM [dbo].[entry_services] main 
				        LEFT JOIN [dbo].[user_masterinfos] a ON a.user_id = main.created_userid
				        LEFT JOIN [dbo].[entry_comments] b ON b.reference_id = main.reference_id
				        WHERE main.entry_service_id = $task_id ORDER BY (main.created_date) ASC";
			            $info = $obj_admin->manage_all_info($sql);
			        	?>
				<form role="form" action="" method="post" autocomplete="off">
				<div class="col-md-6">
			    	<div class="form-group">
			         	<input type="hidden" id="reference_id"  name="reference_id" list="expense" class="form-control" value="<?php echo $row['reference_id']; ?>"  readonly required>
		            </div>
	            </div>

			    <div class="col-md-12">
			        <div class="form-group">
				    	<label for="" class="control-label">Comment</label>
			            <input type="text" placeholder="Comment..." id="comment" name="comment" list="expense" class="form-control" id="default" required>
			        </div>
		        </div>

			    <div class="col-lg-12 text-right justify-content-left d-flex">
			       	<button class="btn btn-primary mr-2" type="submit" name="add_comment">Submit</button>
		        </div>
		        	<?php while( $row = $info->fetch(PDO::FETCH_ASSOC) ){ ?>
		       	    <br> 
					<div class="post">
		 			<div class="user-block">                 
		            <span class="btn-group dropleft float-right">
			        <span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
			        <i class="fa fa-ellipsis-v"></i>
			        </span>
					<div class="dropdown-menu">
				    <a class="dropdown-item delete_progress" href="?delete_task=delete_task&reference_id=<?php echo $row['reference_id']; ?>" onclick=" return check_delete();">Delete</a>
			        </div>
		        	</span>
					<img class="img-circle img-bordered-sm" src="img/logs.png" alt="user image">
		  			<span class="username">
		  			<a href="#"><?php echo ucwords($row['commect_userid']) ?>( <?php echo ucwords($row['title']) ?> )</a>
					</span>
					<span class="description">
	       			<span class="fa fa-calendar-day"></span>
		    		<span><b><?php echo (($row['comment_datetime'])) ?></b></span>
					</div>
	 				 <p><?php echo html_entity_decode($row['comments']) ?><p>
	 				<?php } ?> 
   				  </div>
 				 </span>
  				</span>
   			   </form>
              </div>
			 </div>
			</div>
		   </div>	
	</section>
<!-----script ---->
<?php include 'footer.php' ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script type="text/javascript">
	  flatpickr('#startdate', {
	    enableTime: true
	  });

	  flatpickr('#t_end_time', {
	    enableTime: true
	  });
	</script>
<script>
function myFunction() {
  alert("Update Successfuly");
}
</script>


