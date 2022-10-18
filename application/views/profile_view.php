<!-- <div class="site__body">
  <div class="block mt-5 mb-5">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-12 col-xl-3 d-flex">
              <?php //$this->load->view('layout/navbar-account', array('navacc' => 'profile')); 
              ?>
            </div>
            <div class="col-12 col-xl-9 mb-5">
              <div class="card">
                <div class="card-header">
                  <h5>ข้อมูลส่วนตัว</h5>
                </div>
                <div class="card-divider"></div>
                <div class="card-body card-body--padding--2">
                  <form id="form-edit-profile" method="post" action="<?php echo base_url() . 'profile/update'; ?>" autocomplete="off">
                    <div class="row">
                      <div class="col-md-12 col-lg-2 col-xl-2 text-center">
                        <label class="col-form-label">รูปประจำตัว</label>
                        <a id="image_a" href="<?php echo $data->online_image != '' ? admin_url() . 'assets/upload/online/' . $data->online_image : admin_url() . 'assets/upload/online/none.png'; ?>" class="fancybox">
                          <img id="image_show" src="<?php echo $data->online_image != '' ? admin_url() . 'assets/upload/online/' . $data->online_image : admin_url() . 'assets/upload/online/none.png'; ?>" width="100%">
                        </a>
                        <input type="file" accept="image/*" name="online_image" id="upload-image" onchange="uploadImage();" style="display: none">
                        <label for="upload-image" class="btn btn-info btn-sm btn-block m-t-10"><i class="fa fa-image"></i> อัพโหลดรูป</label>
                      </div>
                      <div class="col-md-12 col-lg-10 col-xl-10">
                        <div class="row">
                          <div class="col-lg-4 col-xl-3">
                            <div class="form-group">
                              <label class="col-form-label">คำนำหน้า <span class="text-danger">*</span></label>
                              <select name="online_prefix" class="form-control bg-white" required>
                                <option value="">เลือกคำนำหน้า</option>
                                <option value="นาย" <?php echo $data->online_prefix == 'นาย' ? 'selected' : ''; ?>>นาย</option>
                                <option value="นางสาว" <?php echo $data->online_prefix == 'นางสาว' ? 'selected' : ''; ?>>นางสาว</option>
                                <option value="นาง" <?php echo $data->online_prefix == 'นาง' ? 'selected' : ''; ?>>นาง</option>
                                <option value="Mr." <?php echo $data->online_prefix == 'Mr.' ? 'selected' : ''; ?>>Mr.</option>
                                <option value="Mrs." <?php echo $data->online_prefix == 'Mrs.' ? 'selected' : ''; ?>>Mrs.</option>
                                <option value="Miss." <?php echo $data->online_prefix == 'Miss.' ? 'selected' : ''; ?>>Miss.</option>
                                <option value="ด.ช." <?php echo $data->online_prefix == 'ด.ช.' ? 'selected' : ''; ?>>ด.ช.</option>
                                <option value="ด.ญ." <?php echo $data->online_prefix == 'ด.ญ.' ? 'selected' : ''; ?>>ด.ญ.</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-4 col-xl">
                            <div class="form-group">
                              <label class="col-form-label">ชื่อ <span class="text-danger">*</span></label>
                              <input type="text" name="online_fname" class="form-control bg-white" value="<?php echo $data->online_fname; ?>" required>
                            </div>
                          </div>
                          <div class="col-lg-4 col-xl">
                            <div class="form-group">
                              <label class="col-form-label">สกุล <span class="text-danger">*</span></label>
                              <input type="text" name="online_lname" class="form-control bg-white" value="<?php echo $data->online_lname; ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg col-xl">
                            <div class="form-group">
                              <label class="col-form-label">กรุ๊ปเลือด <span class="text-danger">*</span></label>
                              <select name="online_blood" class="form-control bg-white" required>
                                <option value="">เลือกกรุ๊ปเลือด</option>
                                <option value="A+" <?php echo $data->online_blood == 'A+' ? 'selected' : ''; ?>>A+</option>
                                <option value="A-" <?php echo $data->online_blood == 'A-' ? 'selected' : ''; ?>>A-</option>
                                <option value="AB+" <?php echo $data->online_blood == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                                <option value="AB-" <?php echo $data->online_blood == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                                <option value="B+" <?php echo $data->online_blood == 'B+' ? 'selected' : ''; ?>>B+</option>
                                <option value="B-" <?php echo $data->online_blood == 'B-' ? 'selected' : ''; ?>>B-</option>
                                <option value="O+" <?php echo $data->online_blood == 'O+' ? 'selected' : ''; ?>>O+</option>
                                <option value="O-" <?php echo $data->online_blood == 'O-' ? 'selected' : ''; ?>>O-</option>
                                <option value="ไม่แน่ใจ" <?php echo $data->online_blood == 'ไม่แน่ใจ' ? 'selected' : ''; ?>>ไม่แน่ใจ</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg col-xl">
                            <div class="form-group">
                              <label class="col-form-label">เพศ <span class="text-danger">*</span></label>
                              <select name="online_gender" class="form-control bg-white" required>
                                <option value="">เลือกเพศ</option>
                                <option value="ชาย" <?php echo $data->online_gender == 'ชาย' ? 'selected' : ''; ?>>ชาย</option>
                                <option value="หญิง" <?php echo $data->online_gender == 'หญิง' ? 'selected' : ''; ?>>หญิง</option>
                                <option value="Male" <?php echo $data->online_gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $data->online_gender == 'Female' ? 'selected' : ''; ?>>Female</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg col-xl">
                            <div class="form-group">
                              <label class="col-form-label">วันเกิด <span class="text-danger">*</span></label>
                              <input type="text" value="<?php echo $data->online_birthdate; ?>" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="col-lg-4 col-xl-4">
                            <div class="form-group">
                              <label class="col-form-label">เลขบัตรประชาชน</label>
                              <input type="text" name="online_idcard" class="form-control bg-white" value="<?php echo $data->online_idcard; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-4 col-xl-3">
                            <label class="col-form-label">เบอร์โทร</label>
                            <input type="text" class="form-control" disabled value="<?php echo $data->online_tel; ?>">
                          </div>
                          <div class="col-lg-4 col-xl">
                            <label class="col-form-label">อีเมล์ <span class="text-danger">*</span></label>
                            <input type="email" name="online_email" class="form-control bg-white" value="<?php echo $data->online_email; ?>" required>
                          </div>
                          <div class="col-lg-4 col-xl-5">
                            <label class="col-form-label">ที่อยู่ <span class="text-danger">*</span></label>
                            <input type="text" name="online_address" class="form-control bg-white" value="<?php echo $data->online_address; ?>" required>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-lg-4 col-xl">
                            <label class="col-form-label">ตำบล <span class="text-danger">*</span></label>
                            <input type="text" name="online_district" class="form-control bg-white" value="<?php echo $data->online_district; ?>" required>
                          </div>
                          <div class="col-lg-4 col-xl">
                            <label class="col-form-label">อำเภอ <span class="text-danger">*</span></label>
                            <input type="text" name="online_amphoe" class="form-control bg-white" value="<?php echo $data->online_amphoe; ?>" required>
                          </div>
                          <div class="col-lg-4 col-xl">
                            <label class="col-form-label">จังหวัด <span class="text-danger">*</span></label>
                            <input type="text" name="online_province" class="form-control bg-white" value="<?php echo $data->online_province; ?>" required>
                          </div>
                          <div class="col-lg-4 col-xl">
                            <label class="col-form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                            <input type="text" name="online_zipcode" class="form-control bg-white" value="<?php echo $data->online_zipcode; ?>" required>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col-lg-4 col-xl">
                            <input type="checkbox" name="subscribe_id" value="1" id="subscribe_id" <?php echo ($data->subscribe_id == 1 ? 'checked="checked"' : ''); ?>>&nbsp;
                            <label for="subscribe_id" class="col-form-label">ยอมรับการแจ้งเตือนข่าวสารโปรโมชั่นผ่านอีเมล์ </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl text-left mt-2">
                        <?php
                        if ($data->online_password != NULL) {
                        ?>
                          <button type="button" class="btn btn-info btn-sm mt-2" onclick="modalEditPassword()"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</button>
                        <?php
                        }
                        ?>
                      </div>
                      <div class="col-xl text-right mt-2">
                        <button type="submit" class="btn btn-primary mt-2"><i class="fa fa-save"></i> บันทึก</button>
                        <button type="reset" class="btn btn-danger mt-2"> <i class="fa fa-times-circle"></i> ยกเลิก</button>
                      </div>
                    </div>
                  </form>
                  <hr>
                  <div class="row">
                    <div class="col-lg-5">
                      <label class="col-form-label">เชื่อมต่อเพื่อเข้าระบบด้วย Facebook</label>
                      <?php
                      if ($data->facebook_id != '') {
                      ?>
                        <button onclick="unlinkfacebook();" class="btn btn-block text-white btn-circle pl-3 pr-3 mt-3" style="background: #c2c2c2;"><img class="" src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="20" style="background: #FFFFFF;"> เชื่อม Facebook แล้ว</button>
                      <?php
                      } else {
                      ?>
                        <button onclick="linkFacebook();" class="btn btn-block text-white btn-circle pl-3 pr-3 mt-3" style="background: #4267B2;"><img class="" src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="20" style="background: #FFFFFF;"> เชื่อมต่อ Facebook</button>
                      <?php
                      }
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
</div> -->

