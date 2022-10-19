<div class="row">
<?php
if ($data->num_rows() > 0) {
    $i = $segment + 1;
    foreach ($data->result() as $row) {
        ?>
        <div class="col-md-6 col-lg-6 col-xl-6 mt-3">
            <div class="card">
                <div class="row">
                    <div class="col-5">
                        <?php
                        if ($row->product_percent > 0) {
                            ?>
                            <div class="ribbon-pink-col">
                                <span><?php echo number_format($row->product_percent, 0); ?>% ส่วนลด</span>
                            </div>
                        <?php } ?>
                        <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row->product_slug; ?>">
                            <span class="pro-view-shop"><i class="fa fa-eye me-2"></i> <?php echo number_format($row->product_view);?></span>
                            <img srcset="<?php echo admin_url() . 'images?src=' . admin_url() . 'assets/upload/product/' . $row->product_image. '&w=190&h=150'; ?>"  alt="" width="100%">
                        </a>
                    </div>
                    <div class="col-7">
                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url().'promotion/'.$row->product_slug; ?>" style="font-size: 16px;"> <?php echo (strlen($row->product_name) > 30 ) ? mb_substr($row->product_name, 0, 30, 'UTF-8') . '...' : $row->product_name; ?></a>
                        <div class="row pr-3">
                            <div class="col-lg mt-2">
                            <span class="" style="font-size: 15px; color:#ffd333;">
                                <?php echo $this->misc->rating($row->product_rating); ?>
                            </span>
                                <span class="text-secondary"><?php echo number_format($row->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row->product_id)); ?>  รีวิว </span>
                                <div class="text-secondary mt-2" ><?php echo $row->shop_nature_name; ?></div>
                            </div>
                        </div>
                        <div style="color: #FF2C64;">ได้รับแต้มคืน <?php echo number_format($row->product_point); ?> แต้ม</div>
                        <div class="product-card__footer">
                            <div class="product-card__prices">
                                <div class="product-card__prices">
                                    <?php
                                    if ($row->product_price > $row->product_total) {
                                        ?>
                                        <span class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row->product_total); ?> บาท</span>
                                        <span class="text-secondary" style="text-decoration: line-through; font-size: 13px;">฿<?php echo number_format($row->product_price); ?> บาท</span>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row->product_total); ?> บาท</div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php if($row->product_group_id == 2){ ?>
                                    <div class="pro-birthday">
                                        <div style="background: #0069FD; border-radius: 50%;">
                                            <i class="fa fa-birthday-cake p-2 text-white me-2"></i>
                                        </div>
                                    </div>
                                <?php }?>
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
    <div class="col text-center mt-5">
        <h5><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5>
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