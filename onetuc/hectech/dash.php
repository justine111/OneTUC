<link rel="icon" type="img/png" href="img/logs.png">
<!---------- authenticate and function for header display name/ID --------->
<?php    
  require 'authentication.php';
  $department = $_SESSION['department'];
  $user_id = $_SESSION['admin_id'];
  $user_role = $_SESSION['user_role'];
?>
  <div class="wrapper">
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>

<br>
<?php if($user_role == 4){ ?>
  <section class="content">
    <div class="container-fluid">     
      <div class="content-wrapper">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['name'] ?>!
            </div>
          </div>
          <!----Count add ticket per day--->
          <form action="" method="post">
            <label>From:</label>
              <input list="from" type="text" name="from" class="form-group" required>
              <datalist id="from">
              <?php 
              $sql = "SELECT created_date FROM [dbo].[entry_services] ";
              $info = $obj_admin->manage_all_info($sql);   
              ?>
              <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
              <option value="<?php echo $row['created_date']; ?>"><?php echo $row['created_date']; ?></option>
              <?php } ?>
              </datalist>
            <label>To:</label> 
              <input list="to" type="text" name="to" class="form-group" required>
              <datalist id="to">
              <?php 
              $sql = "SELECT created_date FROM [dbo].[entry_services] ";
              $info = $obj_admin->manage_all_info($sql);   
              ?>
              <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
              <option value="<?php echo $row['created_date']; ?>"><?php echo $row['created_date']; ?></option>
              <?php } ?>
              </datalist>
            <input  class="btn btn-primary" type="submit" value="FILTER"/>
          </form> 
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
              <div class="small-box bg-info shadow-sm border">
                <div class="inner">
                  <?php
                  if ( isset( $_POST['from'] ) ) {
                  $a = $_POST['from'];
                  $b = $_POST['to'];

                 $sql ="WITH ticket_cte  
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
                        SELECT b.ticket_status , COUNT(a.entry_status) as New 
                        FROM ticket_cte a
                        LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                        WHERE a.entry_status = 0 AND b.ticket_status = 'Approved' 
                        AND b.created_date BETWEEN '$a' AND '$b'
                        GROUP BY b.ticket_status";
                        $totalticket = $obj_admin->manage_all_info($sql);
                        $row=$totalticket->fetch(PDO::FETCH_ASSOC); 
                  }?>
				                <h1><?php
                        if($row == 0){
                        echo '<tr><td colspan="7">No Data Filtered</td></tr>';
                        }else{
                        echo " ".$row['New'];
                        }?></h1>
			                  <p>New tickets</p>
                     </div>
                  <div class="icon">
                <i class="fa fa-bookmark"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-success shadow-sm border">
              <div class="inner">
                <?php
                if ( isset( $_POST['from'] ) ) {
                $a = $_POST['from'];
                $b = $_POST['to'];

                $sql ="WITH ticket_cte  
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
                      SELECT b.ticket_status , COUNT(a.entry_status) as New 
                      FROM ticket_cte a
                      LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                      where a.entry_status = 1 AND b.ticket_status = 'Approved' 
                      AND b.created_date BETWEEN '$a' AND '$b'
                      GROUP BY b.ticket_status";
                      $totalticket = $obj_admin->manage_all_info($sql);
                      $row=$totalticket->fetch(PDO::FETCH_ASSOC); 
                }?>
				              <h1><?php
                      if($row == 0){
                      echo '<tr><td colspan="7">No Data Filtered</td></tr>';
                      }else{
                        echo " ".$row['New'];
                      }?></h1>
			                  <p>Open tickets</p>
                    </div>
                  <div class="icon">
                <i class="fa fa-bookmark"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-danger shadow-sm border">
              <div class="inner">
                <?php
                if ( isset( $_POST['from'] ) ) {
                $a = $_POST['from'];
                $b = $_POST['to'];

                $sql ="WITH ticket_cte  
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
                      SELECT b.ticket_status , COUNT(a.entry_status) as New 
                      FROM ticket_cte a
                      LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                      where a.entry_status = 0 AND b.ticket_status = 'Waiting for Approval' 
                      AND b.created_date BETWEEN '$a' AND '$b'
                      GROUP BY b.ticket_status";
                      $totalticket = $obj_admin->manage_all_info($sql);
                      $row=$totalticket->fetch(PDO::FETCH_ASSOC); 
                }?>
				              <h1><?php
                      if($row == 0){
                      echo '<tr><td colspan="7">No Data Filtered</td></tr>';
                      }else{
                        echo " ".$row['New'];
                      }?></h1>
			                  <p>Pending tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-bookmark"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-info shadow-sm border">
              <div class="inner">
			        <?php
              $ticket_count = 
                    "WITH ticket_cte
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
			               SELECT COUNT(a.entry_status) as countid 
                     FROM ticket_cte a
                     LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                     where a.entry_status = 0 AND b.ticket_status = 'Approved'";
			               $totalticket = $obj_admin->db->prepare($ticket_count);
                     $totalticket->execute();
			               $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
                     ?>
				             <h1><?php
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>New tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-bookmark"></i>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-success shadow-sm border">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where a.entry_status = 1 AND b.ticket_status = 'Approved'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>Open tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-folder-open"></i>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-danger shadow-sm border">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where b.ticket_status = 'Waiting for Approval'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>For Approval</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-thumb-tack"></i>
                </div>
              </div>
            </div>
          </div>

		      <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-danger">
                <div class="card-header">
                  <b>Recent added tickets</b>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0 table-hover" id="list">
                      <thead>
                        <th>#</th>
                        <th>Reference code</th>
                        <th>Task title</th>
                        <th>Priority level</th>
                        <th>Status</th>
                      </thead>
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
                        <td><?php echo '<span class="badge"</span>' . $serial; $serial++; ?></td>
                        <td><a href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>"><?php echo '<span class="badge"</span>' . $row['reference_id']; ?><a/></td>
                        <td>
                          <b><?php echo ucwords($row['title']) ?></b>
                          <p class="truncate"><?php echo  $row['des']; ?></p>
                        </td>
                        <td><?php echo   $row['priority']; ?></td>
                        <td><?php echo   $row['status']; ?></td>
                      </tr>         
                    <?php } ?>   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
