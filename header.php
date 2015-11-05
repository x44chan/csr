<?php date_default_timezone_set("Asia/Manila"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title> C.S.R. <?php if(isset($title)){echo ' - ' . $title; }?> </title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/css.css">
		
		<!-- jQuery library -->
		<script src="js/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/js.js"></script>
		
		<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/> 
		<script type="text/javascript" src="js/datatables.min.js"></script>		
   		<script type="text/javascript">
			//var thetime = <?echo date("H:i:s"); ?>;
			// this would be something like:
			var thetime = '<?=date('h:i:s');?>';
			var arr_time = thetime.split(':');
			var ss = arr_time[2];
			var mm = arr_time[1];
			var hh = arr_time[0];

			var update_ss = setInterval(updatetime, 1000);

			function updatetime() {
			    ss++;
			    if (ss < 10) {
			        ss = '0' + ss;
			    }
			    if (ss == 60) {
			        ss = '00';
			        mm++;
			        if (mm < 10) {
			            mm = '0' + mm;
			        }
			        if (mm == 60) {
			            mm = '00';
			            hh++;
			            if (hh < 10) {
			                hh = '0' + hh;
			            }
			            if (hh == 24) {
			                hh = '00';
			            }
			            $("#hours").html(hh);
			        }
			        $("#minutes").html(mm);
			    }
			    $("#seconds").html(ss);
			}
		</script>
	</head>
	<body>
