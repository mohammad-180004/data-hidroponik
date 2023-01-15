<?php
// Membuat target folder untuk gambar yang diterima
$target_dir = "camera-2/";
$pic_number = 0;
// Setel waktu dan zona waktu untuk nama dari file gambar
date_default_timezone_set("Asia/Jakarta");
$datum = mktime(date('H')+0, date('i'), date('m'), date('d'), date('y'));
$target_file = $target_dir . date('Ymd-H:i-', $datum) . basename($_FILES["imageFile"]["name"]);
// Mendapatkan jenis file dari gambar
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Variabel untuk cek kondisi dari gambar
$uploadOk = 1;

// Cek apakah gambar merupakan gambar asli atau tidak
if (isset($_POST["submit"])) {
	$check = getimagesize($_FILES["imageFile"]["tmp_name"]);
	if ($check !== false) {
		echo "File adalah gambar - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File bukan gambar!";
		$uploadOk = 0;
	}
}

// Cek apakah gambar sudah ada di dalam folder
if (file_exists($target_file)) {
	echo "Maaf, gambar sudah ada.";
	$uploadOk = 0;
}

// Cek ukuran file gambar yang diterima
if ($_FILES["imageFile"]["size"] > 5000000) {
	echo "Maaf, gambar terlalu besar.";
	$uploadOk = 0;
}

// Cek apakah nilai $uploadOk adalah 0, jika 0 maka gambar tidak diunggah
if ($uploadOk == 0) {
	echo "Maaf, gambar gagal diunggah.";

// Jika pengecekan berhasil, maka gambar diunggah dan disimpan di folder dan database
} else {
	// Pindah file ke folder target
	if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $target_file)) {
		// Menamai file gambar yang diterima dengan nama yang baru
		$picture_name = date('Ymd_H:i-', $datum) . basename($_FILES["imageFile"]["name"]);
		$date_time = date("Y-m-d H:i:s");
		
		// Melakukan query INSERT untuk nama file ke tabel camera_2
		$dbc = new PDO("mysql:host=localhost;dbname=data_hidroponik_db","data-hidroponik", "+(JzZ55xedU-5G3k3R");
		$query = $dbc->prepare("INSERT INTO camera_2 (Picture2ID, DateTime, Picture2Name) VALUES (NULL, :DateTime, :Picture2Name");
		$query->bindValue(":DateTime", $date_time);
		$query->bindValue(":Picture2Name", $picture_name);
		$query->execute();

		// Pemberitahuan bahwa file berhasil dikirim
		echo "Gambar ". basename($_FILES["imageFile"]["name"]). " berhasil diunggah.";
	} else {
		// Jika pengunggahan tidak berhasil
		echo "Maaf, ada masalah saat pengunggahan gambar.";
	}
}
?>