<div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php $this->load->view('layout/navbar-account', array('navacc' => 'promotionbirthdate')); ?>
                        </div>
                        <div class="col-12 col-xl-9 mb-5">
                            <div class="card">
                                <div class="card-header pb-2">
                                    <div class="row">
                                        <div class="col-xl">
                                            <h5 class="mt-2"><?php echo $title; ?></h5>
                                        </div>
                                        <div class="col-xl">
                                            <div class="form-group">
                                                <select id="shop_nature_id" class="form-control"
                                                        onchange="ajax_pagination()">
                                                    <option value=''>ประเภทบริการ</option>
                                                    <?php
                                                    $get_shop_nature = $this->productbirthdate_model->getShopNature();
                                                    if ($get_shop_nature->num_rows() > 0) {
                                                        foreach ($get_shop_nature->result() as $row_shop_nature) {
                                                            ?>
                                                            <option value="<?php echo $row_shop_nature->shop_nature_id; ?>"><?php echo $row_shop_nature->shop_nature_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="form-group">
                                                <select id="product_category_id" class="form-control"
                                                        onchange="ajax_pagination()">
                                                    <option value=''>หมวดหมู่บริการ</option>
                                                    <?php
                                                    $get_product_category = $this->productbirthdate_model->getProductCategory();
                                                    if ($get_product_category->num_rows() > 0) {
                                                        foreach ($get_product_category->result() as $row_product_category) {
                                                            ?>
                                                            <option value="<?php echo $row_product_category->product_category_id; ?>"><?php echo $row_product_category->product_category_name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl">
                                            <div class="form-group">
                                                <select id="shop_province" class="form-control"
                                                        onchange="ajax_pagination()">
                                                    <option value=''>พื้นที่จังหวัด</option>
                                                    <?php
                                                    $get_shop_province = $this->productbirthdate_model->getShopProvince();
                                                    if ($get_shop_province->num_rows() > 0) {
                                                        foreach ($get_shop_province->result() as $row_shop_province) {
                                                            ?>
                                                            <option value="<?php echo $row_shop_province->shop_province; ?>"><?php echo $row_shop_province->shop_province; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 text-right ">
                                            <div class="input-group">
                                                <input type="text" id="searchtext" class="form-control font-page "
                                                       placeholder="กรอกคำค้นหา...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="ajax_pagination()"><i
                                                                class="fa fa-search me-2"></i> ค้นหา
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body card-body--padding--2">
                                    <div id="result-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//$month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
//$month_current = date('m');
//if ($month_birthdate == $month_current) { ?>
    <script>
        $(function () {
            ajax_pagination();
        })

        function ajax_pagination() {
            $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
            $.ajax({
                url: service_base_url + 'productbirthdate/ajax_pagination',
                type: 'POST',
                data: {
                    searchtext: $('#searchtext').val(),
                    shop_nature_id: $('#shop_nature_id').val(),
                    product_category_id: $('#product_category_id').val(),
                    shop_province: $('#shop_province').val(),

                },
                success: function (response) {
                    $('#result-pagination').html(response);
                }
            });
        }
    </script>
<?php // } else { ?>
    <script>
//        $(function () {
//            ajax_pagination();
//        })
//
//        function ajax_pagination() {
//            $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"> <h5><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5></div>');
//        }
    </script>
<?php // } ?>
<style>
    [dir=ltr] .product-tabs__item:first-child {
        margin-left: 0px;
    }

    select {
        font-size: 13px !important;
    }

    .font-page {
        font-size: 13px !important;
    }
</style>
