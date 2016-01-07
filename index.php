<?php
	session_start();
	include 'header.php';
    include 'modules/conf.php';
    include 'modules/title.php';	
	if(isset($_SESSION['customer_id'])){
		$cname = $_SESSION['cname'];
?>
<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div style = "float: bottom" class="navbar-header">
        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        		<span class="sr-only">Toggle navigation</span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        		<span class="icon-bar"></span>
        	</button>
        	<a class="navbar-brand" href="/csr"><span class="icon-office" style = "color: #009999;"></span> Netlink Advance Solutions, Inc.</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li class="active"><a  role = "button" href="/csr"><span class="icon-home" style = "font-weight: bold;"></span> Home</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-briefcase" style = "font-weight: bold;"></span> Reports <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu">
                <li><a role = "button" href = "?module=daterange"><span class = "icon-file-text2" style = "font-weight: bold;"></span> Overall Service Report </a></li>
                <li><a role = "button" href = "?module=pcreport"><span class="icon-display" style = "font-weight: bold;"></span> PC Service Report </a></li>  
            	<li><a role = "button" href = "?module=netcon"><span class="icon-power-cord" style = "font-weight: bold;"></span> Network Connection Service Report </a></li>  
              </ul>
            </li> 
          </ul>
          <ul class="nav navbar-nav navbar-right">        
            <li><a href="?module=logout" style="color: red;" id = "logout"><span class="icon-switch"></span> Logout</a></li>
         </ul>
        </div>
      </div>
    </nav>
    <div class = "visible-xs visible-sm hidden-md hidden-lg" style="margin-top: 50px;"></div>
    <header><!-- Jumpbotron -->
	    <div class="jumbotron sb-page-header">
	      <div class="container" style="margin-top: 20px;">
	        <h2>Welcome!</h2> <i><h1><?php echo $cname; ?></h1></i>
	        <h4><?php echo date('l jS \of F Y');?> <span id="hours"><?=date('h');?></span>:<span id="minutes"><?=date('i');?></span>:<span id="seconds"><?=date('s');?></span> <span id="seconds"><?=date('A');?></span></h4> 
	      </div>
	    </div>
    </header>
    <!-- Page Content -->
    <div class = "container-fluid" style="display: hidden;">
      <?php
      	if(!isset($_GET['module'])){
          include 'modules/daterange.php';
      	}elseif(!file_exists('modules/'.$_GET['module'].'.php')){
      		include 'modules/404.php';
      	}else{
      		include 'modules/'.$_GET['module'].'.php';
      	}	
     }elseif((isset($_GET['module']) && $_GET['module'] == 'login' && !isset($_SESSION['customer_id'])) || (!isset($_SESSION['customer_id']))){
      ?>
<style type="text/css">
	.table {border-bottom:0px !important;}
	.table th, .table td {border: 0px !important;}
</style>
<div align = "center" style = "margin-top: 10px;">
			<img class="img-rounded" src = "img/netlink.jpg" height = "200">
		</div>
		<form role = "form" action = "" method = "post">	
			<table align = "center" class = "table form-horizontal" style = "margin-top: 0px; width: 800px;" >
				<thead>
					<tr style = "border: none;">
						<td colspan = 2 align = center><h2><i><span class="icon-lock"></span><i class="fa fa-desktop"></i> Customer Login Form</i></h2></td> 
					</tr>
				</thead>
				<tr>
					<td><label for = "uname"><span class="icon-user"></span>  Username: </label><input <?php if(isset($_POST['uname'])){ echo 'value ="' . $_POST['uname'] . '"'; }else{ echo 'autofocus ';}?>placeholder = "Enter Username" id = "uname" title = "Input your username." type = "text" class = "form-control" required name = "uname"/></td>
				
					<td><label for = "pword"><span class="icon-eye"></span>  Password: </label><input <?php if(isset($_POST['uname'])){ echo 'autofocus '; }?> placeholder = "Enter Password" id = "pword" title = "Input your password." type = "password" class = "form-control" required name = "password"/></td>
				</tr>
				<tr >
					<td colspan = 4 align = "center" ><button style = "width: 150px; margin: auto;" type="submit" name = "submit" class="btn btn-success btn-block"><span class="icon-switch"></span> Login</button></td>
				</tr>
			</table>
		</form>
<?php
	if(isset($_SESSION['logout']) && $_SESSION['logout'] != null){
		echo  '<div class="alert alert-warning" align = "center">						
			<strong>You\'ve been logged out.</strong>
			</div>';
		$_SESSION['logout'] = null;
	}
?>
<?php
	if(isset($_POST['submit'])){
		mysqli_select_db($conn, 'csr');
		$uname = mysqli_real_escape_string($conn, $_POST['uname']);
		$password =  mysqli_real_escape_string($conn, $_POST['password']);
		
		$sql = "SELECT * FROM `customer_login` where user_id = '$uname' and user_pass = '$password'";
		$result = $conn->query($sql);		
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){								
				$_SESSION['customer_id'] = $row['customer_id'];
				$_SESSION['cname'] = $row['cname'];
				$stmt = "UPDATE `customer_login` set login_count = login_count + 1 where customer_id = $_SESSION[customer_id]";
				if ($conn->query($stmt) === TRUE) {					
			  	}else {
			    	echo "Error updating record: " . $conn->error;
			  	}
			  	echo  '<div class="alert alert-success" align = "center">						
						<strong>Logging in ~!</strong>
						</div>';
			  	echo '<script type="text/javascript">setTimeout(function() {window.location.href = "/csr"},1000);; </script>';	
			}				
		}else{
	echo  '<div class="alert alert-warning" align = "center">						
				<strong>Warning!</strong> Incorrect Login.
			</div>';
			
			}
		$conn->close();
	}
	
	
}
include('footer.php');
?>