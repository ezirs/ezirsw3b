<?php
	require __DIR__.'/../../../config.zirsfil.php';

	if (isset($_GET['fn']) && isset($_GET['idf'])) {
		$fileName = $_GET['fn'];
		$token = $_GET['idf'];
		$result = $conn->query("select * from tbaccessfile where token = '$token' and file_name = '$fileName'");
		$row = mysqli_fetch_array($result);
		if ($row) {
			$conn->query("delete from tbaccessfile where token = '$token'");
			$file = 'files/' . base64_decode($row['file_name']);
			$file_name = explode('#', basename($file))[1];
			$type = mime_content_type($file);
			if (file_exists($file)) {
		        header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=$file_name");
			    header("Content-Type: $type");
			    header("Content-Transfer-Encoding: binary");
			    readfile($file);
		        exit();
		    } else {
		    	echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
		    }
		}
	} else {
    	echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
    }
?>