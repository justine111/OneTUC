<link rel="icon" type="img/png" href="img/logs.png">
<?php
  require 'authentication.php'; 
  $user_id = $_SESSION['admin_id'];
  $user_role = $_SESSION['user_role'];

  if(!isset($_SESSION['admin_id'])){
  header('Location: index.php');
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
    if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);

    if($user_role == 4){
      $sql = "UPDATE [dbo].[entry_services] SET ticket_status = 'Approved', supervisor_id = '$user_id', datime_approve = (getdate()) WHERE entry_service_id = (SELECT top 1 entry_service_id FROM [dbo].[entry_services] ORDER BY entry_service_id DESC)";
      $info = $obj_admin->manage_all_info($sql);
    }
    if($user_role == 2){
      $sql = "UPDATE [dbo].[entry_services] SET ticket_status = 'Approved', supervisor_id = '$user_id', datime_approve = (getdate()) WHERE entry_service_id = (SELECT top 1 entry_service_id FROM [dbo].[entry_services] ORDER BY entry_service_id DESC)";
      $info = $obj_admin->manage_all_info($sql);
    }

    echo "<script>      
            Swal.fire({
              icon: 'success',
              title: 'Job Order',
              text: 'Successfully Added',
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
		     <div class="card-body">

              <form role="form" action="" method="post" autocomplete="off">
		            <div class="row">
			            <div class="col-md-6">
				            <div class="form-group">
					            <label for="" class="control-label">Task title</label>
                        <input type="text" placeholder="Your Concern" id="task_title" name="task_title" list="expense" class="form-control" id="default" required>
				          </div>
			         </div>

               <div class="col-md-6">
				         <div class="form-group">
					          <label for="" class="control-label">Priority level</label>
                      <select class="form-control" name="priority" id="priority" required>
                      <?php 
                        $sql = "SELECT priority_id, description FROM [admin].[priority_levels]";
                        $info = $obj_admin->manage_all_info($sql);   
                      ?>
                        <option value="">Select Priority level...</option>
                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?php echo $row['priority_id']; ?>"><?php echo $row['description']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
               </div>

		           <div class="row">
                  <div class="col-md-6">
				            <div class="form-group">
					            <label for="" class="control-label">Department</label>
                      <?php
                          $sql = "Select b.department_name, main.department_id FROM [dbo].[user_rolemap]main
                          LEFT JOIN [dbo].[user_masterinfos]a on a.user_id = main.user_id
                          LEFT JOIN [admin].[departments]b on b.department_id = main.department_id
                          WHERE a.user_id = '$user_id'";
                          $info = $obj_admin->manage_all_info($sql);
                          $row = $info->fetch(PDO::FETCH_ASSOC);
                      ?>

                        <?php if($user_role == 1){ ?>
                          <select class="form-control" name="dept" id="dept" <?php if($user_role == 1){ ?> readonly="true" <?php } ?>>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                          </select>
                        <?php } ?>

                        <?php if($user_role == 2){ ?>
                          <select class="form-control" name="dept" id="dept" <?php if($user_role == 1){ ?> disabled="true" <?php } ?>>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php 
                          $sql = "SELECT department_id, department_name FROM [admin].[departments] 
                          where company_id = $company";
                          $info = $obj_admin->manage_all_info($sql);   
                        ?>
                          <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department_name']; ?></option>
                          <?php } ?>
                          </select>
                        <?php } ?>

                        <?php if($user_role == 3){ ?>
                          <select class="form-control" name="dept" id="dept" <?php if($user_role == 1){ ?> disabled="true" <?php } ?>>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php 
                          $sql = "SELECT department_id, department_name FROM [admin].[departments] 
                          where company_id = $company";
                          $info = $obj_admin->manage_all_info($sql);   
                        ?>
                          <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department_name']; ?></option>
                          <?php } ?>
                          </select>
                        <?php } ?>

                        <?php if($user_role == 4){ ?>
                          <select class="form-control" name="dept" id="dept" <?php if($user_role == 1){ ?> disabled="true" <?php } ?>>
                            <option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
                        <?php 
                          $sql = "SELECT department_id, department_name FROM [admin].[departments] 
                          where company_id = $company";
                          $info = $obj_admin->manage_all_info($sql);   
                        ?>
                          <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department_name']; ?></option>
                          <?php } ?>
                          </select>
                        <?php } ?>
                    </div>
                  </div>

                  <div class="col-md-6">
				            <div class="form-group">
					            <label for="" class="control-label">Category</label>
                      <select class="form-control" name="cat" id="cat" required>
                      <?php 
                        $sql = "SELECT code, category_name FROM [admin].[categories]";
                        $info = $obj_admin->manage_all_info($sql);   
                      ?>
                        <option value="">Select Category...</option>
                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?php echo $row['code']; ?>"><?php echo $row['category_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
			            <div class="col-md-12">
				            <div class="form-group">
					            <label for="" class="control-label">Description</label>
					            <textarea name="task_description" id="task_description" placeholder="Description..." cols="20" rows="8" class="form-control">
					            </textarea>
			  	          </div>
			            </div>
		            </div>
    	        </div>

    	        <div class="card-footer border-top border-info">
    		        <div class="d-flex w-100 justify-content-center align-items-center">
                  <button  type="submit" name="add_task_post" class="btn btn-primary mx-2">Submit</button>
    			        <button class="btn btn-danger mx-2" type="button" onclick="location.href='task-info.php'">Cancel</button>
    		        </div>
    	        </div>
            </form>
	        </div>
        </div>
      </div> 
    </div>
</section>
<?php include 'footer.php' ?>

