<!DOCTYPE html>
<html lang="en">
<head>
	<title>DHT-11 Data Test</title>
	<?php include './include/head.php'; ?>
</head>
<body>
	<?php include './include/sidebar-menu.php'; ?>
	
	<!-- Halaman Konten -->
	<div id="content" class="p-4 p-md-5 pt-5">
		<h2 class="mb-4" style='color: black; font-size: 32px; font-weight: bold;'>
			DHT-11 Data Output
		</h2>
		<table>
			<tr>
				<th>No</th>
				<th>Tanggal dan Waktu</th>
				<th>Suhu (&deg;C)</th>
				<th>Kelembapan (%)</th>
			</tr>
			<?php
				$dbc = new PDO("mysql:host=localhost;dbname=data_hidroponik_db", "data-hidroponik", "+(JzZ55xedU-5G3k3R");
				$query = $dbc->query("SELECT * FROM dht_11");
				foreach ($query as $data) {
			?>
			<tr>
				<td><?php echo $data["id"]; ?></td>
				<td><?php echo $data["date_time"]; ?></td>
				<td><?php echo $data["temperature"]; ?></td>
				<td><?php echo $data["humidity"]; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php include './include/script-js.php'; ?>
</body>
</html>