<!-- <div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md"></div>
                <div class="col-md-5 mt-2 d-flex">
                    <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
                        <div class="card-body card-body--padding--2">
                            <h3 class="card-title text-center"><i class="fas fa-unlock-alt me-2"></i> เข้าสู่ระบบสมาชิก</h3>
                            <form class="account-menu__form" style="padding-bottom: 0px;" id="form-login" method="post" action="<?php //echo base_url() . 'authen/doauthen'; 
                                                                                                                                ?>" autocomplete="off">
                                <div class="text-center" id="flash_message">
                                    <?php
                                    // if ($this->session->flashdata('flash_message_form') != '') {
                                    // 
                                    ?>
                                    //     <?php
                                            //     echo $this->session->flashdata('flash_message_form');
                                            //     
                                            ?>
                                    //     <br>
                                    //     <?php
                                            //   }
                                            ?>
                                </div>
                                <div class="form-group">
                                    <label for="tel">เบอร์โทรศัพท์</label>
                                    <input id="tel" name="tel" type="number" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" autocomplete="new-username" required="" maxlength="12" onkeypress="return isNumberKey(event)" autofocus>
                                </div>  
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-block text-white btn-circle" style="background: #1A79FF;padding: 11px;"> เข้าสู่ระบบด้วยเบอร์โทรศัพท์</button>                                    
                                </div>
                            </form>
                            <div class="account-menu__form" style="padding-top: 0px;">
                                <hr>
                                <div class="account-menu__form-link">
                                    <a href="<?php //echo base_url() . 'forget'; 
                                              ?>"><i class="fa fa-key me-2"></i> ลืมรหัสผ่าน</a> | 
                                    <a href="<?php //echo admin_url(); 
                                              ?>" target="_blank"><i class="fas fa-sign-in-alt me-2"></i> สำหรับเจ้าของคลินิก</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md"></div>
            </div>
        </div>
    </div>
    <div class="block-space block-space--layout--before-footer"></div>
</div>
<script>
    $(function () {
        $('#form-login').parsley();
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57) && charCode != 43) {
            return false;
        }
        return true;
    }

    $('#flash_message').delay(5000).fadeOut(1000);
</script> -->

<section class="position-relative h-100 pt-5 pb-4">
  <!-- Sign in form -->
  <div class="container d-flex flex-wrap justify-content-center justify-content-xl-start h-100 pt-5 pb-4">
    <div class="w-100 align-self-end pt-5 pt-md-5" style="max-width: 526px;">
      <article class="card border-0 shadow-sm h-100">
        <div class="card-body p-5 pb-4 pb-0">
          <h1 class="text-center">เข้าสู่ระบบ</h1>
          <h2 class="text-center pb-3 mb-3">Envyz.me</h2>
          <form id="form-login" class="needs-validation mb-2" novalidate="" method="post" action="<?php echo base_url() . 'authen/doauthen'; ?>" autocomplete="off">
            <div class="position-relative mb-4">
              <div class="text-center" id="flash_message">
                <?php
                if ($this->session->flashdata('flash_message_form') != '') {
                  echo $this->session->flashdata('flash_message_form') . ' <br>';
                }
                ?>
              </div>
              <label for="tel" class="form-label fs-base pb-2">เบอร์โทรศัพท์</label>
              <input type="text" id="tel" name="tel" class="form-control form-control-lg" placeholder="กรอกเบอร์โทรศัพท์" required="">
              <div class="invalid-feedback position-absolute start-0 top-100">กรุณากรอกข้อมูล</div>
            </div>
            <button type="submit" class="btn btn-primary shadow-primary btn-lg w-100 pt-2">เข้าสู่ระบบด้วยเบอร์โทรศัพท์</button>
          </form>
          <div class="row row-cols-1 row-cols-sm-2 pt-3 pb-2">
            <div class="col mb-3">
              <a href="<?php echo base_url() . 'forget'; ?>" class="btn btn-icon btn-secondary btn-google btn-lg w-100">
                <i class="bx bx-key fs-xl me-2 me-2"></i>
                ลืมรหัสผ่าน
              </a>
            </div>
            <div class="col mb-3">
              <a href="<?php echo admin_url(); ?>" class="btn btn-icon btn-secondary btn-facebook btn-lg w-100">
                <i class="bx bx-user-circle fs-xl me-2 me-2"></i>
                สำหรับเจ้าของคลินิก
              </a>
            </div>
          </div>
          <hr>
          <p class="pt-4 text-center" style="font-weight: bold;">เว็บไซต์นี้ได้เข้ารหัสแบบ SSL 256-bit<br>ข้อมูลของคุณจะได้รับการป้องกัน</p>
        </div>
      </article>
    </div>
  </div>

  <!-- Background -->
  <div class="position-absolute top-0 end-0 w-50 h-100 bg-position-center bg-repeat-0 bg-size-cover d-none d-xl-block" style="background-image: url(<?php echo base_url() . 'assets/img/account/signin-bg2.png'; ?>);"></div>
</section>
<script>
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode < 48 || charCode > 57) && charCode != 43) {
      return false;
    }
    return true;
  }
  $('#flash_message').delay(5000).fadeOut(1000);
  
</script>