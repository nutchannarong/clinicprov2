<div class="account-nav flex-grow-1 mb-3">
    <h4 class="account-nav__title">เมนูสมาชิก</h4>
    <ul class="account-nav__list">
        <li class="account-nav__item <?php echo ($navacc == 'profile' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'profile'; ?>" class="font-text"><i class="far fa-user-circle"></i> ข้อมูลส่วนตัว <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'appoint' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'appoint'; ?>" class="font-text"><i class="fa fa-calendar"></i> ปฏิทินนัดหมาย <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'cart' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'cart'; ?>" class="font-text"><i class="fa fa-shopping-basket"></i> ตะกร้าสินค้า <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'order' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'order'; ?>" class="font-text"><i class="fa fa-shopping-cart"></i> ประวัติการสั่งซื้อ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'opdcard' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'opdcard'; ?>" class="font-text"> <i class="fa fa-book"></i> ประวัติการรักษา OPD <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'services' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'services'; ?>" class="font-text"> <i class="fa fa-list"></i> บริการ/คอร์ส <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'servingreview' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'servingreview'; ?>" class="font-text"> <i class="fa fa-star"></i> รีวิวหลังการใช้บริการ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'logpoint' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'logpoint'; ?>" class="font-text"> <i class="fab fa-product-hunt"></i> ประวัติแต้ม <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__item <?php echo ($navacc == 'promotionbirthdate' ? ' account-nav__item--active' : ''); ?>">
            <a href="<?php echo base_url() . 'promotionbirthdate'; ?>" class="font-text"> <i class="fa fa-birthday-cake"></i> บริการแนะนำ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
        </li>
        <li class="account-nav__divider" role="presentation"></li>
        <li class="account-nav__item">
            <a href="<?php echo base_url() . 'authen/logout'; ?>" class="font-text"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ <span class="float-right d-none d-sm-none d-md-block d-lg-block d-xl-block"> <i class="fa fa-angle-right"></i></span></a>
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
</style>