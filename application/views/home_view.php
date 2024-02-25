<div class="jarallax d-none d-md-block" data-jarallax="" data-speed="0.35">
  <span class="position-absolute top-0 start-0 w-100 h-100"></span>
  <div class="d-none d-xxl-block" style="height: 700px;"></div>
  <div class="d-none d-md-block d-xxl-none" style="height: 550px;"></div>
  <div id="jarallax-container-0" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; z-index: -100; clip-path: polygon(0px 0px, 100% 0px, 100% 100%, 0px 100%);">
    <div class="jarallax-img" style="background-image: url('<?php echo base_url() . 'assets/img/show_image.png'; ?>'); object-fit: cover; object-position: 50% 50%; max-width: none; position: fixed; top: 0px; left: 0px; width: 100%; height: 796.35px; overflow: hidden; pointer-events: none; transform-style: preserve-3d; backface-visibility: hidden; will-change: transform, opacity; margin-top: 66.325px; transform: translate3d(0px, -39.725px, 0px);" data-jarallax-original-styles="background-image: url('<?php echo base_url() . 'assets/img/show_image.png'; ?>');"></div>
  </div>
</div>
<section class="container mt-4 mb-lg-5 pt-lg-2 pt-5 pb-4">
  <!-- Page title + Layout switcher + Search form -->
  <h2 class="h1 text-center pb-3 pt-3 pb-md-4 pb-xl-5">รับส่วนลด จากแคชแบ็กทุกครั้งที่ซื้อแพ็กเกจผ้าน Envyz.me</h2>
  <div class="row row-cols-lg-6 row-cols-sm-2 row-cols-2 gy-md-4 gy-2">
    <?php
    $get_shop_nature = $this->global_model->getShopNature();
    if ($get_shop_nature->num_rows() > 0) {
      foreach ($get_shop_nature->result() as $row_shop_nature) { ?>
        <!-- Item -->
        <div class="col pb-3">
          <article class="card border-0 shadow-sm h-100">
            <div class="position-relative">
              <a href="<?php echo base_url() . 'promotions?nature_name=' . $row_shop_nature->shop_nature_name; ?>" class="position-absolute top-0 start-0 w-100 h-100" aria-label="Read more"></a>
              <img src="<?php echo base_url() . 'assets/icon/'. $row_shop_nature->shop_nature_id .'.svg' //echo base_url() . 'assets/icon/' . $row_shop_nature->shop_nature_icon; ?>" class="card-img-top" alt="Image">
            </div>
            <div class="card-body p-2">
              <p class="fs-sm mb-1 text-center" style="font-weight: bold;"><?php echo $row_shop_nature->shop_nature_name; ?></p>
              <hr class="d-none d-lg-inline-flex">
              <p class="fs-xs mt-1 d-none d-lg-inline-flex"><?php //echo $row_shop_nature->shop_nature_detail; ?></p>
            </div>
          </article>
        </div>
    <?php
      }
    }
    ?>
  </div>
</section>

