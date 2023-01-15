<?php
// Membuat array kosong untuk prediktor (X) dan data (Y)
$Y_data = array();
$X_data = array();

// Memasukkan data di tabel MySQL ke dalam array $Y_data
// $table_name dapat disesuaikan dengan tabel pada MySQL
$dbc = new PDO("mysql:host=localhost;dbname=data_hidroponik_db","data-hidroponik", "+(JzZ55xedU-5G3k3R");
$query = $dbc->query("SELECT * FROM " . $table_name);
foreach ($query as $data) {
	array_push($Y_data, $data["Height"]);
}

// Memasukkan nilai X (prediktor) ke dalam array $X_data
if (count($Y_data) % 2 == 1) {
	$x = ((count($Y_data) / 2) * -1) + 0.5;
	while ($x < count($Y_data) / 2) {
		array_push($X_data, $x);
		$x += 1;
	}
} elseif (count($Y_data) % 2 == 0) {
	$x = (count($Y_data) - 1) * -1;
	while ($x < count($Y_data)) {
		array_push($X_data, $x);
		$x += 2;
	}
}

// Inisialisasi variabel untuk menyimpan nilai Sigma X^2 dan Sigma XY
$xx_sum = 0;
$xy_sum = 0;

// Hitung nilai Sigma X^2 dan Sigma XY
for ($i = 0; $i < count($X_data); $i++) {
	$xy_sum += ($X_data[$i] * $Y_data[$i]);
	$xx_sum += ($X_data[$i] ** 2);
}

// Hitung nilai intercept (a) dan nilai slope (b)
$a = array_sum($Y_data) / count($Y_data);
$a = number_format($a, 2);
$b = $xy_sum / $xx_sum;
$b = number_format($b, 2);

// Tampilkan persamaan regresi linier
echo "Model regresi linier: y = " . $a . " + " . $b . "x";
?>