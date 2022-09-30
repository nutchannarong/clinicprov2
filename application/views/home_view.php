<div class="site__body">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3, 1);
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
    <div class="block mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-xl-12 mt-2 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-primary">บริการแนะนำ <span style="float :right"><a href="<?php echo base_url() . 'promotions'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h5>
                                    <div class="row">
                                        <?php
                                        $online_point = 0;
                                        if (!empty($this->session->userdata('online_id'))) {
                                            $online_point = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row()->online_point;
                                        }
                                        $get_product = $this->global_model->getProduct(8, 1, $online_point);
                                        if ($get_product->num_rows() > 0) {
                                            foreach ($get_product->result() as $row_product) {
                                                ?>
                                                <div class="col-md-4 col-lg-4 col-xl-3 mt-3">
                                                    <div class="block-products-carousel__column">
                                                        <div class="block-products-carousel__cell">
                                                            <div class="product-card product-card--layout--grid">
                                                                <div class="product-card__image">
                                                                    <?php
                                                                    if ($row_product->product_percent > 0) {
                                                                        ?>
                                                                        <div class="ribbon-pink">
                                                                            <span><?php echo number_format($row_product->product_percent, 0); ?>% ส่วนลด</span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product->product_slug; ?>">
                                                                        <img src="<?php echo admin_url() . 'assets/upload/product/' . $row_product->product_image; ?>" width="100%">
                                                                    </a>
                                                                </div>
                                                                <div class="product-card__info">
                                                                    <div class="product-card__meta">
                                                                        <a class="text-muted" href="javascript:void(0)"><?php echo $row_product->shop_nature_name; ?></a>
                                                                        <span style="float: right"><i class="fa fa-eye"></i> <?php echo number_format($row_product->product_view); ?></span>
                                                                    </div>
                                                                    <div class="product-card__name mt-2">
                                                                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product->product_slug; ?>"> <?php echo (strlen($row_product->product_name) > 20 ) ? mb_substr($row_product->product_name, 0, 20, 'UTF-8') . '...' : $row_product->product_name; ?></a>
                                                                    </div>
                                                                    <div class="row pl-3 pr-3">
                                                                        <div class="col-lg mt-2">
                                                                            <span class="" style="font-size: 13px; color:#ffd333;">
                                                                                <?php echo $this->misc->rating($row_product->product_rating); ?>
                                                                            </span>
                                                                            <span class="text-secondary" style="font-size: 12px;"><?php echo number_format($row_product->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row_product->product_id)); ?>  รีวิว </span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="pl-3 pr-3 mt-2" style="color: #FF2C64; font-size: 12px;">ได้รับแต้มคืน <?php echo number_format($row_product->product_point); ?> แต้ม</span>
                                                                </div>
                                                                <div class="product-card__footer">
                                                                    <div class="product-card__prices">
                                                                        <?php
                                                                        if ($row_product->product_price > $row_product->product_total) {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product->product_total); ?> บาท</div>
                                                                            <div class="product-card__price product-card__price--old" style="<?php echo $row_product->product_group_id == 2 ? 'margin-left: 0px' : ''; ?>">฿<?php echo number_format($row_product->product_price); ?> บาท</div>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product->product_total); ?> บาท</div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php if ($row_product->product_group_id == 2) { ?>
                                                                        <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product->product_slug; ?>" class="product-card__addtocart-icon" type="button" aria-label="Add to cart">
                                                                            <i class="fa fa-birthday-cake "></i>
                                                                        </a>
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
                            </div>
                        </div>
                        <div class="col-xl-12 mt-2 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-primary">ประเภทบริการ</h5>
                                    <div class="categories-list categories-list--layout--columns-3-sidebar">
                                        <ul class="categories-list__body">
                                            <?php
                                            $get_shop_nature = $this->global_model->getShopNature();
                                            if ($get_shop_nature->num_rows() > 0) {
                                                foreach ($get_shop_nature->result() as $row_shop_nature) {
                                                    ?>
                                                    <li class="categories-list__item p-3">
                                                        <a href="<?php echo base_url() . 'promotions?nature_name=' . $row_shop_nature->shop_nature_name; ?>">
                                                            <div class="row">
                                                                <div class="col-xl-3">
                                                                    <img src="<?php echo base_url() . 'assets/icon/' . $row_shop_nature->shop_nature_id . '.png'; ?>">
                                                                </div>
                                                                <div class="col-xl-9">
                                                                    <div class="categories-list__item-name text-xl-left mt-3">
                                                                        <h6 class="text-primary"><?php echo $row_shop_nature->shop_nature_name; ?></h6></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="categories-list__divider"></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mt-2 mb-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-primary">คลินิกแนะนำ <span style="float :right"><a href="<?php echo base_url() . 'shops'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h5>
                                    <div class="row">
                                        <?php
                                        $get_shop = $this->global_model->getShop();
                                        if ($get_shop->num_rows() > 0) {
                                            foreach ($get_shop->result() as $row_shop) {
                                                ?>
                                                <div class="col-md-4 col-lg-4 col-xl-3 mt-3">
                                                    <div class="block-products-carousel__column">
                                                        <div class="block-products-carousel__cell">
                                                            <div class="product-card product-card--layout--grid">
                                                                <div class="product-card__image">
                                                                    <div style="position: absolute;right: 5%;bottom: 5%; z-index: 1;">
                                                                        <span class="" style="font-size: 13px; color:#ffd333;">
                                                                            <?php echo $this->misc->rating(round($row_shop->rating)); ?>
                                                                        </span>
                                                                    </div>
                                                                    <a target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>">
                                                                        <img src="<?php echo admin_url() . "assets/upload/shop/" . $row_shop->shop_image; ?>" alt="" width="100%" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                                                                    </a>
                                                                </div>
                                                                <div class="product-card__info">
                                                                    <div class="product-card__meta">
                                                                        <a class="text-muted" href="<?php echo base_url(); ?>"><?php echo $row_shop->shop_nature_name; ?></a>
                                                                        <span style="float: right">
                                                                            <?php echo number_format(round($row_shop->rating)); ?> จาก <?php echo number_format($row_shop->count_rating); ?> รีวิว
                                                                        </span>
                                                                    </div>
                                                                    <div class="product-card__name mt-2">
                                                                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>" style="font-size: 16px;"><?php echo $row_shop->shop_name; ?></a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-card__footer">
                                                                    <div class="row">
                                                                        <div class="col-xl-8">
                                                                            <p style="font-size: 10px">
                                                                                ที่อยู่ : <?php echo $row_shop->shop_address; ?>
                                                                                ตำบล<?php echo $row_shop->shop_district; ?>
                                                                                อำเภอ<?php echo $row_shop->shop_amphoe; ?>
                                                                                จังหวัด<?php echo $row_shop->shop_province; ?>
                                                                                รหัสไปรษณีย์ <?php echo $row_shop->shop_zipcode; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-xl-4">
                                                                            <a href="<?php echo 'https://maps.google.com/?daddr=' . $row_shop->shop_latlong; ?>" target="_blank">
                                                                                <img src="<?php echo base_url() . 'assets/img/map.png'; ?>" alt="">
                                                                            </a>
                                                                        </div>
                                                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="row">
                        <div class="col-xl-12 mt-2 text-white">
                            <div class="card" style="background:#FF2C64; min-height: 350px">
                                <div class="card-body text-center">
                                    <h5>สนใจติดต่อเข้าร่วมระบบ</h5>
                                    <img src="<?php echo base_url() . 'assets/img/qrcode/qrcode.png' ?>" width="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mt-2">
                            <div class="card" style="border: 5px solid #FF2C64; min-height: 350px">
                                <div class="card-body">
                                    <h5 style="background: #FF2C64 ;color: #FFFFFF ; margin-top:-10px; margin-left: -20px" class="pt-3 pb-3">Promotion Sale</h5>
                                    <div class="row">
                                        <?php
                                        $get_product_sale = $this->global_model->getProductSale();
                                        if ($get_product_sale->num_rows() > 0) {
                                            foreach ($get_product_sale->result() as $row_product_sale) {
                                                ?>
                                                <div class="col-md-4 col-xl-12 mt-3">
                                                    <div class="block-products-carousel__column">
                                                        <div class="block-products-carousel__cell">
                                                            <div class="product-card product-card--layout--grid">
                                                                <div class="product-card__image">
                                                                    <?php
                                                                    if ($row_product_sale->product_percent > 0) {
                                                                        ?>
                                                                        <div class="ribbon-pink">
                                                                            <span><?php echo number_format($row_product_sale->product_percent, 0); ?>% ส่วนลด</span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_sale->product_slug; ?>"><img src="<?php echo admin_url() . 'assets/upload/product/' . $row_product_sale->product_image; ?>" alt="" width="100%"></a>
                                                                </div>
                                                                <div class="product-card__info">
                                                                    <div class="product-card__meta">
                                                                        <a class="text-muted" href="javascript:void(0)"> <?php echo $row_product_sale->shop_nature_name; ?> </a>
                                                                        <span style="float: right"><i class="fa fa-eye"></i> <?php echo number_format($row_product_sale->product_view); ?></span>
                                                                    </div>
                                                                    <div class="product-card__name mt-2">
                                                                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_sale->product_slug; ?>" style="font-size: 16px;"> <?php echo $row_product_sale->product_name; ?></a>
                                                                    </div>
                                                                    <div class="row pl-3 pr-3">
                                                                        <div class="col-lg mt-2">
                                                                            <span class="" style="font-size: 13px; color:#ffd333;">
                                                                                <?php echo $this->misc->rating($row_product_sale->product_rating); ?>
                                                                            </span>
                                                                            <span class="text-secondary" style="font-size: 12px;"><?php echo number_format($row_product_sale->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row_product_sale->product_id)); ?>  รีวิว </span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="pl-3 pr-3 mt-2" style="color: #FF2C64; font-size: 12px;">ได้รับแต้มคืน <?php echo number_format($row_product_sale->product_point); ?> แต้ม</span>
                                                                </div>
                                                                <div class="product-card__footer">
                                                                    <div class="product-card__prices">
                                                                        <?php
                                                                        if ($row_product_sale->product_price > $row_product_sale->product_total) {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_sale->product_total); ?> บาท</div>
                                                                            <div class="product-card__price product-card__price--old">฿<?php echo number_format($row_product_sale->product_price); ?> บาท</div>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_sale->product_total); ?> บาท</div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php if ($row_product_sale->product_group_id == 2) { ?>
                                                                        <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_sale->product_slug; ?>" class="product-card__addtocart-icon" type="button" aria-label="Add to cart">
                                                                            <i class="fa fa-birthday-cake "></i>
                                                                        </a>
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
                                                <h5 class="text-center mt-5"><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 mt-2 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-primary">บทความ <span style="float :right"><a href="<?php echo base_url() . 'blog'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h5>
                            <div class="row">
                                <?php
                                $get_blog = $this->global_model->getBlog(4);
                                if ($get_blog->num_rows() > 0) {
                                    foreach ($get_blog->result() as $row_blog) {
                                        ?>
                                        <div class="col-md-12 col-lg-4 col-xl-3 mt-3">
                                            <div class="block-products-carousel__column">
                                                <div class="block-products-carousel__cell">
                                                    <div class="product-card product-card--layout--grid">
                                                        <div class="product-card__image">
                                                            <a href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>">
                                                                <?php if ($row_blog->article_thumbnail != "") { ?>
                                                                    <img class="img-fluid" src=" <?php echo admin_url() . 'images?src=' . app_admin_url() . 'assets/upload/article/' . $row_blog->article_thumbnail . '&w=305&h=170'; ?>" width="100%">
                                                                <?php } else { ?>
                                                                    <img class="img-fluid" src="<?php echo app_admin_url() . "assets/upload/article/none.png" ?>" width="100%">
                                                                <?php } ?>
                                                            </a>
                                                        </div>
                                                        <div class="product-card__info">                                                            
                                                            <div class="product-card__name mt-2">
                                                                <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>" style="font-size: 20px;"> <?php echo $row_blog->article_title; ?></a>

                                                                <div class="row">
                                                                    <div class="col-xl-12 col-md-12 col-12 pt-3 pl-2 pr-2">
                                                                        <p style="font-size: 13px">
                                                                            <?php echo (strlen($row_blog->article_excerpt) > 150) ? mb_substr($row_blog->article_excerpt, 0, 150, 'UTF-8') . '...' : $row_blog->article_excerpt; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                                                                        
                                                        </div>
                                                        <div class="product-card__footer">
                                                            <div class="post__tags tags tags--sm pt-2">
                                                                <?php
                                                                if ($row_blog->article_keyword != '') {
                                                                    ?>
                                                                    <div class="tags__list">
                                                                        <b>แท็ก : </b>
                                                                        <?php
                                                                        $keyword = explode(',', $row_blog->article_keyword);
                                                                        foreach ($keyword as $k_list) {
                                                                            ?>
                                                                        <a href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>" style="font-size: 11px;"><?php echo $k_list; ?></a>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
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
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

