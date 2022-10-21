<link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.css' rel='stylesheet' />

<script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/core@4.4.0/locales-all.js'></script>
<script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.js'></script>
<style>
  .calendatevent {
    border-radius: 0px;
    border: none;
    cursor: move;
    font-size: 13px;
    margin: 1px -1px 0 -1px;
    padding: 2px 2px;
  }
</style>
<!-- <div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php //$this->load->view('layout/navbar-account', array('navacc' => 'appoint')); 
                            ?>
                        </div>
                        <div class="col-12 col-xl-9 mb-5">
                            <div class="product__tabs product-tabs product-tabs--layout--full">
                                <ul class="product-tabs__list" style="padding-top: 20px;">
                                    <li class="product-tabs__item product-tabs__item--active"><a href="#list-appoint">รายการนัดหมาย</a></li>
                                    <li class="product-tabs__item "><a href="#tab-calendar">ตารางนัดหมายประจำวัน</a></li>
                                </ul>
                                <div class="product-tabs__content view_calendar" >
                                    <div class="product-tabs__pane product-tabs__pane--active" id="list-appoint">
                                        <div class="row mb-2">
                                            <div class="col-xl-6">
                                                <button class="btn btn-primary mb-2" onclick="modalAdd()"> <i class="fa fa-plus-circle me-2"></i> เพิ่มการนัดหมาย</button>
                                            </div>
                                            <div class="col-xl-6 text-right">
                                                <div class="input-group">
                                                    <input type="text" id="searchtext" class="form-control " placeholder="กรอกคำค้นหา...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" onclick="ajax_pagination()"><i class="fa fa-search me-2"></i> ค้นหา</button>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <div id="result-pagination"></div>
                                    </div>
                                    <div class="product-tabs__pane" id="tab-calendar">
                                        <div id="result_page_calendar">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="calendar"></div>
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
        </div>
    </div>
