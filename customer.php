<?php 
  //☰
	session_start();
	$title="Customer Page";
	include('header.php');
  $cname = $_SESSION['cname'];
  if(!isset($_SESSION['customer_id'])){
    echo '<script type="text/javascript">window.location.href = "index.php"; </script>';  
  }
?>
  <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div style = "float: bottom"class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           <a class="navbar-brand" href="/csr"><span class="icon-rocket" style = "color: #009999;"></span> Netlink Advance Solutions, Inc.</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li class="active"><a  role = "button" href="customer.php"><span class="icon-home" style = "font-weight: bold;"></span> Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-briefcase" style = "font-weight: bold;"></span> Reports <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu">
                <li><a role = "button" href = "?module=daterange"><span class = "icon-file-text2" style = "font-weight: bold;"></span> Overall Service Report </a></li>
                <li><a role = "button" href = "?module=pcreport"><span class="icon-display" style = "font-weight: bold;"></span> PC Service Report </a></li>  
              </ul>
            </li> 
          </ul>
          <ul class="nav navbar-nav navbar-right">        
            <li><a href="logout.php" style="color: red;"><span class="icon-switch"></span> Logout</a></li>
         </ul>
        </div>
      </div>
    </nav>
    <!-- Jumpbotron -->
    <div class="jumbotron sb-page-header">
      <div class="container" style="margin-top: 20px;">
        <h2>Welcome!</h2> <i><h1><?php echo $cname; ?></h1></i>
        <h4><?php echo date('l jS \of F Y');?> <span id="hours"><?=date('h');?></span>:<span id="minutes"><?=date('i');?></span>:<span id="seconds"><?=date('s');?></span> <span id="seconds"><?=date('A');?></span></h4> 
      </div>
    </div>
    <!-- Page Content -->
    <div class = "container-fluid">
      <?php
      	include 'modules/conf.php';
      	if(!isset($_GET['module'])){
          include 'modules/daterange.php';
      	}elseif(!file_exists('modules/'.$_GET['module'].'.php')){
      		include 'modules/404.php';
      	}else{
      		include 'modules/'.$_GET['module'].'.php';
      	}	
      ?>
<?php include 'footer.php'; ?>