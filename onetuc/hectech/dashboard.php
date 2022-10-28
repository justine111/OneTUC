<link rel="icon" type="img/png" href="img/logs.png">
<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
<?php
   require 'authentication.php'; 
   $department = $_SESSION['department'];
   $user_id = $_SESSION['admin_id'];
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
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['name'] ?>!
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
      <!---chartside--->    
      <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
                Tickets per Day 
              </div>
              <div class="card-body">
                <canvas id="myChart" width="400" height="200"></canvas><br>
                <input onchange="FilterData()"  type="date" id="startdate" value="<?php echo $row['created_date']; ?>">
                <input onchange="FilterData()"  type="date" id="enddate" value="<?php echo $row['created_date']; ?>">
                  <!--dataquery-->
                    <?php 
                      $sql ="SELECT
                      Format(T1.created_date, 'yyyy-MM-dd')AS date,
                      sum(CASE WHEN T1.new_ticket = 0 THEN 1 ELSE 0 END) new_ticket,
                      sum(T1.open_ticket) open_ticket,
                      sum(T1.pending) pending
                      FROM (SELECT
                      a.created_date,
                      (SELECT TOP 1 b.entry_status FROM [dbo].[entry_activities] AS b
                      WHERE b.reference_id = a.reference_id AND a.ticket_status = 'Approved'
                      ORDER BY b.datetime_updated DESC) AS new_ticket,
                      (SELECT TOP 1 b.entry_status FROM [dbo].[entry_activities] AS b
                      WHERE b.reference_id = a.reference_id AND a.ticket_status = 'Approved'
                      ORDER BY b.datetime_updated DESC) AS open_ticket,
                      (SELECT count(b.ticket_status) FROM [dbo].[entry_services] b
                      WHERE b.ticket_status = 'Waiting for Approval' and a.reference_id = b.reference_id) AS pending
                      FROM [dbo].[entry_services] a) T1
                      GROUP BY Format(T1.created_date, 'yyyy-MM-dd')";
                            $info = $obj_admin->manage_all_info($sql);
        
                            if($info->rowCount() > 0){
                            echo '<tr><td colspan="7">No Data found</td></tr>';
                            }
                            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                                   $dateArray[] =$row["date"];
                                   $idArray[] =$row["new_ticket"];
                                   $idArray2[] =$row["open_ticket"];
                                   $pendingArray[] =$row["pending"];
                            }
                            ?>                   
                  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
                  <script>
                    const dateArrayJS = <?php echo json_encode($dateArray); ?>;
                    console.log(dateArrayJS)
                    const datapoints = <?php echo json_encode($idArray); ?>;
                    console.log(datapoints)
                    const datapoints2 = <?php echo json_encode($idArray2); ?>;
                    console.log(datapoints2)
                    const pending = <?php echo json_encode($pendingArray); ?>;
                    console.log(pending)
                    // setup 
                    const data = {
                    labels: ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY'],
                    datasets: [{
                    label: 'New tickets',
                    data: datapoints,
                    backgroundColor: 'rgba(0, 197, 235, 0.9)',
                    borderColor:'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                    },{
                    label: 'Open tickets',
                    data: datapoints2,
                    backgroundColor: 'rgb(34, 175, 63)',
                    borderColor:'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                    },{
                    label: 'Pending tickets',
                    data: pending,
                    backgroundColor: 'rgb(255, 0, 0)',
                    borderColor:'rgba(0, 0, 0, 1)',
                    borderWidth: 1
                    }]
                  };
                    // config 
                    const config = {
                    type: 'bar',
                    data,
                    options: {
                    scales: {
                    y: {
                    beginAtZero: true
                   }
                  }
                 }
                };
                  // render init block
                  const myChart = new Chart(
                  document.getElementById('myChart'),
                  config
                  );

                  function FilterData(){
                  const dates2 = [...dateArrayJS  ];
                  console.log(dates2)
                  const startdate = document.getElementById('startdate');
                  const enddate = document.getElementById('enddate');

                  //para ma get it spicific date 1 by 1
                  const indexstartdate = dates2.indexOf(startdate.value);
                  const indexenddate = dates2.indexOf(enddate.value);
                  //console.log(indecstartdate)
                  const filterDate = dates2.slice(indexstartdate, indexenddate + 1);
                  myChart.config.data.labels = filterDate;

                  const datapoints2 = [...datapoints];
                  const filterdatapoints = datapoints2.slice(indexstartdate, indexenddate + 1);
                  myChart.config.data.datasets[0].data = filterdatapoints;
                  myChart.update(); 
                  }
                </script> 
                  </div>
            </div>
          </div>
            <!---piechartside--->
            <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-pie-chart-fill"></i></span>
                Percentage per Priority levels
              </div>
              <div class="card-body">
                <div id="piechart" width="400" height="200"></div>
                  <?php  
                  $sql = "SELECT a.description,
                          DATENAME(m, main.created_date) AS Month,
                          count(a.description) AS Count_of
                          FROM [dbo].[entry_services]main
                          LEFT JOIN [admin].[priority_levels] a on a.priority_id = main.priority_id
                          Group By DATENAME(m, created_date),a.description
                          ORDER BY Month DESC";  
                          $info = $obj_admin->manage_all_info($sql);  
                  ?>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
                <script>  
                  google.charts.load('current', {'packages':['corechart']});  
                  google.charts.setOnLoadCallback(drawChart);  
                  function drawChart()  
                  {  
                  var data = google.visualization.arrayToDataTable([  
                  ['', ''],  
                  <?php  
                  while( $row = $info->fetch(PDO::FETCH_ASSOC) ) 
                  {  
                  echo "['".$row["description"]."', ".$row["Count_of"]."],";  
                  }  
                  ?>  
                  ]);  
                  var options = {  
                  title: '', 
                  'width':500,
                     'height':300, 
                  //is3D:true,  
                  piechart: 0.4  
                  };  
                  var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                  chart.draw(data, options);  
                  }  
                </script> 
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-steps"></i></span>
                Category Chart per issue
              </div>
              <div class="card-body">
                <div id="barchart_material" style="width: 100%; height: 300px;"></div>
                    <?php
                    $sql = "SELECT category,
                    DATENAME(m, created_date) AS Month,
                    count(category) AS Count_of
                    FROM [dbo].[entry_services]main
                    Group By DATENAME(m, created_date),category
                    ORDER BY Month DESC";  
                    $info = $obj_admin->manage_all_info($sql);  
                    ?>
                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                    var data = google.visualization.arrayToDataTable([  
                    ['', ''],  
                    <?php  
                    while( $row = $info->fetch(PDO::FETCH_ASSOC) ) 
                    {  
                    echo "['".$row["category"]."', ".$row["Count_of"]."],";  
                    }  
                    ?>  
                    ]);  

                    var options = {
                    chart: {
                    title: 'Category Issue',
                    subtitle: 'This Month',
                    },
                    bars: 'horizontal', // Required for Material Bar Charts.
                    date: 'now'
                  };
                    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                     }
                  </script>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-steps"></i></span>
                Department Chart per issue
              </div>
              <div class="card-body">
                <div id="barchart_material2" style="width: 100%; height: 300px;"></div>
                    <?php
                    $sql = "SELECT a.department_name,
                    DATENAME(m, main.created_date) AS Month,
                    count(main.department) AS Count_of
                    FROM [dbo].[entry_services]main
                    LEFT JOIN [admin].[departments] a on a.department_id = main.department
                    Group By DATENAME(m, main.created_date),a.department_name
                    ORDER BY Month DESC";  
                    $info = $obj_admin->manage_all_info($sql);  
                    ?>
                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                    var data = google.visualization.arrayToDataTable([  
                    ['', ''],  
                    <?php  
                    while( $row = $info->fetch(PDO::FETCH_ASSOC) ) 
                    {  
                    echo "['".$row["department_name"]."', ".$row["Count_of"]."],";  
                    }  
                    ?>  
                    ]);  

                    var options = {
                    chart: {
                    title: 'Department Request',
                    subtitle: 'This Month',
                    },
                    bars: 'horizontal' // Required for Material Bar Charts.
                  };
                    var chart = new google.charts.Bar(document.getElementById('barchart_material2'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                     }
                  </script>
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
                        <td><b><?php echo $row['title']; ?></b></td>
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
  <?php include 'footer.php' ?>
  <script>
// datatables
$(document).ready(function () {
    $('#list').DataTable({
      "pageLength": 5
});
});
</script>


  

