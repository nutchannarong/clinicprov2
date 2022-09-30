<div class="row">
    <?php
    $i = $segment + 1;
    if ($datas->num_rows() > 0) {
        foreach ($datas->result() as $data) {
            $lat_long = $data->shop_latlong;
            $latlong = explode(",", $lat_long);
            $lat2 = $latlong[0];
            $lon2 = $latlong[1];
            $r = $this->search_model->distance($lat1, $lon1, $lat2, $lon2);
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12" style="padding: 4px 4px 6px 6px;">
                <a href="<?php echo base_url() . 'shop/' . $data->shop_id; ?>" target="_blank">
                    <div class="row" style="margin: 0px 4px 0px 4px; background-color: whitesmoke;min-width: 360px;min-height: 126px;">
                        <div class="col-4 text-center" style="padding: 10px 6px 6px 6px;">
                            <img src="<?php echo admin_url() . 'assets/upload/shop/' . $data->shop_image; ?>" class="card-img-top" style="height: 100px;width: 100px;" alt="<?php echo $data->shop_name; ?>" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                        </div>
                        <div class="col-8"  style="padding: 5px 5px 5px 8px;">
                            <div class="card-text" style="color: dodgerblue; padding-bottom: 0px;"><h1 style="font-size: 18px;"><?php echo $data->shop_name; ?></h1></div>
                            <div class="card-text" style="color: #e83e8c; padding-bottom: 0px; font-weight: bold; font-size: 11px;"><h4 style="font-size: 14px;"><?php echo $data->shop_nature_name . ' ' . 'ระยะทาง ' . number_format($r, 0) . ' กม.'; ?></h4></div>
                            <div class="card-text" style="color: black;  padding-bottom: 0px; font-size: 11px;"><?php echo 'ที่อยู่ : ' . $data->shop_address . ' ตำบล : ' . $data->shop_district; ?></div>
                            <div class="card-text" style="color: black;  padding-bottom: 0px; font-size: 11px;"><?php echo 'อำเภอ : ' . $data->shop_amphoe . ' จังหวัด : ' . $data->shop_province; ?></div>
                            <div class="card-text" style="color: black; padding-bottom: 0px; font-size: 11px;"><?php echo 'รหัสไปรษณีย์ : ' . $data->shop_zipcode; ?></div>
                            <div class="card-text" style="padding-bottom: 0px; font-size: 11px;"><?php echo number_format($this->search_model->countShopCourse($data->shop_id_pri)->num_rows(), 0) . ' คอร์ส, ' . number_format($this->search_model->countShopCustomer($data->shop_id_pri)->num_rows(), 0) . ' ผู้ใช้งาน'; ?></div>
                            <div class="card-text" style="text-align: right;">
                                <a target="_blank" href="<?php echo 'https://maps.google.com/?daddr=' . $data->shop_latlong; ?>">
                                    <button type="button" class="btn btn-sm btn-danger"
                                            style="background-color: #F654A0 !important;
                                            border-color: #e9588f;
                                            border-radius: 5px;
                                            font-size: 12px;
                                            color: #fff !important;">การนำทาง</button>
                                </a>
                                <a href="<?php echo 'tel:' . $data->shop_tel; ?>">
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            style="background-color: #F654A0 !important;
                                            border-color: #e9588f;
                                            border-radius: 5px;
                                            font-size: 12px;
                                            color: #fff !important;">
                                        โทร
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php
            $i++;
        }
    } else {
        ?>
        <div class="col-sm-12 text-center">
            <p style="font-size: 26px; color: darkgray;"><i class="fa fa-database text-"danger></i>&nbsp;<span style="font-size: 26px; color: darkgray;">ไม่พบข้อมูล</span></p>
        </div>
    <?php }
    ?>
</div>
<div class="row" style="margin-top: 20px;">
    <?php
    if ($count != 0) {
        ?>
        <div class="col-sm-5 text-left" style="vertical-align: middle;">
            แสดง <?php echo $segment + 1; ?> ถึง <?php echo $i - 1; ?> ทั้งหมด <?php echo ($count); ?> รายการ
        </div>
        <div class="col-sm-7 text-right" style="vertical-align: middle;">
            <?php echo $links; ?>
        </div>
        <?php
    }
    ?>
</div>