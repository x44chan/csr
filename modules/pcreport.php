<?php 
	if(!isset($_GET['pcreport'])){		
		mysqli_select_db($conn, 'csr');
		if(isset($_POST['pcsearch'])){
			$pcname = mysql_escape_string($_POST['pcname']);
			$sql = "SELECT * FROM `csr`.`csrpc`,`csr`.`customer_login`  where `csr`.`csrpc`.`company_name` = '$cname' and `csr`.`csrpc`.`company_name` = `csr`.`customer_login`.`cname` and `csr`.`csrpc`.`csrpcname` = '$pcname'";
		}else{
			$sql = "SELECT * FROM `csr`.`csrpc`,`csr`.`customer_login`  where `csr`.`csrpc`.`company_name` = '$cname' and `csr`.`csrpc`.`company_name` = `csr`.`customer_login`.`cname`";
		}
		if(!empty($_POST['datefr']) && !empty($_POST['dateto'])){
			$notifs = '<i><b>From: </b>'. date("M j, Y", strtotime($_POST['datefr'])) . '<b> To: </b>' . date("M j, Y", strtotime($_POST['dateto'])) .'</i>';
			$strt = $_POST['datefr'];
			$end = $_POST['dateto'];
			$nme = $_POST['pcname'];
		}else{
			$notifs = "";
			$strt = "";
			$end = "";
			$nme = "";
		}
		$_SESSION['strt'] = null;
		echo '<div style = "min-height: 400px; text-align: center;" >
			<div class = "container" style = "margin-top: -40px;">
				<div class = "row" style="margin-bottom: 10px;">
					<div class="col-xs-12">
						<div align = "left">
							<i><h3 style = "text-decoration: underline;"><span class = "icon-display"></span> PC Service Report</h3></i>
							'.$notifs.'
						</div>
					</div>
				</div>
			</div>	
			<div class = "row" style="margin-bottom: 10px; margin-top: -20px;">
				<div class="col-xs-12" align = "center">
					<div>
						<i><h4>Search</h4></i>
					</div>
				</div>
			</div>
			<form class="form-inline" action = "" role = "form" method = "post">
				<div class = "row ">
					<div class="col-xs-12"align = "center">
						<label for = "datestrt">PC Name: <font color = "red"> * </font></label>
						<input required type = "text" style = "width: 300px;" name  = "pcname" value = "'.$nme.'" class = "form-control" placeholder ="Enter PC Name to Search"/>									
					</div>
				</div>
				<div class = "row">
					<div class = "col-xs-12 col-sm-12 col-md-12">
						<br>
						<label for = "datestrt">Date From:</label>
						<input type = "date" class = "form-control" name = "datefr" value = "'.$strt.'"/>					
						<label style = "margin-left: 10px;"for = "datestrt">Date To:</label>
						<input type = "date" class = "form-control" name = "dateto" value = "'.$end.'"/>	
					</div>
				</div>
				<div class = "row">
					<div class = "col-xs-12">
						<br>
						<button style = "margin-left: 10px;"class = "btn btn-primary" name = "pcsearch"><span class="icon-search"></span> Search</button>
						<a href = "?module=pcreport" class = "btn btn-danger" name = "daterange"><span class="icon-spinner11"></span> Clear</a>
					</div>
				</div>
			</form>
			<div class ="row">
				<div class = "col-xs-12">
					<hr>
				</div>
			</div>			
			<div class="row">
				<div class="col-xs-12" align="right">
					<i><h4><span class="label label-success"><span class = "icon-display"></span> Total PC Service Rendered: <span class="badge" style ="background-color: white; color: black;" id ="total">0</span></span></h4></i>
				</div>	
			</div>
			<div class="table-responsive" id = "csr123 myTable">
				<table class = "table table-hover" id = "myTable">
					<thead>
						<th>PC Name</th>
						<th>User</th>
						<th>Service Rendered</th>
						<th>Action</th>
					</thead>
					<tbody>';
			$result = $conn->query($sql);
			if($result->num_rows > 0){
				$totalcount = 0;
				while($row = $result->fetch_assoc()){	
					$pcid = $row['csrpc_id'];			
					$try = 'csrpc_id';
					if(!empty($_POST['datefr']) && !empty($_POST['dateto']) && isset($_POST['pcname'])){
						$strt = $_POST['datefr'];
						$end = $_POST['dateto'];
						$_SESSION['strt'] = $strt;
						$_SESSION['end'] = $end;
						$sql2 = "SELECT count(`csr`.`csrpc_service`.`$try`) as xcount FROM  `csr`.`csrpc_service` where `csr`.`csrpc_service`.`csrpc_id` = '$pcid' and servdate BETWEEN '$strt' and '$end'";	
					}else{
						$sql2 = "SELECT count(`csr`.`csrpc_service`.`$try`) as xcount FROM  `csr`.`csrpc_service` where `csr`.`csrpc_service`.`csrpc_id` = '$pcid'";
					}
					$result1 = $conn->query($sql2);
					$res123 = $result1->fetch_assoc();
					$xcount = $res123['xcount'];				
					echo '<tr>';
					echo '<td>' . $row['csrpcname'] .'</td>';
					echo '<td>' . $row['csrpcuser'] .'</td>';
					echo '<td>' . $xcount . '</td>';
					echo '<td><a style = "width: 100px;" target = "_blank" href = "?module='.$_GET['module'].'&pcreport='.$row['csrpc_id'] .'" class = "btn btn-primary"><span class = "icon-eye"></span> View</a></td>';
					echo '</tr>';	
					$totalcount += $xcount;		
				}
			echo '<script type = "text/javascript">$(document).ready(function(){ $("#total").text("'.$totalcount.'");});</script>';			
		}else{
			
		}
		echo '</tbody></table></div>';
}
?>
<?php
	if(isset($_GET['pcreport'])){
		mysqli_select_db($conn, 'csr');
		$pcid = mysql_escape_string($_GET['pcreport']);
		if(!empty($_SESSION['strt']) && !empty($_SESSION['end'])){
			$strt = $_SESSION['strt'];
			$end = $_SESSION['end'];
			$notifs = 'From: <b>' . date('M j, Y', strtotime($strt)) . '</b> To: <b>' . date('M j, Y', strtotime($end)) . '</b>';
			$sql = "SELECT * FROM `csr`.`csrpc`,`csr`.`csrpc_service`  where `csr`.`csrpc_service`.`csrpc_id` = '$pcid' and `csr`.`csrpc`.`csrpc_id` = '$pcid' and servdate BETWEEN '$strt' and '$end'";		
			$sql2 = "SELECT count(`csr`.`csrpc_service`.`csrpc_id`) as xcount FROM  `csr`.`csrpc_service` where `csr`.`csrpc_service`.`csrpc_id` = '$pcid' and servdate BETWEEN '$strt' and '$end'";	
		}else{
			$notifs = "";
			$sql = "SELECT * FROM `csr`.`csrpc`,`csr`.`csrpc_service`  where `csr`.`csrpc_service`.`csrpc_id` = '$pcid' and `csr`.`csrpc`.`csrpc_id` = '$pcid'";		
			$sql2 = "SELECT count(`csr`.`csrpc_service`.`csrpc_id`) as xcount FROM  `csr`.`csrpc_service` where `csr`.`csrpc_service`.`csrpc_id` = '$pcid'";	
		}
		$result2 = $conn->query($sql);
		$res123 = $result2->fetch_assoc();
		$rpcname = $res123['csrpcname'];
		$rpcuser = $res123['csrpcuser']; 
		$result1 = $conn->query($sql2);
		$res123 = $result1->fetch_assoc();
		$xcount = $res123['xcount'];	
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			echo '<div class = "container" style="padding: 5px 10px; margin-top: -50px; text-align: center;">
					<div class = "row">
						<div class="col-xs-12">
			    			<div align = "center"class="page-header">
								<h2 style = "text-decoration: underline;"><span class = "icon-display"></span> PC Service Report</h2>
								'.$notifs.'
							</div>
			    		</div>
					</div>';
			echo '<div class = "row" align ="left">
					<div class="col-xs-4">
						<label for = "pcname">PC NAME: </label>	
					</div>
					<div class="col-xs-7">
						<u><i>'.$rpcname.'</i></u>
					</div>
				</div>	
				<div class = "row" align = "left">
					<div class="col-xs-4">
						<label for = "pcname">USER: </label>
					</div>
					<div class="col-xs-7">
						<u><i>'.$rpcuser.'</i></u>
					</div>
				</div>
				<div class = "row" align = "left">
					<div class="col-xs-4">
						<label for = "pcname">TOTAL SERVICE RENDERED: </label>
					</div>
					<div class="col-xs-7">
						<u><i>'.$xcount.'</i></u>
					</div>
				</div>
				<div class = "row"><div class = "col-xs-12"><hr></div>';
			echo '<div class="row" style="margin-top: 20px;">
					<div class="col-xs-4">
						<label>Date</label>
					</div>
					<div class="col-xs-4">
						<label>Reported Problem/s</label>
					</div>
					<div class="col-xs-4">
						<label>Action Taken</label>
					</div>					
				</div>';
			while($row = $result->fetch_assoc()){
?>
	<div class="row" style="margin-top: 20px;">
		<div class="col-xs-4">
			<i><?php echo date("M j, Y", strtotime($row['servdate'])); ?></i>
		</div>
		<div class="col-xs-4">
			<i><?php echo $row['csrpcprob'] ?></i>
		</div>
		<div class="col-xs-4">
			<i><?php echo $row['csrpcact'] ?></i>
		</div>
	</div>
<?php    
		}
		echo '<div class = "row"><div class = "col-xs-12"><hr></div></div>';
	}else{
		echo '<div align = "center"><h3>No Record Found</h3></div>';
	}
	echo '<div class="row" style="margin-top: 10px;">
			<div class="col-xs-12" align = "center">
				<a href = "javascript:window.open(\'\',\'_parent\',\'\');window.close();" class="btn btn-danger"><span class = "icon-arrow-left"></span> Back </a>
			</div>
		</div>
	</div>';
}
?>