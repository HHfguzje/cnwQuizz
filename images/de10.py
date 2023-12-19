import cv2
import numpy as np
import matplotlib.pyplot as plt

# Định nghĩa hàm Tich_chap() để lọc Trung bình, Trung bình có trọng số và lọc Gaussian
def Tich_chap(img,mask):
    m, n = img.shape
    img_new = np.zeros([m, n])
    for i in range(1, m-1):
        for j in range(1, n-1):
            temp   =  img[i-1, j-1]    * mask[0, 0]\
                   +  img[i-1, j]      * mask[0, 1]\
                   +  img[i-1, j + 1]  * mask[0, 2]\
                   +  img[i, j-1]      * mask[1, 0]\
                   +  img[i, j]        * mask[1, 1]\
                   +  img[i, j + 1]    * mask[1, 2]\
                   +  img[i + 1, j-1]  * mask[2, 0]\
                   +  img[i + 1, j]    * mask[2, 1]\
                   +  img[i + 1, j + 1]* mask[2, 2]
            img_new[i, j]= temp
    img_new = img_new.astype(np.uint8)
    return img_new
# Định nghĩa hàm lọc trung vị
def loc_trung_vi(img):
    m, n = img.shape
    img_new = np.zeros([m, n])
    for i in range(1, m - 1):
        for j in range(1, n - 1):
            temp = [img[i - 1, j - 1],
                    img[i - 1, j],
                    img[i - 1, j + 1],
                    img[i, j - 1],
                    img[i, j],
                    img[i, j + 1],
                    img[i + 1, j - 1],
                    img[i + 1, j],
                    img[i + 1, j + 1]]

            temp = sorted(temp)
            img_new[i, j] = temp[4]
    img_new = img_new.astype(np.uint8)
    return img_new
# Định nghĩa hàm lọc Max
def loc_max(img):
    m, n = img.shape
    img_new = np.zeros([m, n])
    for i in range(1, m - 1):
        for j in range(1, n - 1):
            temp = [img[i - 1, j - 1],
                    img[i - 1, j],
                    img[i - 1, j + 1],
                    img[i, j - 1],
                    img[i, j],
                    img[i, j + 1],
                    img[i + 1, j - 1],
                    img[i + 1, j],
                    img[i + 1, j + 1]]

            temp = max(temp)     # nếu lọc min thì thay hàm max bằng min(temp)
            img_new[i, j] = temp
    return img_new

#hàm lọc min
def min_filter(img):
    m, n = img.shape
    img_new = np.zeros([m, n])

    for i in range(1, m - 1):
        for j in range(1, n - 1):
            temp = [img[i - 1, j - 1],
                    img[i - 1, j],
                    img[i - 1, j + 1],
                    img[i, j - 1],
                    img[i, j],
                    img[i, j + 1],
                    img[i + 1, j - 1],
                    img[i + 1, j],
                    img[i + 1, j + 1]]

            temp = min(temp)
            img_new[i, j] = temp

    return img_new

img = cv2.imread("image/main_board.tif")
print(img.shape)
gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
print(gray.shape)
imgTV_3x3 = loc_trung_vi(gray) #Gọi hàm lọc

imgmax_3x3 = loc_max(gray) 

imgmin_3x3 = min_filter(gray)

output = imgmin_3x3 + imgTV_3x3




cv2.waitKey()

#áp dụng các phép xử lí hình thái
kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (5,5))

#dilate
dilate = cv2.dilate(imgmin_3x3, kernel, iterations=1)
#erode
erosion = cv2.erode(dilate, kernel, iterations=1)





cv2.imshow("anh goc", img)
cv2.imshow("anh sau xu li", imgTV_3x3)
cv2.waitKey()

#xoay ảnh -90 độ quanh tâm
w, h = gray.shape
roltate_matrix = cv2.getRotationMatrix2D((w/2, h/2), 45, 1)
img_roltate = cv2.warpAffine(gray, roltate_matrix, (w,h))
cv2.imshow("roltate", img_roltate)
cv2.waitKey()





