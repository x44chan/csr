<?php 
	if(!isset($_GET['view'])){		
		mysqli_select_db($conn, 'csr');
		if(isset($_POST['datefr']) && isset($_POST['dateto'])){
			$strt = mysql_escape_string($_POST['datefr']);
			$end = mysql_escape_string($_POST['dateto']);
			$sql = "SELECT * FROM `csr`.`csr`,`new`.`login`  where `csr`.`csr`.`csrname` = '$cname' and `csr`.`csr`.`account_id` = `new`.`login`.`account_id` and `csr`.`csr`.`csrdate` BETWEEN '$strt' and '$end' order by csrdate desc";
			$sql2 = "SELECT count(`csr`.`csr`.`csrname`) as xcount FROM `csr`.`csr`,`new`.`login`  where `csr`.`csr`.`csrname` = '$cname' and `csr`.`csr`.`account_id` = `new`.`login`.`account_id` and `csr`.`csr`.`csrdate` BETWEEN '$strt' and '$end' order by csrdate desc";
		}else{
			$sql = "SELECT * FROM `csr`.`csr`,`new`.`login`  where `csr`.`csr`.`csrname` = '$cname' and `csr`.`csr`.`account_id` = `new`.`login`.`account_id` order by csrdate desc";
			$sql2 = "SELECT count(`csr`.`csr`.`csrname`) as xcount FROM `csr`.`csr`,`new`.`login`  where `csr`.`csr`.`csrname` = '$cname' and `csr`.`csr`.`account_id` = `new`.`login`.`account_id` order by csrdate desc";
		}
		$result1 = $conn->query($sql2);
		$res123 = $result1->fetch_assoc();
		$xcount = $res123['xcount'];
		$result = $conn->query($sql);
		if(isset($strt) && isset($end)){
				$notifs = '<i><b>From: </b>'. date("M j, Y", strtotime($strt)) . '<b> To: </b>' . date("M j, Y", strtotime($end)) .'</i>';				
			}else{
				$notifs = "";
				$strt = "";
				$end = "";
			}
		echo '<div class = "container" style = "margin-top: -40px;">
				<div class = "row" style="margin-bottom: 10px;">
					<div class="col-xs-12">
				    	<div align = "left">
							<i><h3 style = "text-decoration: underline;"><span class = "icon-file-text2"></span> Customer\'s Service Report</h3></i>
							'.$notifs.'
						</div>
				    </div>
				</div>
			</div>	
			<div class = "row" style="margin-bottom: 10px;">
				<div class="col-xs-12" align = "center">
			    	<div>
						<i><h4>Search by Date Range</h4></i>
					</div>
			    </div>
			</div>
			<form class="form-inline" action = "" role = "form" method = "post">
				<div class = "row">
					<div class="col-xs-12"align = "center">
						<label for = "datestrt">Date From:</label>
						<input required type = "date" class = "form-control" name = "datefr" value = "'.$strt.'"/>					
						<label style = "margin-left: 10px;"for = "datestrt">Date To:</label>
						<input required type = "date" class = "form-control" name = "dateto" value = "'.$end.'"/>					
						<button style = "margin-left: 10px;"class = "btn btn-primary" name = "daterange"><span class="icon-search"></span> Search</button>
						<a href = "customer.php" class = "btn btn-danger" name = "daterange"><span class="icon-spinner11"></span> Clear</a>
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
					<i><h4><span class="label label-success"><span class = "icon-file-text2"></span> Total Reports: <span class="badge" style ="background-color: white; color: black;">'.$xcount.'</span></span></h4></i>
				</div>	
			</div>
			<div class="table-responsive" id = "csr123">
				<table class = "table table-hover" id = "myTable2">
					<thead>
						<th>Date</th>
						<th>Technician</th>
						<th>Time In - Time Out</th>
						<th>Action</th>
					</thead>
					<tbody>';
		if($result->num_rows > 0){		
			while($row = $result->fetch_assoc()){
				echo '<tr>';
					echo '<td>' . date("M j, Y", strtotime($row['csrdate'])) . '</td>';
					echo '<td>' . $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'].'</td>';
					echo '<td>' . $row['csrtimein'] . ' - ' . $row['csrtimeout'] . '</td>';
					echo '<td><a style = "width: 100px;" target = "_blank" href = "?view='.$row['csr_id'] .'" class = "btn btn-primary"><span class = "icon-eye"></span> View</a></td>';
				echo '</tr>';
			}
		
		}
		echo '</tbody></table>';
	}
