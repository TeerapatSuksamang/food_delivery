<?php

    include_once '../db.php';
    include_once '../template/load.html';

    if(isset($_POST['submit'])){
        $member = $_POST['member']; // ประเภทผู้ใช้
        $member_id = $_POST['member_id']; // ชื่อ column id ตามประเภทผู้ใช้
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        include '../upload.php';

        // เลือกชื่อผู้ใช้ที่ซ้ำกับที่กรอกมา โดยไม่เอาไอดีของผู้ใช้ที่ล็อคอินใช้งานอยู่ตอนนี้ 
        $select = mysqli_query($conn, "SELECT * FROM `$member` WHERE `username` = '$username' AND `$member_id` != '".$_SESSION[$member_id]."' ");

        if($select -> num_rows > 0){
            alert('ขออภัย ชื่อผู้ใช้นี้ถูกใช้งานแล้ว');
        } else {
            // เก็บคำสั่ง sql ที่จะอัพเดทข้อมูล
            $sql = "`full_name` = '$full_name',
                `username` = '$username', 
                `address` = '$address', 
                `phone` = '$phone' ";

            // ถ้ามีการอัพโหลดรูป
            if(move_uploaded_file($_FILES['img']['tmp_name'], $path)){
                // เพิ่มคำสั่งนี้ลงในตัวแปรด้วย
                $sql .= ", `img` = '$img' ";
            }

            // ถ้าเป็นร้าน จะรับข้อมูลของร้านเพิ่ม
            if($member == 'restaurant'){
                $res_name = $_POST['res_name'];
                $res_type = $_POST['res_type'];
                // เพิ่มคำสั่งอัพเดทข้อมูลของร้าน
                $sql .= ", `res_name` = '$res_name', `res_type_id` = '$res_type' ";
            }

            // อัพเดทข้อมูลตามประเภทผู้ใช้ โดยเอาชุดคำสั่งที่เก็บไว้ในตัวแปร $sql มาใส่ เพื่อลดความซ้ำซ้อนของโค้ด และไม่ต้องเขียน if else หลายรอบ
            $sql = mysqli_query($conn, "UPDATE `$member` SET $sql WHERE `$member_id` = '".$_SESSION[$member_id]."' ");

            // ถ้าอัพเดทสำเร็จ กลับไปหน้าโปรไฟล์ของแต่ละประเภทผู้ใช้
            ($sql ? alert('แก้ไขข้อมูลส่วนตัวสำเร็จ', '../'.$member.'/index.php?page=../template/profile') : alert('ขออภัย เกิดข้อผิดพลาด กรุณาลองอีกครั้งในภายหลัง'));
        }
    }

?>