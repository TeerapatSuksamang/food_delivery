<link rel="stylesheet" href="../style/form.css">

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <form action="../system/password_edit_db.php" class="card shadow p-3" method="post" enctype="multipart/form-data">
                <h1 class="text-center mb-4">เปลี่ยนรหัสผ่าน</h1>
                <!-- 3ค่านี้จะมาจากไฟล์ navbar ของแต่ละประเภทผู้ใช้  -->
                <input type="hidden" name="member" value="<?php echo $member ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id ?>">
                <input type="hidden" name="password" value="<?php echo $row['password'] ?>">

                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="old_pass" id="pass" placeholder="" required>
                    <label for="">รหัสผ่านเก่า</label>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="new_pass" id="pass" placeholder="" required>
                    <label for="">รหัสผ่านใหม่</label>
                </div>

                <div class="mb-4">
                    <input type="checkbox" class="form-check-input" id="show" onclick="showpass();">
                    <label for="show">แสดงรหัสผ่าน</label>
                </div>

                <div class="d-flex gap-3">
                    <a href="index.php?page=../template/profile" class="btn btn-outline-danger w-100">ย้อนกลับ</a>
                    <input type="submit" class="btn btn-success w-100" name="submit" value="ยืนยัน">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../function.js"></script>