?>
<?php
	if(isset($_GET['view'])){
		mysqli_select_db($conn, 'csr');
		$csrid = mysql_escape_string($_GET['view']);
		$sql = "SELECT * FROM `csr`.`csr`,`new`.`login` where `csr`.`csr`.`csr_id` = $csrid and `csr`.`csr`.`account_id` = `new`.`login`.`account_id`";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
?>
<div class = "container" style="padding: 5px 10px; text-align: left;">
	<form role="form" action = "" method = "post">
		<div class = "row" style="margin-top: -50px;">
			<div class="col-xs-12">
		    	<div align = "center"class="page-header">
					<h2>Customer's Service Report</h2>
					
				</div>
		    </div>
		</div>
	    <div class="clear"></div>
		<div class = "row">
			<div class="col-xs-7 col-sm-7 col-md-7" >
	        	<label for="usrname"> Customer Name </label>
	        	<i><p style="margin-left: 25px;"><?php echo $row['csrname'];?></p></i>
	        </div>
	        <div class="col-xs-5 col-sm-5 col-md-5">
	        	<label for="usrname"> Tel #: </label>
	        	<i><p style="margin-left: 25px;"><?php echo $row['csrtel'];?></p></i>
	        </div>
	    </div>
	    <div class = "row">
	        <div class="col-xs-7 col-sm-7 col-md-7">
	        	<label for="usrname"> Address: </label>
	        	<i><p style="margin-left: 25px;"><?php echo $row['csradd'];?></p></i>
	        </div>
	        <div class="col-xs-5 col-sm-5 col-md-5">
	        	<label for="usrname"> Date: </label>
	        	<i><p style="margin-left: 25px;"><?php echo date('M j, Y', strtotime($row['csrdate']));?></i></p>
	        </div>
		</div>
		<div class = "row">
			<div class="col-xs-7">
				<label for="usrname"> Type </label>
				<i><p style="margin-left: 25px;"><?php echo $row['csrchck'];?></i></p>
			</div>
		</div>
		<div class = "row">
	        <div class="col-xs-3 col-sm-3 col-md-3 col-xs-offset-3">
	        	<label for="usrname"> Time Started </label>
	        	<i><p><?php echo $row['csrtimein'];?></i></p>
	        </div>
	        <div class="col-xs-3 col-sm-3 col-md-3">
	        	<label for="usrname"> Time Finished </label>
	        	<i><p><?php echo $row['csrtimeout'];?></i></p>
	        </div>
		</div>
		<div class="row">
			<div class="col-xs-12">
		    	<div class="page-header">
					<p style="font-size: 20px">Maintenance Report</p>
				</div>
		    </div>
		</div>
		<div id = "netcon" <?php if($row['csrintprob'] == "" && $row['csrrouterprob'] == "" && $row['csrfirewallprob'] == "" && $row['csrswitchprob'] == "" && $row['csraccprob'] == ""){echo 'style = "display: none;"';}else{echo 'style = "text-align: center;"';}?>>
			<div class="row"  style = "  font-weight: bold;margin-bottom: 10px;">
				<div class="col-xs-4 col-sm-4 col-md-4">
					NETWORK CONNECTIONS
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					REPORTED PROBLEM
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					ACTION TAKEN
				</div>
			</div>
			<div class="row" <?php if($row['csrintprob'] == null || $row['csrintprob'] == ""){ echo 'style = "display: none;"';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>INTERNET </p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrintprob'];?></i></p>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrintact'];?></i></p>
				</div>
			</div>
			<div class="row" <?php if($row['csrrouterprob'] == null || $row['csrrouterprob'] == ""){echo 'style ="display:none"';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>ROUTER</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrrouterprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrrouteract'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csrfirewallprob'] == null || $row['csrfirewallprob'] == ""){echo 'style ="display:none"';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>FIREWALL</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrfirewallprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrfirewallact'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csrswitchprob'] == "" || $row['csrswitchprob'] == null){echo 'style="display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>SWITCHES</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrswitchprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrswitchact'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csraccprob'] == "" || $row['csraccprob'] == null){echo 'style="display: none" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>ACCESS POINT</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csraccprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csraccact'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
		<div id = "servers" <?php if($row['csractvedrctoryprob'] == "" && $row['csrfilesrvrprob'] == "" && $row['csrmailprob'] == "" && $row['csrappprob'] == "" && $row['csrotherprob'] == ""){echo 'style = "display: none;"';}else{echo 'style = "text-align: center;"';}?>>
			<div class="row" style = "  font-weight: bold; margin-bottom: 10px;">
				<div class="col-xs-4 col-sm-4 col-md-4">
					SERVERS
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					REPORTED PROBLEM
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					ACTION TAKEN
				</div>
			</div>
			<div class="row" <?php if($row['csractvedrctoryprob'] == "" || $row['csractvedrctoryprob'] == null){echo 'style ="display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>ACTIVE DIRECTORY</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csractvedrctoryprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csractvedrctoryact'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csrfilesrvrprob'] == "" || $row['csrfilesrvrprob'] == null){echo 'style = "display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>FILE SERVER</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrfilesrvrprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrfilesrvract'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csrmailprob'] == "" || $row['csrmailprob'] == null){echo 'style="display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>MAIL SERVER</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrmailprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrmailact'];?></p></i>
				</div>
			</div>
			<div class="row"  <?php if($row['csrappprob'] == "" || $row['csrappprob'] == null){echo 'style = "display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>APPLICATION SERVER</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrappprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrappact'];?></p></i>
				</div>
			</div>
			<div class="row" <?php if($row['csrotherprob'] == "" || $row['csrotherprob'] == null){echo 'style = "display: none;" ';}?>>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<div style = "margin-left: 20px;"class="checkbox">
						<i><p>OTHER SERVER</p></i>
					</div>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrotherprob'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrotheract'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
		<div id = "pclaptop" <?php if($row['csrpcname1'] == "" && $row['csrpcname2'] == "" && $row['csrpcname3'] == "" && $row['csrpcname4'] == "" && $row['csrpcname5'] == "" && $row['csrpcname6'] == ""&& $row['csrpcname7'] == ""&& $row['csrpcname8'] == "" && $row['csrpcname9'] == "" && $row['csrpcname10'] == ""){echo 'style = "display: none;"';}else{echo 'style = "text-align: center;"';}?>>
			<!--<div class="row">
				<div class="col-xs-4 form-inline">
					<div style="font-size: 15px;  ">
						Numbers Of PC <input name = "csrother" id = "numberofpc" class = "form-control" type="number" placeholder="Number of PC">
					</div>
				</div>
			</div>-->
			<div class="row" style = "  font-weight: bold;">
				<div class="col-xs-4 col-sm-4 col-md-4">
					DESKTOP / LAPTOP<br>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					REPORTED PROBLEM
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					ACTION TAKEN
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px; font-weight: bold;">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;">
						<i>PC NAME</i>
					</div>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;">
						<i>USER</i>
					</div>
				</div>
				
			</div>
		<?php 
			for($i = 1; $i <= 10; $i++){
				$csrpcname = $row['csrpcname'.$i];
				if($csrpcname != "" || $csrpcname != null){	
		?>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrpcname'.$i];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrpcuser'.$i];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrpcprob'.$i];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrpcact'.$i];?></p></i>
				</div>
			</div>
		<?php } } ?>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
		<div id = "prinfax" <?php if($row['csrprntbrand1'] == "" && $row['csrprntbrand2'] == "" && $row['csrprntbrand3'] == ""){echo 'style = "display: none;"';}else{echo 'style = "text-align: center;"';}?>>
			<div class="row" style = "  font-weight: bold;">
				<div class="col-xs-4 col-sm-4 col-md-4">
					PRINTERS / FAX<br>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					REPORTED PROBLEM
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					ACTION TAKEN
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;  font-weight: bold;">
						<i>BRAND</i>
					</div>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;  font-weight: bold;">
						<i>MODEL</i>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntbrand1'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntmodel1'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntprob1'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntact1'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntbrand2'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntmodel2'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntprob2'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntact2'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntbrand3'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrprntmodel3'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntprob3'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrprntact3'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
		<?php if($row['csrtellocal1'] != "" || $row['csrtellocal2'] != "" || $row['csrtellocal3'] != ""){?>
		<div id = "telphone" style = "text-align: center;">
			<div class="row" style = "  font-weight: bold;">
				<div class="col-xs-4 col-sm-4 col-md-4">
					TELEPHONE / PABX<br>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					REPORTED PROBLEM
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					ACTION TAKEN
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;  font-weight: bold;">
						<i>LOCAL #</i>
					</div>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<div style="font-size: 15px;  font-weight: bold;">
						<i>USER</i>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtellocal1'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtelusr1'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelprob1'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelact1'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtellocal2'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtelusr2'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelprob2'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelact2'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtellocal3'];?></p></i>
				</div>
				<div class="col-xs-2 col-sm-2 col-md-2">
					<i><p><?php echo $row['csrtelusr3'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelprob3'];?></p></i>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4">
					<i><p><?php echo $row['csrtelact3'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if($row['csrrmrks1'] != "" || $row['csrrmrks2'] != "" || $row['csrrmrks3'] != "" || $row['csrrmrks4'] != "" || $row['csrrmrks5'] != ""){?>
		<div id = "remarks" style = "text-align: center;">
			<div class="row" style = "font-weight: bold;">
				<div class="col-xs-12">
					
					REMARKS
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2" style="text-align:right;">
					<b>1.</b>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<i><p style="text-align: left;"><?php echo $row['csrrmrks1'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2" style="text-align:right;">
					<b>2.</b>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<i><p style="text-align: left;"><?php echo $row['csrrmrks2'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2" style="text-align:right;">
					<b>3.</b>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<i><p style="text-align: left;"><?php echo $row['csrrmrks3'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2" style="text-align:right;">
					<b>4.</b>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<i><p style="text-align: left;"><?php echo $row['csrrmrks4'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-2 col-sm-2 col-md-2" style="text-align:right;">
					<b>5.</b>
				</div>
				<div class="col-xs-10 col-sm-10 col-md-10">
					<i><p style="text-align: left;"><?php echo $row['csrrmrks5'];?></p></i>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<hr>
				</div>
			</div>
		</div>
		<?php }?>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6" style="font-size: 17px;">
					<i>Prepared By: <b><u><?php echo $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'];?></u></b></i>
				</div>
				<!--<div class="col-xs-2" style="text-align: right;">
					<label for="csrconforme">Conforme:</label>			
				</div>
				<div class="col-xs-4">
					<input name = "csrconforme" id = "csrconforme" type = "text" class="form-control"/>
				</div>-->
			</div>
			
	</form>

</div>
<div class="row">
	<div class="col-xs-12" align="center">
	<!--<button type = "submit" class="btn btn-success col-xs-4" name = "upcsrsubmits"><span class="glyphicon glyphicon-off"></span> Update </button>-->
		<a style="margin-left: 10px;" href = "javascript:window.open('','_parent','');window.close();" class="btn btn-danger"><span class="icon-arrow-left"></span> Back</a>
		<input type = "hidden" value = "<?php echo $row['csr_id'];?>" name = "csr_id"/>
	</div>
</div>
	<script type="text/javascript">
	$('#checkbox').on('change', function() {
		$('#checkbox1').not(this).prop('checked', false);
	});
	$('#checkbox1').on('change', function() {
		$('#checkbox').not(this).prop('checked', false);
	});
	$(document).ready(function(){
		/*$('input[name="csrtimein"]').ptTimeSelect();
		$('input[name="csrtimeout"]').ptTimeSelect();
		$('#numberofpc').on('change', function() {
			var q = $('#numberofpc').val();
			var pc = ['#pc1','#pc2','#pc3','#pc4','#pc5','#pc6','#pc7','#pc8','#pc9','#pc10'];
			for(i = 0; i < 10; i++){			
				$(pc[i]).hide();
			}
			var pc = ['#pc1','#pc2','#pc3','#pc4','#pc5','#pc6','#pc7','#pc8','#pc9','#pc10'];
			for(i = 0; i < q; i++){			
				$(pc[i]).show();
			}
		});*/
	});
	</script>
<?php
			}
		}
	}
?>