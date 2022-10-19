<div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md"></div>
                <div class="col-md-5 mt-2 d-flex">
                    <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
                        <div class="card-body card-body--padding--2">
                            <h3 class="card-title text-center"><i class="fas fa-key me-2"></i> เปลี่ยนรหัสผ่านใหม่</h3>
                            <form class="account-menu__form" style="padding-bottom: 0px;" id="form-login" method="post" action="<?php echo base_url() . 'forget/docreatepassword'; ?>" autocomplete="off">
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
                                    <label for="tel">เบอร์โทรศัพท์</label>
                                    <input id="tel" name="tel" type="text" class="form-control" placeholder="เบอร์โทรศัพท์" value="<?php echo $tel; ?>" autocomplete="new-username" required="" readonly="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">รหัสผ่านใหม่</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                    <input type="password" id="password_confirm" name="password_confirm" class="form-control form-control-sm" onchange="checkPassword()" required>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" id="btn-form-modal" class="btn btn-block text-white btn-circle" style="background: #1A79FF;padding: 11px;"> เปลี่ยนรหัสผ่าน</button>                                    
                                </div>
                            </form>
                            <div class="account-menu__form" style="padding-top: 0px;">
                                <hr>
                                <div class="account-menu__form-link">
                                    <a href="<?php echo base_url() . 'authen'; ?>"><i class="fas fa-angle-left me-2"></i> กลับหน้าเข้าสู่ระบบ</a>
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

    $('#flash_message').delay(5000).fadeOut(1000);

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
</script>