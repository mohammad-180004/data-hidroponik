import cv2
from object_detector import *
import numpy as np
import mysql.connector
import datetime
import pytz

# Mendapatkan waktu saat ini (UTC+07.00)
utc_time = datetime.datetime.utcnow()
utc7_timezone = pytz.timezone('Asia/Jakarta')
utc7_time = utc7_timezone.localize(utc_time)
date_time = utc7_time.strftime('%Y-%m-%d %H:%M:%S')

# Melakukan query untuk mendapatkan nama file yang disimpan di database
cnx = mysql.connector.connect(user='data-hidroponik', password='+(JzZ55xedU-5G3k3R',host='localhost', database='data_hidroponik_db')
file_img = ""
cursor = cnx.cursor()
query = 'SELECT EditedName FROM edited_picture ORDER BY EditedID DESC LIMIT 1;'
cursor.execute(query)
results = cursor.fetchall()
for row in results:
	file_img = row[0] 
cursor.close()
cnx.close()

# Muat modul deteksi aruco marker
parameters = cv2.aruco.DetectorParameters_create()
aruco_dict = cv2.aruco.Dictionary_get(cv2.aruco.DICT_5X5_50)


# Muat program deteksi objek
detector = HomogeneousBgDetector()

# Muat gambar yang ingin diukur
img = cv2.imread(file_img) # Change the filename to Query in MySQL

# Melakuakan deteksi aruco marker
corners, _, _ = cv2.aruco.detectMarkers(img, aruco_dict, parameters=parameters)

# Membuat pinggiran persegi panjang untuk objek
int_corners = np.int0(corners)
cv2.polylines(img, int_corners, True, (0, 255, 0), 5)

# Keliling aruco marker
aruco_perimeter = cv2.arcLength(corners[0], True)

# Menghitung rasio piksel ke cm sebagai acuan pengukuran
# Angka 20 diperoleh dari keliling dari Aruco marker (4 x sisi)
pixel_cm_ratio = aruco_perimeter / 20 
contours = detector.detect_objects(img)

# Menampung lebar dan tinggi dari objek yang diukur
list_height = []

# Menggambar batas pada objek
for cnt in contours:
	# Mendapatakan persegi panjang dari objek
	rect = cv2.minAreaRect(cnt)
	(x, y), (w, h), angle = rect

	# Mendapatkan lebar dan tinggi dari objek dengan menerapkan rasio piksel ke cm
	object_width = w / pixel_cm_ratio
	object_height = h / pixel_cm_ratio

	# Menampilkan batas persegi panjang
	box = cv2.boxPoints(rect)
	box = np.int0(box)

	# Menampikan ukuran dalam cm
	cv2.circle(img, (int(x), int(y)), 5, (0, 0, 255), -1)
	cv2.polylines(img, [box], True, (255, 0, 0), 2)
	cv2.putText(img, "Width {} cm".format(round(object_width, 1)), (int(x - 100), int(y - 20)), cv2.FONT_HERSHEY_PLAIN, 2, (100, 200, 0), 2)
	cv2.putText(img, "Height {} cm".format(round(object_height, 1)), (int(x - 100), int(y + 15)), cv2.FONT_HERSHEY_PLAIN, 2, (100, 200, 0), 2)
	list_height_width.append('{:.2f}'.format(object_height))
	
list_height_width.pop(-1)
print (list_height_width)
cv2.waitKey(0)

# Simpan tinggi objek pada tabel database baru
cursor = cnx.cursor()
query = 'INSERT INTO plant_growth (GrowthID, DateTime, Height, Growth) VALUES (%s, %s, %s, %s)'
values = (NULL, date_time, list_height_width[0])
cursor.execute(query, values)
cursor.close()
conn.close()