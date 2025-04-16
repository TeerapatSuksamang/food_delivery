<?php

    include_once '../db.php';
    include_once '../template/load.html';

    if(isset($_POST['submit'])){
        $member = $_POST['member']; // ประเภทผู้ใช้ เป็นชื่อเดียวกับตารางในฐานข้อมูล
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // นำชื่อประเภทผู้ใช้มาต่อกับ _id ถ้าเป็นร้าน จะให้เป็น res_id 
        $member_id = ($member == 'restaurant' ? 'res_id' : $member.'_id'); // เก็บ column id ของแต่ละประเภทผู้ใช้
        /* เพราะไอดีของแต่ละผู้ใช้จะเป็น user_id , rider_id , res_id เลยเอาชื่อประเภทผู้ใช้มาต่อสตริงกับ _id 
            เวลาแข่งมีจำกัด ผมจึงใช้วิธีนี้แทนการใช้ if else เช็คทีละประเภทผู้ใช้
        */


        // เช็คว่าชื่อที่ส่งมา มีในตารางของประเภทผู้ใช้นั้นไหม
        $select = mysqli_query($conn, "SELECT * FROM `$member` WHERE `username` = '$username' ");

        if($select -> num_rows > 0){
            // ถ้ามีก็จะนำข้อมูลมาใส่ใน row 
            $row = mysqli_fetch_array($select);
            
            // เช็ครหัสผ่านว่าที่กรอกมา ตรงกับในฐานข้อมูลไหม
            if(password_verify($password, $row['password'])){
                if($member == 'admin'){
                    // เก็บไอดีของ admin ไว้ใน session แล้วไปหน้าหลักของ admin
                    $_SESSION['admin_id'] = $row['admin_id'];
                    alert('เข้าสู่ระบบสำเร็จ', '../admin/index.php');
                } else {
                    // ถ้าไม่ใช่แอดมิน จะมาเช็คสถานะว่าถูกยกเลิก หรืออนุมัติการใช้งานแล้ว
                    if($row['status'] == 1){
                        // เก็บไอดีของผู้ใช้ตามประเภทนั้นๆ ลงใน session (เช่น rider_id, res_id, user_id)
                        $_SESSION[$member_id] = $row[$member_id];
                        // แล้วไปยังหน้าแรกของโฟลเดอร์ของประเภทผู้ใช้นั้นๆที่ได้ล็อคอินเข้ามา
                        alert('เข้าสู่ระบบสำเร็จ', '../'.$member.'/index.php');
                    } else {
                        // เช็คว่าแอดมินเพิ่มหมายเหตุการระงับการใช้งานมาไหม
                        if($row['note'] != NULL){
                            alert('ถูกระงับการใช้งาน หมายเหตุ: '.$row['note']);
                        } else {
                            alert('ยังไม่ได้รับอนุมัติการใช้งาน');
                        }
                    }
                }
            } else {
                // ใส่ password ใน function เพื่อเก็บลงใน session form เมื่อย้อนกลับไปหน้าก่อนหน้าที่เป็นหน้า Login ก็จะไฮไลท์ในช่อง password
                alert('รหัสผ่านไม่ถูกต้อง', '', 'password');
            }
        } else {
            alert('ชื่อผู้ใช้ไม่ถูกต้อง', '', 'username');
        }
    }

?>