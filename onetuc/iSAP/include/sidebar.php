<?php
  include("include/login_header.php");
?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <div class="layout-fixed layout-navbar-fixed layout-footer-fixed">
  <aside class="main-sidebar elevation-4" style="background-color: #616161;">
    <div class="dropdown">
   	  <a href="#" class="brand-link">
      <!-----user-side----->
      <img src="img/ISAP .png" style="width: 235px;" alt="profileImg">
      </a>
    </div>
    <br>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!----user-side----->
          <li class="nav-item">
            <a href="#" class="nav-link nav-home" style="background-color: #FF5F1F;">
              <i class="nav-icon fa-solid fa-circle-info"></i>
              <b>
                iSAP iQuantity
              </b>
            </a>
          </li>  
          <!---ul class="nav nav-treeview-active">
          <li class="nav-item">
            <a href="#" class="nav-link nav-new_project tree-item">
              <i class="fa-solid fa-circle-plus nav-icon"></i>
              <p>Add New JRF</p>
            </a>
            <a href="#" class="nav-link nav-new_project tree-item">
              <i class="fa-solid fa-circle-plus nav-icon"></i>
              <p>Add user</p>
            </a>
          </li>
          </ul>
          </li> 
          <li class="nav-item">
            <a href="#" class="nav-link nav-project_list tree-item">
              <i class=" nav-icon fa-solid fa-list-check"></i>
                <p>List</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link nav-project_list tree-item">
              <i class=" nav-icon fa-brands fa-discourse"></i>
                <p>Your Request</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-task_list">
              <i class="nav-icon fas fa-users"></i>
                <p>Manage user</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-task_list">
              <i class="nav-icon fa-solid fa-calendar-check"></i>
                <p>Manage Approval</p>
                </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-task_list">
              <i class="nav-icon fa-solid fa-user-shield"></i>
                <p>User Approval</p>
            </a>
          </li--->
          </ul>
          </nav>
          </div>
          </aside>
        </div>

    <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>