<div class="row">
    <?php
    if ($data->num_rows() > 0) {
        $i = $segment + 1;
        foreach ($data->result() as $row) {
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 mt-3" style="padding-right: 5px;min-height: 380px;">
                <div class="block-products-carousel__column">
                    <div class="block-products-carousel__cell">
                        <div class="product-card product-card--layout--grid">
                            <div class="product-card__image">
                                <div style="position: absolute;right: 5%;bottom: 5%; z-index: 1;">
                                    <span class="" style="font-size: 13px; color:#ffd333;">
                                        <?php echo $this->misc->rating(round($row->rating)); ?>
                                    </span>
                                </div>
                                <a target="blank_" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>">
                                    <img src="<?php echo admin_url() . "assets/upload/shop/" . $row->shop_image; ?>" alt="<?php echo $row->shop_nature_name; ?>" style="padding: 10px;" width="100%" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__meta">
                                    <a class="text-muted" href="<?php echo base_url(); ?>"><?php echo $row->shop_nature_name; ?></a>
                                    <span style="float: right">
                                        <?php echo number_format(round($row->rating)); ?> จาก <?php echo number_format($row->count_rating); ?> รีวิว
                                    </span>
                                </div>
                                <div class="product-card__name mt-2">
                                    <a class="mt-2 text-primary" target="blank_"
                                       href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>"
                                       style="font-size: 16px;"><?php echo $row->shop_name; ?></a>
                                </div>
                            </div>
                            <div class="product-card__footer">
                                <div class="row" style="min-height: 90px;">
                                    <div class="col-xl-9 col-md-8" style="padding-right: 2px;">
                                        <p style="font-size: 12px;margin-bottom: 5px;">
                                            ที่อยู่ : <?php echo $row->shop_address; ?>
                                            ตำบล<?php echo $row->shop_district; ?>
                                            อำเภอ<?php echo $row->shop_amphoe; ?>
                                            จังหวัด<?php echo $row->shop_province; ?>
                                            รหัสไปรษณีย์ <?php echo $row->shop_zipcode; ?>
                                        </p>
                                    </div>
                                    <div class="col-xl-3 col-md-4">
                                        <a href="<?php echo 'https://maps.google.com/?daddr=' . $row->shop_latlong; ?>" target="_blank">
                                            <img src="<?php echo base_url() . 'assets/img/map.png'; ?>" width="35px">
                                        </a>
                                    </div>
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
            <div class="text-center mt-5">
                <h5><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
            </div>
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
<script>
    $(function () {
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        })
    })
</script>