<form id="form-modal" method="post" onsubmit="submit_add();" action="<?php echo base_url('shopdetail/add_appoint'); ?>" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header">
        <h6 class="modal-title"> <i class="fa fa-plus-circle"></i> เพิ่มการนัดหมาย</h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label">หัวข้อ <span class="text-danger">*</span></label>
                        <input type="text" name="appoint_topic" id="appoint_topic" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label">ชื่อคลินิก <span class="text-danger">*</span></label>
                        <input type="hidden" name="shop_id_pri" id="shop_id_pri"  value="<?php echo $data->shop_id_pri ?>" class="form-control" required>
                        <input type="text"  class="form-control" value="<?php echo $data->shop_name ?>" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label">นัดแพทย์ <span class="text-danger">*</span></label>
                        <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $data->user_id ?>"class="form-control" required>
                        <input type="text" class="form-control" value="<?php echo $data->user_fullname ?>" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label">วันที่นัด <span class="text-danger">*</span></label>
                        <input type="text" name="date" id="date" value="<?php echo $date; ?>" class="form-control" placeholder="เลือกวันที่นัด" readonly="">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">เวลานัด <span class="text-danger">*</span></label>
                        <input type="text" name="appoint_start" id="appoint_start" value="<?php echo $appoint_start; ?>" class="form-control" placeholder="เลือกวันที่นัด" readonly="">
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label">หมายเหตุ </label>
                        <textarea name="appoint_note" id="appoint_note" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" id="btn-add-submit" class="btn btn-primary">
            <i class="fa fa-save"></i> ตกลง
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times-circle"></i> ปิด</button>
    </div>
</form>
<script>
    $(function () {
        $('#form-modal').parsley();
    });

    function submit_add() {
        var form = $("#form-modal");
        form.parsley().validate();
        if (form.parsley().isValid() == true) {
            $('#btn-add-submit').prop('disabled', true);
            return true;
        } else {
            return false;
        }
    }
</script>
