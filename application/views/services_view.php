<!-- <div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php //$this->load->view('layout/navbar-account', array('navacc' => 'services')); 
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
          <?php $this->load->view('layout/navbar-account', array('navacc' => 'services')); ?>
        </div>
      </div>
    </aside>
    <!-- Account details -->
    <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
      <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
        <h2 class="h2 pt-xl-1 pb-2"><?php echo $title; ?></h2>
        <!-- Basic info -->
        <div class="row">
          <div class="col-0 col-md-5 col-lg-6"></div>
          <div class="col-12 col-md-7 col-lg-6 text-right">
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

<div id="result-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" id='modal-content'></div>
  </div>
</div>

<div id="result-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id='modal-content-lg'></div>
  </div>
</div>
<script>
  $(function() {
    ajax_pagination();
  })

  function ajax_pagination() {
    $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
    $.ajax({
      url: service_base_url + 'services/ajax_pagination',
      type: 'POST',
      data: {
        searchtext: $('#searchtext').val(),

      },
      success: function(response) {
        $('#result-pagination').html(response);
      }
    });
  }

  function viewModal(course_id_pri, serving_status_id) {
    $('.modal-content').html('');
    $.ajax({
      url: service_base_url + 'services/viewmodal',
      type: 'POST',
      data: {
        course_id_pri: course_id_pri,
        serving_status_id: serving_status_id
      },
      success: function(response) {
        $('#result-modal-lg .modal-content').html(response);
        $('#result-modal-lg').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }
</script>
<style>
  [dir=ltr] .product-tabs__item:first-child {
    margin-left: 0px;
  }

  .font-page {
    font-size: 13px !important;
  }
</style>