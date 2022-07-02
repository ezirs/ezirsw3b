<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ezirs W3b</title>
    
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		body {
			display: none;
		}
	</style>
</head>
<body onload="onLoad()" id="page" style="display: none;">
<div class="col-md-6 mx-auto p-3 py-md-5 border-start border-end">
  	<header class="d-flex align-items-center pb-3 mb-5 border-bottom">
      	<span id="judul" class="fs-4">Ezirs W3B</span>
  	</header>

	<?php
		error_reporting(1);

		if (!isset($_GET['page'])) {
		    include 'page.zirsfil.php';
		} else {
			require __DIR__.'/../config.zirsfil.php';
			$url_halaman = $_GET['page'];
			$query = "select * from tbhalaman where url_halaman = '$url_halaman'";
	        $result = $conn->query($query);
	        $row = mysqli_fetch_array($result);
	        if ($row) {
	?>

				<script type="text/javascript">
					document.getElementById('judul').innerHTML += " || <?= $row['judul_halaman'] ?>";
				</script>

	<?php
	        	include 'page/' . $row['path'] . '/' . $_GET['page'] . '.zirsfil.php';
	        } else {
	        	echo '<div class="text-center"><h1>Halaman Tidak Ditemukan</h1></div>';
	        }
			
		}
		
	?>
    
    <div id="iklan">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4007486504785362"
             crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-4007486504785362"
             data-ad-slot="1067740672"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4007486504785362"
             crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-format="fluid"
             data-ad-layout-key="-fc+5g+70-cl-1m"
             data-ad-client="ca-pub-4007486504785362"
             data-ad-slot="7277925804"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
        
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4007486504785362"
             crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-format="autorelaxed"
             data-ad-client="ca-pub-4007486504785362"
             data-ad-slot="4432270619"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    
    <footer id="footer" class="pt-5 my-5 text-muted border-top">
    	Created by ezirs &middot; &copy; <?= date('Y') ?>
    </footer>
</div>

<script type="text/javascript">
    function onLoad() {
        $('body').find('img[src$="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]').remove();
        $('body').find('div[class$="disclaimer"]').remove();
        $('body').find('style').remove();
        document.getElementById('page').style.display = 'block';
    }
    
    if (window.top != window.self) {
        $('#iklan').hide();
        $('#footer').hide();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>  

</body>
</html>