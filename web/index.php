<!DOCTYPE html>
<html>
<head>
	<title>Phron</title>
</head>
<script type="text/javascript" 
		src="assets/js/jquery.js"></script>
<script type="text/javascript" 
		src="assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<style type="text/css">
	body {
		background: url(/assets/bg.jpg);
	}
</style>
	<body>
		<div class="container">
			<div class="row">
				<div class="col4">
					<div class="page-header text-center">
						<h2>Phron</h2>
					</div>
				</div>
			</div>
			<div class="">
				<?php require __DIR__.'/../views/cron_table.php'; ?>
			</div>
		</div>
	</body>
</html>