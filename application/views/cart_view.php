<!-- <div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php //$this->load->view('layout/navbar-account', array('navacc' => 'cart')); 
                            ?>
                        </div>
                        <div class="col-12 col-xl-9 mb-5">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <h5><?php //echo $title; 
                                                ?></h5>
                                        </div>
                                        <div class="col-xl-6 text-right">
                                            <a href="<?php //echo base_url('promotions'); 
                                                      ?>" class="btn btn-primary"><i class="fa fa-shopping-basket me-2"></i> เลือกซื้อบริการ</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body card-body--padding--2">
                                    <div class="table-responsive-sm">
                                        <div id="result-pagination"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button id="checkout_btn" class="btn btn-primary" onclick="checkoutModal()"><i class="fa fa-shopping-cart me-2"></i> ชำระเงิน</button>
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
          <?php $this->load->view('layout/navbar-account', array('navacc' => 'cart')); ?>
        </div>
      </div>
    </aside>
    <!-- Account details -->
    <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
      <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
        <section class="container d-md-flex align-items-center justify-content-between pb-3">
          <h2 class="h2 pt-xl-1 pb-2"><?php echo $title; ?></h2>
          <div class="flex-nowrap justify-content-lg-center overflow-auto pb-2 mb-3 mb-lg-4">
            <a href="<?php echo base_url('promotions'); ?>" class="btn btn-primary"><i class="fa fa-shopping-basket me-2"></i> เลือกซื้อบริการ</a>
          </div>
        </section>
        <!-- Basic info -->
        <div class="table-responsive-sm">
          <div id="result-pagination"></div>
        </div>
        <div class="row">
          <div class="col-lg-12 text-right">
            <button id="checkout_btn" class="btn btn-primary" onclick="checkoutModal()"><i class="fa fa-shopping-cart me-2"></i> ชำระเงิน</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<div id="modal-delete" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-delete" method="post" action="#" onsubmit="return false" autocomplete="off">
        <input type="hidden" name="odt_id" id="odt_id" value="">
        <div class="modal-header">
          <h5 class="modal-title text-danger"><i class="fa fa-exclamation-triangle me-2"></i> ยืนยันการลบรายการ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
        </div>
        <div class="modal-body text-center">
          ต้องการลบรายการนี้ใช่หรือไม่ ?
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn-delete" class="btn btn-primary">ตกลง</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> ปิด</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="result-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content"></div>
  </div>
</div>

<div id="result-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content"></div>
  </div>
</div>

<div id="result-modal-checkout" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static" style="display: none;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content"></div>
  </div>
</div>

<style>
  .modal-checkout {
    min-width: 70%;
  }
</style>

<script>
  $(function() {
    $('#form-delete').parsley()
    getCart();
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
  })

  function getCart() {
    $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>')
    $.ajax({
      url: service_base_url + 'cart/getcart',
      type: 'POST',
      data: {},
      success: function(response) {
        $('#result-pagination').html(response)
        if (parseInt($('#count').val()) > 0 && $('#is_cart_error').val() == 0) {
          $('#checkout_btn').prop('disabled', false)
        } else {
          $('#checkout_btn').prop('disabled', true)
        }
      }
    })
  }

  function addToCart(product_id, odt_id) {
    $('#btn_cart_' + odt_id).prop('disabled', true)
    $.ajax({
      url: service_base_url + 'cart/addtocartajax',
      type: 'POST',
      data: {
        product_id: product_id
      },
      dataType: 'JSON',
      success: function(response) {
        setTimeout(function() {
          getCart()
          notification(response.status, response.title, response.message)
        }, 200)
      }
    })
  }

  function modalDelete(odt_id) {
    $('#odt_id').val(odt_id);
    $('#modal-delete').modal('show', {
      backdrop: 'true'
    });
  }

  $('#btn-delete').click(function() {
    if ($('#form-delete').parsley().validate() === true) {
      $('#btn-delete').prop('disabled', true)
      $.ajax({
        url: service_base_url + 'cart/deletecart',
        type: 'POST',
        data: {
          odt_id: $('#odt_id').val()
        },
        dataType: 'JSON',
        success: function(response) {
          setTimeout(function() {
            getCart()
            $('.modal').modal('hide')
            $('#btn-delete').prop('disabled', false)
            notification(response.status, response.title, response.message)
          }, 200)
        }
      })
    }
  })

  function checkoutModal() {
    $('#result-modal-checkout .modal-content').html('')
    $.ajax({
      url: service_base_url + 'cart/checkoutmodal',
      type: 'POST',
      success: function(response) {
        if (response != '') {
          $('#result-modal-checkout .modal-content').html(response)
          $('#result-modal-checkout').modal('show')
        } else {
          notification('error', 'ทำรายการไม่สำเร็จ', 'ไม่สามารถทำรายการนี้ได้')
        }
      }
    })
  }
</script>
<style>
  [dir=ltr] .product-tabs__item:first-child {
    margin-left: 0px;
  }
</style>