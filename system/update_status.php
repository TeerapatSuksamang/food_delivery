<?php

    include_once '../db.php';
    include_once '../template/load.html';


    if(isset($_GET['status'])){
        $status = $_GET['status']; // สถานะ order
        $order_id = $_GET['order_id'];

        // สถานะที่ 3 เป็นสถานะที่ไรเดอร์กดรับออร์เดอร์
        if($status == 3){
            $sql = mysqli_query($conn, "UPDATE `order_detail` SET `status` = '$status', `rider_id` = '".$_SESSION['rider_id']."' WHERE `order_id` = '$order_id' ");
            ($sql ? alert('รับออร์เดอร์สำเร็จ รอรับอาหารที่ร้านได้เลย', '../rider/status.php') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        } else {
            $sql = mysqli_query($conn, "UPDATE `order_detail` SET `status` = '$status' WHERE `order_id` = '$order_id' ");
            ($sql ? alert('อัพเดทสถานะสำเร็จ') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        }
    }

?>