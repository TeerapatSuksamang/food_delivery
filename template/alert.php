<!-- โค้ดนี้รับข้อมูล session จาก function alert()  -->
<div class="toast show fade position-fixed we-toast shadow bg-light">
    <!-- แสดง bg- ที่ต่อกับ session c ซึ่งเก็บชื่อสีของคลาส bootstrap  -->
    <div class="toast-header bg-<?php echo $_SESSION['c'] ?> text-<?php echo ($_SESSION['c'] == 'warning' ? 'dark' : 'light') ?>">
        <h5 class="me-auto">แจ้งเตือน</h5>
        <small>เมื่อสักครู่</small>
        <button type="button" class="btn-close we-close" onclick="hide();"></button>
    </div>

    <!-- เส้นนับเวลาถอยหลัง -->
    <div class="timer-container">
        <div class="timer"></div>
    </div>

    <!-- กล่องแสดงข้อความแจ้งเตือน -->
    <div class="toast-body">
        <h6><?php echo $_SESSION['alert'] ?></h6>
    </div>
</div>

<script>
    // กดเพื่อปิดแจ้งเตือน
    function hide(){
        // เพิ่มคลาสใน css ที่จะเล่นอนิเมชั่น เด้งกลับขึ้นไป
        const toast = document.querySelector('.toast');
        toast.classList.add('we-hide');
    }
</script>