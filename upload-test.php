<!DOCTYPE html>
<html lang="en">
<head>
	<title>Image Upload Test</title>
	<?php include './include/head.php'; ?>
</head>
<body>
	<?php include './include/sidebar-menu.php'; ?>
	
	<!-- Halaman Konten -->
	<div id="content" class="p-4 p-md-5 pt-5">
		<h2 class="mb-4" style='color: black; font-size: 32px; font-weight: bold;'>
			Image Upload Test
		</h2>
		<form action="upload-camera.php" method="post">
			<input type="file" name="image-upload" id="image-upload"> <br><br>
			<input type="submit" value="Upload">
		</form>
	</div>
	<?php include './include/script-js.php'; ?>
</body>
</html>