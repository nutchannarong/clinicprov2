<!-- Footer -->
<footer class="footer dark-mode bg-dark pt-5 pb-4 pb-lg-5">
  <div class="container pt-lg-4">
    <div class="row pb-5">
      <div class="col-lg-4 col-md-6">
        <div class="navbar-brand text-dark p-0 me-0 mb-3 mb-lg-4">
          <img src="<?php echo base_url() . 'assets/img/logo.svg'; ?>" width="47" alt="Silicon">
          ClinicPRO
        </div>
        <p class="fs-md text-light pb-lg-3 mb-4">ศูนย์รวมโปรโมชั่นคลินิก<br>แหล่งบริการสุขภาพและความงามทุกประเภท<br>รีวิวข้อมูล ข่าวสารที่เกี่ยวข้อง</p>
        <h5 class="text-light">เข้าถึงโปรโมชั่นเร็วก่อนใคร</h5>
        <div class="row pb-2">
          <div class="col-lg-6 col-md-6">
            <img src="<?php echo base_url() . 'assets/img/qrcode.png'; ?>" style="max-height: 140px;" class="img-responsive">
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="row">
              <div class="col-lg-12 col-md-6 pb-2">
                <img src="<?php echo base_url() . 'assets/img/play-store.jpg'; ?>" style="max-height: 70px;" class="img-responsive">
              </div>
              <div class="col-lg-12 col-md-6">
                <img src="<?php echo base_url() . 'assets/img/apple-store.jpg'; ?>" style="max-height: 70px;" class="img-responsive">
              </div>
            </div>
          </div>
        </div>
        <img src="<?php echo base_url() . 'assets/img/payments.png'; ?>" class="img-responsive">
      </div>
      <div class="col-xl-6 col-lg-7 col-md-5 offset-xl-2 offset-md-1 pt-4 pt-md-1 pt-lg-0">
        <div id="footer-links" class="row">
          <div class="col-lg-6">
            <h6 class="mb-2">
              <a href="#useful-links" class="d-block text-dark dropdown-toggle d-lg-none py-2" data-bs-toggle="collapse">ลิงค์ที่เป็นประโยชน์</a>
            </h6>
            <div id="useful-links" class="collapse d-lg-block" data-bs-parent="#footer-links">
              <ul class="nav flex-column pb-lg-1 mb-lg-3">
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">เกี่ยวกับเรา</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">ข้อตกลงและเงื่อนไข</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">นโยบายความเป็นส่วนตัว</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">โปรโมชั่น</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">ค้นหาคลินิก</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">เข้าสู่ระบบ</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">สำหรับเจ้าของคลินิก</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">รีวิว</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">บทความ</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">ติดต่อเรา</a></li>
                <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">ผังเว็บไซต์</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-6 col-lg-5 pt-0 pt-lg-0">
            <h5 class="text-light">ฝ่ายบริการลูกค้า</h5>
            <p class="">098-181-6769</p>
            <p class="">apsth456@gmail.com</p>
            <p class="">@apsth456</p>
            <p class="">09.00 - 17.00 น.</p>
            <p class="">จันทร์ - ศุกร์ (ยกเว้นวันหยุดนักขัตฤกษ์)</p>
            <h5 class="text-light">ติดตามเราได้ที่</h5>
            <p class=""><a href="#" class="nav-link d-inline-block">https://www.clinicpro.app</a></p>
            <p class=""><a href="#" class="nav-link d-inline-block">facebook Apsth</a></p>
          </div>
        </div>
      </div>
    </div>
    <p class="nav d-block fs-md text-center text-md-start pb-2 pb-lg-0 mb-0">
      <span class="text-light opacity-50">&copy; All rights reserved. Made by </span>
      <a class="nav-link d-inline-block p-0" href="https://createx.studio/" target="_blank" rel="noopener">Createx Studio</a>
    </p>
  </div>
</footer>

<style>
  .avatar-upload {
    position: relative;
    max-width: 205px;
  }

  .avatar-upload .avatar-edit {
    position: absolute;
    right: 12px;
    z-index: 1;
    top: 10px;
  }

  .avatar-upload .avatar-edit input {
    display: none;
  }

  .avatar-upload .avatar-edit input+label {
    display: inline-block;
    width: 34px;
    height: 34px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #ffffff;
    border: 1px solid transparent;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
  }

  .avatar-upload .avatar-edit input+label:hover {
    background: #f1f1f1;
    border-color: #d6d6d6;
  }

  .avatar-upload .avatar-edit input+label:after {
    /* content: "\f040"; */
    /* font-family: "FontAwesome"; */
    color: #757575;
    position: absolute;
    top: 20px;
    left: 0;
    right: 0;
    text-align: center;
    margin: auto;
  }

  .avatar-upload .avatar-preview {
    width: 192px;
    height: 192px;
    position: relative;
    border-radius: 100%;
    border: 6px solid #f8f8f8;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
  }

  .avatar-upload .avatar-preview>div {
    width: 100%;
    height: 100%;
    border-radius: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
</style>

<!-- Back to top button -->
<a href="#top" class="btn-scroll-top" data-scroll>
  <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span>
  <i class="btn-scroll-top-icon bx bx-chevron-up me-2"></i>
</a>


<!-- Vendor Scripts -->
<script src="<?php echo base_url() . 'assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js'; ?>"></script>

<!-- Main Theme Script -->
<script src="<?php echo base_url() . 'assets/js/theme.min.js'; ?>"></script>

</body>

</html>