<!-- <div class="site__body">
  <div class="block mt-5 mb-5">
    <div class="container">
      <div class="row">
        <div class="col-xl-12">
          <div class="row">
            <div class="col-12 col-xl-3 d-flex">
              <?php //$this->load->view('layout/navbar-account', array('navacc' => 'promotionbirthdate')); 
              ?>
            </div>
            <div class="col-12 col-xl-9 mb-5">
              <div class="card">
                <div class="card-header pb-2">
                  <div class="row">
                    <div class="col-xl">
                      <h5 class="mt-2"><?php //echo $title; 
                                        ?></h5>
                    </div>
                    <div class="col-xl">
                      <div class="form-group">
                        <select id="shop_nature_id" class="form-control" onchange="ajax_pagination()">
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
                        <select id="product_category_id" class="form-control" onchange="ajax_pagination()">
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
                        <select id="shop_province" class="form-control" onchange="ajax_pagination()">
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
                        <input type="text" id="searchtext" class="form-control font-page " placeholder="กรอกคำค้นหา...">
                        <div class="input-group-append">
                          <button class="btn btn-primary" onclick="ajax_pagination()"><i class="fa fa-search me-2"></i> ค้นหา
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
</div> -->

<!-- Page content -->
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
          <?php $this->load->view('layout/navbar-account', array('navacc' => 'promotionbirthdate')); ?>
        </div>
      </div>
    </aside>
    <!-- Account details -->
    <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
      <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
        <h2 class="h2 pt-xl-1 pb-2"><?php echo $title; ?></h2>
        <!-- Basic info -->
        <div class="row">
          <div class="col-3">
            <select id="shop_nature_id" class="form-select form-select-sm" onchange="ajax_pagination()">
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
          <div class="col-3">
            <select id="product_category_id" class="form-select form-select-sm" onchange="ajax_pagination()">
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
          <div class="col-3">
            <select id="shop_province" class="form-select form-select-sm" onchange="ajax_pagination()">
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
          <div class="col-3">
            <div class="input-group">
              <input type="text" id="searchtext" class="form-control form-control-sm" placeholder="กรอกคำค้นหา...">
              <button type="button" class="btn btn-sm btn-primary" onclick="ajax_pagination()"><i class="fa fa-search me-2"></i> ค้นหา</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="result-pagination">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
//$month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
//$month_current = date('m');
//if ($month_birthdate == $month_current) { 
?>
<script>
  $(function() {
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
      success: function(response) {
        $('#result-pagination').html(response);
      }
    });
  }
</script>
<?php // } else { 
?>
<script>
  //        $(function () {
  //            ajax_pagination();
  //        })
  //
  //        function ajax_pagination() {
  //            $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"> <h5><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5></div>');
  //        }
</script>
<?php // } 
?>
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