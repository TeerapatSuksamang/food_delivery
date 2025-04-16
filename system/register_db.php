<?php

    include_once '../db.php';
    include_once '../template/load.html';


    if(isset($_POST['submit'])){
        $member = $_POST['member']; // ประเภทผู้ใช้
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        // เข้ารหัสให้รหัสผ่าน
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        include '../upload.php';

        // เช็คชื่อซ้ำที่มีในประเภทผู้ใช้นั้นๆ
        $select = mysqli_query($conn, "SELECT * FROM `$member` WHERE `username` = '$username' ");
        if($select -> num_rows > 0){
            alert('ชื่อผู้ใช้งานซ้ำ กรุณาเปลี่ยนใหม่', '', 'username');
        } else {
            // เก็บคำสั่ง sql ลงตัวแปร
            $c = "`full_name`, `username`, `password`, `address`, `phone` "; // column
            $v = "'$full_name', '$username', '$password', '$address', '$phone' "; // value

            // ถ้ามีการอัพโหลดรูป
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                // เพิ่มคำสั่งนี้ลงในตัวแปรด้วย
                $c .= ", `img` ";
                $v .= ", '$img' ";
            }

            // ถ้าเป็นร้าน จะรับข้อมูลของร้านเพิ่ม
            if($member == 'restaurant'){
                $res_name = $_POST['res_name'];
                $res_type = $_POST['res_type'];
                $c .= ", `res_name`, `res_type_id` ";
                $v .= ", '$res_name', '$res_type' ";
            }

            $sql = mysqli_query($conn, "INSERT INTO `$member`($c) VALUES($v) ");

            ($sql ? alert('สมัครใช้งานสำเร็จ รอนุมัติการใช้งานสักครู่', '../login.php?member='.$member) : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));

        }
    }

?>