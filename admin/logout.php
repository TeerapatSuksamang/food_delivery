<?php

    // ลบ session admin_id ออก แล้วกลับไปหน้าหลักของเว็บ
    session_start();
    unset($_SESSION['admin_id']);
    header('location: ../index.php');

?>