# Ubah background menjadi putih dan menambahkan aruco marker di tengah gambar
from rembg import remove
from PIL import Image
import os
import mysql.connector
import datetime
import pytz

# Mendapatkan waktu saat ini (UTC+07.00)
utc_time = datetime.datetime.utcnow()
utc7_timezone = pytz.timezone('Asia/Jakarta')
utc7_time = utc7_timezone.localize(utc_time)
date_time = utc7_time.strftime('%Y-%m-%d %H:%M:%S')

# Membuat koneksi ke database
cnx = mysql.connector.connect(user='data-hidroponik', password='+(JzZ55xedU-5G3k3R',host='localhost', database='data_hidroponik_db')

# Mendapatkan semua nama file dalam folder
folder_path = "/camera-upload/"
filename_list = []

# Query untuk mendapatkan nama file
cursor = cnx.cursor()
query = 'SELECT PictureName FROM uploaded_pictures'
cursor.execute(query)
results = cursor.fetchall()
for data in results:
	# Menambahkan semua nama file dari gambar ke dalam list untuk diproses
	filename_list.append(data[0])
cursor.close()
cnx.close()

# Melakukan iterasi untuk menjalankan algoritma
for filename in range (len(filename_list)):
	# Deklarasi nama file
	image_file = filename_list[filename] # Nama file dari gambar yang akan diolah
	aruco_file = 'aruco-marker-190px.jpg' # Nama file dari Aruco Marker (ukuran 190px menyesuaikan 72 dpi)
	output_file = image_file[:-11] + '-growth.jpg' # Nama file output dari gambar yang telah diolah

	# Muat file gambar
	input_image = Image.open(folder_path + "/" + image_file)
	input_aruco = Image.open(aruco_file)

	# Hapus latar belakang dari gambar
	output = remove(input_image)

	# Ubah latar belakang menjadi putih serta merubah ektensi dari PNG ke JPG (menghilangkan transparansi)
	output = output.convert("RGBA")
	white_back = Image.new("RGB", output.size, (255, 255, 255))
	white_back.paste(output, mask=output)

	# Taruh Aruco Marker di pojok kiri atas
	x, y = white_back.size[0] // 4, white_back.size[1] // 4
	white_back.paste(input_aruco, (x - input_aruco.size[0] // 2, y - input_aruco.size[1] // 2))

	# Simpan gambar yang telah diolah
	white_back.save("/edited_picture/" + output_file)
	print(output_file + " successfully saved!")

	# Query untuk menambahkan nama file di tabel edited_pictures
	cursor = cnx.cursor()
	query = 'SELECT PictureName FROM uploaded_pictures'
	cursor.execute(query)