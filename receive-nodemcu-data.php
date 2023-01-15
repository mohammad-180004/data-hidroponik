<?php
// Membuat koneksi dengan database
$dbc = new PDO("mysql:host=localhost;dbname=data_hidroponik_db","data-hidroponik", "+(JzZ55xedU-5G3k3R");

// API Key digunakan untuk mencocokkan dengan API Key pada NodeMCU
$api_key_value = "ZVgXDxg38a";

// Buat variabel kosong
$api_key = $temperature = $humidity = "";

// Periksa apakah data telah dikirmkan dari NodeMCU
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$api_key = test_input($_POST["api_key"]);
	// Cek apakah API Key cocok
	if ($api_key == $api_key_value) { 
		// Atur waktu ke UTC+07.00 dan setel format tanggal dan waktu
		date_default_timezone_set("Asia/Jakarta"); 
		$date_time = date("Y-m-d H:i:s");

		// Mendapatkan nilai suhu kelembaban dari DHT11 melalui NodeMCU
		$temperature = test_input($_POST["temperature"]); 
		$humidity = test_input($_POST["humidity"]);
		
		// Melakukan query INSERT ke tabel dht_11 untuk suhu dan kelembaban
		$statement = $dbc->prepare("INSERT INTO dht_11 (DataID, DateTime, Temperature, Humidity) 
									VALUES (NULL, :DateTime, :Temperature, :Humidity);"); 
		$statement->bindValue(":DateTime", $date_time);
		$statement->bindValue(":Temperature", $temperature);
		$statement->bindValue(":Humidity", $humidity);
		$statement->execute();
	} else {
		// Jika API Key tidak sama
		echo "API key tidak sesuai!";
	}
} else {
	// Jika tidak ada data yang terkirim dengan metode POST
	echo "Tidak ada data yang dikirim dengan metode POST!";
}

// Melakukan tes input dari data yang diterima
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>