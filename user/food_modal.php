<!-- ไฟล์นี้สำหรับแสดง modal เมื่อกดจาก food_item.php -->
<form action="add_cart.php" class="modal fade" id="see_food_<?php echo $row['food_id'] ?>" method="post" enctype="multipart/form-data" onmousemove="up_<?php echo $row['food_id'] ?>()">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $row['food_name'] ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <img src="../upload/<?php echo $row['img'] ?>" class="img" style="max-height: 20rem;">

            <div class="modal-body">
                <h6>
                    <?php
                        // เช็คส่วนลด แล้วเก็บราคาลง $price เพื่อเอาไปคำนวนต่อใน function
                        if($row['discount'] != 0){
                            $price = discount($row['price'], $row['discount']);
                    ?>
                        <s class="text-secondary">฿<?php echo $row['price'] ?></s>
                        <span class="text-success">฿<?php echo discount($row['price'], $row['discount']) ?></span>
                        <span class="text-danger">(ลด - <?php echo $row['discount'] ?>%)</span>
                    <?php } else {
                            $price = $row['price'];
                            echo '฿'.$price;
                        }
                    ?>
                </h6>

                <!-- ปุ่มเพิ่มลดจำนวน ในฟังก์ชั่น ใช้ php แสดงไอดีของเมนูต่อท้ายเพื่อให้ใช้ฟังก์ชั่นเฉพาะกับเมนูที่กำลังเลือกเท่านั้น -->
                <div class="d-flex gap-2">
                    <p class="btn btn-warning" onclick="minus_<?php echo $row['food_id'] ?>()">➖</p>
                    <input type="number" min="1" max="100" class="form-control h-25" name="qty" id="qty_<?php echo $row['food_id'] ?>" value="1" required>
                    <p class="btn btn-primary" onclick="plus_<?php echo $row['food_id'] ?>()">➕</p>
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="food_id" value="<?php echo $row['food_id'] ?>">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <input type="submit" class="btn btn-success" name="add_cart" id="sum_<?php echo $row['food_id'] ?>" value="เพิ่มลงตะกร้า ฿<?php echo $price ?>">
            </div>
        </div>
    </div>
</form>

<script>
    // function ที่สร้างในหน้านี้จะต่อท้ายชื่อด้วยไอดีของเมนูนั้นๆ เพราะหน้านี้กำลังถูกวนลูป จะได้เรียกฟังก์ชั่นได้ถูกต้องไม่ซ้ำกัน 
    // ตัวอย่างเช่น plus_< ?php echo $row['food_id'] ?>() แล้วไอดีของเมนูที่กำลังแสดงคือ5 ผลลัพธ์ที่ออกมาคือ plus_5()

    // เพิ่มจำนวน
    function plus_<?php echo $row['food_id'] ?>(){
        // รับจำนวนปัจจุบันจาก input#qty_ ซึ่งต่อกับ < ?php echo $row['food_id'] ?> ก็จะรับจากไอดีของเมนูนั้นๆ (เช่น qty_5)
        var input = document.getElementById('qty_<?php echo $row['food_id'] ?>');
        var input_value = parseInt(input.value); // แปลงเป็นเลขจำนวนเต็ม
        input.value = input_value + 1; // เพิ่มจากค่าเดิมมา 1 แล้วใส่ค่าใน input

        // อัพเดทผลรวม
        var sum = document.getElementById('sum_<?php echo $row['food_id'] ?>');
        // เอาจำนวนที่พึ่งเพิ่มเมื่อกี้ มาคูณกับ ราคาที่ได้เช็คส่วนลดแล้วจากใน php แล้วกำหนดค่าลง input นี้
        sum.value = "เพิ่มลงตะกร้า ฿" + (input.value * <?php echo $price ?>);
    }

    // ลดจำนวน
    function minus_<?php echo $row['food_id'] ?>(){
        var input = document.getElementById('qty_<?php echo $row['food_id'] ?>');
        var input_value = parseInt(input.value);
        // เช็คไม่ให้จำนวนต่ำกว่า 1
        if(input_value > 1){
            input.value = input_value - 1;
        }

        var sum = document.getElementById('sum_<?php echo $row['food_id'] ?>');
        sum.value = "เพิ่มลงตะกร้า ฿" + (input.value * <?php echo $price ?>);
    }

    // อัพเดทราคาเมื่อขยับเมาส์กรณีที่กรอกเลขเองในช่อง input (ไม่ค่อยเหมาะสม แต่อยากให้ดูเหมือนว่าราคาอัพเดททันทีหลังกรอก ในการแข่งมี ajax ให้ใช้ แต่กลัวทำไม่ทันจึงใช้วิธีนี้)
    // * ผมคิดตั้งนาน กรรมการไม่ถามตรงนี้เลยอะจ้ารรรร
    function up_<?php echo $row['food_id'] ?>(){
        var input = document.getElementById('qty_<?php echo $row['food_id'] ?>');
        var input_value = parseInt('input.value');

        var sum = document.getElementById('sum_<?php echo $row['food_id'] ?>');
        sum.value = "เพิ่มลงตะกร้า ฿" + (input.value * <?php echo $price ?>);
    }
</script>