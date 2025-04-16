<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการจัดส่ง</title>
</head>
<body>
    <?php

        include_once 'nav.php';
    
    ?>

    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <h1 class="text-center mb-3">ประวัติการจัดส่ง</h1>
            <?php
                // ดึงออร์เดอร์ที่จัดส่งสำเร็จแล้ว ที่ไรเดอร์คนนี้ได้จัดส่ง
                $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `rider_id` = '$rider_id' AND `status` = 7");
                if($select -> num_rows > 0){
                    include '../template/status.php';
                }else{
            
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีประวัติการจัดส่ง</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>