<!-- Page content -->
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
<section class="container pt-5">
  <div class="row">
    <?php $get_online = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row(); ?>
    <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
      <div class="position-sticky top-0">
        <div class="text-center pt-5">
          <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
            <div class="avatar-upload">
              <div class="avatar-edit">
                <input type="file" accept="image/*" name="online_image" id="upload-image" onchange="uploadImage();">
                <label for="upload-image"><i class="bx bx-pencil" style="font-size: 23px; font-weight: bold; padding-top: 5px;"></i></label>
              </div>
              <div class="avatar-preview">
                <div id="image_show" style="background-image: url('<?php echo $data->online_image != '' ? admin_url() . 'assets/upload/online/' . $data->online_image : admin_url() . 'assets/upload/online/none.png'; ?>');"></div>
              </div>
            </div>
          </div>
          <h2 class="h5 mb-3"><?php echo $get_online->online_fname . ' ' . $get_online->online_lname; ?></h2>
          <?php $this->load->view('layout/navbar-account', array('navacc' => 'profile')); ?>
        </div>
      </div>
    </aside>
    <!-- Account details -->
    <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
      <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
        <h2 class="h2 pt-xl-1 pb-2">ข้อมูลส่วนตัว</h2>
        <!-- Basic info -->
        <form id="form-edit-profile" method="post" action="<?php echo base_url() . 'profile/update'; ?>" autocomplete="off" class="needs-validation border-bottom pb-3 pb-lg-4" novalidate>
          <div class="row pb-2">
            <div class="col-sm-6 mb-3">
              <label for="online_gender" class="form-label fs-base">เพศ <span class="text-danger">*</span></label>
              <select name="online_gender" id="online_gender" class="form-select form-select-md" required>
                <option value="">เลือกเพศ</option>
                <option value="ชาย" <?php echo $data->online_gender == 'ชาย' ? 'selected' : ''; ?>>ชาย</option>
                <option value="หญิง" <?php echo $data->online_gender == 'หญิง' ? 'selected' : ''; ?>>หญิง</option>
                <option value="Male" <?php echo $data->online_gender == 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $data->online_gender == 'Female' ? 'selected' : ''; ?>>Female</option>
              </select>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_prefix" class="form-label fs-base">คำนำหน้า <span class="text-danger">*</span></label>
              <select name="online_prefix" id="online_prefix" class="form-select form-select-md" required>
                <option value="">เลือกคำนำหน้า</option>
                <option value="นาย" <?php echo $data->online_prefix == 'นาย' ? 'selected' : ''; ?>>นาย</option>
                <option value="นางสาว" <?php echo $data->online_prefix == 'นางสาว' ? 'selected' : ''; ?>>นางสาว</option>
                <option value="นาง" <?php echo $data->online_prefix == 'นาง' ? 'selected' : ''; ?>>นาง</option>
                <option value="Mr." <?php echo $data->online_prefix == 'Mr.' ? 'selected' : ''; ?>>Mr.</option>
                <option value="Mrs." <?php echo $data->online_prefix == 'Mrs.' ? 'selected' : ''; ?>>Mrs.</option>
                <option value="Miss." <?php echo $data->online_prefix == 'Miss.' ? 'selected' : ''; ?>>Miss.</option>
                <option value="ด.ช." <?php echo $data->online_prefix == 'ด.ช.' ? 'selected' : ''; ?>>ด.ช.</option>
                <option value="ด.ญ." <?php echo $data->online_prefix == 'ด.ญ.' ? 'selected' : ''; ?>>ด.ญ.</option>
              </select>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_fname" class="form-label fs-base">ชื่อ <span class="text-danger">*</span></label>
              <input type="text" name="online_fname" id="online_fname" class="form-control form-control-md" value="<?php echo $data->online_fname; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_lname" class="form-label fs-base">สกุล <span class="text-danger">*</span></label>
              <input type="text" name="online_lname" id="online_lname" class="form-control form-control-md" value="<?php echo $data->online_lname; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_blood" class="form-label fs-base">กรุ๊ปเลือด <span class="text-danger">*</span></label>
              <select name="online_blood" id="online_blood" class="form-select form-select-md" required>
                <option value="">เลือกกรุ๊ปเลือด</option>
                <option value="A+" <?php echo $data->online_blood == 'A+' ? 'selected' : ''; ?>>A+</option>
                <option value="A-" <?php echo $data->online_blood == 'A-' ? 'selected' : ''; ?>>A-</option>
                <option value="AB+" <?php echo $data->online_blood == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                <option value="AB-" <?php echo $data->online_blood == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                <option value="B+" <?php echo $data->online_blood == 'B+' ? 'selected' : ''; ?>>B+</option>
                <option value="B-" <?php echo $data->online_blood == 'B-' ? 'selected' : ''; ?>>B-</option>
                <option value="O+" <?php echo $data->online_blood == 'O+' ? 'selected' : ''; ?>>O+</option>
                <option value="O-" <?php echo $data->online_blood == 'O-' ? 'selected' : ''; ?>>O-</option>
                <option value="ไม่แน่ใจ" <?php echo $data->online_blood == 'ไม่แน่ใจ' ? 'selected' : ''; ?>>ไม่แน่ใจ</option>
              </select>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_birthdate" class="form-label fs-base">วันเกิด <span class="text-danger">*</span></label>
              <input type="text" name="online_birthdate" id="online_birthdate" value="<?php echo $data->online_birthdate; ?>" class="form-control form-control-md" disabled>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_idcard" class="form-label fs-base">เลขบัตรประชาชน <span class="text-danger">*</span></label>
              <input type="text" name="online_idcard" id="online_idcard" class="form-control form-control-md" value="<?php echo $data->online_idcard; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_tel" class="form-label fs-base">เบอร์โทร <span class="text-danger">*</span></label>
              <input type="text" name="online_tel" id="online_tel" class="form-control form-control-md" value="<?php echo $data->online_tel; ?>" disabled>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_email" class="form-label fs-base">อีเมล์ <span class="text-danger">*</span></label>
              <input type="email" name="online_email" id="online_email" class="form-control form-control-md" value="<?php echo $data->online_email; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_address" class="form-label fs-base">ที่อยู่ <span class="text-danger">*</span></label>
              <input type="text" name="online_address" id="online_address" class="form-control form-control-md" value="<?php echo $data->online_address; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_district" class="form-label fs-base">ตำบล <span class="text-danger">*</span></label>
              <input type="text" name="online_district" id="online_district" class="form-control form-control-md" value="<?php echo $data->online_district; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_amphoe" class="form-label fs-base">อำเภอ <span class="text-danger">*</span></label>
              <input type="text" name="online_amphoe" id="online_amphoe" class="form-control form-control-md" value="<?php echo $data->online_amphoe; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_province" class="form-label fs-base">จังหวัด <span class="text-danger">*</span></label>
              <input type="text" name="online_province" id="online_province" class="form-control form-control-md" value="<?php echo $data->online_province; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-sm-6 mb-3">
              <label for="online_zipcode" class="form-label fs-base">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
              <input type="text" name="online_zipcode" id="online_zipcode" class="form-control form-control-md" value="<?php echo $data->online_zipcode; ?>" required>
              <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" name="subscribe_id" value="1" id="subscribe_id" <?php echo ($data->subscribe_id == 1 ? 'checked="checked"' : ''); ?> class="form-check-input">
            <label for="delete-account" class="form-check-label fs-base">ยอมรับการแจ้งเตือนข่าวสารโปรโมชั่นผ่านอีเมล์</label>
          </div>
          <div class="d-flex mb-3">
            <?php
            // if ($data->facebook_id != '') {
            ?>
              <!-- <button ype="button" onclick="unlinkfacebook();" class="btn btn-info me-3"><img class="" src="<?php //echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="20" style="background: #FFFFFF; margin-right: 5px;"> เชื่อม Facebook แล้ว</button> -->
            <?php
            // } else {
            ?>
              <!-- <button type="button" onclick="linkFacebook();" class="btn btn-info me-3"><img class="" src="<?php //echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="20" style="background: #FFFFFF; margin-right: 5px;"> เชื่อมต่อ Facebook</button> -->
            <?php
            // }
            if ($data->online_password != NULL) {
            ?>
              <button type="button" class="btn btn-info me-3" onclick="modalEditPassword()"><i class="fa fa-key pe-1"></i> เปลี่ยนรหัสผ่าน</button>
            <?php
            }
            ?>
            <button type="reset" class="btn btn-secondary me-3">ยกเลิก</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<div id="result-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content"></div>
  </div>
