<!-- Page wrapper for sticky footer -->
<!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
<main class="page-wrapper">
  <!-- Navbar -->
  <!-- Remove "fixed-top" class to make navigation bar scrollable with the page -->
  <header class="header navbar navbar-expand-lg bg-light fixed-top">
    <div class="container px-3">
      <a href="index.html" class="navbar-brand pe-3">
        <img src="<?php echo base_url() . 'assets/img/logo.svg'; ?>" width="47" alt="Envyz.me">
        Envyz.me
      </a>
      <div id="navbarNav" class="offcanvas offcanvas-end">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title">เข้าสู่ระบบ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a href="components/typography.html" class="nav-link">หน้าแรก</a>
            </li>
            <li class="nav-item">
              <a href="docs/getting-started.html" class="nav-link">โปรโมชั่น</a>
            </li>
            <li class="nav-item">
              <a href="docs/getting-started.html" class="nav-link">ค้นหาคลินิก</a>
            </li>
            <li class="nav-item">
              <a href="docs/getting-started.html" class="nav-link">รีวิว</a>
            </li>
            <li class="nav-item">
              <a href="docs/getting-started.html" class="nav-link">บทความ</a>
            </li>
            <li class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-current="page">ประเภทคลินิค</a>
              <ul class="dropdown-menu">
                <?php
                $get_shop_nature = $this->global_model->getShopNature();
                if ($get_shop_nature->num_rows() > 0) {
                  foreach ($get_shop_nature->result() as $row_shop_nature) {
                ?>
                    <li>
                      <a href="<?php echo base_url() . 'promotions?nature_name=' . $row_shop_nature->shop_nature_name; ?>" class="dropdown-item">
                        <?php echo $row_shop_nature->shop_nature_name; ?>
                      </a>
                    </li>
                <?php
                  }
                }
                ?>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="pe-lg-1 ms-auto me-4 d-none d-lg-inline-flex">
        <div class="input-group">
          <input type="text" class="form-control form-control-sm rounded-start ps-5" placeholder="ค้นหาชื่อร้านหรือ บริการ">
          <i class="bx bx-search fs-lg text-muted position-absolute top-50 start-0 translate-middle-y ms-3 zindex-5"></i>
          <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </div>
      </div>
      <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <?php if ($this->session->userdata('islogin') == 1) {
        $get_online = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row(); ?>
        <div id="navbarNav1" class="offcanvas offcanvas-end">
          <div class="offcanvas-body">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                  <div class="row">
                    <div class="col-12">
                      <span class="fs-sm" style="padding-bottom; 0px"><?php echo $get_online->online_fname . ' ' . $get_online->online_lname; ?></span>
                    </div>
                    <div class="col-12">
                      <span class="fs-sm"><?php echo number_format($get_online->online_point); ?> เเต้ม </span>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="<?php echo base_url() . 'profile'; ?>" class="dropdown-item">
                      ข้อมูลส่วนตัว
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'appoint'; ?>" class="dropdown-item">
                      ปฏิทินนัดหมาย
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'cart'; ?>" class="dropdown-item">
                      ตะกร้าสินค้า
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'order'; ?>" class="dropdown-item">
                      ประวัติการสั่งซื้อ
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'opdcard'; ?>" class="dropdown-item">
                      ประวัติการรักษา OPD
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'services'; ?>" class="dropdown-item">
                      บริการ/คอร์ส
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'servingreview'; ?>" class="dropdown-item">
                      รีวิวหลังการใช้บริการ
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'logpoint'; ?>" class="dropdown-item">
                      ประวัติแต้ม
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo base_url() . 'promotionbirthdate'; ?>" class="dropdown-item">
                      บริการแนะนำ
                    </a>
                  </li>
                  <hr>
                  <li>
                    <a style="color: #6366f1; font-weight: bold;" href="<?php echo base_url() . 'authen/logout'; ?>" class="dropdown-item">
                      ออกจากระบบ
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarNav1" aria-controls="navbarNav1" aria-expanded="false" aria-label="Toggle navigation">
          <i class="bx bx-user-circle fs-5 lh-1 me-1"></i>
        </button>
      <?php } else { ?>
        <a href="<?php echo base_url() . 'authen'; ?>" class="btn btn-primary btn-sm fs-sm rounded d-none d-lg-inline-flex" rel="noopener">
          <i class="bx bx-user-circle fs-5 lh-1 me-1"></i>
          &nbsp;เข้าสู่ระบบ
        </a>
      <?php } ?>
    </div>
  </header>

  <!-- Page content -->
  <section class="container">

  </section>
</main>