</section>
<?php } ?>

<?php if($user_role == 3){ ?>
  <section class="content">
    <div class="container-fluid">     
      <div class="content-wrapper">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['name'] ?>!
            </div>
          </div>
          <!----Count add ticket per day--->
          <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
              <div class="small-box bg-warning shadow-sm border">
                <div class="inner">
                  <h3> <?php
                  $ticket_count = "SELECT
                  DATENAME (m, created_date) AS month,
                  DATENAME (dw, created_date) AS Day,
                  DATENAME (d, created_date) AS Daysof,
                  count(entry_service_id) AS count_of
                  FROM [dbo].[entry_services]
                  Group By DATENAME (dw, created_date), DATENAME(d, created_date), DATENAME(m, created_date)
                  ORDER BY Daysof DESC";
			            $totalticket = $obj_admin->db->prepare($ticket_count);
                  $totalticket->execute();
			            $countme=$totalticket->fetch(PDO::FETCH_ASSOC);                
                  ?>
				          <h1><h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['count_of'];
                      }?></h1></h3>
			                <p>Ticket add as per Today: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['month'];?> <?php echo $countme['Daysof']; ?>, <?php echo $countme['Day'];
                      }?></b><p></p></h3>
                </div>
              <div class="icon">
                <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATEPART (wk, created_date) AS Week,
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                Group By DATEPART (wk, created_date), DATENAME(m, created_date)
                ORDER BY Week DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Week: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                      echo "Week ".$countme['Week'];?> of <?php echo $countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                Group By DATENAME(m, created_date)
                ORDER BY Month DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Month: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                    echo " ".$countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
			        <h3><?php
              $ticket_count = "SELECT YEAR(created_date) AS YEAR, COUNT(*) AS COUNT 
                    FROM [dbo].[entry_services]
                    GROUP BY YEAR(created_date)
                    ORDER BY YEAR";
			              $totalticket = $obj_admin->db->prepare($ticket_count);
                    $totalticket->execute();
			              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
                    ?>
				            <h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['COUNT'];
                      }?></h1></h3>
			                <p>Ticket add per Year: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['YEAR'];
                      }?></b><p></p>                        
                      </div>
                    <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-info shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
                    "WITH ticket_cte
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
			               SELECT COUNT(a.entry_status) as countid 
                     FROM ticket_cte a
                     LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                     where a.entry_status = 0 AND b.ticket_status = 'Approved'";
			               $totalticket = $obj_admin->db->prepare($ticket_count);
                     $totalticket->execute();
			               $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
                     ?>
				             <h1><?php
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>New tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-bookmark"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-success shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where a.entry_status = 1 AND b.ticket_status = 'Approved'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>Open tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-folder-open"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-danger shadow-sm border">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where b.ticket_status = 'Waiting for Approval'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        echo " ".$countme['countid'];
                        echo "<br />"; 
                        ?></h1>
			                    <p>For Approval</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-thumb-tack"></i>
                </div>
              </div>
            </div>
          </div>

		      <div class="row">
            <div class="col-md-12">
              <div class="card card-outline card-danger">
                <div class="card-header">
                  <b>Recent added tickets</b>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0 table-hover" id="list">
                      <thead>
                        <th>#</th>
                        <th>Reference code</th>
                        <th>Task title</th>
                        <th>Priority level</th>
                        <th>Status</th>
                      </thead>
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
                        <td><?php echo '<span class="badge"</span>' . $serial; $serial++; ?></td>
                        <td><a href="task-details.php?task_id=<?php echo $row['entry_service_id']; ?>"><?php echo '<span class="badge"</span>' . $row['reference_id']; ?><a/></td>
                        <td>
                          <b><?php echo ucwords($row['title']) ?></b>
                          <p class="truncate"><?php echo  $row['des']; ?></p>
                        </td>
                        <td><?php echo   $row['priority']; ?></td>
                        <td><?php echo   $row['status']; ?></td>
                      </tr>         
                    <?php } ?>   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
