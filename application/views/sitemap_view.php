<div class="site__body">
    <div class="block-header block-header--has-breadcrumb block-header--has-title">
        <div class="container">
            <div class="block-header__body">
                <h1 class="block-header__title mb-2 mt-2"><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> หน้าทั้งหมด</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?php echo base_url();?>">หน้าหลัก</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'promotions';?>">Promotion</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'shops';?>">ค้นหาคลินิก</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'review';?>">รีวิว</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'blog';?>">บทความ</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'authen';?>">เข้าสู่ระบบ</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'about';?>">เกี่ยวกับเรา</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'conditions';?>">ข้อตกลงและเงื่อนไข</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'privacypolicy';?>">นโยบายความเป็นส่วนตัว</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url();?>">สมัครรับจดหมายข่าว</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'contact';?>">ติดต่อเรา</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'sitemap';?>">ผังเว็บไซต์</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'sitemap.xml';?>">sitemap.xml</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'promotions.xml';?>">promotions.xml</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'shops.xml';?>">shops.xml</a></li>
                                <li class="list-group-item"><a href="<?php echo base_url().'blog.xml';?>">blog.xml</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> โปรโมชั่น</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?php echo base_url().'promotions';?>">Promotion</a></li>
                                <?php
                                $get_product = $this->sitemap_model->getProduct();
                                if ($get_product->num_rows() > 0) {
                                    foreach ($get_product->result() as $row_product) {
                                        ?>
                                        <li class="list-group-item"><a href="<?php echo base_url() . 'promotion/' . $row_product->product_slug; ?>"><?php echo $row_product->product_name; ?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> คลินิก</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?php echo base_url().'shops';?>">คลินิกทั้งหมด</a></li>
                                <?php
                                $get_shop = $this->sitemap_model->getShop();
                                if ($get_shop->num_rows() > 0) {
                                    foreach ($get_shop->result() as $row_shop) {
                                        ?>
                                        <li class="list-group-item"><a href="<?php echo base_url() . 'shop/' . $row_shop->shop_id; ?>"><?php echo $row_shop->shop_name; ?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> บทความ</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="<?php echo base_url().'blog';?>">บทความทั้งหมด</a></li>
                                <?php
                                $get_blog = $this->sitemap_model->getBlog();
                                if ($get_blog->num_rows() > 0) {
                                    foreach ($get_blog->result() as $row_blog) {
                                        ?>
                                        <li class="list-group-item"><a href="<?php echo base_url() . "blog/detail/" . $row_blog->article_slug; ?>"><?php echo $row_blog->article_title; ?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> ประเภทบริการ</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <?php
                                $get_shop_nature = $this->sitemap_model->getShopNature();
                                if ($get_shop_nature->num_rows() > 0) {
                                    foreach ($get_shop_nature->result() as $row_shop_nature) {
                                        ?>
                                        <li class="list-group-item"><a href="<?php echo base_url().'promotions/?nature_name='.$row_shop_nature->shop_nature_name; ?>"><?php echo $row_shop_nature->shop_nature_name; ?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mtb-10">
                                <h5><i class="fa fa-sitemap me-2"></i> หมวดหมู่บริการ</h5>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="list-group">
                                <?php
                                $get_product_category = $this->sitemap_model->getProductCategory();
                                if ($get_product_category->num_rows() > 0) {
                                    foreach ($get_product_category->result() as $row_product_category) {
                                        ?>
                                        <li class="list-group-item"><a href="<?php echo base_url().'promotions/?category_name='.$row_product_category->product_category_name; ?>"><?php echo $row_product_category->product_category_name; ?></a></li>
                                    <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-space block-space--layout--divider-lg"></div>
</div>