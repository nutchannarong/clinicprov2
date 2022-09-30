<footer class="site__footer">
    <div class="site-footer">
        <div class="site-footer__widgets">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="row">
                            <div class="col-6 col-md-4 col-xl">
                                <div class="site-footer__widget footer-links">
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'about'; ?>" class="footer-links__link">เกี่ยวกับเรา</a></li>
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'conditions'; ?>" class="footer-links__link">ข้อตกลงและเงื่อนไข</a></li>
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'privacypolicy'; ?>" class="footer-links__link">นโยบายความเป็นส่วนตัว</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="site-footer__widget footer-links">
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'promotions'; ?>" class="footer-links__link">โปรโมชั่น</a></li>
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'shops'; ?>" class="footer-links__link">ค้นหาคลินิก</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="site-footer__widget footer-links">
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'authen'; ?>" class="footer-links__link">เข้าสู่ระบบ</a></li>
                                        <li class="footer-links__item"><a href="<?php echo admin_url(); ?>" target="_blank" class="footer-links__link">สำหรับเจ้าของคลินิก</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="site-footer__widget footer-links">
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'review'; ?>" class="footer-links__link">รีวิว</a></li>
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'blog'; ?>" class="footer-links__link">บทความ</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-xl">
                                <div class="site-footer__widget footer-links">
                                    <ul class="footer-links__list">
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'contact'; ?>" class="footer-links__link">ติดต่อเรา</a></li>
                                        <li class="footer-links__item"><a href="<?php echo base_url() . 'sitemap'; ?>" class="footer-links__link">ผังเว็บไซต์</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-12 col-md-12 col-xl-12 text-center">  
                                <div class="d-block d-sm-block d-md-none d-lg-none d-xl-none">
                                    <img src="<?php echo base_url() . 'assets/img/payments.png'; ?>" width="350" class="img-responsive"/>    
                                </div>
                                <div class="d-none d-sm-none d-md-block d-lg-block d-xl-block">
                                    <img src="<?php echo base_url() . 'assets/img/payments.png'; ?>" height="50" class="img-responsive"/>                                
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-xl-12 text-center mt-3">
                                <?php echo $this->config->item('app_footer'); ?> Page rendered in <strong>{elapsed_time}</strong> seconds.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- mobile-menu -->
<div class="mobile-menu">
    <div class="mobile-menu__backdrop"></div>
    <div class="mobile-menu__body">
        <button class="mobile-menu__close" type="button">
            <i class="fas fa-times-circle"></i>
        </button>
        <div class="mobile-menu__panel">
            <div class="mobile-menu__panel-header">
                <div class="mobile-menu__panel-title">เมนู</div>
            </div>
            <div class="mobile-menu__panel-body">
                <!--                <div class="mobile-menu__settings-list" style="min-height: 38px;">
                                    <div class="mobile-menu__setting" data-mobile-menu-item>
                                        <a href="<?php echo base_url(); ?>" class="mobile-menu__setting-button" title="รายการ" data-mobile-menu-trigger>
                                            <span class="mobile-menu__setting-title">ประวัติการสั่งซื้อ </span>
                                        </a>
                                    </div>
                                    <div class="mobile-menu__setting" data-mobile-menu-item>
                                        <a href="<?php echo base_url() . 'appoint'; ?>" class="mobile-menu__setting-button" title="รายการ" data-mobile-menu-trigger>
                                            <span class="mobile-menu__setting-title">ตารางนัดหมาย </span>
                                        </a>
                                    </div>
                                </div>-->
                <div class="mobile-menu__divider"></div>
                <?php
                if ($this->session->userdata('islogin') == 1) {
                    $get_online = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row();
                    ?>
                    <div class="mobile-menu__indicators" style="min-height: 76px;">
                        <a class="mobile-menu__indicator" href="<?php echo base_url() . 'profile'; ?>" style="padding-top: 2px;">
                            <span class="mobile-menu__indicator-icon account-menu__user-avatar" style="margin-right: -10px;">
                                <img src="<?php echo admin_url() . 'assets/upload/online/' . $get_online->online_image; ?>" width="28" height="28" alt="Profile">
                            </span>
                            <span class="mobile-menu__indicator-title">ประวัติส่วนตัว</span>
                        </a>
                        <a class="mobile-menu__indicator" href="<?php echo base_url() . 'promotionbirthdate'; ?>" style="padding-top: 2px;">
                            <span class="mobile-menu__indicator-icon  account-menu__user-avatar" style="margin-right: -10px;">
                                <i class="fa fa-birthday-cake" style="font-size: 18px;"></i>
                            </span>
                            <span class="mobile-menu__indicator-title">บริการแนะนำ</span>
                        </a>
                        <a class="mobile-menu__indicator" href="<?php echo base_url() . 'services'; ?>" style="padding-top: 2px;">
                            <span class="mobile-menu__indicator-icon  account-menu__user-avatar" style="margin-right: -10px;">
                                <i class="fa fa-list" style="font-size: 18px;"></i>
                            </span>
                            <span class="mobile-menu__indicator-title">บริการ/คอร์ส</span>
                        </a>
                        <a class="mobile-menu__indicator" href="<?php echo base_url() . 'authen/logout'; ?>" style="padding-top: 2px;">
                            <span class="mobile-menu__indicator-icon text-center">
                                <i class="fas fa-sign-out-alt" style="font-size: 18px;"></i>
                            </span>
                            <span class="mobile-menu__indicator-title">ออกจากระบบ</span>
                        </a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="mobile-menu__indicators" style="min-height: 76px;">
                        <a class="mobile-menu__indicator" href="<?php echo base_url('authen'); ?>">
                            <span class="mobile-menu__indicator-icon">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            <span class="mobile-menu__indicator-title">เข้าสู่ระบบ</span>
                        </a>                        
                    </div>
                    <?php
                }
                ?>
                <div class="mobile-menu__divider"></div>
                <ul class="mobile-menu__links">
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url(); ?>" class="" data-mobile-menu-trigger>
                            หน้าเเรก
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'promotions'; ?>" class="" data-mobile-menu-trigger>
                            โปรโมชั่น
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'shops'; ?>" class="" data-mobile-menu-trigger>
                            ค้นหาคลินิก
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'review'; ?>" class="" data-mobile-menu-trigger>
                            รีวิว
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'blog'; ?>" class="" data-mobile-menu-trigger>
                            บทความ
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'about'; ?>" class="" data-mobile-menu-trigger>
                            เกี่ยวกับเรา
                        </a>
                    </li>                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'conditions'; ?>" class="" data-mobile-menu-trigger>
                            ข้อตกลงและเงื่อนไข
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'privacypolicy'; ?>" class="" data-mobile-menu-trigger>
                            นโยบายความเป็นส่วนตัว
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'contact'; ?>" class="" data-mobile-menu-trigger>
                            ติดต่อเรา
                        </a>
                    </li>
                    <li data-mobile-menu-item>
                        <a href="<?php echo base_url() . 'sitemap'; ?>" class="" data-mobile-menu-trigger>
                            ผังเว็บไซต์
                        </a>
                    </li>
                </ul>
                <div class="mobile-menu__spring"></div>
                <div class="mobile-menu__divider"></div>
                <a class="mobile-menu__contacts" href="">
                    <div class="mobile-menu__contacts-subtitle">โทรสายด่วน</div>
                    <div class="mobile-menu__contacts-title"> <?php echo $this->config->item('app_phone'); ?></div>
                </a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="alert_message" value="<?php echo $this->session->flashdata('flash_message') != '' ? $this->session->flashdata('flash_message') : ''; ?>">

