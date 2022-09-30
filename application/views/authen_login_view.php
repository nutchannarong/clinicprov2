<div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md"></div>
                <div class="col-md-5 mt-2 d-flex">
                    <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
                        <div class="card-body card-body--padding--2">
                            <h3 class="card-title text-center"><i class="fas fa-unlock-alt"></i> เข้าสู่ระบบสมาชิก</h3>
                            <form class="account-menu__form" style="padding-bottom: 0px;" id="form-login" method="post" action="<?php echo base_url() . 'authen/doauthen'; ?>" autocomplete="off">
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
                                    <input id="tel" name="tel" type="number" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" autocomplete="new-username" required="" maxlength="12" onkeypress="return isNumberKey(event)" autofocus>
                                </div>  
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-block text-white btn-circle" style="background: #1A79FF;padding: 11px;"> เข้าสู่ระบบด้วยเบอร์โทรศัพท์</button>                                    
                                </div>
                            </form>
                            <div class="account-menu__form" style="padding-top: 0px;">
                                <hr>
                                <div class="account-menu__form-link">
                                    <a href="<?php echo base_url() . 'forget'; ?>"><i class="fa fa-key"></i> ลืมรหัสผ่าน</a> | 
                                    <a href="<?php echo admin_url(); ?>" target="_blank"><i class="fas fa-sign-in-alt"></i> สำหรับเจ้าของคลินิก</a>
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
</script>