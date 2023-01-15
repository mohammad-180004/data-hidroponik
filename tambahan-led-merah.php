<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mendapat Tambahan Cahaya LED Merah</title>
	<?php include './include/head.php'; ?>
	
</head>
<body>
	<?php include './include/sidebar-menu.php'; ?>
	<?php $table_name = "growth_red_led" ?>
	
	<!-- Halaman Konten -->
	<div id="content" class="p-4 p-md-5 pt-5">
		<h2 class="mb-4" style='color: black; font-size: 32px; font-weight: bold;'>
			Pertumbuhan Tanaman yang Mendapatkan Tambahan Cahaya LED Merah
		</h2>
		<table>
			<?php include './include/table-header.php'; ?>
			<?php
				$query = $dbc->query("SELECT * FROM " . $table_name);
				foreach ($query as $data) {
			?>
			<tr>
				<td><?php echo $data["ID"]; ?></td>
				<td><?php echo $data["DateTime"]; ?></td>
				<td><?php echo $data["Temperature"]; ?>&deg;C</td>
				<td><?php echo $data["Humidity"]; ?>%</td>
				<td><?php echo $data["Height"]; ?> cm</td>
				<td><?php echo $data["Growth"]; ?> cm</td>
			</tr>
			<?php } ?>
		</table> <br>
		<p style='color: black; font-size: 16px;'>
			<?php include './include/regresi-linier.php' ?>
		</p>
	
	</div>

	<?php include './include/script-js.php'; ?>
</body>
</html>