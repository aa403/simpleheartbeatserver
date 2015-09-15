
<?php
	$dbopts = parse_url(getenv('DATABASE_URL'));
	$connstr = 'host='.$dbopts["host"].' dbname='.ltrim($dbopts["path"],'/').' user='.$dbopts["user"].' password='.$dbopts["pass"];

	
	if ($_POST){
		
		if (empty($_POST["source"])){
			$proceed = false;
		}
		else {
			$source = $_POST["source"];
			$proceed = true;
		}

		if (empty($_POST["message"])){
			$message = '';
		}
		else {
			$message = $_POST["message"];
		}


		if ($proceed == true){
		
				$dbconn = pg_connect($connstr)
						or die('Could not connect: ' . pg_last_error());
		
				$result = pg_query_params($dbconn, 'INSERT INTO beats (source, message) VALUES($1, $2)', array($source, $message));
		
				//dump the result object
				if ($result == false) {
					echo false;
				}
		
				else{
					echo true;
				}
		
				// Closing connection
				pg_close($dbconn);
			}
		else {
			echo 'source must be provided';
		}
	}
	else {
		$ctxt = '';
		
		if (!empty($_GET["source"])){
			$source = $_GET["source"];
		}

		if (empty($_GET["since"])){
			$since = 3600;
		}
		else {
			$since = $_GET["since"];

			if (!is_numeric($since)) {
				$since = 3600;
				$ctxt = 'non numeric value provided for \'since\' - defaulting to 3600';

    		} 
		}

		$dbconn = pg_connect($connstr)
						or die('Could not connect: ' . pg_last_error());
		
		if (empty($_GET["source"])){
			$result = pg_query_params($dbconn, 'select *, extract(epoch from (current_timestamp - created_date)) as since 
				from beats WHERE extract(epoch from (current_timestamp - created_date)) < $1 order by created_date desc', array($since));
		}
		else{
			$result = pg_query_params($dbconn, 'select *, extract(epoch from (current_timestamp - created_date)) as since 
				from beats WHERE extract(epoch from (current_timestamp - created_date)) < $1 and source = $2 order by created_date desc', array($since, $source));
		}

		if (!$result) {
    	
    		echo "An error occurred.\n";
    		exit;
		} 
		else{

			$arr = pg_fetch_all($result);
			if ($arr == false || empty($arr)) {
				$arr = 'No results found';
			}
			
			if (empty($ctxt)){
				echo json_encode($arr);
			}
			else{
				echo json_encode(array($ctxt,$arr));	
			}
		}

	}
?>