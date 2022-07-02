<?php
	include 'get-video-info.zirsfil.php';
	$isvalid = '';
	$isVideoIdValid = '';

	if (isset($_POST['submit'])) {
		$video_link = $_POST['video_url'];
		if ($video_link != '') {
			$isVideoIdValid = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_link, $match);
			if ($isVideoIdValid == '1') {
	          	$video_id =  $match[1];
	          	$video = json_decode(GetVideoInfo($video_id));
	          	$isvalid = $video->playabilityStatus->status;
	          	$playableInEmbed = $video->playabilityStatus->playableInEmbed;

	          	@$formats = $video->streamingData->formats;
	          	@$adaptiveFormats = $video->streamingData->adaptiveFormats;
	          	@$thumbnails = $video->videoDetails->thumbnail->thumbnails;
	          	@$title = $video->videoDetails->title;
	          	@$short_description = $video->videoDetails->shortDescription;
	          	@$channel_id = $video->videoDetails->channelId;
	          	@$channel_name = $video->videoDetails->author;
	          	@$views = $video->videoDetails->viewCount;
	          	@$video_duration_in_seconds = $video->videoDetails->lengthSeconds;
	          	@$thumbnail = end($thumbnails)->url;

	          	@$video_embed = $video->microformat->playerMicroformatRenderer->embed->iframeUrl;
	          	@$isLiveNow = $video->microformat->playerMicroformatRenderer->liveBroadcastDetails->isLiveNow;

	          	$jam = floor($video_duration_in_seconds / 3600);
	          	$menit = floor(($video_duration_in_seconds / 60) % 60);
	          	$detik = $video_duration_in_seconds % 60;
	        }
		}
	}

	function convert($size) {
	 	if($size >= 1073741824) {
	 		return $fileSize = round($size / 1024 / 1024 / 1024,2) . ' GB';
	 	} elseif ($size >= 1048576) {
	  		return $fileSize = round($size / 1024 / 1024,2) . ' MB';
 		} elseif ($size >= 1024) {
	  		return $fileSize = round($size / 1024,2) . ' KB';
	 	}
	}
?>

