<?php
	require __DIR__.'/../../../config.zirsfil.php';
    $uniqId = uniqid();
	if (isset($_GET['fn'])) {
		if (isset($_POST['pass_file'])) {
			$fileName = base64_decode($_GET['fn']);
			$pass_file = $_POST['pass_file'];
			$result = $conn->query("select * from tbfiles where file_name = '$fileName' and password = '$pass_file'");
			$row = mysqli_fetch_array($result);
			if ($row) {
				$file = 'files/' . $fileName;
				$file_name = base64_encode(basename($file));
				if (file_exists($file)) {
				    $conn->query("insert into tbaccessfile (token, file_name) values ('$uniqId','$file_name')");
?>
					<div class="text-center mb-3">
						<a href="?page=dw-fil-pw&fn=<?= base64_encode($row['file_name']) ?>&idf=<?= $uniqId ?>" download="<?= explode('#', $row['file_name'])[1]; ?>" onclick="javascript:location.reload(true)" class="btn btn-outline-success w-50">Download</a>
					</div>
<?php
			    } else {
			    	echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
			    }
			} else {
?>
				<div class="text-center mb-3"><h1>Password wrong</h1></div>
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="mb-3">
					<div class="input-group mb-3">
						<span class="input-group-text">Password File</span>
			            <input type="password" name="pass_file" class="form-control" placeholder="This file is password protected" required>
			            <button type="submit" class="btn btn-outline-success">Download</button>
			        </div>
			    </form>

<?php
			}
		} else {
			$fileName = base64_decode($_GET['fn']);
			$result = $conn->query("select * from tbfiles where file_name = '$fileName'");
			$row = mysqli_fetch_array($result);
			if ($row) {
				if ($row['password'] == "" || $row['password'] == null || $_GET['uniqid'] == $uniqId) {
					$file = 'files/' . $fileName;
					$file_name = explode('#', basename($file))[1];
					$type = mime_content_type($file);
					if (file_exists($file)) {
    				    readfile($file);
    				    exit();
				    } else {
				    	echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
				    }
				} else {
?>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="mb-3">
		<div class="input-group mb-3">
			<span class="input-group-text">Password File</span>
            <input type="password" name="pass_file" class="form-control" placeholder="This file is password protected" required>
            <button type="submit" class="btn btn-outline-success">Download</button>
        </div>
    </form>
<?php
				}
			} else {
				echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
			}
		}
	} else {
		echo '<div class="text-center"><h1>Sorry, we could not find requested download file</h1></div>';
	}
?>

<script type="text/javascript">
	document.getElementById('judul').innerHTML += ' || <button type="button" onclick="backToLSFIL()" class="btn btn-outline-secondary btn-sm">Back</button>';

	function backToLSFIL() {
		window.location = "?page=ls-fil";
	}
</script>