<!-- <div class="site__body">
  <div class="block-space block-space--layout--after-header"></div>
  <div class="block">
    <div class="container">
      <div class="row">
        <div class="col-md"></div>
        <div class="col-md-5 d-flex">
          <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
            <div class="card-body card-body--padding--2">
              <h3 class="card-title text-center"><i class="fas fa-unlock-alt"></i> ซิงค์ข้อมูล</h3>
              <form class="account-menu__form" id="form-sunc" method="post" action="<?php //echo base_url() . 'register/dosync'; 
                                                                                    ?>" autocomplete="off">
                <div class="text-center" id="flash_message">
                  <?php
                  if ($this->session->flashdata('flash_message_form') != '') {
                  ?>
                    <?php
                    echo $this->session->flashdata('flash_message_form');
                    ?>
                    <br>
                  <?php
                  }
                  ?>
                </div>
                <div class="form-group">
                  <label for="">เลือกคลินิก ที่ไปใช้งานล่าสุด</label>
                </div>
                <div class="form-group">
                  <label for="customer_id_pri">เพื่อซิงค์ข้อมูลส่วนตัว</label>
                  <select class="form-control" id="customer_id_pri" name="customer_id_pri" required="">
                    <?php
                    foreach ($customers->result() as $row) {
                    ?>
                      <option value="<?php //echo $row->customer_id_pri; 
                                      ?>"><?php //echo '(' . $row->shop_name . ') ' . $row->customer_fname . ' ' . $row->customer_lname . ($row->shop_province != '' ? ' (' . $row->shop_province . ')' : ''); 
                                          ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <hr>
                <div class="form-group">
                  <label class="form-label">รหัสผ่าน</label>
                  <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password" required>
                </div>
                <div class="form-group">
                  <label class="form-label">ยืนยันรหัสผ่าน</label>
                  <input type="password" id="password_confirm" name="password_confirm" class="form-control form-control-sm" onchange="checkPassword()" required>
                </div>
                <div class="form-group mb-0">
                  <button type="submit" id="btn-form-modal" class="btn btn-block text-white btn-circle" style="background: #1A79FF;padding: 11px;"> ยืนยันการซิงค์ข้อมูล</button>
                </div>
                <hr>
                <div class="account-menu__form-link">
                  <a href="<?php //echo base_url() . 'authen'; 
                            ?>"><i class="fas fa-sign-in-alt"></i> กลับหน้าเข้าสู่ระบบ</a>
                </div>

              </form>
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
  $(function() {
    $('#form-sunc').parsley();
  });

  function checkPassword() {
    let password = $('#password').val()
    let password_confirm = $('#password_confirm').val()
    if (password.length >= 6 && password_confirm.length >= 6) {
      if (password == password_confirm) {
        $('#btn-form-modal').prop('disabled', false)
        notification('success', 'ทำรายการเรียบร้อยแล้ว', 'กดตกลงเพื่อเปลี่ยนรหัสผ่าน')
      } else {
        $('#btn-form-modal').prop('disabled', true)
        notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
      }
    } else {
      $('#btn-form-modal').prop('disabled', true)
      notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
    }
  }

  $('#flash_message').delay(5000).fadeOut(1000);
</script> -->

<section class="position-relative h-100 pt-5 pb-4">
  <!-- Sign in form -->
  <div class="container d-flex flex-wrap justify-content-center justify-content-xl-start h-100 pt-5">
    <div class="w-100 align-self-end pt-5 pt-md-5 pb-5" style="max-width: 526px;">
      <article class="card border-0 shadow-sm h-100">
        <div class="card-body p-5">
          <h1 class="text-center">ซิงค์ข้อมูล</h1>
          <h2 class="text-center pb-3 mb-3">Envyz.me</h2>
          <form id="form-sync" class="needs-validation mb-2 pb-4" novalidate="" method="post" action="<?php echo base_url() . 'register/dosync'; ?>" autocomplete="off">
            <div class="position-relative mb-4">
              <div class="form-group pb-2">
                <label for="customer_id_pri" class="form-label fs-base pb-2">เลือกคลินิกที่ไปใช้งาน เพื่อซิงค์ข้อมูลส่วนตัว</label>
                <select class="form-control form-control-lg" id="customer_id_pri" name="customer_id_pri" required="">
                  <?php
                  foreach ($customers->result() as $row) {
                  ?>
                    <option value="<?php echo $row->customer_id_pri; ?>"><?php echo '(' . $row->shop_name . ') ' . $row->customer_fname . ' ' . $row->customer_lname . ($row->shop_province != '' ? ' (' . $row->shop_province . ')' : ''); ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group pb-2">
                <label for="password" class="form-label fs-base pb-2">เบอร์โทรศัพท์</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" autocomplete="new-password" placeholder="Password" required="">
              </div>
              <div class="form-group pb-2">
                <label for="password_confirm" class="form-label fs-base pb-2">ยืนยันรหัสผ่าน</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control form-control-lg" placeholder="Confirm Password" onchange="checkPassword()" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary shadow-primary btn-lg w-100 pt-2">ยืนยันการซิงค์ข้อมูล</button>
          </form>
          <hr>
          <p class="pt-4 text-center" style="font-weight: bold;"><a href="<?php echo base_url() . 'authen'; ?>"><i class="fas fa-sign-in-alt"></i> กลับหน้าเข้าสู่ระบบ</a></p>
        </div>
      </article>
    </div>
  </div>

  <!-- Background -->
  <div class="position-absolute top-0 end-0 w-50 h-100 bg-position-center bg-repeat-0 bg-size-cover d-none d-xl-block" style="background-image: url(<?php echo base_url() . 'assets/img/account/signin-bg2.png'; ?>);"></div>
</section>
<script>
  $(function() {
    $('#form-sync').parsley();
  });

  function checkPassword() {
    let password = $('#password').val()
    let password_confirm = $('#password_confirm').val()
    if (password.length >= 6 && password_confirm.length >= 6) {
      if (password == password_confirm) {
        $('#btn-form-modal').prop('disabled', false)
        notification('success', 'ทำรายการเรียบร้อยแล้ว', 'กดตกลงเพื่อเปลี่ยนรหัสผ่าน')
      } else {
        $('#btn-form-modal').prop('disabled', true)
        notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
      }
    } else {
      $('#btn-form-modal').prop('disabled', true)
      notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
    }
  }

  $('#flash_message').delay(5000).fadeOut(1000);
</script>