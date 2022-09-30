<!-- site__mobile-header -->
<header class="site__mobile-header">
    <div class="mobile-header">
        <div class="container">
            <div class="mobile-header__body">
                <button class="mobile-header__menu-button" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="14px">
                        <path d="M-0,8L-0,6L18,6L18,8L-0,8ZM-0,-0L18,-0L18,2L-0,2L-0,-0ZM14,14L-0,14L-0,12L14,12L14,14Z" />
                    </svg>
                </button>
                <a class="mobile-header__logo" href="<?php echo base_url(); ?>">
                    <!-- mobile-logo -->
                    <h1>ClinicPRO</h1>
                    <!-- mobile-logo / end -->
                </a>
                <div class="mobile-header__search mobile-search">
                    <form class="mobile-search__body" action="<?php echo base_url() . 'promotions' ?>" method="get">
                        <input type="text" name="search" class="mobile-search__input" placeholder="ค้นหาบริการ" value="<?php echo $this->input->get('search'); ?>">
                            <button type="submit" class="mobile-search__button mobile-search__button--search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15
                                          c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8
                                          c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                                </svg>
                            </button>
                            <button type="button" class="mobile-search__button mobile-search__button--close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path d="M16.7,16.7L16.7,16.7c-0.4,0.4-1,0.4-1.4,0L10,11.4l-5.3,5.3c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L8.6,10L3.3,4.7
                                          c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L10,8.6l5.3-5.3c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L11.4,10l5.3,5.3
                                          C17.1,15.7,17.1,16.3,16.7,16.7z" />
                                </svg>
                            </button>
                            <div class="mobile-search__field"></div>
                    </form>
                </div>
                <div class="mobile-header__indicators">
                    <div class="mobile-indicator mobile-indicator--search d-md-none">
                        <button type="button" class="mobile-indicator__button">
                            <span class="mobile-indicator__icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15
                                          c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8
                                          c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="mobile-indicator d-none d-md-block">
                        <a href="<?php echo base_url(); ?>" class="mobile-indicator__button">
                            <span class="mobile-indicator__icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                    <path d="M20,20h-2c0-4.4-3.6-8-8-8s-8,3.6-8,8H0c0-4.2,2.6-7.8,6.3-9.3C4.9,9.6,4,7.9,4,6c0-3.3,2.7-6,6-6s6,2.7,6,6c0,1.9-0.9,3.6-2.3,4.7C17.4,12.2,20,15.8,20,20z M14,6c0-2.2-1.8-4-4-4S6,3.8,6,6s1.8,4,4,4S14,8.2,14,6z" /></svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- site__mobile-header / end -->
