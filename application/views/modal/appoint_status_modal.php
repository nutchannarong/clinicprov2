<form id="form-modal" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="appoint_id_pri" id="appoint_id_pri" value="<?php echo $data->appoint_id_pri; ?>">
    <div class="modal-header">
        <h5 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i> ยืนยันการยกเลิก</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="row form-group">
            <div class="col-lg-12">
                <label class="control-label m-b-5">หมายเหตุ <span class="text-danger">*</span></label>
                <input type="text" name="appoint_comment" class="form-control form-control-sm" value="" required="">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-form-modal" class="btn btn-primary">
            <i class="fa fa-save"></i> ตกลง
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times-circle"></i> ปิด</button>
    </div>
</form>

<script>
    $('#btn-form-modal').click(function () {
        if ($('#form-modal').parsley().validate() === true) {
            $('#btn-form-modal').prop('disabled', true)
            var formData = new FormData($('#form-modal')[0])
            $.ajax({
                url: service_base_url + 'appoint/status',
                type: 'POST',
                data: formData,
                dataType: 'JSON',
                // file
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    setTimeout(function () {
                        ajax_pagination()
                        loadPageListAppoint()
                        $('.modal').modal('hide')
                        notification(response.status, response.title, response.message)
                    }, 200)
                }
            })
        }
    })
</script>