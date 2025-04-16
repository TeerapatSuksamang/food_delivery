<?php

    include_once '../db.php';
    include_once '../template/load.html';

    if(isset($_POST['submit'])){
        $member = $_POST['member']; // ประเภทผู้ใช้
        $member_id = $_POST['member_id']; // ชื่อ column id ตามประเภทผู้ใช้
        $password = $_POST['password']; // รหัสผ่านเดิมจากฐานข้อมูล
        $old_pass = $_POST['old_pass']; // รหัสผ่านเดิมที่ผู้ใช้กรอก เพื่อเอามาเช็ค
        $new_pass = password_hash($_POST['new_pass'], PASSWORD_BCRYPT); // เข้ารหัสให้รหัสผ่านใหม่

        if($member == 'admin'){
            // ใส่ danger ใน function เพื่อแสดงสีแดงตอนแจ้งเตือน
            alert('ไม่อนุญาติให้เปลี่ยนรหัสผ่านในระบบทดลอง', '', '', 'danger');
        } else if(password_verify($old_pass, $password)){ // ตรวจสอบรหัสผ่านเดิมที่กรอก กับในฐานข้อมูลว่าตรงกันไหม
            // อัพเดทตามประเภทผู้ใช้ที่รับข้อมูลมา
            $sql = mysqli_query($conn, "UPDATE `$member` SET `password` = '$new_pass' WHERE `$member_id` = '".$_SESSION[$member_id]."' ");
            ($sql ? alert('แก้ไขรหัสผ่านสำเร็จ', '../'.$member.'/index.php?page=../template/profile') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        } else {
            alert('รหัสผ่านเก่าไม่ถูกต้อง');
        }
    }

?>