</section>
<?php } ?>

<!-----user-side-dashboard----->
<?php if($user_role == 1){ ?> 
<section class="content">
    <div class="container-fluid">     
      <div class="content-wrapper">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['name'] ?>!
            </div>
          </div>
          <!----Count add ticket per day--->
          <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
              <div class="small-box bg-warning shadow-sm border">
                <div class="inner">
                  <h3> <?php
                  $ticket_count = "SELECT
                  DATENAME (m, created_date) AS month,
                  DATENAME (dw, created_date) AS Day,
                  DATENAME (d, created_date) AS Daysof,
                  count(entry_service_id) AS count_of
                  FROM [dbo].[entry_services]
                  WHERE created_userid = '$user_id'
                  Group By DATENAME (dw, created_date), DATENAME(d, created_date), DATENAME(m, created_date)
                  ORDER BY Daysof DESC";
			            $totalticket = $obj_admin->db->prepare($ticket_count);
                  $totalticket->execute();
			            $countme=$totalticket->fetch(PDO::FETCH_ASSOC);                
                  ?>
				          <h1><h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['count_of'];
                      }?></h1></h3>
			                <p>Ticket add as per Today: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['month'];?> <?php echo $countme['Daysof']; ?>, <?php echo $countme['Day'];
                      }?></b><p></p></h3>
                </div>
              <div class="icon">
                <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATEPART (wk, created_date) AS Week,
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                WHERE created_userid = '$user_id'
                Group By DATEPART (wk, created_date), DATENAME(m, created_date)
                ORDER BY Week DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Week: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                      echo "Week ".$countme['Week'];?> of <?php echo $countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                WHERE created_userid = '$user_id'
                Group By DATENAME(m, created_date)
                ORDER BY Month DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Month: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                    echo " ".$countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
			        <h3><?php
              $ticket_count = "SELECT YEAR(created_date) AS YEAR, COUNT(*) AS COUNT 
                    FROM [dbo].[entry_services]
                    WHERE created_userid = '$user_id'
                    GROUP BY YEAR(created_date)
                    ORDER BY YEAR";
			              $totalticket = $obj_admin->db->prepare($ticket_count);
                    $totalticket->execute();
			              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
                    ?>
				            <h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['COUNT'];
                      }?></h1></h3>
			                <p>Ticket add per Year: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['YEAR'];
                      }?></b><p></p>                        
                      </div>
                    <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-info shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
                    "WITH ticket_cte
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
			               SELECT COUNT(a.entry_status) as countid 
                     FROM ticket_cte a
                     LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                     where a.entry_status = 0 AND b.ticket_status = 'Approved' AND created_userid = '$user_id'";
			               $totalticket = $obj_admin->db->prepare($ticket_count);
                     $totalticket->execute();
			               $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if($countme == 0){
                          echo '<tr><td colspan="7">0</td></tr>';
                          }
                          else{
                          echo " ".$countme['countid'];
                          echo "<br />";} 
                        ?></h1>
			                    <p>New tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-bookmark"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-success shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where a.entry_status = 1 AND b.ticket_status = 'Approved' AND created_userid = '$user_id'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if($countme == 0){
                          echo '<tr><td colspan="7">0</td></tr>';
                          }
                          else{
                          echo " ".$countme['countid'];
                          echo "<br />";} 
                        ?></h1>
			                    <p>Open tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-folder-open"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <div class="small-box bg-danger shadow-sm border">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              WHERE b.ticket_status = 'Waiting for Approval' AND created_userid = '$user_id'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if( $countme == 0){
                        echo '<tr><td colspan="7">0</td></tr>';
                        }
                        else{
                        echo " ".$countme['countid'];
                        echo "<br />";}
                        ?></h1>
			                    <p>Waiting for Approval</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-thumb-tack"></i>
                </div>
              </div>
            </div>
          </div>
  </section>
  <?php } ?>

