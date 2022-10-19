<div class="site__body">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3, 4);
                    if ($slides->num_rows() > 0) {
                        $s_r = 0;
                        foreach ($slides->result() as $slide_r) {
                            ?>
                            <a class="block-slideshow__item"
                               href="<?php echo($slide_r->slideshow_link != '' ? $slide_r->slideshow_link : 'javascript:void(0);'); ?>" <?php echo($slide_r->slideshow_open_link == 2 ? 'target="_blank"' : ''); ?>
                               title="<?php echo $slide_r->slideshow_name; ?>">
                                <span class="block-slideshow__item-image block-slideshow__item-image--desktop"
                                      style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image != '' ? $slide_r->slideshow_image : 'none.png'); ?>')"></span>
                                <span class="block-slideshow__item-image block-slideshow__item-image--mobile"
                                      style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image_half != '' ? $slide_r->slideshow_image_half : 'none-half.png'); ?>')"></span>
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
    <div class="block blog-view blog-view--layout--list">
        <div class="container">
            <div class="blog-view__body mt-5 mb-5">
                <div class="blog-view__item blog-view__item-posts">
                    <div class="post-view__card post">
                        <div class="post__body typography">
                            <h1 style="font-size: 32px;">
                                <?php echo $data->article_title; ?>
                            </h1>
                            <?php if ($data->article_thumbnail != "") { ?>
                                <img class="img-fluid" src="<?php echo app_admin_url() . "assets/upload/article/" . $data->article_thumbnail; ?>" width="100%" alt="<?php echo $data->article_title; ?>">
                            <?php } ?>
                            <br>
                            <br>
                            <?php
                            echo $data->article_text;
                            ?>
                            <div class="widget-posts__date">
                                <?php echo $this->libs->date2Thai($data->article_create, '%d %m %y') ?>
                            </div>
                        </div>
                        <div class="post__pagination">
                        </div>
                        <div class="post__footer">
                            <div class="post__tags tags tags--sm">
                                <div class="tags__list">
                                    <?php
                                    $keyword = explode(',', $data->article_keyword);
                                    foreach ($keyword as $k_list) {
                                        ?>
                                        <a href="<?php echo current_url(); ?>"><?php echo $k_list; ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="post__share-links share-links">
                                <span>แชร์ : </span>
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url() . 'blog/detail/' . $data->article_slug; ?>"><img class="img-responsive mt-1" src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="28"></a>
                                <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo base_url() . 'blog/detail/' . $data->article_slug; ?>"><img class="img-responsive mt-1" src="<?php echo base_url() . "assets/img/social-icon/twitter.png"; ?>" width="28"></a>
                                <a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php echo base_url() . 'blog/detail/' . $data->article_slug; ?>"><img class="img-responsive mt-1" src="<?php echo base_url() . "assets/img/social-icon/pinterest.png"; ?>" width="28"></a>
                                <a target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?php echo base_url() . 'blog/detail/' . $data->article_slug; ?>"><img class="img-responsive mt-1" src="<?php echo base_url() . "assets/img/social-icon/line.png"; ?>" width="28"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blog-view__item blog-view__item-sidebar">
                    <div class="row">
                        <div class="col-xl-12 mb-3">
                            <div class="card" style="border: 5px solid #FF2C64; min-height: 350px">
                                <div class="card-body">
                                    <h5 style="background: #FF2C64 ;color: #FFFFFF ; margin-top:-10px; margin-left: -20px" class="pt-3 pb-3">บทความล่าสุด</h5>
                                    <div class="row">
                                        <?php
                                        $get_blog = $this->global_model->getBlog(4, $data->article_id);
                                        if ($get_blog->num_rows() > 0) {
                                            foreach ($get_blog->result() as $row_blog) {
                                                ?>
                                                <div class="col-md-4 col-xl-12 mt-3">
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
                                                <h5 class="text-center"><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card" style="border: 5px solid #FF2C64; min-height: 350px">
                                <div class="card-body">
                                    <h5 style="background: #FF2C64 ;color: #FFFFFF ; margin-top:-10px; margin-left: -20px" class="pt-3 pb-3">Promotion News</h5>
                                    <div class="row">
                                        <?php
                                        $get_product_new = $this->global_model->getProduct(4);
                                        if ($get_product_new->num_rows() > 0) {
                                            foreach ($get_product_new->result() as $row_product_new) {
                                                ?>
                                                <div class="col-md-4 col-xl-12 mt-3">
                                                    <div class="block-products-carousel__column">
                                                        <div class="block-products-carousel__cell">
                                                            <div class="product-card product-card--layout--grid">
                                                                <div class="product-card__image">
                                                                    <?php
                                                                    if ($row_product_new->product_percent > 0) {
                                                                        ?>
                                                                        <div class="ribbon-pink">
                                                                            <span><?php echo number_format($row_product_new->product_percent, 0); ?>% ส่วนลด</span>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_new->product_slug; ?>"><img src="<?php echo admin_url() . 'assets/upload/product/' . $row_product_new->product_image; ?>" alt="" width="100%"></a>
                                                                </div>
                                                                <div class="product-card__info">
                                                                    <div class="product-card__meta">
                                                                        <a class="text-muted" href="javascript:void(0)"><?php echo $row_product_new->shop_nature_name; ?></a>
                                                                        <span style="float: right"><i class="fa fa-eye me-2"></i> <?php echo number_format($row_product_new->product_view); ?></span>
                                                                    </div>
                                                                    <div class="product-card__name mt-2">
                                                                        <a class="mt-2 text-primary" target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_new->product_slug; ?>" style="font-size: 16px;"> <?php echo $row_product_new->product_name; ?></a>
                                                                    </div>
                                                                    <div class="row pl-3 pr-3">
                                                                        <div class="col-lg mt-2">
                                                                            <span class="" style="font-size: 13px; color:#ffd333;">
                                                                                <?php echo $this->misc->rating($row_product_new->product_rating); ?>
                                                                            </span>
                                                                            <span class="text-secondary" style="font-size: 12px;"><?php echo number_format($row_product_new->product_rating); ?> จาก <?php echo number_format($this->global_model->getProductReview($row_product_new->product_id)); ?> รีวิว </span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="pl-3 pr-3 mt-2" style="color: #FF2C64; font-size: 12px;">ได้รับแต้มคืน <?php echo number_format($row_product_new->product_point); ?> แต้ม</span>
                                                                </div>
                                                                <div class="product-card__footer">
                                                                    <div class="product-card__prices">
                                                                        <?php
                                                                        if ($row_product_new->product_price > $row_product_new->product_total) {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_new->product_total); ?> บาท</div>
                                                                            <div class="product-card__price product-card__price--old">฿<?php echo number_format($row_product_new->product_price); ?> บาท</div>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <div class="product-card__price product-card__price--new" style="color: #ff3c0c;">฿<?php echo number_format($row_product_new->product_total); ?> บาท</div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php if ($row_product_new->product_group_id == 2) { ?>
                                                                        <a target="blank_" href="<?php echo base_url() . 'promotion/' . $row_product_new->product_slug; ?>" class="product-card__addtocart-icon" type="button" aria-label="Add to cart">
                                                                            <i class="fa fa-birthday-cake  me-2"></i>
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
                                                <h5 class="text-center mt-5"><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5>
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
        </div>
    </div>
</div>