</div>

<form action="<?php echo "profile/linkfacebook"; ?>" method="post" name="linkFB" id="linkFB">
  <input type="hidden" id="link_facebook_id" name="link_facebook_id">
  <input type="hidden" id="link_facebook_email" name="link_facebook_email">
</form>

<form action="<?php echo "profile/unlinkfacebook"; ?>" method="post" name="unlinkFB" id="unlinkFB">
  <input type="hidden" id="unlink_facebook_id" name="unlink_facebook_id" value="<?php echo $data->facebook_id; ?>">
  <input type="hidden" id="unlink_facebook_email" name="unlink_facebook_email" value="<?php echo $data->online_email; ?>">
</form>

<script>
  $(function() {
    $('#form-edit-profile').parsley();

    $('#online_birthdate').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $(function() {
      $('.fancybox').fancybox({
        padding: 0,
        helpers: {
          title: {
            type: 'outside'
          }
        }
      })
    })
  });

  function modalEditPassword() {
    $.ajax({
      url: service_base_url + 'profile/modaleditpassword',
      method: 'POST',
      data: {},
      success: function(response) {
        $('#result-modal .modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function uploadImage() {
    var myfiles = document.getElementById("upload-image");
    var files = myfiles.files;
    var data = new FormData();
    for (i = 0; i < files.length; i++) {
      data.append('file' + i, files[i]);
    }
    data.append('online_id', '<?php echo $data->online_id; ?>');
    url = service_admin_url + 'profileonline/uploadimage';
    $.ajax({
      url: url,
      dataType: "json",
      type: 'POST',
      contentType: false,
      data: data,
      processData: false,
      cache: false
    }).done(function(res) {
      if (res.error) {
        notification('error', 'Fail', 'อัพโหลดไม่สำเร็จ');
      } else {
        image_link = service_admin_url + 'assets/upload/online/' + res.file_name;
        $('#image_show').css('background-image', 'url(' + image_link + ')');
        $('#image_show').hide();
        $('#image_show').fadeIn(650);
        notification('success', 'Uploaded', 'บันทึกข้อมูลเรียบร้อย');
      }
    });
  }

  // login facebook
  window.fbAsyncInit = function() {
    FB.init({
      appId: '<?php echo $this->config->item('fb_app_id') ?>',
      cookie: true,
      xfbml: true,
      version: 'v3.2'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function linkFacebook() {
    FB.getLoginStatus(function(response) {
      // console.log(response);
      statusChangeCallbackLink(response);
    });
  }

  function statusChangeCallbackLink(response) {
    // console.log(response);
    if (response.status === "connected") {
      fetchUserProfileLink();
    } else {
      // Logging the user to Facebook by a Dialog Window
      facebookLoginByDialogLink();
    }
  }

  function fetchUserProfileLink() {
    // console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=id,name,email', function(response) {
      $("#link_facebook_id").val(response.id);
      $("#link_facebook_email").val(response.email);
      $("#linkFB").submit();
    });
  }

  function facebookLoginByDialogLink() {
    FB.login(function(response) {
      statusChangeCallbackLink(response);
    }, {
      scope: 'public_profile,email'
    });
  }

  function unlinkfacebook() {
    swal({
      title: "ยกเลิกการเชื่อม Facebook",
      showCancelButton: true,
      confirmButtonColor: "#0069FD",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) {
        $("#unlinkFB").submit();
      }
    });
  }
</script>
<style>
  [dir=ltr] .product-tabs__item:first-child {
    margin-left: 0px;
  }
</style>