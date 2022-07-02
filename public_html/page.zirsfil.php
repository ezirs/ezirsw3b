<main>
	<h1>Selamat datang</h1>
	<p class="fs-5 col-md-8">
		Ezirs W3B menyediakan berbagai jenis fitur-fitur yang siap dipakai untuk pengguna dengan gratis.
	</p>

	<div class="mb-5">
  		<a href="#list_halaman" class="btn btn-primary px-4">Mulai Sekarang</a>
	</div>

	<hr class="mb-3">

	<div class="d-flex justify-content-around">
		<a href="https://www.instagram.com/yorandyorick" class="btn btn-outline-danger btn-lg" target="_blank"><i class="bi bi-instagram"></i></a>
		<a href="https://github.com/ezirs" class="btn btn-outline-dark btn-lg" target="_blank"><i class="bi bi-github"></i></a>
	</div>
	
	<hr class="mb-3">
	
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4007486504785362"
     crossorigin="anonymous"></script>
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-4007486504785362"
         data-ad-slot="2352331360"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    
    <hr class="mb-5">

	<div id="list_halaman">
  		<div>
    		<h2>Halaman Tersedia</h2>
    		<?php
				require __DIR__.'/../config.zirsfil.php';
			    $result = $conn->query("select * from tbhalaman order by tanggal_pembuatan desc");
			    $num = mysqli_num_rows($result);
			?>
			<table class="table table-striped table-hover table-bordered text-center">
				<thead>
			    	<tr>
				      	<th>Judul Halaman</th>
				      	<th>Status Halaman</th>
				      	<th>Link Halaman</th>
			    	</tr>
			  	</thead>
				<tbody>
				<?php
				    for ($i = 1; $i <= $num; $i++) {
						$row = mysqli_fetch_array($result);
						if ($row['status_halaman'] == "PRIVATE") {
							
						} else {
				?>
					<tr>
						<td><?= $row['judul_halaman'] ?></td>
						<td>
							<?php
								if ($row['status_halaman'] == "ACTIVE") {
							?>
							<span class="badge text-bg-success"><?= $row['status_halaman'] ?></span>
							<?php
								} else {
							?>
							<span class="badge text-bg-danger"><?= $row['status_halaman'] ?></span>
							<?php
								}
							?>
							
						</td>
						<td>
							<?php
								if ($row['status_halaman'] == "ACTIVE") {
							?>
							<a class="btn btn-outline-secondary w-100" href="?page=<?= $row['url_halaman'] ?>">Go</a>
							<?php
								} else {
							?>
							<button class="btn btn-outline-secondary w-100" disabled>Go</button>
							<?php
								}
							?>
						</td>
					</tr>
				<?php
						}
					}
				?>
				</tbody>
			</table>
  		</div>
	</div>
</main>
