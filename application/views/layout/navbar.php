<!-- Page wrapper for sticky footer -->
<!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
<main class="page-wrapper">
  <!-- Navbar -->
  <!-- Remove "fixed-top" class to make navigation bar scrollable with the page -->
  <header class="header navbar navbar-expand-lg bg-light fixed-top">
    <div class="container px-3">
      <a href="index.html" class="navbar-brand pe-3">
        <img src="assets/img/logo.svg" width="47" alt="Envyz.me">
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
      <a href="https://themes.getbootstrap.com/product/silicon-business-technology-template-ui-kit/" class="btn btn-primary btn-sm fs-sm rounded d-none d-lg-inline-flex" target="_blank" rel="noopener">
        <i class="bx bx-user-circle fs-5 lh-1 me-1"></i>
        &nbsp;เข้าสู่ระบบ
      </a>
    </div>
  </header>

  <!-- Page content -->
  <section class="container">

  </section>
</main>