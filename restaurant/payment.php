<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตัวเลือกชำระเงิน</title>
    <link rel="stylesheet" href="../style/form.css">

</head>
<body>
    <?php
        include_once 'nav.php';
    ?>

    <div class="container">
        <div class="row justify-content-center my-5">
            <h1 class="text-center">บัญชีธนาคาร</h1>
            <div class="col-md-6">
                <form action="payment_db.php" class="card shadow p-3" method="post" enctype="multipart/form-data" onchange="form_change();">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="hover-img border h-auto w-100" style="aspect-ratio: 1/1;">
                                <label for="img_upload" class="w-100 h-100" style="cursor: pointer;">
                                    <img src="../upload/<?php echo $row['qr_code'] ?>" class="img bg-secondary" id="preview">
                                </label>
                                <input type="file" name="img" id="img_upload" hidden>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="bank" value="<?php echo $row['bank'] ?>" id="" placeholder="" required>
                                <label for="">บัญชีธนาคาร</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="ac_num" value="<?php echo $row['ac_num'] ?>" id="" placeholder="" required>
                                <label for="">เลขบัญชี</label>
                            </div>
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="ac_name" value="<?php echo $row['ac_name'] ?>" id="" placeholder="" required>
                                <label for="">ชื่อบัญชี</label>
                            </div>

                            <input type="submit" class="btn btn-primary w-100" name="submit" value="ยืนยันการเปลี่ยนแปลง" disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../function.js"></script>
</body>
</html>