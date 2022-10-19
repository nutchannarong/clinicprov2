<div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md"></div>
                <div class="col-md-5 d-flex">
                    <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
                        <div class="card-body card-body--padding--2">
                            <h3 class="card-title text-center"><i class="fas fa-user-edit me-2"></i> สมัครสมาชิก</h3>
                            <form class="account-menu__form" id="form-register" method="post" action="<?php echo base_url() . 'register/doregister'; ?>" autocomplete="off">
                                <div class="form-group">
                                    <label for="idcard">รหัสประจำตัวประชาชน <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="idcard" name="idcard" placeholder="ID Card" required="">
                                </div>
                                <div class="form-group">
                                    <label for="prefix">คำนำหน้าชื่อ <span class="text-danger">*</span></label>
                                    <select class="form-control" id="prefix" name="prefix" required="">
                                        <option value="นาย">นาย</option>
                                        <option value="นางสาว">นางสาว</option>
                                        <option value="นาง">นาง</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Miss.">Miss.</option>
                                        <option value="ด.ช.">ด.ช.</option>
                                        <option value="ด.ญ.">ด.ญ.</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fname">ชื่อ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required="">
                                </div>
                                <div class="form-group">
                                    <label for="lname">นามสกุล <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required="">
                                </div>
                                <div class="form-group">
                                    <label for="gender">เพศ <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required="">
                                        <option value="ชาย">ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="blood">กรุ๊ปเลือด <span class="text-danger">*</span></label>
                                    <select class="form-control" id="blood" name="blood" required="">
                                        <option value="A+">A+</option> 
                                        <option value="A-">A-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="ไม่แน่ใจ">ไม่แน่ใจ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="birthdate">วันเกิด <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="Birthdate" required="">
                                </div>
                                <div class="form-group">
                                    <label for="email">อีเมลล์ <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="address">ที่อยู่ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required="">
                                </div>
                                <div class="form-group">
                                    <label for="district">ตำบล <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="district" name="district" placeholder="ตำบล" required="">
                                </div>
                                <div class="form-group">
                                    <label for="amphoe">อำเภอ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="amphoe" name="amphoe" placeholder="อำเภอ" required="">
                                </div>
                                <div class="form-group">
                                    <label for="province">จังหวัด <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="province" name="province" placeholder="จังหวัด" required="">
                                </div>
                                <div class="form-group">
                                    <label for="zipcode">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code" required="">
                                </div>
                                <div class="form-group">
                                    <label for="allergic">แพ้ยา</label>
                                    <input type="text" class="form-control" id="allergic" name="allergic" placeholder="แพ้ยา">
                                </div>
                                <div class="form-group">
                                    <label for="disease">โรคประจำตัว</label>
                                    <input type="text" class="form-control" id="disease" name="disease" placeholder="โรคประจำตัว">
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
                                <hr>

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
                                <input type="hidden" value="<?php echo $this->session->userdata('tel'); ?>">
                                <div class="form-group mb-0">
                                    <button type="submit" id="btn-form-modal" class="btn btn-block text-white btn-circle" style="background: #1A79FF;padding: 11px;"> ยืนยันสมัครสมาชิก</button>                                    
                                </div>
                                <hr>
                                <div class="account-menu__form-link">
                                    <a href="<?php echo base_url() . 'authen'; ?>"><i class="fas fa-sign-in-alt me-2"></i> กลับหน้าเข้าสู่ระบบ</a>
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
    $(function () {
        $('#form-register').parsley();

        $('#birthdate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
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