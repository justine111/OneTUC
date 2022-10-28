<?php
   require 'authentication.php'; 
?>
<div class="wrapper">
<?php
  include("include/topbar.php");
  include("include/sidebar.php");
?>

<section class="content">
  <div class="container-fluid">     
    <div class="content-wrapper">
      <div class="col-12">
      <!---chartside--->    
        <div class="row pt-2 d-flex justify-content-center">
          <div class=" col-auto">
            <div class="card mb-3 text-center" style="width:46.5rem;">
              <div class="card-body">
                <h5 class="card-title">Number of Tickets per day</h5>
                  <canvas id="myChart" width="250" height="111"></canvas>
                    <?php 
                    $sql = "SELECT created_date FROM [dbo].[entry_services] ";
                    $info = $obj_admin->manage_all_info($sql);   
                    ?>
                  <input onchange="FilterData()"  type="date" id="startdate" value="<?php echo $row['created_date']; ?>">
                  <input onchange="FilterData()"  type="date" id="enddate" value="<?php echo $row['created_date']; ?>">
                  <!--dataquery-->
                    <?php 
                    try{
                      $sql ="SELECT
                            T1.created_date,
                            sum(CASE WHEN T1.new_ticket = 0 THEN 1 ELSE 0 END) new_ticket,
                            sum(T1.open_ticket) open_ticket,
                            sum(T1.pending) as pending
                            FROM (SELECT
                            a.created_date,
                            (SELECT TOP 1 b.entry_status FROM [dbo].[entry_activities] AS b
                            WHERE b.reference_id = a.reference_id
                            ORDER BY b.datetime_updated DESC) AS new_ticket,
                            (SELECT TOP 1 b.entry_status FROM [dbo].[entry_activities] AS b
                            WHERE b.reference_id = a.reference_id
                            ORDER BY b.datetime_updated DESC) AS open_ticket,
                            (SELECT count(b.ticket_status) FROM [dbo].[entry_services] b
                            WHERE b.ticket_status = 'Waiting for Approval' and a.reference_id = b.reference_id) AS pending
                            FROM [dbo].[entry_services] a) T1
                            GROUP BY T1.created_date";
                            $info = $obj_admin->manage_all_info($sql);
        
                            if($info->rowCount() > 0){
                            echo '<tr><td colspan="7">No Data found</td></tr>';
                            }
                            while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
                                   $dateArray[] =$row["created_date"];
                                   $idArray[] =$row["new_ticket"];
                                   $idArray2[] =$row["open_ticket"];
                                   $pendingArray[] =$row["pending"];
                            }
                            unset($info);
                            } catch(PDOException $e){
                            die("ERROR: connot connect to database. " . $e->getMessage());
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
                  labels: dateArrayJS,
                  datasets: [{
                  label: 'New tickets',
                  data: datapoints,
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor:'rgba(75, 192, 192, 1)',
                  borderWidth: 1
                  },{
                  label: 'Open tickets',
                  data: datapoints2,
                  backgroundColor: 'rgba(52, 162, 235, 0.2)',
                  borderColor:'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                  },{
                  label: 'Pending tickets',
                  data: pending,
                  backgroundColor: 'rgba(0, 0, 0, 0.2)',
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
                x: {
                type: 'time',
                time: {
                unit: 'day'
                }
                },
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



        
        
            <div class="card mb-3 text-center" style="width:46.5rem;">
                <div class="card-body">
                    <div id="piechart"></div>

      <?php  
      $sql = "SELECT a.description, count(*) as number FROM [dbo].[entry_services] main
      LEFT JOIN [admin].[priority_levels] a on a.priority_id = main.priority_id
      GROUP BY a.description";  
      $info = $obj_admin->manage_all_info($sql);  
      ?>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
      <script>  
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawChart);  
        function drawChart()  
        {  
          var data = google.visualization.arrayToDataTable([  
            ['Gender', 'Number'],  
          <?php  
          while( $row = $info->fetch(PDO::FETCH_ASSOC) ) 
          {  
          echo "['".$row["description"]."', ".$row["number"]."],";  
          }  
          ?>  
          ]);  
          var options = {  
          title: 'Percentage per Priority levels',  
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





        <div class="col-auto">
        <div class="card mb-3 text-center" style="width:46.5rem;">
                <div class="card-body">
                    <?php
                    $sql = "SELECT category, count(*) as number FROM [dbo].[entry_services] main
                    GROUP BY category";  
                  $info = $obj_admin->manage_all_info($sql);  
?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([  
      ['Gender', 'Number'],  
    <?php  
    while( $row = $info->fetch(PDO::FETCH_ASSOC) ) 
    {  
    echo "['".$row["category"]."', ".$row["number"]."],";  
    }  
    ?>  
    ]);  

        var options = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="barchart_material"></div>
  </body>
  
                </div>
            </div>
        </div>

  </section> 
  <?php include 'footer.php' ?>

