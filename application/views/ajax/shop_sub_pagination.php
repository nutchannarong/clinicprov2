<div class="row">
<?php
if ($data->num_rows() > 0) {
    $i = $segment + 1;
    foreach ($data->result() as $row) {
        ?>
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card p-2 mt-2">
                <div class="row">
                    <div class="col-4 text-center mt-2">
                        <a target="blank_" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>">
                            <img src="<?php echo admin_url() . "assets/upload/shop/" . $row->shop_image; ?>" alt="" width="100%" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                        </a>
                        <br>
                    </div>
                    <div class="col-8 mt-2">
                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>" style="font-size: 20px;"><?php echo $row->shop_name; ?></a><br>
                        <a class="text-muted" href="<?php echo base_url(); ?>"><?php echo $row->shop_nature_name; ?></a>
                        <div class="row mt-4">
                            <div class="col-xl-8">
                                <p>
                                    ที่อยู่ : <?php echo $row->shop_address; ?>
                                    ตำบล<?php echo $row->shop_district; ?>
                                    อำเภอ<?php echo $row->shop_amphoe; ?>
                                    จังหวัด<?php echo $row->shop_province; ?>
                                    รหัสไปรษณีย์ <?php echo $row->shop_zipcode; ?>
                                </p>
                            </div>
                            <div class="col-xl-4">
                                <a href="<?php echo 'https://maps.google.com/?daddr=' . $row->shop_latlong; ?>" target="_blank">
                                    <img src="<?php echo base_url() . 'assets/img/map.png'; ?>" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
} else {
    ?>
    <div class="col">
        <h5 class="text-center mt-5"><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
    </div>
    <?php
}
?>
</div>
<div class="row mt-5">
    <?php
    if ($count != 0) {
        ?>
        <div class="col-sm-4">
            แสดง <?php echo $segment + 1; ?> ถึง <?php echo $i - 1; ?> ทั้งหมด <?php echo($count); ?> รายการ
        </div>
        <div class="col-sm-8" style="float: right">
            <?php echo $links; ?>
        </div>
        <?php
    }
    ?>
</div>
<style>
    .pro-view-shop{
        position: absolute;
        top: 3%;
        right: 10%;
        color: black;
    }
    .pro-birthday{
        position: absolute;
        bottom: 10%;
        right: 10%;
        color: black;
    }
</style>