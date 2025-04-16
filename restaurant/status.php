<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1, initial-scale=1.0">
    <title>ออร์เดอร์ขณะนี้</title>
</head>
<body>
    <?php
        include_once 'nav.php';
    ?>

    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <h1 class="text-center mb-3">ออร์เดอร์ขณะนี้</h1>
            <?php
                // ดึงออร์เดอร์ที่สถานะอยู่ระหว่างการจัดส่ง
                $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `res_id` = '$res_id' AND `status` BETWEEN 0 AND 6");
                if($select -> num_rows > 0){
                    // แล้วดึงส่วนสำหรับแสดงรายละเอียดออร์เดอร์จาก template
                    include '../template/status.php';
                }else{
            
            ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีออร์เดอร์ในตอนนี้</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>