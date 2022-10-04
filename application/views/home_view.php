<div class="jarallax d-none d-md-block" data-jarallax="" data-speed="0.35">
  <span class="position-absolute top-0 start-0 w-100 h-100"></span>
  <div class="d-none d-xxl-block" style="height: 700px;"></div>
  <div class="d-none d-md-block d-xxl-none" style="height: 550px;"></div>
  <div id="jarallax-container-0" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; z-index: -100; clip-path: polygon(0px 0px, 100% 0px, 100% 100%, 0px 100%);">
    <div class="jarallax-img" style="background-image: url('<?php echo base_url() . 'assets/img/show_image.png'; ?>'); object-fit: cover; object-position: 50% 50%; max-width: none; position: fixed; top: 0px; left: 0px; width: 100%; height: 796.35px; overflow: hidden; pointer-events: none; transform-style: preserve-3d; backface-visibility: hidden; will-change: transform, opacity; margin-top: 66.325px; transform: translate3d(0px, -39.725px, 0px);" data-jarallax-original-styles="background-image: url('<?php echo base_url() . 'assets/img/show_image.png'; ?>');"></div>
  </div>
</div>
<section class="container mt-4 mb-lg-5 pt-lg-2 pt-4 pb-5">
  <!-- Page title + Layout switcher + Search form -->
  <div class="row align-items-end gy-3 mb-4 pb-lg-3 pb-1">
    <div class="col-lg-5 col-md-4">
      <h1 class="mb-2 mb-md-0"></h1>
    </div>
  </div>
  <!--  -->
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
              <img src="<?php echo base_url() . 'assets/icon/' . $row_shop_nature->shop_nature_id . '.png'; ?>" class="card-img-top" alt="Image">
            </div>
            <div class="card-body p-2">
              <p class="fs-sm mb-1 text-center" style="font-weight: bold;"><?php echo $row_shop_nature->shop_nature_name; ?></p>
              <hr>
              <p class="fs-xs mt-1"><?php echo $row_shop_nature->shop_nature_name . ' ' . $row_shop_nature->shop_nature_name  . ' ' . $row_shop_nature->shop_nature_name  . ' ' . $row_shop_nature->shop_nature_name; ?></p>
            </div>
          </article>
        </div>
    <?php
      }
    }
    ?>
  </div>
</section>