</div> -->

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
          <?php $this->load->view('layout/navbar-account', array('navacc' => 'appoint')); ?>
        </div>
      </div>
    </aside>
    <!-- Account details -->
    <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
      <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
        <section class="container d-md-flex align-items-center justify-content-between pb-3">
          <h2 class="text-nowrap mb-md-4 pe-md-5"><?php echo $title; ?></h2>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs flex-nowrap justify-content-lg-center overflow-auto pb-2 mb-3 mb-lg-4" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link text-nowrap active" id="list-appoint-tab" onclick="ajax_pagination();" data-bs-toggle="tab" data-bs-target="#list-appoint" type="button" role="tab" aria-controls="list-appoint" aria-selected="true">
                <i class="bx bx-list-ul fs-lg opacity-60 me-2 me-2"></i>
                รายการนัดหมาย
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link text-nowrap" id="tab-calendar-tab" onclick="calendarShow();" data-bs-toggle="tab" data-bs-target="#tab-calendar" type="button" role="tab" aria-controls="tab-calendar" aria-selected="false">
                <i class="bx bx-calendar fs-lg opacity-60 me-2 me-2"></i>
                ตารางนัดหมายประจำวัน
              </button>
            </li>
          </ul>
        </section>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="list-appoint" role="tabpanel" aria-labelledby="list-appoint-tab">
            <div class="row mb-2">
              <div class="col-xl-6">
                <button class="btn btn-sm btn-info mb-2" onclick="modalAdd()"> <i class="fa fa-plus-circle me-2 me-2"></i> เพิ่มการนัดหมาย</button>
              </div>
              <div class="col-xl-6 text-right">
                <div class="input-group">
                  <input type="text" id="searchtext" class="form-control form-control-sm" placeholder="กรอกคำค้นหา...">
                  <div class="input-group-append">
                    <button class="btn btn-sm btn-info" onclick="ajax_pagination()"><i class="fa fa-search me-2 me-2"></i> ค้นหา</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="result-pagination"></div>
          </div>
          <div class="tab-pane fade" id="tab-calendar" role="tabpanel" aria-labelledby="tab-calendar-tab">
            <div id="result_page_calendar">
              <div class="row">
                <div class="col-lg-12">
                  <div id="calendar"></div>
                </div>
              </div>
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
  });

  function ajax_pagination() {
    $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
    $.ajax({
      url: service_base_url + 'appoint/ajax_pagination',
      type: 'POST',
      data: {
        searchtext: $('#searchtext').val(),
      },
      success: function(response) {
        $('#result-pagination').html(response);
      }
    });
  }

  function loadPageListAppoint () {
    $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></div>');
    $.ajax({
      url: service_base_url + 'appoint/ajax_pagination',
      type: 'POST',
      data: {
        searchtext: $('#searchtext').val(),
      },
      success: function(response) {
        $('#result-pagination').html(response);
      }
    });
  }

  function calendarShow() {
    document.getElementById('calendar').innerHTML = ""
    var initialLocaleCode = 'th';
    var calendarEl = document.getElementById('calendar');

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var today = new Date($.now());

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      locale: initialLocaleCode,
      buttonIcons: false, // show the prev/next text
      navLinks: false, // can click day/week names to navigate views
      eventLimit: true,
      eventClick: function(info) {
        var eventObj = info.event;
        console.log(eventObj);
        //                console.log(eventObj.id);
        modalView(eventObj.id);
      },
      events: service_base_url + 'appoint/calendarjson'
    });
    calendar.render();
  }

  function modalView(appoint_id_pri) {
    $('#modal-content').html('');
    $.ajax({
      url: service_base_url + 'appoint/viewmodal',
      type: 'POST',
      data: {
        appoint_id_pri: appoint_id_pri,
      },
      success: function(response) {
        $('#result-modal #modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function modalAdd() {
    $('#modal-content').html('');
    $.ajax({
      url: service_base_url + 'appoint/modaladd',
      type: 'POST',
      data: {},
      success: function(response) {
        $('#result-modal #modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function modalCancel(chatbot_id) {
    $('#modal-content').html('');
    $.ajax({
      url: service_base_url + 'appoint/modalcancel',
      type: 'POST',
      data: {
        chatbot_id: chatbot_id
      },
      success: function(response) {
        $('#result-modal #modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function modalEdit(appoint_id_pri) {
    $('#modal-content').html('');
    $.ajax({
      url: service_base_url + 'appoint/modaledit',
      type: 'POST',
      data: {
        appoint_id_pri: appoint_id_pri,
      },
      success: function(response) {
        $('#result-modal #modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function modalStatus(appoint_id_pri) {
    $('#modal-content').html('');
    $.ajax({
      url: service_base_url + 'appoint/modalStatus',
      type: 'POST',
      data: {
        appoint_id_pri: appoint_id_pri,
      },
      success: function(response) {
        $('#result-modal #modal-content').html(response);
        $('#result-modal').modal('show', {
          backdrop: 'true'
        });
      }
    });
  }

  function uploadImage() {
    var myfiles = document.getElementById("upload-image");
    var files = myfiles.files;
    var data = new FormData();
    for (i = 0; i < files.length; i++) {
      data.append('file' + i, files[i]);
    }
    data.append('online_id', '<?php echo $data->online_id; ?>');
    url = service_admin_url + 'profileonline/uploadimage';
    $.ajax({
      url: url,
      dataType: "json",
      type: 'POST',
      contentType: false,
      data: data,
      processData: false,
      cache: false
    }).done(function(res) {
      if (res.error) {
        notification('error', 'Fail', 'อัพโหลดไม่สำเร็จ');
      } else {
        image_link = service_admin_url + 'assets/upload/online/' + res.file_name;
        $('#image_show').css('background-image', 'url(' + image_link + ')');
        $('#image_show').hide();
        $('#image_show').fadeIn(650);
        notification('success', 'Uploaded', 'บันทึกข้อมูลเรียบร้อย');
      }
    });
  }
</script>
<style>
  [dir=ltr] .product-tabs__item:first-child {
    margin-left: 0px;
  }

  .product-tabs--layout--full .product-tabs__pane--active {
    padding: 20px;
  }


  @media only screen and (max-width: 600px) {
    .view_calendar {
      overflow: scroll;
    }
  }
</style>