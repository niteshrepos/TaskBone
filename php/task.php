<?php require_once("functions.php") ?>
<?php include("connection.php") ?>

<?php 
	
	switch (request_type()) {
		case 'GET':
			$id = $_GET["id"];
			echo get_record_json_by_id($id);
			break;
		
		case 'PUT':
			$json_str = file_get_contents('php://input');
			update_record($json_str);
			break; 

		case 'DELETE':
			$id = $_GET["id"];
			delete_record_by_id($id);
			break; 

		case 'POST':	
			$json_str = file_get_contents('php://input');
			add_record($json_str);
			break; 			
				
		default:
			echo "unknown request";
			break;
	}

 ?>