<?php

    include_once 'nav.php';

    if(isset($_POST['submit'])){
        $bank = $_POST['bank']; // ธนาคาร
        $ac_num = $_POST['ac_num']; // เลขบัญชี
        $ac_name = $_POST['ac_name']; // ชื่อบัญชี
        // ดึงชุดคำสั่งอัพโหลดรูป เพื่ออัพโหลด qr code
        include '../upload.php';
 
        // เช็คการอัพโหลดรูป และบันทึกข้อมูลบัญชีธนาคาร
        if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
            $sql = mysqli_query($conn, "UPDATE `restaurant` SET 
            `bank` = '$bank',
            `ac_num` = '$ac_num',
            `ac_name` = '$ac_name',
            `qr_code` = '$img' WHERE `res_id` = '$res_id' ");
        } else {
            $sql = mysqli_query($conn, "UPDATE `restaurant` SET 
            `bank` = '$bank',
            `ac_num` = '$ac_num',
            `ac_name` = '$ac_name' WHERE `res_id` = '$res_id' ");
        }
        

        ($sql ? alert('อัพเดทบัญชีธนาคารสำเร็จ') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
    }

?>