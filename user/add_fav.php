<?php
    // จัดการรายการโปรด

    include_once 'nav.php';
    // $user_id มาจากไฟล์ nav
    
    // เพิ่มร้านโปรด
    if(isset($_GET['fav_res'])){
        $res_id = $_GET['fav_res'];
        $sql = mysqli_query($conn, "INSERT INTO `fav_res`(`res_id`, `user_id`) VALUES('$res_id', '$user_id') ");
        ($sql ? alert('บันทึกไปยังร้านโปรดแล้ว') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // นำร้านออกจากรายการโปรด
    if(isset($_GET['dis_res'])){
        $sql = mysqli_query($conn, "DELETE FROM `fav_res` WHERE `fav_id` = '".$_GET['dis_res']."' ");
        ($sql ? alert('นำออกจากร้านโปรดแล้ว') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // เพิ่มเมนูโปรด
    if(isset($_GET['fav_food'])){
        $food_id = $_GET['fav_food'];
        $res_id = $_SESSION['see_res'];
        $sql = mysqli_query($conn, "INSERT INTO `fav_food`(`food_id`, `res_id`, `user_id`) VALUES('$food_id', '$res_id', '$user_id') ");
        ($sql ? alert('บันทึกไปยังเมนูโปรดแล้ว') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

    // ลบเมนูโปรด
    if(isset($_GET['un_food'])){
        $sql = mysqli_query($conn, "DELETE FROM `fav_food` WHERE `fav_id` = '".$_GET['un_food']."' ");
        ($sql ? alert('นำออกจากเมนูโปรดแล้ว') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

?>