<section class="container py-3 mb-1 mb-md-4 mb-lg-5">
  <h4 class="pt-1 pb-4 mb-1 mb-lg-3">แพ็กเกจแนะนำ <span style="float :right"><a href="<?php echo base_url() . 'shops'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h4>
  <div class="position-relative px-xl-5">
    <!-- Slider prev/next buttons -->
    <button type="button" id="prev-news" class="btn btn-prev btn-icon btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-left"></i>
    </button>
    <button type="button" id="next-news" class="btn btn-next btn-icon btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-right"></i>
    </button>
    <!-- Slider -->
    <div class="px-xl-2">
      <div class="swiper mx-n2" data-swiper-options='{
              "slidesPerView": 1,
              "loop": true,
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
              },
              "navigation": {
                "prevEl": "#prev-news",
                "nextEl": "#next-news"
              },
              "breakpoints": {
                "500": { "slidesPerView": 2 },
                "1000": { "slidesPerView": 5 }
              }
            }'>
        <div class="swiper-wrapper">

          <!-- Item -->
          <?php
          $get_shop = $this->global_model->getShop();
          if ($get_shop->num_rows() > 0) {
            foreach ($get_shop->result() as $row_shop) {
          ?>

              <div class="swiper-slide h-auto pb-3">
                <article class="card h-100 border-0 shadow-sm mx-2">
                  <div class="position-relative">
                    <a target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>" class="position-absolute top-0 start-0 w-100 h-100" aria-label="Read more"></a>
                    <img src="<?php echo admin_url() . "assets/upload/shop/" . $row_shop->shop_image; ?>" class="card-img-top" alt="Image" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                  </div>
                  <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <a class="badge fs-xs text-nav bg-secondary text-decoration-none" href="<?php echo base_url(); ?>"><?php echo $row_shop->shop_nature_name; ?></a>
                      <!-- <span class="fs-xs text-muted"><?php //echo number_format(round($row_shop->rating)); 
                                                          ?> จาก <?php //echo number_format($row_shop->count_rating); 
                                                                  ?> รีวิว</span> -->
                    </div>
                    <a class="text-primary" target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>" style="font-size: 16px;"><?php echo $row_shop->shop_name; ?></a>
                    <div class="row">
                      <div class="col-xl-8">
                        <p style="font-size: 12px">
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
                </article>
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
        <!-- Pagination (bullets) -->
        <div class="swiper-pagination position-relative pt-2 pt-sm-3 mt-4 swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
      </div>
    </div>

  </div>
</section>


<section class="container py-3 mb-1 mb-md-4 mb-lg-5">
  <h4 class="pt-1 pb-4 mb-1 mb-lg-3">คลินิกแนะนำ <span style="float :right"><a href="<?php echo base_url() . 'shops'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h4>
  <div class="position-relative px-xl-5">
    <!-- Slider prev/next buttons -->
    <button type="button" id="prev-news" class="btn btn-prev btn-icon btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-left"></i>
    </button>
    <button type="button" id="next-news" class="btn btn-next btn-icon btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-right"></i>
    </button>
    <!-- Slider -->
    <div class="px-xl-2">
      <div class="swiper mx-n2" data-swiper-options='{
              "slidesPerView": 1,
              "loop": true,
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
              },
              "navigation": {
                "prevEl": "#prev-news",
                "nextEl": "#next-news"
              },
              "breakpoints": {
                "500": { "slidesPerView": 2 },
                "1000": { "slidesPerView": 5 }
              }
            }'>
        <div class="swiper-wrapper">

          <!-- Item -->
          <?php
          $get_shop = $this->global_model->getShop();
          if ($get_shop->num_rows() > 0) {
            foreach ($get_shop->result() as $row_shop) {
          ?>

              <div class="swiper-slide h-auto pb-3">
                <article class="card h-100 border-0 shadow-sm mx-2">
                  <div class="position-relative">
                    <a target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>" class="position-absolute top-0 start-0 w-100 h-100" aria-label="Read more"></a>
                    <img src="<?php echo admin_url() . "assets/upload/shop/" . $row_shop->shop_image; ?>" class="card-img-top" alt="Image" onerror="this.onerror=null;this.src='<?php echo admin_url() . "assets/upload/shop/none.png"; ?>';">
                  </div>
                  <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                      <a class="badge fs-xs text-nav bg-secondary text-decoration-none" href="<?php echo base_url(); ?>"><?php echo $row_shop->shop_nature_name; ?></a>
                      <!-- <span class="fs-xs text-muted"><?php //echo number_format(round($row_shop->rating)); 
                                                          ?> จาก <?php //echo number_format($row_shop->count_rating); 
                                                                  ?> รีวิว</span> -->
                    </div>
                    <a class="text-primary" target="blank_" href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>" style="font-size: 16px;"><?php echo $row_shop->shop_name; ?></a>
                    <div class="row">
                      <div class="col-xl-8">
                        <p style="font-size: 12px">
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
                </article>
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
        <!-- Pagination (bullets) -->
        <div class="swiper-pagination position-relative pt-2 pt-sm-3 mt-4 swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
      </div>
    </div>

  </div>
</section>


<!-- Testimonials -->
<section class="pt-2 pb-lg-4 pb-xl-5 mb-5">
  <h3 class="text-center pb-3 pb-md-4 pb-xl-5"> <a href="<?php echo base_url() . 'shops'; ?>" class="text-primary">รีวิวจากผู้ใช้งาน</a></h3>
  <div class="px-2 px-sm-0">
    <div class="swiper" data-swiper-options='{
            "slidesPerView": 1,
            "centeredSlides": true,
            "spaceBetween": 8,
            "loop": true,
            "pagination": {
              "el": ".swiper-pagination",
              "clickable": true
            },
            "breakpoints": {
              "500": {
                "slidesPerView": 2,
                "spaceBetween": 24
              },
              "1000": {
                "slidesPerView": 4,
                "spaceBetween": 24
              },
              "1500": {
                "slidesPerView": 6,
                "spaceBetween": 24
              }
            }
          }'>
      <div class="swiper-wrapper">

        <!-- Item -->
        <div class="swiper-slide h-auto pt-4">
          <figure class="d-flex flex-column h-100 px-2 px-sm-0 mb-0">
            <div class="card h-100 position-relative border-0 shadow-sm pt-4">
              <span class="btn btn-icon btn-primary shadow-primary pe-none position-absolute top-0 start-0 translate-middle-y ms-4">
                <i class="bx bxs-quote-left"></i>
              </span>
              <blockquote class="card-body pb-3 mb-0">
                <p class="mb-0">Id mollis consectetur congue egestas egestas suspendisse blandit justo. Tellus augue commodo id quis tempus etiam pulvinar at maecenas.</p>
              </blockquote>
              <div class="card-footer border-0 text-nowrap pt-0">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bx-star text-muted opacity-75"></i>
                <i class="bx bx-star text-muted opacity-75"></i>
              </div>
            </div>
            <figcaption class="d-flex align-items-center ps-4 pt-4">
              <img src="assets/img/avatar/03.jpg" width="48" class="rounded-circle" alt="Fannie Summers">
              <div class="ps-3">
                <h6 class="fs-sm fw-semibold mb-0">Fannie Summers</h6>
                <span class="fs-xs text-muted">Designer</span>
              </div>
            </figcaption>
          </figure>
        </div>

      </div>
      <!-- Pagination (bullets) -->
      <div class="swiper-pagination position-relative pt-1 pt-sm-3 mt-5"></div>
    </div>
  </div>
</section>


<section class="container py-3 mb-1 mb-md-4 mb-lg-5">
  <h4 class="pt-1 pb-4 mb-1 mb-lg-3">บทความ <span style="float :right"><a href="<?php echo base_url() . 'blog'; ?>" class="text-primary">แสดงทั้งหมด</a></span></h4>
  <div class="position-relative px-xl-5">
    <!-- Slider prev/next buttons -->
    <button type="button" id="prev-news" class="btn btn-prev btn-icon btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-left"></i>
    </button>
    <button type="button" id="next-news" class="btn btn-next btn-icon btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-xl-inline-flex">
      <i class="bx bx-chevron-right"></i>
    </button>
    <!-- Slider -->
    <div class="px-xl-2">
      <div class="swiper mx-n2" data-swiper-options='{
              "slidesPerView": 1,
              "loop": true,
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
              },
              "navigation": {
                "prevEl": "#prev-news",
                "nextEl": "#next-news"
              },
              "breakpoints": {
                "500": { "slidesPerView": 2 },
                "1000": { "slidesPerView": 5 }
              }
            }'>
        <div class="swiper-wrapper">
          <!-- Item -->
          <?php
          $get_blog = $this->global_model->getBlog(10);
          if ($get_blog->num_rows() > 0) {
            foreach ($get_blog->result() as $row_blog) {
          ?>
              <div class="swiper-slide h-auto pb-3">
                <article class="card h-100 border-0 shadow-sm mx-2">
                  <div class="position-relative">
                    <a target="blank_" href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>" class="position-absolute top-0 start-0 w-100 h-100" aria-label="Read more"></a>
                    <img src=" <?php echo admin_url() . 'images?src=' . app_admin_url() . 'assets/upload/article/' . $row_blog->article_thumbnail . '&w=305&h=170'; ?>" class="card-img-top" alt="Image" onerror="this.onerror=null;this.src='<?php echo app_admin_url() . "assets/upload/article/none.png"; ?>';">
                  </div>
                  <div class="card-body p-3">
                    <a class="text-primary" target="blank_" href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>" style="font-size: 18px;"> <?php echo $row_blog->article_title; ?></a>
                    <div class="row">
                      <div class="col-xl-12 col-md-12 col-12 pt-3 pl-2 pr-2">
                        <p style="font-size: 13px">
                          <?php echo (strlen($row_blog->article_excerpt) > 150) ? mb_substr($row_blog->article_excerpt, 0, 150, 'UTF-8') . '...' : $row_blog->article_excerpt; ?>
                        </p>
                      </div>
                    </div>
                    <div class="d-flex flex-wrap">
                      <?php
                      if ($row_blog->article_keyword != '') {
                      ?>
                        <?php
                        $keyword = explode(',', $row_blog->article_keyword);
                        foreach ($keyword as $k_list) {
                        ?>
                          <a class="btn btn-outline-secondary btn-sm p-1 m-0" style="border: 0;" href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>" style="font-size: 11px;"><?php echo '#'.$k_list; ?></a>
                        <?php } ?>
                      <?php
                      }
                      ?>
                    </div>

                  </div>
                </article>
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
        <!-- Pagination (bullets) -->
        <div class="swiper-pagination position-relative pt-2 pt-sm-3 mt-4 swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 3" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span></div>
        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
      </div>
    </div>
  </div>
</section>