<!-- site__header -->
<header class="site__header">
    <div class="header">
        <div class="header__logo">
            <a href="<?php echo base_url(); ?>" class="logo">
                <div class="logo__slogan">
                    Auto parts for Cars, trucks and motorcycles
                </div>
                <div class="logo__image">
                    <!-- logo -->
                    <h1 class="text-white">ClinicPRO</h1>
                    <!-- logo / end -->
                </div>
            </a>
        </div>
        <div class="header__search">
            <div class="search">
                <div class="row">
                    <div class="col-1">
                        <div class="indicator indicator--trigger--click">
                            <a href="<?php echo base_url(); ?>" class="indicator__button bg-white">
                                <span class="indicator__icon">
                                    <i class="fas fa-th text-primary mb-3 " style="font-size: 45px;"></i>
                                </span>
                                <br />
                                <br />
                            </a>
                            <div class="indicator__content" style="left:0;">
                                <div class="account-menu">
                                    <div class="account-menu__divider"></div>
                                    <ul class="account-menu__links">
                                        <?php
                                        $get_shop_nature = $this->global_model->getShopNature();
                                        if ($get_shop_nature->num_rows() > 0) {
                                            foreach ($get_shop_nature->result() as $row_shop_nature) {
                                                ?>
                                                <li class="menu__item menu__item--has-submenu">
                                                    <a href="<?php echo base_url() . 'promotions?nature_name=' . $row_shop_nature->shop_nature_name; ?>" class="menu__link">
                                                        <img src="<?php echo base_url() . 'assets/icon/' . $row_shop_nature->shop_nature_id . '.png'; ?>" width="24" />&nbsp;
                                                        <?php echo $row_shop_nature->shop_nature_name; ?>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <div class="account-menu__divider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <form method="get" class="mobile-search__body ml-xl-3" action="<?php echo base_url() . 'promotions' ?>" style="margin-top: 10px;">
                            <input type="text" name="search" class="mobile-search__input" placeholder="ค้นหาบริการ" style="height: 45px;" value="<?php echo $this->input->get('search'); ?>">
                                <button type="submit" class="mobile-search__button mobile-search__button--search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z"></path>
                                    </svg>
                                </button>
                                <button type="button" class="mobile-search__button mobile-search__button--close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path d="M16.7,16.7L16.7,16.7c-0.4,0.4-1,0.4-1.4,0L10,11.4l-5.3,5.3c-0.4,0.4-1,0.4-1.4,0l0,0c-0.4-0.4-0.4-1,0-1.4L8.6,10L3.3,4.7c-0.4-0.4-0.4-1,0-1.4l0,0c0.4-0.4,1-0.4,1.4,0L10,8.6l5.3-5.3c0.4-0.4,1-0.4,1.4,0l0,0c0.4,0.4,0.4,1,0,1.4L11.4,10l5.3,5.3C17.1,15.7,17.1,16.3,16.7,16.7z"></path>
                                    </svg>
                                </button>
                                <div class="mobile-search__field"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__indicators">
            <div class="header__navbar-menu mt-3">
                <div class="main-menu">
                    <ul class="main-menu__list">
                        <li class="main-menu__item pl-2 pr-2">
                            <a href="<?php echo base_url() . 'promotions'; ?>" class="main-menu__link">
                                <b>โปรโมชั่น</b>
                            </a>
                        </li>
                        <li class="main-menu__item pl-2 pr-2">
                            <a href="<?php echo base_url() . 'shops'; ?>" class="main-menu__link">
                                <b>ค้นหาคลินิก</b>
                            </a>
                        </li>
                        <li class="main-menu__item pl-2 pr-2">
                            <a href="<?php echo base_url() . 'review'; ?>" class="main-menu__link">
                                <b>รีวิว</b>
                            </a>
                        </li>
                        <li class="main-menu__item pl-2 pr-2">
                            <a href="<?php echo base_url() . 'blog'; ?>" class="main-menu__link">
                                <b>บทความ</b>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="indicator indicator--trigger--click">
                <?php
                if ($this->session->userdata('islogin') == 1) {
                    $get_online = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row();
                    ?>
                    <a href="<?php echo base_url(); ?>" class="indicator__button">
                        <span class="indicator__icon">
                            <img id="image_main" class="img-circle" src="<?php echo admin_url() . 'assets/upload/online/' . $get_online->online_image; ?>" width="100%">
                        </span>
                        <span class="indicator__title text-dark"><b><?php echo $get_online->online_fname . ' ' . $get_online->online_lname; ?></b></span>
                        <span class="indicator__value text-center mt-2" style="font-size: 13px; color: #FF0045"><?php echo number_format($get_online->online_point); ?> เเต้ม</span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="<?php echo base_url() . 'authen'; ?>" class="indicator__button">
                        <span class="indicator__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                                <path d="M16,18C9.4,18,4,23.4,4,30H2c0-6.2,4-11.5,9.6-13.3C9.4,15.3,8,12.8,8,10c0-4.4,3.6-8,8-8s8,3.6,8,8c0,2.8-1.5,5.3-3.6,6.7C26,18.5,30,23.8,30,30h-2C28,23.4,22.6,18,16,18z M22,10c0-3.3-2.7-6-6-6s-6,2.7-6,6s2.7,6,6,6S22,13.3,22,10z" />
                            </svg>
                        </span>
                        <span class="indicator__value" style="padding-top: 10px;">เข้าสู่ระบบ</span>
                    </a>
                    <?php
                }
                ?>
                <div class="indicator__content">
                    <div class="account-menu">
                        <?php
                        if ($this->session->userdata('islogin') == 1) {
                            // cart
                            $count_cart = 0;
                            $get_cart_navbar = $this->global_model->getCartNavbar();
                            if ($get_cart_navbar->num_rows() > 0) {
                                $ids = array();
                                foreach ($get_cart_navbar->result() as $row_cart_navbar) {
                                    if (in_array($row_cart_navbar->product_group_id, array(3, 4, 5))) {
                                        $ids[] = $row_cart_navbar->orderdetail_temp_id_pri;
                                    } else {
                                        $count_cart++;
                                    }
                                }
                                if (!empty($ids)) {
                                    $this->global_model->clearCartByIds($ids);
                                }
                            }
                            $count_appoint = $this->global_model->countAppoint();
                            $online_point = 0;
                            if (!empty($this->session->userdata('online_id'))) {
                                $online_point = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row()->online_point;
                            }
                            $count_product_birth_date = $this->global_model->countProductBirthDate($online_point);
                            //$count_service = $this->global_model->countService();
                            //$sum_servingdetail_book = $this->global_model->sum_servingdetail_book_customer()->num_rows();
                            //$count_service_wait = $this->global_model->get_serving(1)->num_rows() - $sum_servingdetail_book;
                             $count_un_review = $this->global_model->countUnReview();
                            ?>
                            <ul class="account-menu__links p-3">
                                <li class="account-menu__links_border"><a href="<?php echo base_url('profile'); ?>" class="text-primary"><i class="far fa-user-circle"></i> ข้อมูลส่วนตัว</a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url() . 'appoint'; ?>" class="text-primary"><i class="fa fa-calendar"></i> ปฏิทินนัดหมาย <?php echo $count_appoint > 0 ? '<span class="badge badge-pill badge-danger">' . number_format($count_appoint) . '</span>' : ''; ?> </a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url() . 'promotionbirthdate'; ?>" class="text-primary"> <i class="fa fa-birthday-cake"></i> บริการแนะนำ <?php echo $count_product_birth_date > 0 ? '<span class="badge badge-pill badge-danger">' . number_format($count_product_birth_date) . '</span>' : ''; ?></a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url('cart'); ?>" class="text-primary"><i class="fa fa-shopping-basket"></i> ตะกร้าสินค้า <?php echo $count_cart > 0 ? '<span class="badge badge-pill badge-danger">' . number_format($count_cart) . '</span>' : ''; ?> </a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url('order'); ?>" class="text-primary"><i class="fa fa-shopping-cart"></i> ประวัติการสั่งซื้อ </a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url() . 'services'; ?>" class="text-primary"> <i class="fa fa-list"></i> บริการ/คอร์ส <?php //echo $count_service_wait > 0 ? '<span class="badge badge-pill badge-danger">' . number_format($count_service_wait) . '</span>' : '';  ?></a></li>
                                <li class="account-menu__links_border_main"><a href="<?php echo base_url() . 'servingreview'; ?>" class="text-primary"> <i class="fa fa-star"></i> รีวิวหลังการใช้บริการ <?php echo $count_un_review > 0 ? '<span class="badge badge-pill badge-danger">' . $count_un_review . '</span>' : ''; ?></a></li>
                                <li class="account-menu__links_border_main_list"><a href="<?php echo base_url() . 'opdcard'; ?>" class="text-primary"> <i class="fa fa-book"></i> ประวัติการรักษา OPD</a></li>
                            </ul>
                            <div class="row ml-3 mr-3 ">
                                <div class="col p-0">
                                    <input type="hidden" id="ref_link" value="<?php echo base_url() . 'authen?ref=' . $this->session->userdata('online_id'); ?>"/>
                                    <button onclick="copylink();" class="btn btn-secondary btn-sm btn-block"> ลิงค์แนะนำเพื่อน</button>
                                </div>
                                <!--                                <div class="col p-0">
                                                                    <a href="<?php echo base_url() . 'authen/logout'; ?>" class="btn btn-secondary btn-sm btn-block ml-1"> ออกจากระบบ</a>
                                                                </div>-->
                            </div>
                            <br>
                                <?php
                            } else {
                                ?>
                                <form class="account-menu__form" style="padding-bottom: 0px;" id="header-form-login" method="post" action="<?php echo base_url() . 'authen/doauthen'; ?>" autocomplete="off">
                                    <div class="account-menu__form-title">
                                        เข้าสู่ระบบสมาชิก
                                    </div>
                                    <div class="form-group">
                                        <input id="tel" name="tel" type="number" class="form-control form-control-sm btn-circle" placeholder="กรอกเบอร์โทรศัพท์" required>
                                    </div>
                                    <div class="form-group account-menu__form-button" style="margin-bottom: 0px;">
                                        <button type="submit" class="btn btn-sm btn-block text-white btn-circle" style="background: #1A79FF">เข้าสู่ระบบด้วยเบอร์โทรศัพท์</button>
                                    </div>
                                </form>
                                <div class="account-menu__form" style="padding-top: 0px;">
                                    <!--                                    <div class="form-group account-menu__form-button" style="margin-top: 10px;">
                                                                            <button onclick="facebookLogin();" class="btn btn-sm btn-block text-white btn-circle pl-0 pr-0" style="background: #4267B2;"><img class="" src="<?php echo base_url() . "assets/img/social-icon/facebook.png"; ?>" width="15" style="background: #FFFFFF;"> เข้าสู่ระบบด้วย Facebook</button>
                                                                        </div>-->
                                    <div class="account-menu__form-link">
                                        <a target="_blank" href="<?php echo admin_url(); ?>" class="btn btn-secondary btn-circle mt-3">สำหรับเจ้าของคลินิก</a>
                                    </div>
                                </div>
                                <script>
                                    $(function () {
                                        $('#header-form-login').parsley();
                                    });
                                </script>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    .img-circle{
        border-radius: 100%;
    }
    .btn-circle{
        border-radius: 20px;
    }
    .account-menu__form-button{
        margin-top: 20px;
    }
    .account-menu__links_border{
        border: 1px #F0F0F0 solid;
    }
    .account-menu__links_border{
        border: 1px #F0F0F0 solid;
    }
    .account-menu__links_border_main{
        border-left: 1px #F0F0F0 solid;
        border-right: 1px #F0F0F0 solid;
        border-bottom: 1px #F0F0F0 solid;
    }
    .account-menu__links_border_main_list{
        border-left: 1px #F0F0F0 solid;
        border-right: 1px #F0F0F0 solid;
    }
    .account-menu__links a{
        padding: 10px 10px 10px 40px;
        font-size: 13px;
    }
</style>