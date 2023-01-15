<?php
// Atur waktu untuk menjalankan program
date_default_timezone_set("Asia/Jakarta");
$run_times = array("8:05", "11:35", "15:05");

while (true) {
	// Mendapatkan waktu sekarang
	$current_time = date("H:i");

	// Cek waktu apakah sudah sesuai dengan yang diinginkan
	if (in_array($current_time, $run_times)) {
		// Jalankan program Python
		exec("python /rembg-aruco.py");
		sleep (120);
		exec("python /measure_object_size.py");

		// Hapus waktu sekarang agar tidak sengaja dijalankan lagi pada waktu yang sama
		unset($run_times[array_search($current_time, $run_times)]);

		// Berhenti menjalankan pengulangan jika waktu dalam list habis
		if (count($run_times) == 0) {
			break;
		}
	}

	// Beri waktu jeda 1 menit untuk menjalankan program lagi
	sleep(60);
}

?>