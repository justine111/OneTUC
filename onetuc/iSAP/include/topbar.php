<?php
include("include/login_header.php");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" 
integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" 
crossorigin="anonymous" referrerpolicy="no-referrer"/>
<!-- Navbar -->
<br>
<br>
<div class="layout-fixed layout-navbar fixed-top">
  <nav class="main-header navbar navbar-expand" style="background-color: #FF5F1F;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     <li class="nav-item dropdown">
            <a class="nav-link text-white"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class="fa fa-user-large mr-2"></span>
                  <span><b>iSAP</b></span>
                  <span class="fa-sharp fa-solid fa-arrow-right-from-bracket ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" href="?logout=logout" onclick="window.close();"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
    </ul>
  </nav>
</div>
