import cv2
import numpy as np

class HomogeneousBgDetector():
	def __init__(self):
		pass

	def detect_objects(self, frame):
		# Ubah gambar ke monokrom
		gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)

		# Atur gamma dari gambar
		gamma = 0.1
		invGamma = 1 / gamma

		table = [((i / 255) ** invGamma) * 255 for i in range(256)]
		table = np.array(table, np.uint8)
		gray = cv2.LUT(gray, table)

		# Create a Mask with adaptive threshold
		mask = cv2.adaptiveThreshold(gray, 255, cv2.ADAPTIVE_THRESH_MEAN_C, cv2.THRESH_BINARY_INV, 19, 5)

		# Find contours
		contours, _ = cv2.findContours(mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

		#cv2.imshow("mask", mask)
		objects_contours = []

		for cnt in contours:
			area = cv2.contourArea(cnt)
			if area > 2000:
				objects_contours.append(cnt)

		return objects_contours