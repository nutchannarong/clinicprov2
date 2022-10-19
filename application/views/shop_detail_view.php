<div class="site__body mb-5">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3, 5);
                    if ($slides->num_rows() > 0) {
                        $s_r = 0;
                        foreach ($slides->result() as $slide_r) {
                            ?>
                            <a class="block-slideshow__item"
                               href="<?php echo($slide_r->slideshow_link != '' ? $slide_r->slideshow_link : 'javascript:void(0);'); ?>" <?php echo($slide_r->slideshow_open_link == 2 ? 'target="_blank"' : ''); ?>
                               title="<?php echo $slide_r->slideshow_name; ?>">
                                <span class="block-slideshow__item-image block-slideshow__item-image--desktop" style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image != '' ? $slide_r->slideshow_image : 'none.png'); ?>')"></span>
                                <span class="block-slideshow__item-image block-slideshow__item-image--mobile" style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image_half != '' ? $slide_r->slideshow_image_half : 'none-half.png'); ?>')"></span>
                            </a>
                            <?php
                            $s_r++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="block-split mt-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4 mt-2">
                            <div class="text-center">
                                <img src="<?php echo admin_url() . "assets/upload/shop/" . $row_shop['shop_image']; ?>" alt="" width="70%" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';" class="text-center">
                            </div>
                            <div class="ml-2 mt-4" style="font-size: 16px;">
                                <span>ชื่อร้าน : <?php echo $row_shop['shop_name']; ?></span><br>
                                <span>ลักษณะการให้บริการ : <?php echo $row_shop['shop_nature_name']; ?></span><br>
                                <span>เลขที่ใบอนุญาติ : <?php echo $row_shop['shop_license']; ?></span><br>
                                <span>โทร : <?php echo $row_shop['shop_tel']; ?></span><br>
                                <span>อีเมล : <?php echo $row_shop['shop_email']; ?></span><br>
                                <span>
                                    ที่อยู่ : <?php echo $row_shop['shop_address']; ?>
                                    ตำบล<?php echo $row_shop['shop_district']; ?>
                                    อำเภอ<?php echo $row_shop['shop_amphoe']; ?>
                                    จังหวัด<?php echo $row_shop['shop_province']; ?>
                                    รหัสไปรษณีย์ <?php echo $row_shop['shop_zipcode']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-xl-8 mt-4">
                            <ul id="lightSlider" class="lightSlider">
                                <?php
                                $shop_image = array();
                                for ($i = 1; $i <= 6; $i++) {
                                    if ($row_shop['shop_image' . $i] != null) {
                                        $shop_image[] = admin_url() . 'assets/upload/shop/' . $row_shop['shop_image' . $i];
                                    }
                                }
                                if (count($shop_image) > 0) {
                                    foreach ($shop_image as $row_image) {
                                        ?>
                                        <li data-thumb="<?php echo $row_image; ?>">
                                            <a href="<?php echo $row_image; ?>" class="fancybox">
                                                <img src="<?php echo $row_image; ?>">
                                            </a>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                    <li data-thumb="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>">
                                        <a href="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"
                                           class="fancybox">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/840_460.png"; ?>"/>
                                        </a>
                                    </li>
                                <?php }
                                ?>
                            </ul>
                            <div class="mt-3">
                                <?php
                                // count review by shop_id_pri
                                $get_shop_rating = $this->global_model->getShopReviewByID($row_shop['shop_id_pri']);
                                if ($get_shop_rating->num_rows() == 1) {
                                    $row_shop_rating = $get_shop_rating->row();
                                    $shop_rating_total = $row_shop_rating->rating;
                                    $count_review_product = $row_shop_rating->count_rating;
                                } else {
                                    $shop_rating_total = 0;
                                    $count_review_product = 0;
                                }
                                ?>
                                <span style="font-size: 35px; color:#ffd333;">
                                    <?php echo $this->misc->rating(round($shop_rating_total)); ?>
                                    <span style="font-size: 20px; color:black;"><?php echo number_format(round($shop_rating_total)); ?> จาก <?php echo number_format($count_review_product); ?> รีวิว</span>
                                </span>
                            </div>
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <a target="_blank" href="<?php echo 'https://maps.google.com/?daddr=' . $row_shop['shop_latlong']; ?>" class="btn btn-outline-primary btn-block"> นำทาง</a>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <a href="tel:<?php echo $row_shop['shop_tel']; ?>" class="btn btn-primary btn-block"> โทร</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mt-2 mt-lg-0">
                                        <ul class="share-links__list float-right">
                                            <?php $share_url = base_url() . 'shop/' . $row_shop['shop_id']; ?>
                                            <a target="_blank"
                                               href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="35"></a>&nbsp;
                                            <a target="_blank"
                                               href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/twitter.png"; ?>" width="35"></a>&nbsp;
                                            <a target="_blank"
                                               href="http://pinterest.com/pin/create/button/?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/pinterest.png"; ?>" width="35"></a>&nbsp;
                                            <a target="_blank"
                                               href="https://social-plugins.line.me/lineit/share?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/line.png"; ?>" width="35"></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product__tabs product-tabs product-tabs--layout--full mt-5">
                <ul class="product-tabs__list">
                    <li class="product-tabs__item product-tabs__item--active"><a href="#product-tab-description">รายละเอียดคลินิก</a>
                    </li>
                    <li class="product-tabs__item"><a href="#product-tab-specification">บริการ</a></li>
                    <li class="product-tabs__item"><a href="#product-tab-docter">นัดหมายออนไลน์</a></li>
                    <li class="product-tabs__item"><a href="#product-tab-branch">สาขา</a></li>
                </ul>
                <div class="product-tabs__content">
                    <div class="product-tabs__pane product-tabs__pane--active" id="product-tab-description">
                        <?php echo $row_shop['shop_detail']; ?>
                    </div>
                    <div class="product-tabs__pane" id="product-tab-specification">
                        <div id="result-pagination"></div>
                    </div>
                    <div class="product-tabs__pane" id="product-tab-docter">
                        <div id="result-doctor-pagination"></div>
                    </div>
                    <div class="product-tabs__pane" id="product-tab-branch">
                        <div id="result-shop-sub-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        ajax_pagination();
        ajax_doctor_pagination();
        ajax_shop_sub_pagination();
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        }).attr('data-fancybox', 'group1');

        $('#lightSlider').lightSlider({
            gallery: true,
            item: 1,
            auto: true,
            loop: true,
            thumbItem: 6,
            slideMargin: 0,
            pause: 8000,
            enableDrag: false,
            controls: true,
            currentPagerPosition: 'left',
        });
    })

    function ajax_pagination() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
        $.ajax({
            url: service_base_url + 'shopdetail/ajax_pagination',
            type: 'POST',
            data: {
                searchtext: '',
                shop_id_pri: '<?php echo $row_shop['shop_id_pri']; ?>'
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }

    function ajax_doctor_pagination() {
        $('#result-doctor-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
        $.ajax({
            url: service_base_url + 'shopdetail/ajax_doctor_pagination',
            type: 'POST',
            data: {
                shop_id_pri: '<?php echo $row_shop['shop_id_pri']; ?>'
            },
            success: function (response) {
                $('#result-doctor-pagination').html(response);
            }
        });
    }

    function ajax_shop_sub_pagination() {
        $('#result-shop-sub-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
        $.ajax({
            url: service_base_url + 'shopdetail/ajax_shop_sub_pagination',
            type: 'POST',
            data: {
                shop_id_pri: '<?php echo $row_shop['shop_id_pri']; ?>'
            },
            success: function (response) {
                $('#result-shop-sub-pagination').html(response);
            }
        });
    }
</script>
<?php
$get_product_price = $this->shopdetail_model->getProductByShopID($row_shop['shop_id_pri'], 1);
if ($get_product_price->num_rows() == 1) {
    $row_product = $get_product_price->row();
    $product_price = $row_product->product_total;
} else {
    $product_price = 0;
}
$get_product_date = $this->shopdetail_model->getProductByShopID($row_shop['shop_id_pri'], 0);
if ($get_product_date->num_rows() == 1) {
    $row_date = $get_product_date->row();
    $product_date = date('Y-m-d', strtotime($row_date->product_update));
} else {
    $product_date = '2020-09-01';
}
?>
<!-- มาร์กอัป JSON-LD ที่สร้างขึ้นโดยโปรแกรมช่วยมาร์กอัปข้อมูลที่มีโครงสร้างของ Google -->
<script type="application/ld+json">
    {
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "<?php echo $row_shop['shop_name']; ?>", 
    "image": [
    <?php
    if ($row_shop['shop_image'] != '' && $row_shop['shop_image'] != 'none.png') {
        echo '"' . admin_url() . "assets/upload/shop/" . $row_shop['shop_image'] . '"';
    }
    if (count($shop_image) > 0) {
        foreach ($shop_image as $row_image) {
            echo ',' . "\n\t" . '"' . $row_image . '"';
        }
    }
    ?>
    ],
    "description": "<?php echo $row_shop['shop_nature']; ?>",
    "sku": "<?php echo $row_shop['shop_id']; ?>",
    "mpn": "<?php echo $row_shop['shop_id']; ?>",
    "brand": {
    "@type": "Brand",
    "name": "<?php echo $row_shop['shop_name']; ?>"
    },
    "review": {
    "@type": "Review",
    "reviewRating": {
    "@type": "Rating",
    "ratingValue": "<?php echo number_format(($shop_rating_total > 0 ? $shop_rating_total : 1), 1); ?>",
    "bestRating": "5"
    },
    "author": {
    "@type": "Person",
    "name": "<?php echo $row_shop['shop_name']; ?>"
    }
    },
    "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo number_format(($shop_rating_total > 0 ? $shop_rating_total : 1), 1); ?>",
    "reviewCount": "<?php echo number_format(($count_review_product > 0 ? $count_review_product : 1)); ?>"
    },
    "offers": {
    "@type": "Offer",
    "priceCurrency": "THB",
    "availability": "https://schema.org/OnlineOnly",
    "price": "<?php echo $product_price; ?>",
    "priceValidUntil": "<?php echo $product_date; ?>",
    "url": "<?php echo $share_url; ?>"
    }
    }
</script>

<style>
    .lightSlider ul {
        list-style: none outside none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .lightSlider li {
        display: block;
        float: left;
        margin-right: 6px;
        cursor: pointer;
    }

    .lightSlider img {
        display: block;
        max-height: 460px;
        width: 100%;
    }

    .btn-outline-primary {
        border: 1px solid #0069FD;
        color: #0069FD;
    }

    .pro-view {
        position: absolute;
        top: 3%;
        right: 3%;
        color: black;
    }
</style>