<!-----lead-side-dashboard---->
<?php if($user_role == 2){ ?> 
<section class="content">
    <div class="container-fluid">     
      <div class="content-wrapper">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['name'] ?>!
            </div>
          </div>
          <!----Count add ticket per day--->
          <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
              <div class="small-box bg-warning shadow-sm border">
                <div class="inner">
                  <h3> <?php
                  $ticket_count = "SELECT
                  DATENAME (m, created_date) AS month,
                  DATENAME (dw, created_date) AS Day,
                  DATENAME (d, created_date) AS Daysof,
                  count(entry_service_id) AS count_of
                  FROM [dbo].[entry_services]
                  WHERE created_userid = '$user_id'
                  Group By DATENAME (dw, created_date), DATENAME(d, created_date), DATENAME(m, created_date)
                  ORDER BY Daysof DESC";
			            $totalticket = $obj_admin->db->prepare($ticket_count);
                  $totalticket->execute();
			            $countme=$totalticket->fetch(PDO::FETCH_ASSOC);                
                  ?>
				          <h1><h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['count_of'];
                      }?></h1></h3>
			                <p>Ticket add as per Today: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['month'];?> <?php echo $countme['Daysof']; ?>, <?php echo $countme['Day'];
                      }?></b><p></p></h3>
                </div>
              <div class="icon">
                <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATEPART (wk, created_date) AS Week,
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                WHERE created_userid = '$user_id'
                Group By DATEPART (wk, created_date), DATENAME(m, created_date)
                ORDER BY Week DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Week: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                      echo "Week ".$countme['Week'];?> of <?php echo $countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
                <h3><?php
                $ticket_count = "SELECT
                DATENAME(m, created_date) AS Month,
                count(entry_service_id) AS Count_of
                FROM [dbo].[entry_services]
                WHERE created_userid = '$user_id'
                Group By DATENAME(m, created_date)
                ORDER BY Month DESC";
                $totalticket = $obj_admin->db->prepare($ticket_count);
                $totalticket->execute();
                $countme=$totalticket->fetch(PDO::FETCH_ASSOC); 
                ?>
				        <h1><?php
                    if($countme == 0){
                    echo '<tr><td colspan="7">No Data</td></tr>';
                    }else{
                    echo " ".$countme['Count_of'];
                    }?></h1></h3>
			              <p>Ticket add per Month: <p><b>
                    <?php
                    if($countme == 0){
                    echo'<tr><td colspan="7">No Data</td></tr>';
                    }else{ 
                    echo " ".$countme['Month'];
                    }?></b><p></p>
              </div>
             <div class="icon">
               <i class="fa fa-file"></i>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="small-box bg-warning shadow-sm border">
              <div class="inner">
			        <h3><?php
              $ticket_count = "SELECT YEAR(created_date) AS YEAR, COUNT(*) AS COUNT 
                    FROM [dbo].[entry_services]
                    WHERE created_userid = '$user_id'
                    GROUP BY YEAR(created_date)
                    ORDER BY YEAR";
			              $totalticket = $obj_admin->db->prepare($ticket_count);
                    $totalticket->execute();
			              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
                    ?>
				            <h1><?php
                      if($countme == 0){
                      echo '<tr><td colspan="7">No Data</td></tr>';
                      }else{
                      echo " ".$countme['COUNT'];
                      }?></h1></h3>
			                <p>Ticket add per Year: <p><b>
                      <?php
                      if($countme == 0){
                      echo'<tr><td colspan="7">No Data</td></tr>';
                      }else{ 
                      echo " ".$countme['YEAR'];
                      }?></b><p></p>                        
                      </div>
                    <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-info shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
                    "WITH ticket_cte
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
			               SELECT COUNT(a.entry_status) as countid 
                     FROM ticket_cte a
                     LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
                     where a.entry_status = 0 AND b.ticket_status = 'Approved' AND created_userid = '$user_id'";
			               $totalticket = $obj_admin->db->prepare($ticket_count);
                     $totalticket->execute();
			               $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if($countme == 0){
                          echo '<tr><td colspan="7">0</td></tr>';
                          }
                          else{
                          echo " ".$countme['countid'];
                          echo "<br />";} 
                        ?></h1>
			                    <p>New tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-bookmark"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-success shadow-sm border" href="task-info.php">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              where a.entry_status = 1 AND b.ticket_status = 'Approved' AND created_userid = '$user_id'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if($countme == 0){
                          echo '<tr><td colspan="7">0</td></tr>';
                          }
                          else{
                          echo " ".$countme['countid'];
                          echo "<br />";} 
                        ?></h1>
			                    <p>Open tickets</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-folder-open"></i>
                </div>
              </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 mb-20">
            <a class="small-box bg-danger shadow-sm border" href="manage-approval.php">
              <div class="inner">
			        <?php
              $ticket_count = 
              "WITH ticket_cte
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
              SELECT COUNT(a.entry_status) as countid 
              FROM ticket_cte a
              LEFT JOIN [dbo].[entry_services] b on b.reference_id = a.reference_id 
              WHERE b.ticket_status = 'Waiting for Approval' AND created_userid = '$user_id'";
              $totalticket = $obj_admin->db->prepare($ticket_count);
              $totalticket->execute();
              $countme=$totalticket->fetch(PDO::FETCH_ASSOC);
              ?>
				             <h1><?php 
                        if( $countme == 0){
                        echo '<tr><td colspan="7">0</td></tr>';
                        }
                        else{
                        echo " ".$countme['countid'];
                        echo "<br />";}
                        ?></h1>
			                    <p>Waiting for Approval</p>
                      </div>
                    <div class="icon">
                  <i class="fa fa-thumb-tack"></i>
                </div>
              </a>
            </div>
          </div>
  </section>
  <?php } ?>
<script>
// datatables
$(document).ready(function () {
    $('#list').DataTable({
      "pageLength": 5
});
});
</script>

<script>
     $('#to').editableSelect();
</script>
<style>
  input[type=text]{
    width:22%;
    border:2px solid #aaa;
    border-radius:4px;
    margin:7px 0;
    outline:none;
    padding:5px;
    box-sizing:border-box;
    transition:.3s;
  }
  
  input[type=text]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }
</style>

<!----------script for sidbar --------->
<?php include 'footer.php' ?>
