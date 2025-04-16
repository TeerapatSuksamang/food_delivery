<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php
    
        include_once 'nav.php';
        if($_GET['page'] != ''){
            // นำค่าจาก get มาต่อกับ .php เพื่อเป็นชื่อไฟล์ แล้วเช็คว่ามีไฟล์นั้นอยู๋จริงหรือไม่
            if(file_exists($_GET['page'].'.php')){
                // ถ้าเปิดหน้าอื่นที่ไม่ใช่หน้าแรกจะดึงไฟล์ session เพื่อมาเช็คการล็อคอิน
                if($_GET['page'] != 'home'){
                    include_once 'session.php';
                }
                include_once $_GET['page'].'.php';
            }else{
                echo "<h1 class='text-center blockquote-footer mt-5 pt-5'>ขออภัยไม่พบหน้านี้</h1>";
            }
        } else {
            // ดึงหน้า home.php เป็นหน้าเริ่มต้น
            include_once 'home.php';
        }
    
    ?>
</body>
</html>