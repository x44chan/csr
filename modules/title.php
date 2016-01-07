<?php
$page = array("pcreport" => "PC Service Reports",
			 "daterange" => "Customer Service Report");

foreach($page as $x => $tag) {
    if(isset($_GET['module']) && $_GET['module'] == $x){
    	$title = $tag;
    }elseif(isset($_SESSION['customer_id'])){
		$title="Customer Page";
	}elseif(!isset($_SESSION['customer_id'])){
		$title="Login Page";
	}
}
?>