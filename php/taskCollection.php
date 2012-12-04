<?php require_once("functions.php") ?>
<?php include("connection.php") ?>

<?php 
	if(request_type() === "GET"){
	echo get_all_records();
	}

 ?>