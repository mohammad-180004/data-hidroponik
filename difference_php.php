<?php
// Membuat koneksi ke database
$dbc = new PDO("mysql:host=localhost;dbname=data_hidroponik_db","data-hidroponik", "+(JzZ55xedU-5G3k3R");

// Inisialisasi variabel jumlah data pada tabel dan urutan id dari setiap data
$row_count = 0;
$current_id = 2;
$previous_id = $current_id - 1;

// Membuat query untuk mendapatkan jumlah data
$query = $dbc->query("SELECT COUNT(*) FROM plant_growth");
foreach ($query as $data) {
	$row_count = $data['COUNT(*)']; // Jumlah data disimpan pada variabel $row_count
}

// Membuat perulangan untuk menghitung pertumbuhan
while ($current_id <= $row_count and $row_count > 1) { // Cek apakah jumlah data lebih dari 1
	// Melakukan operasi pengurangan pada data sekarang dikurangi data sebelumnya
	// Melakukan query UPDATE pada data dengan nilai Growth = NULL dengan data yang sudah dihitung
	$statement = $dbc->prepare("UPDATE plant_growth 
	SET Growth = (SELECT Height FROM plant_growth WHERE GrowthID = :id_2) - (SELECT Height FROM plant_growth WHERE Growth = :id_1) 
	WHERE Growth = :current_id AND Growth IS NULL;"); 
	$statement->bindValue(":id_1", $previous_id);
	$statement->bindValue(":id_2", $current_id);
	$statement->bindValue(":current_id", $current_id);
	$statement->execute();

	$current_id++; // Ke urutan data selanjutnya
}
?>