<link rel="icon" type="img/png" href="img/ISAP LOGO.png">  
<div class="wrapper">
<?php
  require 'connect.php'; 


  include("include/topbar.php");
  include("include/sidebar.php");
  include("include/footer.php");
?>
 <br>
 <section class="content">

  <div class="container-fluid">     
    <div class="content-wrapper">
      <div class="col-lg-12">
	      <div class="card card-outline card-secondary">
		      <div class="card-header">
			        <div class="card-tools">
			      </div>
		      </div>

	<div class="table-responsive">
		<table class="table tabe-hover table-condensed" id="list" >
        <!--------master-admin-table------>
				<thead>
					<tr>
					<th class="text-center">#</th>
					<th class="text-center">ItemCode</th>
					<th class="text-center">CodeBars</th>
					<th class="text-center">ItemName</th>
					<th class="text-center">Retail</th>
          <th class="text-center">Suki</th>
          <th class="text-center">Kanegosyo</th>
          <th class="text-center">DIY</th>
          <th class="text-center">DUBAI</th>
          <th class="text-center">JERUSALEM</th>
          <th class="text-center">BUILDERS</th>
          <th class="text-center">SAUDI</th>
					</tr>
				</thead>
        <tbody>
        <?php
        $sql="EXEC [iSAP].[dbo].[iSAP-Report_SP]"; 
        $info = $obj_admin->manage_all_info($sql);
        $serial  = 1;
        $num_row = $info->rowcount();
        if($num_row==0){
          echo '<tr><td colspan="7">No Data found</td></tr>';
          }
          while( $row = $info->fetch(PDO::FETCH_ASSOC) ){
        ?>
          <tr>
          <td style="text-align: center;"><?php echo $serial; $serial++; ?></td>
          <td style="text-align: center;"><?php echo $row['ItemCode']; ?></td>
          <td style="text-align: center;"><?php echo $row['CodeBars']; ?></td>
          <td style="text-align: center;"><?php echo $row['ItemName']; ?></td>
          <td style="text-align: center;"><?php echo $row['Retail']; ?></td>
          <td style="text-align: center;"><?php echo $row['Suki']; ?></td>
          <td style="text-align: center;"><?php echo $row['Kanegosyo']; ?></td>
          <td style="text-align: center;"><?php echo $row['DIY']; ?></td>
          <td style="text-align: center;"><?php echo $row['DUBAI']; ?></td>
          <td style="text-align: center;"><?php echo $row['JERUSALEM']; ?></td>
          <td style="text-align: center;"><?php echo $row['BUILDERS']; ?></td>
          <td style="text-align: center;"><?php echo $row['SAUDI']; ?></td>
          </tr>
          <?php } ?>  
        </tbody>
</section>

<script>
// datatables
$(document).ready(function () {
    $('#list').DataTable();
});
</script>