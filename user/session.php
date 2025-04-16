<?php

    include_once '../db.php';
    if(!isset($_SESSION['user_id'])){
        alert('กรุณาเข้าสู่ระบบก่อนใช้งาน', '../login.php?member=user');
        end();
    }

?>