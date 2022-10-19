<!-- <div class="account-nav flex-grow-1 mb-3">
    <h4 class="account-nav__title">เมนูสมาชิก</h4>
    <ul class="account-nav__list">
        <li class="account-nav__item <?php echo ($navacc == 'profile' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'profile'; ?>" class="font-text"><i class="far fa-user-circle me-2"></i> ข้อมูลส่วนตัว <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'appoint' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'appoint'; ?>" class="font-text"><i class="fa fa-calendar me-2"></i> ปฏิทินนัดหมาย <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'cart' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'cart'; ?>" class="font-text"><i class="fa fa-shopping-basket me-2"></i> ตะกร้าสินค้า <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'order' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'order'; ?>" class="font-text"><i class="fa fa-shopping-cart me-2"></i> ประวัติการสั่งซื้อ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'opdcard' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'opdcard'; ?>" class="font-text"> <i class="fa fa-book me-2"></i> ประวัติการรักษา OPD <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'services' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'services'; ?>" class="font-text"> <i class="fa fa-list me-2"></i> บริการ/คอร์ส <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'servingreview' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'servingreview'; ?>" class="font-text"> <i class="fa fa-star me-2"></i> รีวิวหลังการใช้บริการ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'logpoint' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'logpoint'; ?>" class="font-text"> <i class="fab fa-product-hunt me-2"></i> ประวัติแต้ม <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'promotionbirthdate' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'promotionbirthdate'; ?>" class="font-text"> <i class="fa fa-birthday-cake me-2"></i> บริการแนะนำ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
        <li class="account-nav__divider" role="presentation"></li>
        <li class="account-nav__item">
            <a href="<?php echo base_url() . 'authen/logout'; ?>" class="font-text"><i class="fas fa-sign-out-alt me-2"></i> ออกจากระบบ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right me-2"></i></span></a>
        </li>
    </ul>
</div>
<style>
    .account-nav__item{
        padding: 5px 0px 5px 0px;
    }
    .font-text{
        font-size: 18px;
    }
</style> -->
<button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
  <i class="bx bxs-user-detail fs-xl fw-bold me-2 me-2"></i>
  เมนูสมาชิก
  <i class="bx bx-chevron-down fw-bold fs-lg ms-1 me-2"></i>
</button>
<div id="account-menu" class="list-group list-group-flush collapse d-md-block">
  <a href="<?php echo base_url() . 'profile'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'profile' ? ' active' : ''); ?>">
    <i class="bx bx-user-circle fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ข้อมูลส่วนตัว
  </a>
  <a href="<?php echo base_url() . 'appoint'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'appoint' ? ' active' : ''); ?>">
    <i class="bx bx-calendar fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ปฏิทินนัดหมาย
  </a>
  <a href="<?php echo base_url() . 'cart'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'cart' ? ' active' : ''); ?>">
    <i class="bx bx-cart fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ตะกร้าสินค้า
  </a>
  <a href="<?php echo base_url() . 'order'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'order' ? ' active' : ''); ?>">
    <i class="bx bx-store fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ประวัติการสั่งซื้อ
  </a>
  <a href="<?php echo base_url() . 'opdcard'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'opdcard' ? ' active' : ''); ?>">
    <i class="bx bx-id-card fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ประวัติการรักษา OPD
  </a>
  <a href="<?php echo base_url() . 'services'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'services' ? ' active' : ''); ?>">
    <i class="bx bx-list-ul fw-bold fs-xl opacity-60 me-2 me-2"></i>
    บริการ/คอร์ส
  </a>
  <a href="<?php echo base_url() . 'servingreview'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'servingreview' ? ' active' : ''); ?>">
    <i class="bx bx-star fs-xl fw-bold opacity-60 me-2 me-2"></i>
    รีวิวหลังการใช้บริการ
  </a>
  <a href="<?php echo base_url() . 'logpoint'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'logpoint' ? ' active' : ''); ?>">
    <i class="bx bx-book-content fw-bold fs-xl opacity-60 me-2 me-2"></i>
    ประวัติแต้ม
  </a>
  <a href="<?php echo base_url() . 'promotionbirthdate'; ?>" class="list-group-item list-group-item-action d-flex align-items-center <?php echo ($navacc == 'promotionbirthdate' ? ' active' : ''); ?>">
    <i class="bx bx-gift fs-xl fw-bold opacity-60 me-2 me-2"></i>
    บริการแนะนำ
  </a>
  <a href="<?php echo base_url() . 'authen/logout'; ?>" class="list-group-item list-group-item-action d-flex align-items-center">
    <i class="bx bx-log-out fs-xl fw-bold opacity-60 me-2 me-2"></i>
    ออกจากระบบ
  </a>
</div>