<link rel="stylesheet" href="../style/form.css">

<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <form action="../system/profile_edit_db.php" class="card shadow p-3" method="post" enctype="multipart/form-data">
                <h3>
                    <a href="index.php?page=../template/profile" class="btn p-0" onclick="return confirm('ยังไม่ได้บันทึกข้อมูล ต้องการย้อนกลับหรือไม่?')"><h3>&#11148;</h3></a>
                    แก้ไขข้อมูลส่วนตัว
                    <input type="submit" class="btn text-primary float-end" name="submit" value="บันทึก">
                </h3>
                <!-- ค่าในตัวแปรต่างๆมาจากไฟล์ navbar  -->
                <input type="hidden" name="member" value="<?php echo $member ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id ?>">

                <center>
                    <div class="rounded-circle hover-img border mb-2" style="width: 7rem; height: 7rem;">
                        <img src="../upload/<?php echo $row['img'] ?>" class="img" id="preview">
                    </div>
                    <input type="file" name="img" id="img_upload" hidden>
                    <label for="img_upload" class="btn btn-outline-primary mb-4">เพิ่มรูปโปรไฟล์</label>
                </center>

                <?php if($member == 'restaurant'){ ?>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" name="res_name" value="<?php echo $row['res_name'] ?>" id="" placeholder="" required>
                        <label for="">ชื่อร้านอาหาร</label>
                    </div>
                <?php } ?>

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name'] ?>" id="" placeholder="" required>
                    <label for="">ชื่อ - นามสกุล</label>
                </div>

                <div class="form-floating mb-4 <?php form('username') ?>">
                    <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" id="" placeholder="" required>
                    <label for="">ชื่อผู้ใช้</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="text" class="form-control" name="address" value="<?php echo $row['address'] ?>" id="" placeholder="" required>
                    <label for="">ที่อยู่</label>
                </div>

                <div class="form-floating mb-4">
                    <input type="tel" class="form-control" name="phone" value="<?php echo $row['phone'] ?>" id="" placeholder="" required>
                    <label for="">เบอร์โทรศัพท์</label>
                </div>

                <?php if($member == 'restaurant'){ ?>
                    <label for="">ประเภทร้านอาหาร</label>
                    <select name="res_type" class="form-select mb-4">
                        <?php
                            $select_type = mysqli_query($conn, "SELECT * FROM `restaurant_type` ");
                            while($row_type = mysqli_fetch_array($select_type)){
                        ?>
                            <!-- 
                                ส่งค่าไอดีของประเภทร้าน 
                                และเช็คว่าไอดีประเภทร้านของร้านที่กำลังแก้ไข ตรงกับตัวที่ดึงมาไหม ถ้าตรง ก็ใส่ selected เพื่อแสดงว่าร้านนี้เป็นประเภทนั้นอยู่
                            -->
                            <option 
                                value="<?php echo $row_type['res_type_id'] ?>" 
                                <?php echo (($row['res_type_id'] == $row_type['res_type_id']) ? 'selected' : '') ?> 
                            >
                                <?php echo $row_type['res_type'] ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </form>
        </div>
    </div>
</div>

<script src="../function.js"></script>