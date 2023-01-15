<!DOCTYPE html>
<html lang="en">
<head>
	<title>Hanya Mendapat Cahaya Matahari</title>
	<?php include './include/head.php'; ?>
</head>
<body>
	<?php include './include/sidebar-menu.php'; ?>
	
	<!-- Halaman Konten -->
	<div id="content" class="p-4 p-md-5 pt-5">
		<h2 class="mb-4" style='color: black; font-size: 32px; font-weight: bold;'>
			Uji Coba Sistem
		</h2>
		<table>
			<tr>
				<th>No</th>
				<th>Tanggal dan Waktu</th>
				<th>Tinggi</th>
				<th>Pertumbuhan</th>
			</tr>
			<?php
				$query = $dbc->query("SELECT * FROM plant_growth]");
				foreach ($query as $data) {
			?>
			<tr>
				<td><?php echo $data["ID"]; ?></td>
				<td><?php echo $data["DateTime"]; ?></td>
				<td><?php echo $data["Height"]; ?> cm</td>
				<td><?php echo $data["Growth"]; ?> cm</td>
			</tr>
			<?php } ?>
		</table>
	</div>

	<?php include './include/script-js.php'; ?>
</body>
</html>