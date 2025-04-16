<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สถานะการสั่งซื้อ</title>
</head>
<body>
    <?php

        include_once 'nav.php';
    
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <h1 class="text-center mb-3">สถานะการสั่งซื้อ</h1>
            <?php

                // ดึงออร์เดอร์ที่ผู้ใช้คนนี้สั่ง มาเช็คว่ามีไหม ถ้ามีก็จะดึงไฟล์ที่แสดงสถานะออร์เดอร์มาทำงาน
                $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `user_id` = '$user_id' AND `status` BETWEEN 0 AND 6");
                if($select -> num_rows > 0){
                    include '../template/status.php';
                }else{
            
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีออร์เดอร์ที่สั่ง</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>