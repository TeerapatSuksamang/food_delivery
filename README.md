# Food Delivery Website 🛵
ระบบเว็บไซต์สั่งอาหารออนไลน์ ที่ผมกับเพื่อนช่วยกันสร้างในการแข่งขันทักษะวิชาชีพประเภทวิชาเทคโนโลยีสารสนเทศและการสื่อสาร สาขาวิชาเทคโนโลยีสารสนเทศ ระดับ ปวช. ได้รับรางวัลชนะเลิศระดับชาติ ปี2568  
[ข้อมูลการแข่งขัน จาก VECSkills](http://www2.chainat.ac.th/vecskills/pages/level1_contest_list_detail.php?c_id=1383016201&lh_id=1&st_id=5&sma_id=7&smi_id=1&sl_id=1)  
[ผลการแข่งขัน](http://www2.chainat.ac.th/vecskills/pages/level1_contest_trophy2.php) (ลำดับที่ 7.1 ประเภทวิชาเทคโนโลยีสารสนเทศและการสื่อสาร สาขาวิชาเทคโนโลยีสารสนเทศ)  

ในการแข่งขันเป็นประเภททีม(2 คน) ผมได้แบ่งหน้าที่กับเพื่อนให้เพื่อนทำหน้าเว็บไซต์ ส่วนผมทำระบบหลังบ้าน หลังจากการแข่งขันเสร็จ ผมได้นำโค้ดนี้มาปรับปรุงแก้ไขข้อผิดพลาดบางส่วน และเขียนอธิบายส่วนต่างๆไว้ในโค้ดคร่าวๆ  
***เนื่องจากในการแข่งขันมีเวลาจำกัด 8ชั่วโมง** ผมได้ปรับโค้ดให้สั้นและไวต่อการเขียนระบบต่างๆในช่วงการแข่ง โค้ดบางส่วนอาจไม่เหมาะกับงานจริง ไม่ได้เน้นความปลอดภัย **อาจมีช่องโหว่ และข้อผิดพลาด** หากต้องการนำไปพัฒนาต่อ  

## Brief features 💻
- **Admin 👮‍♂️**
  - แก้ไขรูปภาพ/ข้อมูลส่วนตัว
  - แก้ไขชื่อเว็บไซต์
  - เพิ่ม/ลบ/แก้ไข คูปอง
  - เพิ่ม/ลบ/แก้ไข ประเภทร้านอาหาร
  -  อนุมัติ/ระงับ และเพิ่มหมายเหตุการระงับ ของการใช้งานผู้ใช้

- **User 🙋**
  - สมัคร/ล็อคอิน เข้าใช้งานระบบ
  - แก้ไขรูปภาพ/ข้อมูลส่วนตัว
  - ค้นหา เลือกดูร้าน/รีวิวร้าน และเพิ่มเป็นร้านโปรด
  - เพิ่มเมนูลงตะกร้า 
  - สั่งอาหาร และเพิ่มคะแนนรีวิวเมื่อสำเร็จ
  - ดูประวัติการสั่ง

- **Restaurant 🧑‍🍳**
  - สมัคร/ล็อคอิน เข้าใช้งานระบบ
  - แก้ไขรูปภาพ/ข้อมูลส่วนตัว
  - เพิ่ม/ลบ/แก้ไข หมวดหมู่อาหาร และเมนูอาหาร
  - เพิ่มส่วนลดเมนูเป็นเปอร์เซ็นต์
  - ปรับสถานะคงเหลือของเมนู
  - เพิ่มรูป QR code และข้อมูลบัญชีธนาคาร
  - ยกเลิก/ยืนยัน และอัพเดทสถานะออร์เดอร์
  - ดูรายงานสรุปยอดขาย และรายได้รวม
  - ปริ้นท์ใบเสร็จออกเป็นไฟล์ PDF ด้วย mPDF

- **Rider 🛵**
  - สมัคร/ล็อคอิน เข้าใช้งานระบบ
  - แก้ไขรูปภาพ/ข้อมูลส่วนตัว
  - ค้นหา เลือกดูร้านอาหาร และรับออร์เดอร์
  - ดูรายการออร์เดอร์ทั้งหมดที่อยู่ในสถานะรอรับออร์เดอร์
  - ดูประวัติการจัดส่ง

## Tech stack 📦
- **Front-end**
  - html, css, js, Bootstrap v5.2.3
- **Back-end**
  - xampp
  - MySql v10.4.32
  - php v8.2.12 
  - mPdf v6.1


## Installation 🔧
1. **ติดตั้งโปรเจคไปยัง xampp/htdocs**
``` bash
cd C:\xampp\htdocs
git clone https://github.com/TeerapatSuksamang/food_delivery.git 
```
หรือดาวโหลดไฟล์จาก github แล้วแตกไฟล์ไปยังโฟลเดอร์ xampp/htdocs

2. **ตั้งค่าฐานข้อมูล**
   1. สร้างฐานข้อมูลชื่อ atc_deli
   2. import ไฟล์ [atc_deli.sql](https://github.com/TeerapatSuksamang/food_delivery/blob/main/atc_deli.sql) ลงฐานข้อมูล
3. **ติดตั้ง mPDF**
   1. ไปที่ ``cd C:/xampp/htdocs/food_delivery/restaurant``
   2. ติดตั้ง ``composer require mpdf/mpdf``
   3. หรือดาวน์โหลดโฟลเดอร์ vendor จาก https://drive.google.com/drive/folders/1pnhDBTN2_5kO6VSNQfod5cSjx_gOJhSo?usp=drive_link แล้วแตกไฟล์ไปยังโฟลเดอร์ restaurant พร้อมใช้งาน
   4.  เข้าสู่ระบบ
		- admin | username: admin | password: admin123
		- user | username: user1 | password: user1

##  Project structure 📂
```
food_delivery/
├── admin/           // ผู้ดูแลระบบ
├── bootstrap/       // bootstrap เวอร์ชั่น 5.2.3
├── font/            // ฟอนต์
├── img/             // รูปภาพ
├── restaurant/      // ร้านอาหาร
│   ├── vendor/      // เก็บไฟล์ไลบรารีจาก Composer สำหรับสร้าง PDF
├── rider/           // ผู้ส่งอาหาร
├── style/      
├── system/          // เก็บไฟล์ที่ทุกประเภทผู้ใช้ต้องประมวลผลเหมือนกัน
├── template/        // รวมไฟล์ element ที่ใช้บ่อยๆในหลายหน้า
├── upload/          // เก็บรูปภาพที่อัพโหลด
├── user/            // ลูกค้า
├── db.php           // เชื่อมต่อฐานข้อมูล + php function 
├── function.js      
├── index.php        // หน้าแรก
├── login.php        // หน้าเข้าสู่ระบบ
├── readme.md        // เอกสารนี้
├── reister.php      // หน้าสมัครใช้งาน
└── upload.php       // ไฟล์คำสั่ง upload รูปภาพ
```

## Developer👨‍💻
[นายธีรภัทร สุขสำอางค์](https://www.facebook.com/teerapat.suksamang) ผมเอง😊  
[นายภัศกร กันภัย](https://www.facebook.com/pxssakorn.eiei)

## License ⚠️
- สามารถนำไปศึกษา แก้ไข หรือพัฒนาต่อได้
- ไม่รับผิดชอบข้อผิดพลาดใดๆทั้งสิ้น

## Demo 🌐
- https://www.iet-dev.com/krujune/food_delivery/
