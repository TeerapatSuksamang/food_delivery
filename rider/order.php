<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รับออร์เดอร์</title>
</head>
<body>
    <?php
        include_once 'nav.php';
    ?>
    
    <div class="container">
        <div class="row my-5">
            <h1 class="text-center mb-3">รับออร์เดอร์</h1>
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `order_detail` WHERE `status` = 2 ");
                if($select -> num_rows > 0){
                    while($row = mysqli_fetch_array($select)){
                        $select_res = mysqli_query($conn, "SELECT * FROM `restaurant` WHERE `res_id` = '".$row['res_id']."' ");
                        $row_res = mysqli_fetch_array($select_res);
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 p-1">
                    <div class="card p-0 bg-light mb-3">
                        <div class="card-header p-2">
                            <div class="text-center">
                                <h5>ร้านอาหาร : <?php echo $row_res['res_name'] ?></h5>
                                <h6><?php echo $row_res['address'] ?></h6>
                            </div>
                        </div>

                        <div class="card-body">
                            <h6>
                                ที่อยู่ผู้สั่ง : <?php echo $row['address'] ?>
                                <span class="float-end">฿<?php echo $row['sum_price'] ?></span>
                            </h6>
                            <!-- ใส่ # เพื่อให้เมื่อเปิดหน้าร้านมาแล้วจะเลื่อนไปยังออร์เดอร์นั้นๆ -->
                            <a href="see_res.php?rider_see_res=<?php echo $row['res_id'].'#'.$row['order_id'] ?>" class="btn btn-primary w-100">ดูรายละเอียด</a>
                        </div>
                    </div>
                </div>
            <?php }} else { ?>
                <p class="text-center blockquote-footer my-3">ยังไม่มีออร์เดอร์</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>