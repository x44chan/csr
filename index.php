<?php
	session_start();
	$title="Login Page";
	include('header.php');
	if(isset($_SESSION['customer_id'])){
		echo '<script type = "text/javascript"> window.location.replace("customer.php");</script>';
	}
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
					<td><label for = "uname"><span class="icon-user"></span>  Username: </label><input <?php if(isset($_POST['user_id'])){ echo 'value ="' . $_POST['user_id'] . '"'; }else{ echo 'autofocus ';}?>placeholder = "Enter Username" id = "uname" title = "Input your username." type = "text" class = "form-control" required name = "uname"/></td>
				
					<td><label for = "pword"><span class="icon-eye"></span>  Password: </label><input <?php if(isset($_POST['user_id'])){ echo 'autofocus '; }?> placeholder = "Enter Password" id = "pword" title = "Input your password." type = "password" class = "form-control" required name = "password"/></td>
				</tr>
				<tr >
					<td colspan = 4 align = "center" ><button style = "width: 150px; margin: auto;" type="submit" name = "submit" class="btn btn-success btn-block"><span class="icon-switch"></span> Login</button></td>
				</tr>
			</table>
		</form>

<?php
	if(isset($_POST['submit'])){
		include('modules/conf.php');
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
			  	echo '<script type="text/javascript">setTimeout(function() {window.location.href = "customer.php"},1000);; </script>';	
			}				
		}else{
	echo  '<div class="alert alert-warning" align = "center">						
				<strong>Warning!</strong> Incorrect Login.
			</div>';
			
			}
		$conn->close();
	}
	
	include('footer.php');
?>