<main>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-group mb-3 input-group-lg">
		  	<input type="text" class="form-control" placeholder="Masukkan url youtube disini!" value="<?php if (isset($_POST['submit'])) { echo $_POST['video_url']; } ?>" name="video_url">
		  	<span class="mx-1"></span>
		  	<button type="submit" name="submit" class="btn btn-outline-success shadow">Unduh</button>
		</div>
	</form>

	<?php
		if ($isVideoIdValid == '0') {
	?>
			<div class="text-center my-5">
				<h3>URL salah</h3>
				<p>Periksa tautan yang Anda masukkan</p>
			</div>
	<?php
		} elseif ($isvalid == 'OK') {
	?>
			<div class="card mb-3">
			  	<div class="row g-0">
			    	<div class="col p-2">
			      		<img src="<?php echo $thumbnail; ?>" class="img-fluid rounded border border-2 mb-2 border-dark w-100" alt="thumbnail">
			      		<?php
			      			if ($playableInEmbed == 'true') {
		  				?>
				  				<input type="text" class="form-control mb-2" value="<?= $video_embed ?>" id="video_embed" readonly>
					      		<button type="button" class="btn btn-outline-primary w-100" id="copyTextBtn">Salin link video embed</button>
		  				<?php	
		  					} else {
		  				?>
				  				<div class="text-center my-3">
				     				<p>Embed video tidak di izinkan pada video ini</p>
				     			</div>
		  				<?php
		  					}
		  				?>
			    	</div>
			    	<div class="col-md-8">
			    		<?php
			      			if (!empty($adaptiveFormats)) {
		  						if(@$adaptiveFormats[0]->url == '') {
		  				?>
					  				<div class="text-center my-5">
						    			<h3>Tidak didukung</h3>
					     				<p>Video ini saat ini tidak didukung</p>
					     			</div>
		  				<?php
		  						} else {
		  				?>
					  				<div class="card-body">
						        		<h5 class="card-title"><?php echo $title; ?></h5>
						        		<ul class="list-group mb-2">
										  	<li class="list-group-item d-flex justify-content-between align-items-center">
										    Youtube Channel
										    	<a class="btn btn-outline-secondary btn-sm" href="<?php echo 'https://www.youtube.com/channel/'.$channel_id ?>" target="_blank"><?php echo $channel_name ?></a>
										  	</li>
										  	<?php
										  		if ($isLiveNow == 'true') {

										  		} else {
										  	?>	
										  	<li class="list-group-item d-flex justify-content-between align-items-center">
										    Video Durasi
										    	<span class="badge bg-primary rounded-pill"><?php echo "$jam : $menit : $detik"; ?></span>
										  	</li>
										  	<?php
										  		}
										  	?>
										  	<li class="list-group-item d-flex justify-content-between align-items-center">
										    Penonton
										    	<span class="badge bg-primary rounded-pill"><?php echo $views; ?></span>
										  	</li>
										</ul>
						      		</div>
		  				<?php
		  						}
		  					}
		  				?>
			    	</div>
			  	</div>
			</div>
			<?php
				if (!empty($adaptiveFormats)) {
					if(@$adaptiveFormats[0]->url == '') {

					} else {
						if ($isLiveNow == 'true') {
			?>
							<div class="text-center my-5">
								<h3>Untuk video live streaming tidak dapat unduh</h3>
								<p>Harap coba lagi ketika live streaming selesai</p>
							</div>
			<?php
							if ($playableInEmbed == 'true') {
			?>
								<div class="text-center my-2">
									<iframe width="560" height="315" src="<?= $video_embed ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
			<?php	
							}
						} else {
			?>
							<table class="table table-striped table-hover table-bordered text-center">
								<thead>
							    	<tr>
								      	<th>Resolusi</th>
								      	<th>Format</th>
								      	<th>Ukuran File</th>
								      	<th>Download</th>
							    	</tr>
							  	</thead>
								<tbody>
								<?php
									$i = 1;
									$qualityLabel = '';
									foreach($formats as $adaptiveFormat) {
										if (@$adaptiveFormat->url == '') {
						                    $signature = "https://youtube.com?" . $adaptiveFormat->signatureCipher;
						                    parse_str(parse_url($signature, PHP_URL_QUERY ), $parse_signature);
						                    $url = $parse_signature['url'] . "&sig=" . $parse_signature['s'];
						                } else {
						                  	$url = $adaptiveFormat->url;
						                }
						                $mimeType = explode(';', explode('/', $adaptiveFormat->mimeType)[1])[0];
						                if (isset($adaptiveFormat->qualityLabel) && $mimeType == 'mp4') {
						                	if ($adaptiveFormat->qualityLabel == $qualityLabel) {
						                		
						                	} else {
						        ?>	
												<tr>
											      	<td>
											        	<?= $adaptiveFormat->qualityLabel ?>
											        </td>
											      	<td>
											      		<?= $mimeType ?>
											      	</td>
											      	<th>
											      		<?php
											      			if (isset($adaptiveFormat->contentLength)) {
											      				echo '['.convert($adaptiveFormat->contentLength).']';
											      			} else {
											      				echo '[Unknown]';
											      			}
											      		?>
											      	</th>
											      	<td>
											      		<a href="<?= $url ?>" download="<?= $title . '.' . $mimeType ?>" class="btn btn-outline-secondary btn-sm" target="_blank">Download</a>
											      	</td>
											    </tr>
						        <?php
						                	}
						            	}
						                $i++;
						                $qualityLabel = $adaptiveFormat->qualityLabel;
									}
								?>
								</tbody>
							</table>
	<?php
						}
					}
				}
		} elseif ($isvalid == '') {
			
		} else {
	?>
			<div class="text-center my-5">
				<h3>Kami tidak dapat memperoleh informasi video</h3>
			    <p>Anda dapat memeriksa tautan yang Anda masukkan</p>
			</div>
	<?php
		}
	?>

</main>

<script type="text/javascript">
    copyTextBtn = document.querySelector('#copyTextBtn');
    copyTextBtn.addEventListener('click', function(event) {
        let copyText = document.querySelector('#video_embed');
        copyText.focus();
        copyText.select();
        try {
          	let successful = document.execCommand('copy');
          	let msg = successful ? 'successful' : 'unsuccessful';
          	alert('Copy url was ' + msg);
        } catch(err) {
          	alert('Unable to copy');
        }
    });
</script>