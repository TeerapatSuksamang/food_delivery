<link rel="stylesheet" href="../style/form.css">

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <form action="" class="card shadow p-3" method="post" enctype="multipart/form-data">
                <h3>
                    ข้อมูลส่วนตัว
                    <a href="index.php?page=../template/profile_edit" class="btn text-primary float-end">แก้ไข</a>
                </h3>
                <!-- ค่าในตัวแปรต่างๆมาจากไฟล์ navbar  -->
                <input type="hidden" name="member" value="<?php echo $member ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id ?>">

                <center>
                    <div class="rounded-circle hover-img border mb-2" style="width: 7rem; height: 7rem;">
                        <img src="../upload/<?php echo $row['img'] ?>" class="img">
                    </div>
                    <a href="index.php?page=../template/password_edit" class="btn btn-warning mb-4">เปลี่ยนรหัสผ่าน</a>
                </center>

                <?php if($member == 'restaurant'){ ?>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="res_name" value="<?php echo $row['res_name'] ?>" id="" placeholder="" readonly>
                        <label for="">ชื่อร้านอาหาร</label>
                    </div>
                <?php } ?>

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name'] ?>" id="" placeholder="" readonly>
                    <label for="">ชื่อ - นามสกุล</label>
                </div>

                <div class="form-floating mb-4 <?php form('username') ?>">
                    <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" id="" placeholder="" readonly>
                    <label for="">ชื่อผู้ใช้</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="address" value="<?php echo $row['address'] ?>" id="" placeholder="" readonly>
                    <label for="">ที่อยู่</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="tel" class="form-control" name="phone" value="<?php echo $row['phone'] ?>" id="" placeholder="" readonly minlength="10" maxlength="10" pattern="[0-9]{10}">
                    <label for="">เบอร์โทรศัพท์</label>
                </div>

                <?php if($member == 'restaurant'){ ?>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="<?php echo $row['res_type_id'] ?>" value="<?php echo $row['res_type'] ?>" id="" placeholder="" readonly>
                        <label for="">ประเภทร้านอาหาร</label>
                    </div>
                <?php } ?>

                <!-- 
                    เรียกใช้ function confirm เพื่อเรียกใช้ modal 
                    และเก็บค่าที return ลง $target เพื่อเอาไปใส่ใน data-bs-target="" เพื่อให้เปิด modal ได้ถูกต้อง
                    กรณีในแค่ต้องการให้ไปไฟล์ logout เลยไม่ต้องใส่ $get และ $id
                -->
                <?php $target = confirm('logout.php', '', '', 'ต้องการออกจากระบบหรือไม่?'); ?>
                <a class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="<?php echo $target ?>">ออกจากระบบ</a>

            </form>
        </div>
    </div>
</div>

<script src="../function.js"></script>