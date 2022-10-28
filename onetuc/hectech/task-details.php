<link rel="icon" type="img/png" href="img/logs.png">
<?php
require 'authentication.php'; 
$task_id = $_GET['task_id'];

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
<br>  
<section class="content">
<div class="container-fluid">     
<div class="content-wrapper">
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-12">
			<div class="callout callout-danger">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt><b class="border-bottom border-primary">Reference ID</b></dt>
								<dd><?php echo $row['reference_id']; ?></dd>
								<dt><b class="border-bottom border-primary">Task title</b></dt>
								<dd><?php echo $row['title']; ?></dd>
								<dt><b class="border-bottom border-primary">Description</b></dt>
								<dd><?php echo $row['description']; ?></dd>
								<dt><b class="border-bottom border-primary">Assign to</b></dt>
								<dd><?php echo $row['fullname']; ?></dd>
								<dt><b class="border-bottom border-primary">Raised by</b></dt>
								<dd><?php echo $row['createduser']; ?></dd>
								<dt><b class="border-bottom border-primary">Priority level</b></dt>
								<dd><?php echo $row['priority']; ?></dd>
								<dt><b class="border-bottom border-primary">Ticket Status</b></dt>
								<dd><?php echo $row['ticket_status']; ?></dd>
							</dl>
						</div>
						<div class="col-md-6">
								<dt><b class="border-bottom border-primary">Category</b></dt>
								<dd><?php echo $row['category']; ?></dd>
								<dt><b class="border-bottom border-primary">Department</b></dt>
								<dd><?php echo $row['department']; ?></dd>
								<dt><b class="border-bottom border-primary">Date requested</b></dt>
								<dd><?php echo $row['startdate']; ?></dd>
								<dt><b class="border-bottom border-primary">Date solve</b></dt>
								<dd><?php echo $row['enddate']; ?></dd>														
								<dt><b class="border-bottom border-primary">Resolution</b></dt>
								<dd><?php echo $row['resolution'];  ?></dd>													
								<dt><b class="border-bottom border-primary">Time rendered</b></dt>
								<dd><?php echo $row['render']." minutes";  ?></dd>							
								<dt><b class="border-bottom border-primary">Status</b></dt>
								<dd><?php echo $row['status']; ?></dd>
							</dl>
							<?php if($user_role == 3){ ?>
							<input type="button" class="btn btn-primary" value="Copy Report text" onclick="jscopyA()">
							<?php } ?>
							<?php if($user_role == 4){ ?>
							<input type="button" class="btn btn-primary" value="Copy Report text" onclick="jscopyA()">
							<?php } ?>
							<a title="Update Task"  href="task-info.php"><span class="btn btn-danger">Go Back</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
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
				           ,b.comment_datetime
				           , (SELECT c.full_name FROM [dbo].[user_masterinfos] c where c.user_id = b.user_id) as commect_userid
				           FROM [dbo].[entry_services] main 
				           LEFT JOIN [dbo].[user_masterinfos] a ON a.user_id = main.created_userid
				           LEFT JOIN [dbo].[entry_comments] b ON b.reference_id = main.reference_id
				           WHERE main.entry_service_id = $task_id ORDER BY (main.created_date) DESC";
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
<!----------copy details------->
<?php include 'footer.php' ?>
<script>
// (A) COPY TEXT TO CLIPBOARD
function jscopyA () {
  // (A1) GET TEXT FROM TEXT FIELD
  var txt = document.getElementById("demoA");
  txt.select();
  // (A2) PUT TEXT INTO CLIPBOARD
  //navigator.clipboard.writeText(txt.value)
  document.execCommand('copy');

  // (A3) OPTIONAL - DO THIS AFTER COPY
  //.then(() => { alert("Copied"); });
};
</script>

 <!-- (B) HTML -->
<textarea type="text" id="demoA" readonly style="position: relative; bottom: 111000px">
<?php
$sql = "EXEC [dbo].[Details_Tickets_SP] @param_intServiceid = '$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

$test = '';
if($row['priority'] == 'Very High'){
	$test = "1 - Very High";
}elseif($row['priority'] == 'High'){
	$test = "2 - High";
}elseif($row['priority'] == 'Medium'){
	   $test = "3 - Medium";
}elseif($row['priority'] == 'Low'){
	   $test = "4 - Low";
}else{
	  $test = "5 - Incomplete";
}

if($row['status']=='Close'){
echo "~TICKET NO.: ".$row['reference_id']."~
*STATUS : CLOSED*
PRIORITY: ".$row['priority']."
RENDERED TIME: ".$row['render']." mins
DATE&TIME: ".$row['enddate']."
RESO: ".$row['resolution'];
}else{
echo "*TICKET NO.: ".$row['reference_id']."*
ISSUE: ".$row['title']."
PRIORITY: ".$test."
DEPARTMENT: ".$row['department']."
RAISED BY: ".$row['createduser']."
DATE&TIME: ".$row['startdate']."
ASSIGNED: ".$row['fullname'];
};
?>
</textarea>