<!--<form action="<?php echo "authen/dologinfacebook"; ?>" method="post" name="fbLogin" id="fbLogin">
    <input type="hidden" id="facebook_id" name="facebook_id">
    <input type="hidden" id="facebook_fullname" name="facebook_fullname">
    <input type="hidden" id="facebook_email" name="facebook_email">
</form>-->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5W6JJH8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<script>
    $(function () {
        var alert_message = $('#alert_message').val();
        if (alert_message != '') {
            var foo = alert_message.split(',')
            notification(foo[0], foo[1], foo[2])
        }
    })

    function notification(type, head, message) {
        $.toast({
            heading: head,
            text: message,
            position: 'top-right',
            loaderBg: '#D8DBDD',
            icon: type,
            hideAfter: 3000,
            stack: 3
        })
    }

    function copylink() {
        swal({
            title: "รับฟรีทันที " + '<?php echo $this->config->item('point_guide') ?>' + " แต้ม \r\nหลังจากที่เพื่อนซื้อบริการแล้ว",
            text: $("#ref_link").val(),
            showCancelButton: true,
            confirmButtonColor: "#00897b",
            confirmButtonText: "คัดลอก",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($("#ref_link").val()).select();
                document.execCommand("copy");
                $temp.remove();
                swal("Copy Success", "นำลิงค์แนะนำไปวางได้เลย !", "success");
            }
        });
    }


// login facebook
//    window.fbAsyncInit = function () {
//        FB.init({
//            appId: '<?php echo $this->config->item('fb_app_id') ?>',
//            cookie: true,
//            xfbml: true,
//            version: 'v3.2'
//        });
//        FB.AppEvents.logPageView();
//    };
//
//    (function (d, s, id) {
//        var js, fjs = d.getElementsByTagName(s)[0];
//        if (d.getElementById(id)) {
//            return;
//        }
//        js = d.createElement(s);
//        js.id = id;
//        js.src = "//connect.facebook.net/en_US/sdk.js";
//        fjs.parentNode.insertBefore(js, fjs);
//    }(document, 'script', 'facebook-jssdk'));
//
//
//    function facebookLogin() {
//        FB.getLoginStatus(function (response) {
//            // console.log(response);
//            statusChangeCallback(response);
//        });
//    }
//
//    function statusChangeCallback(response) {
//        // console.log(response);
//        if (response.status === "connected") {
//            fetchUserProfile();
//        } else {
//            // Logging the user to Facebook by a Dialog Window
//            facebookLoginByDialog();
//        }
//    }
//
//
//    function fetchUserProfile() {
//        // console.log('Welcome!  Fetching your information.... ');
//        FB.api('/me?fields=id,name,email', function (response) {
//            $("#facebook_id").val(response.id);
//            $("#facebook_fullname ").val(response.name);
//            $("#facebook_email").val(response.email);
//            $("#fbLogin").submit();
//        });
//    }
//
//    function facebookLoginByDialog() {
//        FB.login(function (response) {
//            statusChangeCallback(response);
//        }, {scope: 'public_profile,email'});
//    }


</script>
<style>
    .jq-icon-info {
        background-color: #398bf7;
        color: #ffffff; }

    .jq-icon-success {
        background-color: #06d79c;
        color: #ffffff; }

    .jq-icon-error {
        background-color: #ef5350;
        color: #ffffff; }

    .jq-icon-warning {
        background-color: #ffb22b;
        color: #ffffff; }
</style>
</body>
</html>