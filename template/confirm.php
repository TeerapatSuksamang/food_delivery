<!-- โค้ดนี้ถูกใช้ใน function confirm() -->
<!-- ใน id จะนำ get ต่อกับไอดี ที่มาจากตอนเรียกใช้ function เพื่อระบุในตอนเรียกใช้ modal -->
<div class="modal fade" id="id_<?php echo $get.$id ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- แสดงข้อความแจ้งเตือน -->
                <h4><?php echo $msg ?></h4>
            </div>
            <div class="modal-body d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">ยกเลิก</button>
                <!-- ไฟล์ที่จะให้ส่งไปทำงาน พร้อมส่ง get และค่าไอดีที่ต้องการให้ถูกทำงาน -->
                <a href="<?php echo $action.'?'.$get.'='.$id ?>" class="btn btn-success w-100">ยืนยัน</a>
                <!-- เช่นปุ่มลบคูปองที่หน้า web_manage.php ก็จะส่งค่าเป็น web_manage_db.php?del_cpn=5 เป็นต้น -->
            </div>
        </div>
    </div>
</div>