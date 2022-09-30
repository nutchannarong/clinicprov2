<div class="row">
    <?php
    if ($data->num_rows() > 0) {
        $i = $segment + 1;
        foreach ($data->result() as $row) {
            ?>
            <div class="col-md-4 col-lg-4 col-xl-3 mt-3">
                <div class="block-products-carousel__column">
                    <div class="block-products-carousel__cell">
                        <div class="product-card product-card--layout--grid">
                            <div class="product-card__image">
                                <?php
                                if ($row->product_percent > 0) {
                                    ?>
                                    <div class="ribbon-pink">
                                        <span><?php echo number_format($row->product_percent, 0); ?>% ส่วนลด</span>
                                    </div>
                                <?php } ?>
                                <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row->product_slug; ?>">
                                    <img src="<?php echo admin_url() . 'assets/upload/product/' . $row->product_image; ?>" width="100%">
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__meta">
                                    <a class="text-muted" href="javascript:void(0)"><?php echo $row->shop_nature_name; ?></a>
                                    <span style="float: right"><i class="fa fa-eye"></i> <?php echo number_format($row->product_view); ?></span>
                                </div>
                                <div class="product-card__name mt-2">
                                    <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'promotion/' . $row->product_slug; ?>" style="font-size: 16px;"> <?php echo (strlen($row->product_name) > 20 ) ? mb_substr($row->product_name, 0, 20, 'UTF-8') . '...' : $row->product_name; ?></a>
                                </div>
                                <div class="row pl-3 pr-3">
                                    <div class="col-lg mt-2">
                                        <span class="" style="font-size: 13px; color:#ffd333;">
                                            <?php echo $this->misc->rating($row->product_rating); ?>
                                        </span>
                                        <span class="text-secondary" style="font-size: 12px;"><?php echo number_format($row->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row->product_id)); ?>  รีวิว </span>
                                    </div>
                                </div>
                                <span class="pl-3 pr-3 mt-2" style="color: #FF2C64; font-size: 12px;">ได้รับแต้มคืน <?php echo number_format($row->product_point); ?> แต้ม</span>
                            </div>
                            <div class="product-card__footer">
                                <div class="product-card__prices">
                                    <?php
                                    if ($row->product_price > $row->product_total) {
                                        ?>
                                        <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row->product_total); ?> บาท</div>
                                        <div class="product-card__price product-card__price--old">฿<?php echo number_format($row->product_price); ?> บาท</div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row->product_total); ?> บาท</div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php if ($row->product_group_id == 2) { ?>
                                    <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row->product_slug; ?>" class="product-card__addtocart-icon" type="button" aria-label="Add to cart">
                                        <i class="fa fa-birthday-cake "></i>
                                    </a>
                                <?php } ?>
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