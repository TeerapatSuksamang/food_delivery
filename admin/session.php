<?php

    include_once '../db.php';
    // ถ้าไม่มี session admin_id ก็คือ ไม่มีการล็อคอิน ก็จะแจ้งเตือนแล้วเด้งไปหน้าล็อคอินของ admin
    if(!isset($_SESSION['admin_id'])){
        alert('กรุณาเข้าสู่ระบบก่อนใช้งาน', '../login.php?member=admin');
        end();
    }

?>