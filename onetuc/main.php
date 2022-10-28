<link rel="icon" type="img/png" href="img/logs.png">
<script type = "text/javascript" >  
    function preventBack() { window.history.forward(); }  
    setTimeout("preventBack()", 0);  
    window.onunload = function () { null };  
</script> 
<?php
  require 'authentication.php';
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['name'];
  $user_role = $_SESSION['user_role'];
  $employee = $_SESSION['employee'];
  $active = $_SESSION['active'];

  if(!isset($_SESSION['admin_id'])){
  header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>OneTUC | Home</title>
    <link rel="stylesheet" href="main.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
 </head>
 <script type="text/javascript">
	window.history.forward();
	function noBack() { window.history.forward(); }
</script>
</HEAD>
 <body>
 <nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="logo"><a href="#">ONETUC</a></div>
      <div class="nav-links">
        <ul class="links">
          <li><a href="#">User ID: <?php echo $employee; ?></a></li>
          <li>
            <a href="#"><?php echo $user_name; ?></a>
            <i class='bx bxs-chevron-down js-arrow arrow '></i>
            <ul class="js-sub-menu sub-menu">
              <li><a href="?logout=logout">Log out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!---link per page side---->
  <div id="aligncenter" class="make-center" >
      <!---master-admin---->
        <?php if($user_role == 4){ ?>
            <a  class="dropdown-item" href="hectech/dashboard.php" target="_blank" rel="noopener noreferrer"><i class="fa fa-power-off">
            <?php if($active == 1){ ?>
            <img src="img/logs.png" style="width: 180px;" alt="centered image"/>
        <?php } ?> 
            </a>
        <?php } ?> 

        <!---engineer-side---->
        <?php if($user_role == 3){ ?>
            <a  class="dropdown-item" href="hectech/dash.php" target="_blank" rel="noopener noreferrer"><i class="fa fa-power-off">
            <?php if($active == 1){ ?>
            <img src="img/logs.png" style="width: 180px;" alt="centered image"/>
        <?php } ?> 
            </a>
        <?php } ?> 

        <!---lead-side---->
        <?php if($user_role == 2){ ?>
            <a  class="dropdown-item" href="hectech/dash.php" target="_blank" rel="noopener noreferrer"><i class="fa fa-power-off">
            <?php if($active == 1){ ?>
            <img src="img/logs.png" style="width: 180px;" alt="centered image"/>
        <?php } ?> 
            </a>
        <?php } ?>
      
        <!---user-side---->
        <?php if($user_role == 1){ ?>
            <a  class="dropdown-item" href="hectech/dash.php" target="_blank" rel="noopener noreferrer"><i class="fa fa-power-off">
            <?php if($active == 1){ ?>
            <img src="img/logs.png" style="width: 180px;" alt="centered image"/>
        <?php } ?> 
            </a>
        <?php } ?>
      
        <!----icon---->
        <?php if($active == 0){ ?>
          <img src="img/1.svg" style="display: none;" alt="centered image"/>
        <?php } ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      
        <!---iSAP side--->
        <?php if($user_role == 4){ ?>
          <a  class="dropdown-item" href="iSAP/index.php" target="_blank" rel="noopener noreferrer"><i class="fa fa-power-off">
          <img src="img/ISAP LOGO.png" style="width: 195px;" alt="centered image"/>
        <?php } ?>
          </a>
      </div>
    </body>
  </html>

  <style>
  html,body{
  height: 100%;
  background: linear-gradient(27deg, #013A6B 50%, #004E95 50%);
  }
  #aligncenter {
  height: 100%;
  }
  .make-center{
  display: flex;
  justify-content: center;
  align-items: center;
  }
  </style>

  <script>
      // search-box open close js code
  let navbar = document.querySelector(".navbar");
  let navLinks = document.querySelector(".nav-links");
  let menuOpenBtn = document.querySelector(".navbar .bx-menu");
  let menuCloseBtn = document.querySelector(".nav-links .bx-x");
  menuOpenBtn.onclick = function() {
  navLinks.style.left = "0";  
  }
  menuCloseBtn.onclick = function() {
  navLinks.style.left = "-100%";
  }
  // sidebar submenu open close js code
  let htmlcssArrow = document.querySelector(".htmlcss-arrow");
  htmlcssArrow.onclick = function() {
  navLinks.classList.toggle("show1");
  }
  let moreArrow = document.querySelector(".more-arrow");
  moreArrow.onclick = function() {
  navLinks.classList.toggle("show2"); 
  }
  let jsArrow = document.querySelector(".js-arrow");
  jsArrow.onclick = function() {
  navLinks.classList.toggle("show3");
  }
  </script>