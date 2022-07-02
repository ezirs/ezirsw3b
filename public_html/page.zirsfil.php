<main>
	<h1>Welcome</h1>
	<p class="fs-5 col-md-8">
		Ezirs W3B provides various types of ready-to-use features for users for free.
	</p>

	<div class="mb-5">
  		<a href="#page_list" class="btn btn-primary px-4">Get started</a>
	</div>

	<hr class="mb-3">

	<div class="d-flex justify-content-around">
		<a href="https://www.instagram.com/yorandyorick" class="btn btn-outline-danger btn-lg" target="_blank"><i class="bi bi-instagram"></i></a>
		<a href="https://github.com/ezirs" class="btn btn-outline-dark btn-lg" target="_blank"><i class="bi bi-github"></i></a>
	</div>
    
    	<hr class="mb-5">

	<div id="page_list">
  		<div>
    		<h2>Available Pages</h2>
    		<?php
				require __DIR__.'/../config.zirsfil.php';
			    $result = $conn->query("select * from tbpage order by created_at desc");
			    $num = mysqli_num_rows($result);
			?>
			<table class="table table-striped table-hover table-bordered text-center">
				<thead>
			    	<tr>
				      	<th>Page Title</th>
				      	<th>Page Status</th>
				      	<th>Page Links</th>
			    	</tr>
			  	</thead>
				<tbody>
				<?php
				    for ($i = 1; $i <= $num; $i++) {
						$row = mysqli_fetch_array($result);
						if ($row['page_status'] == "PRIVATE") {
							
						} else {
				?>
					<tr>
						<td><?= $row['page_title'] ?></td>
						<td>
							<?php
								if ($row['page_status'] == "ACTIVE") {
							?>
							<span class="badge text-bg-success"><?= $row['page_status'] ?></span>
							<?php
								} else {
							?>
							<span class="badge text-bg-danger"><?= $row['page_status'] ?></span>
							<?php
								}
							?>
							
						</td>
						<td>
							<?php
								if ($row['page_status'] == "ACTIVE") {
							?>
							<a class="btn btn-outline-secondary w-100" href="?page=<?= $row['url_page'] ?>">Go</a>
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
