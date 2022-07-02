<?php
	require __DIR__.'/../../../config.zirsfil.php';
    $result = $conn->query("select * from tbfiles order by tanggal_pembuatan desc");
    $num = mysqli_num_rows($result);

    function convert($size) {
	 	if($size >= 1000000000) {
	 		return $fileSize = round($size / 1000 / 1000 / 1000,2) . ' GB';
	 	} elseif ($size >= 1000000) {
	  		return $fileSize = round($size / 1000 / 1000,2) . ' MB';
 		} elseif ($size >= 1000) {
	  		return $fileSize = round($size / 1000,2) . ' KB';
	 	} else {
	 		return $fileSize = $size . ' Bytes';
	 	}
	}
?>
<main>
	<div class="list-group">
		<?php
			if ($num) {
		    	for ($i = 1; $i <= $num; $i++) {
				$row = mysqli_fetch_array($result);
				$nm_fil = explode('#', $row['nama_file'])[1];
				$dw = 'download="'. $nm_fil . '"';

		?>
	  	<a href="?page=dw-fil&fn=<?= base64_encode($row['nama_file']) ?>" <?php if ($row['password'] == "" || $row['password'] == null) { echo $dw; } ?> class="list-group-item list-group-item-action" aria-current="true">
	    	<div class="d-flex w-100 justify-content-between">
	      		<h5 class="mb-1"><?= explode('#', $row['nama_file'])[1] ?></h5>
	      		<small><?= convert($row['size']) ?></small>
	    	</div>
    		<small>
    			<b>ID : </b>[<?= explode('_', explode('#', $row['nama_file'])[0])[1] ?>] 
    			<b>PW : </b>[<?php if ($row['password'] == "" || $row['password'] == null) { echo 'false'; } else { echo 'true'; } ?>]
    		</small>
	  	</a>
		<?php
				}
			} else {
		?>
			<div class="text-center"><h1>Tidak ada file yang bisa ditampilkan</h1></div>
		<?php
			}
		?>
	</div>
</main>