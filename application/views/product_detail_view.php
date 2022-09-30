<div class="site__body">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3, 2);
                    if ($slides->num_rows() > 0) {
                        $s_r = 0;
                        foreach ($slides->result() as $slide_r) {
                            ?>
                            <a class="block-slideshow__item" href="<?php echo($slide_r->slideshow_link != '' ? $slide_r->slideshow_link : 'javascript:void(0);'); ?>" <?php echo($slide_r->slideshow_open_link == 2 ? 'target="_blank"' : ''); ?> title="<?php echo $slide_r->slideshow_name; ?>">
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
            <div class="block-split__row row no-gutters">
                <div class="block-split__item block-split__item-content col-auto">
                    <div class="product product--layout--full">
                        <div class="product__body">
                            <div class="product__card product__card--one"></div>
                            <div class="product__card product__card--two"></div>
                            <div class="product-gallery product-gallery--layout--product-full product__gallery" data-layout="product-full">
                                <?php
                                $pro_image = array();
                                $pro_image[] = admin_url() . 'assets/upload/product/' . $row_product['product_image'];
                                for ($i = 1; $i <= 6; $i++) {
                                    if ($row_product['product_image' . $i] != null) {
                                        $pro_image[] = admin_url() . 'assets/upload/product/' . $row_product['product_image' . $i];
                                    }
                                }
                                ?>
                                <div class="product-gallery__featured mb-2">
                                    <?php
                                    if ($row_product['product_percent'] > 0) {
                                        ?>
                                        <div class="ribbon-pink" style="z-index: 2">
                                            <span><?php echo number_format($row_product['product_percent'], 0); ?>% ส่วนลด</span>
                                        </div>
                                    <?php } ?>

                                    <div class="owl-carousel">
                                        <?php foreach ($pro_image as $row_image) { ?>
                                            <a href="<?php echo $row_image; ?>" class="fancybox">
                                                <span class="pro-view"><i class="fa fa-eye"></i> <?php echo number_format($row_product['product_view']); ?></span>
                                                <img src="<?php echo $row_image; ?>">
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="product-gallery__thumbnails">
                                    <div class="owl-carousel">
                                        <?php foreach ($pro_image as $row_image) { ?>
                                            <a href="<?php echo $row_image; ?>" class="product-gallery__thumbnails-item" target="_blank">
                                                <img src="<?php echo $row_image; ?>">
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="product__header">
                                <h1 class="product__title"><?php echo $row_product['product_name']; ?></h1>
                            </div>
                            <div class="product__main">
                                <div class="row">
                                    <div class="col-3">
                                        <a target="blank_" href="<?php echo base_url() . 'shop/' . $row_product['shop_id']; ?>">
                                            <img src="<?php echo admin_url() . "assets/upload/shop/" . $row_product['shop_image']; ?>" alt="" width="100%" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                                        </a>
                                    </div>
                                    <div class="col-9 text-right">
                                        <?php
                                        if ($row_product['product_price'] > $row_product['product_total']) {
                                            ?>
                                            <h3>฿<?php echo number_format($row_product['product_total']); ?> บาท</h3>
                                            <span style="text-decoration: line-through;" class="text-secondary">฿<?php echo number_format($row_product['product_price']); ?> บาท</span><br>
                                            <?php
                                        } else {
                                            ?>
                                            <h3>฿<?php echo number_format($row_product['product_total']); ?> บาท</h3>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (!empty($this->session->userdata('online_id'))) {
                                            if ($this->productdetail_model->checkShopCart($row_product['shop_id_pri']) > 0) {
                                                ?>
                                                <button type="button" class="btn btn-primary mt-2" style="width: 150px; background: #fc4f1f;" onclick="confirmCart('<?php echo $row_product['product_id']; ?>')">สั่งซื้อ</button>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="<?php echo base_url('cart/addtocart/' . $row_product['product_id']); ?>" class="btn btn-primary mt-2" style="width: 150px; background: #fc4f1f;">สั่งซื้อ</a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <a href="<?php echo base_url() . 'authen'; ?>" class="btn btn-primary mt-2" style="width: 150px; background: #fc4f1f;">สั่งซื้อ</a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="product__excerpt mt-2">
                                    <span>ชื่อร้าน : <?php echo $row_product['shop_name']; ?></span><br>
                                    <span>ลักษณะการให้บริการ : <?php echo $row_product['shop_nature_name']; ?></span><br>
                                    <span>เลขที่ใบอนุญาติ : <?php echo $row_product['shop_license']; ?></span><br>
                                    <span>โทร : <?php echo $row_product['shop_tel']; ?></span><br>
                                    <span>อีเมล : <?php echo $row_product['shop_email']; ?></span><br>
                                    <span>
                                        ที่อยู่ : <?php echo $row_product['shop_address']; ?>
                                        ตำบล<?php echo $row_product['shop_district']; ?>
                                        อำเภอ<?php echo $row_product['shop_amphoe']; ?>
                                        จังหวัด<?php echo $row_product['shop_province']; ?>
                                        รหัสไปรษณีย์ <?php echo $row_product['shop_zipcode']; ?>
                                    </span>
                                </div>

                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="mt-5 text-danger">
                                            <span>ได้รับแต้มคืน <?php echo number_format($row_product['product_point']); ?> แต้ม</span><br>
                                            <span>เริ่ม <?php echo $this->libs->endate2thdate($row_product['product_start'], 0); ?> ถึง <?php echo $this->libs->endate2thdate($row_product['product_end'], 0); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <ul class="share-links__list float-right" style="margin-top: 60px;">
                                            <?php $share_url = base_url() . 'promotion/' . $row_product['product_slug']; ?>
                                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="30"></a>&nbsp;
                                            <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/twitter.png"; ?>" width="30"></a>&nbsp;
                                            <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/pinterest.png"; ?>" width="30"></a>&nbsp;
                                            <a target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?php echo $share_url; ?>"><img src="<?php echo base_url() . "assets/img/social-icon/line.png"; ?>" width="30"></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="product__info">
                                <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block">
                                    <?php $this->load->view('layout/navbar-search-product'); ?>
                                </div>
                            </div>
                            <div class="product__tabs product-tabs product-tabs--layout--full">
                                <ul class="product-tabs__list">
                                    <li class="product-tabs__item product-tabs__item--active"><a href="#product-tab-description">รายละเอียด</a></li>
                                    <li class="product-tabs__item"><a href="#product-tab-specification">รายการอื่น ๆ</a></li>
                                    <li class="product-tabs__item"><a href="#product-tab-vdo">VDO</a></li>
                                    <li class="product-tabs__item">
                                        <a href="#product-tab-reviews">
                                            รีวิว
                                            <span class="product-tabs__item-counter">
                                                <?php
                                                $count_review_product = number_format($this->productdetail_model->getProductReviewByID($row_product['product_id'])->num_rows());
                                                echo $count_review_product;
                                                ?>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="product-tabs__content">
                                    <div class="product-tabs__pane product-tabs__pane--active" id="product-tab-description">
                                        <div class="typography">
                                            <?php echo $row_product['product_detail']; ?>
                                        </div>
                                        <div>
                                            <span><span class="text-primary">ประเภท : </span> <a href="<?php echo base_url() . 'promotions?nature_name=' . $row_product['shop_nature_name']; ?>"><?php echo $row_product['shop_nature_name']; ?></a> </span><br>
                                            <span class="text-primary">หมวดหมู่ : </span>
                                            <?php
                                            $product_category_name = $row_product['shop_nature_name'];
                                            $get_product_category = $this->productdetail_model->getProductCategory($row_product['product_id']);
                                            if ($get_product_category->num_rows() > 0) {
                                                foreach ($get_product_category->result() as $row_product_category) {
                                                    $product_category_name = $product_category_name . ' ' .$row_product_category->product_category_name;
                                                    ?>
                                                    <a href="<?php echo base_url() . 'promotions?category_name=' . $row_product_category->product_category_name; ?>"><?php echo $row_product_category->product_category_name; ?></a>&nbsp
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </span>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="product-tabs__pane" id="product-tab-specification">
                                        <div class="row">
                                            <?php
                                            $get_product_by_shop = $this->productdetail_model->getProductByShopID($row_product['shop_id_pri'], $row_product['product_id']);
                                            if ($get_product_by_shop->num_rows() > 0) {
                                                foreach ($get_product_by_shop->result() as $row_product_by_shop) {
                                                    ?>
                                                    <div class="col-md-6 col-lg-6 col-xl-6 mt-3">
                                                        <div class="card">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <?php
                                                                    if ($row_product_by_shop->product_percent > 0) {
                                                                        ?>
                                                                        <div class="ribbon-pink-col">
                                                                            <span><?php echo number_format($row_product_by_shop->product_percent, 0); ?>% ส่วนลด</span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_by_shop->product_slug; ?>">
                                                                        <span class="pro-view-shop"><i class="fa fa-eye"></i> <?php echo number_format($row_product_by_shop->product_view); ?></span>
                                                                        <img srcset="<?php echo admin_url() . 'images?src=' . admin_url() . 'assets/upload/product/' . $row_product_by_shop->product_image . '&w=190&h=170'; ?>"  alt="" width="100%">
                                                                    </a>
                                                                </div>
                                                                <div class="col-7 mt-2 mb-2">
                                                                    <a class="text-primary" target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_by_shop->product_slug; ?>" style="font-size: 16px;"> <?php echo (strlen($row_product_by_shop->product_name) > 30 ) ? mb_substr($row_product_by_shop->product_name, 0, 30, 'UTF-8') . '...' : $row_product_by_shop->product_name; ?></a>
                                                                    <div class="row pr-3">
                                                                        <div class="col-lg mt-2">
                                                                            <span class="" style="font-size: 15px; color:#ffd333;">
                                                                                <?php echo $this->misc->rating($row_product_by_shop->product_rating); ?>
                                                                            </span>
                                                                            <span class="text-secondary"><?php echo number_format($row_product_by_shop->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row_product_by_shop->product_id)); ?>  รีวิว </span>
                                                                            <div class="text-secondary mt-2"><?php echo $row_product_by_shop->shop_nature_name; ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <div style="color: #FF2C64;">ได้รับแต้มคืน <?php echo number_format($row_product_by_shop->product_point); ?> แต้ม</div>
                                                                    <div class="product-card__footer">
                                                                        <div class="product-card__prices">
                                                                            <div class="product-card__prices">
                                                                                <?php
                                                                                if ($row_product_by_shop->product_price > $row_product_by_shop->product_total) {
                                                                                    ?>
                                                                                    <span class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_by_shop->product_total); ?> บาท</span>
                                                                                    <span class="text-secondary" style="text-decoration: line-through; font-size: 13px;">฿<?php echo number_format($row_product_by_shop->product_price); ?> บาท</span>
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_by_shop->product_total); ?> บาท</div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php if ($row_product_by_shop->product_group_id == 2) { ?>
                                                                            <div class="pro-birthday">
                                                                                <div style="background: #0069FD; border-radius: 50%;">
                                                                                    <i class="fa fa-birthday-cake p-2 text-white"></i>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="col">
                                                    <h5 class="text-center"><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
                                                </div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product-tabs__pane" id="product-tab-vdo">
                                        <div style="min-height: 200px;" class="mt-1 p-2">
                                            <?php
                                            if ($row_product['product_vdo'] != "" && strpos($row_product['product_vdo'], 'watch?v') !== false) {
                                                $link_youtube = str_replace("watch?v=", "embed/", $row_product['product_vdo'])
                                                ?>
                                                <div class="mt-3 text-center">
                                                    <embed width="90%" height="400" src="<?php echo $link_youtube; ?>">
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="mt-4 text-center">
                                                    <h5><i class="fa fa-exclamation-triangle"></i> ไม่พบวิดีโอ</h5>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product-tabs__pane" id="product-tab-reviews">
                                        <?php
                                        $check_ordered = $this->productdetail_model->checkOrdered($row_product['product_id']);
                                        $check_reviewed = $this->productdetail_model->checkReviewed($row_product['product_id']);
                                        if ($check_ordered > 0 && $check_reviewed == 0) {
                                            ?>
                                            <div id="review_form_panel">
                                                <label class="text-primary">รีวิวของคุณ</label>
                                                <form id="form-review" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
                                                    <input type="hidden" name="product_id" value="<?php echo $row_product['product_id']; ?>">
                                                    <input type="hidden" name="shop_id_pri" value="<?php echo $row_product['shop_id_pri']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>รูปภาพ</label>
                                                            <img id="preview_image" src="<?php echo admin_url() . 'assets/upload/online/none.png'; ?>" width="100%">
                                                            <input type="file" id="review_image" name="review_image" accept="image/*" onchange="previewImage(event)" style="display: none">
                                                            <label for="review_image" class="btn btn-info btn-sm btn-block m-t-10"><i class="fa fa-image"></i> เลือกรูปภาพ</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label>ให้คะเเนน :</label>
                                                            <div>
                                                                <span class="my-rating-1"></span>
                                                                <input type="text" name="review_rating" id="review_rating" class="d-none" value="" required>
                                                            </div>
                                                            <label class="mt-2">ความคิดเห็น</label>
                                                            <textarea name="review_comment" class="form-control" rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 mt-2 text-right">
                                                            <button type="button" id="btn-form-review" class="btn btn-primary"><i id="fa-form-review" class="fas fa-check"></i> ตกลง</button>
                                                            <button type="reset" class="btn btn-secondary"><i class="fa fa-times"></i> ยกเลิก</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <script>
                                                    $('#form-review').parsley();

                                                    $('.my-rating-1').starRating({
                                                        initialRating: parseInt($('#review_rating').val()),
                                                        strokeColor: 'yellow',
                                                        totalStars: 5,
                                                        useFullStars: true,
                                                        starSize: 25,
                                                        disableAfterRate: false,
                                                        callback: function (currentRating) {
                                                            $('#review_rating').val(parseInt(currentRating))
                                                        }
                                                    })

                                                    var previewImage = function (event) {
                                                        var output = document.getElementById('preview_image')
                                                        output.src = URL.createObjectURL(event.target.files[0])
                                                        output.onload = function () {
                                                            URL.revokeObjectURL(output.src)
                                                        }
                                                    }

                                                    $('#btn-form-review').click(function () {
                                                        if ($('#form-review').parsley().validate() === true) {
                                                            $('#fa-form-review').removeClass('fa-check').addClass('fa-spinner fa-spin')
                                                            $('#btn-form-review').prop('disabled', true)
                                                            var formData = new FormData($('#form-review')[0])
                                                            $.ajax({
                                                                url: service_base_url + 'productdetail/processreview',
                                                                type: 'POST',
                                                                data: formData,
                                                                dataType: 'JSON',
                                                                // file
                                                                enctype: 'multipart/form-data',
                                                                processData: false,
                                                                contentType: false,
                                                                cache: false,
                                                                success: function (response) {
                                                                    setTimeout(function () {
                                                                        if (response.status == 'success') {
                                                                            $('#review_form_panel').remove()
                                                                        } else {
                                                                            $('#fa-form-review').removeClass('fa-spinner fa-spin').addClass('fa-check')
                                                                            $('#btn-form-review').prop('disabled', false)
                                                                        }
                                                                        notification(response.status, response.title, response.message)
                                                                        ajax_pagination()
                                                                    }, 200)
                                                                }
                                                            })
                                                        }
                                                    })
                                                </script>
                                                <hr style="border-top: 1px solid #ebebeb;">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div id="result-pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-space block-space--layout--divider-nl"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="confirm-cart-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> ต้องการเริ่มตะกร้าใหม่ ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-center">
                <span class="text-secondary">รายการสินค้าร้านเดิมจะถูกลบออก หากคุณสั่งสินค้าจากร้านใหม่<br>ต้องการสั่งซื้อต่อหรือไม่</span>
            </div>
            <div class="modal-footer">
                <a href="" id="btn-confirm-cart" class="btn btn-primary"><i class="fa fa-shopping-basket"></i> สั่งซื้อ</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times"></i> ยกเลิก</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        ajax_pagination();
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        }).attr('data-fancybox', 'group1');
    })

    function ajax_pagination() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.ajax({
            url: service_base_url + 'productdetail/ajax_pagination',
            type: 'POST',
            data: {
                product_id: '<?php echo $row_product['product_id']; ?>'
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }

    function confirmCart(product_id) {
        $('#btn-confirm-cart').attr('href', service_base_url + 'cart/addtocart/' + product_id)
        $('#confirm-cart-modal').modal('show', {backdrop: 'true'})
    }

</script>
<?php
$get_sum_review = $this->productdetail_model->sumProductReview($row_product['product_id']);
if ($get_sum_review->num_rows() == 1) {
    $row_sum_review = $get_sum_review->row();
    $sum_review = $row_sum_review->productreview_rating;
    if ($count_review_product > 0) {
        $rating = ($sum_review / $count_review_product);
    } else {
        $rating = 1;
    }
} else {
    $rating = 1;
}
?>
<!-- มาร์กอัป JSON-LD ที่สร้างขึ้นโดยโปรแกรมช่วยมาร์กอัปข้อมูลที่มีโครงสร้างของ Google -->
<script type="application/ld+json">
    {
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "<?php echo $row_product['product_name']; ?>", 
    "image": [
    <?php
    if (count($pro_image) > 0) {
        $ii = 1;
        foreach ($pro_image as $row_image) {
            echo ($ii > 1 ? ',' : '') . "\n\t" . '"' . $row_image . '"';
            $ii++;
        }
    }
    ?>
    ],
    "description": "<?php echo $product_category_name; ?>",
    "sku": "<?php echo $row_product['product_slug']; ?>",
    "mpn": "<?php echo $row_product['product_slug']; ?>",
    "brand": {
    "@type": "Brand",
    "name": "<?php echo $row_product['shop_name']; ?>"
    },
    "review": {
    "@type": "Review",
    "reviewRating": {
    "@type": "Rating",
    "ratingValue": "<?php echo number_format($rating, 1); ?>",
    "bestRating": "5"
    },
    "author": {
    "@type": "Person",
    "name": "<?php echo $row_product['shop_name']; ?>"
    }
    },
    "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo number_format($rating, 1); ?>",
    "reviewCount": "<?php echo number_format(($count_review_product > 1 ? $count_review_product : 1)); ?>"
    },
    "offers": {
    "@type": "Offer",
    "priceCurrency": "THB",
    "availability": "https://schema.org/OnlineOnly",
    "price": "<?php echo $row_product['product_total']; ?>",
    "priceValidUntil": "<?php echo date('Y-m-d', strtotime($row_product['product_update'])); ?>",
    "url": "<?php echo $share_url; ?>"
    }
    }
</script>

<style>
    .pro-view{
        position: absolute;
        top: 3%;
        right: 3%;
        color: black;
    }
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
