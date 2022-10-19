<?php if ($data->appoint_status_id != 0) { ?>
  <form id="form-modal" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="appoint_id_pri" id="appoint_id_pri" class="form-control" value="<?php echo $data->appoint_id_pri; ?>">
    <div class="modal-header">
      <h6 class="modal-title"> <i class="fa fa-edit me-2"></i> แก้ไขการนัดหมาย</h6>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-lg-12 mt-2">
          <div class="row">
            <div class="col-lg-12">
              <label class="form-label">หัวข้อ <span class="text-danger">*</span></label>
              <input type="text" name="appoint_topic" id="appoint_topic" value="<?php echo $data->appoint_topic; ?>" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mt-2">
          <div class="row">
            <div class="col-lg-12">
              <label class="form-label">ชื่อคลินิก <span class="text-danger">*</span></label>
              <input type="hidden" name="shop_id_pri" id="shop_id_pri" class="form-control" value="<?php echo $data->shop_id_pri; ?>">
              <input type="text" class="form-control" value="<?php echo $data->shop_name; ?>" readonly="">
            </div>
          </div>
        </div>
        <div class="col-lg-12 mt-2">
          <div class="row">
            <div class="col-lg-12">
              <label class="form-label">นัดแพทย์ <span class="text-danger">*</span></label>
              <select name="doctor_id" id="doctor_id" class="form-control" required="">
                <?php
                foreach ($this->appoint_model->getdoctorappoint($data->shop_id_pri)->result() as $user) {
                  $specialized = '';
                  if ($user->specialized_id != null) {
                    $specialized = $this->appoint_model->getspecialized($user->specialized_id)->row()->specialized_name;
                  }
                ?>
                  <option value="<?php echo $user->user_id; ?>" <?php echo $user->user_id == $data->user_id ? 'selected' : ''; ?> data-left="<?php echo admin_url() . 'assets/upload/user/' . (!empty($data->user_image) ? $data->user_image : 'none.png') ?>" data-subtitle="<?php echo $specialized; ?>"><?php echo $user->user_fullname; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mt-2">
          <div class="row">
            <div class="col-lg-6">
              <label class="form-label">วันที่นัด <span class="text-danger">*</span></label>
              <input type="text" name="date" id="date" class="form-control" value="<?php echo $data->appoint_date; ?>" placeholder="เลือกวันที่นัด" required>
            </div>
            <div class="col-lg-6">
              <label class="form-label">เวลานัด <span class="text-danger">*</span></label>
              <select name="appoint_start" id="appoint_start" class="form-control form-control">
                <?php foreach ($this->appoint_model->getsection($data->shop_id_pri)->result() as $section) { ?>
                  <option value="<?php echo $section->section_time; ?>" <?php echo $section->section_time == $this->libs->date2thai($data->appoint_start, '%h:%i', 1) ? 'selected' : ''; ?>><?php echo $section->section_time; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mt-2">
          <div class="row">
            <div class="col-lg-12">
              <label class="form-label">หมายเหตุ </label>
              <textarea name="appoint_note" id="appoint_note" rows="3" class="form-control"><?php echo $data->appoint_note; ?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" id="btn-form-modal" class="btn btn-primary">
        <i class="fa fa-save me-2"></i> ตกลง
      </button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i class="fa fa-times-circle me-2"></i> ปิด</button>
    </div>
  </form>
<?php } else { ?>
  <div class="modal-header">
    <h6 class="modal-title"><i class="fa fa-list me-2"></i> หมายเหตุ </h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
  </div>
  <div class="modal-body">
    <h6 class="text-center text-danger"><?php echo $data->appoint_comment ?></h6>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><i class="fa fa-close me-2"></i> ยกเลิก</button>
  </div>
<?php } ?>
<script>
  $(function() {
    $('#date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
    $('#doctor_id').selectator({
      useSearch: false
    });
  })
  $('#btn-form-modal').click(function() {
    if ($('#form-modal').parsley().validate() === true) {
      $('#btn-form-modal').prop('disabled', true)
      var formData = new FormData($('#form-modal')[0])
      $.ajax({
        url: service_base_url + 'appoint/edit',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        // file
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success: function(response) {
          setTimeout(function() {
            ajax_pagination()
            $('#result-modal').modal('toggle');
            notification(response.status, response.title, response.message)
          }, 200)
        }
      })
    }
  })

  //    function selected() {
  //        shop_id_pri = $('#shop_id_pri').val();
  //        appoint_start_tag = $('#appoint_start');
  //        appoint_start_tag.find('option').remove();
  //        doctor_tag = $('#doctor_id');
  //        doctor_tag.find('option').remove();
  //        $.ajax({
  //            url: service_base_url + 'appoint/selected',
  //            type: 'POST',
  //            dataType: 'json',
  //            data: {
  //                shop_id_pri: shop_id_pri,
  //            },
  //            success: function (response) {
  //                count_row1 = response.appoint_start_id.length;
  //                appoint_start_tag.append($("<option></option>").attr("value", "").text('เลือกเวลานัด'));
  //                for (i = 0; i < count_row1; i++) {
  //                    appoint_start_id = response.appoint_start_id[i];
  //                    appoint_start_name = response.appoint_start_name[i];
  //                    appoint_start_tag.append($("<option></option>").attr("value", appoint_start_id).text(appoint_start_name));
  //                }
  //                count_row2 = response.doctor_id.length;
  //                doctor_tag.append($("<option></option>").attr("value", "").text('เลือกแพทย์'));
  //                for (i = 0; i < count_row2; i++) {
  //                    doctor_id = response.doctor_id[i];
  //                    doctor_name = response.doctor_name[i];
  //                    doctor_tag.append($("<option></option>").attr("value", doctor_id).text(doctor_name));
  //                }
  //            }
  //        });
  //    }
</script>