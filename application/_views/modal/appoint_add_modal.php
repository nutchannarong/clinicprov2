<form id="form-modal" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
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
                        <select name="shop_id_pri" id="shop_id_pri" class="form-control" required onchange="selected();">
                            <option value="">เลือกคลินิก</option>
                            <?php
                            $get_shop = $this->appoint_model->getAppointShop();
                            if ($get_shop->num_rows() > 0) {
                                foreach ($get_shop->result() as $row_shop) {
                                    ?>
                                    <option value="<?php echo $row_shop->shop_id_pri; ?>"><?php echo $row_shop->shop_name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label">นัดแพทย์ <span class="text-danger">*</span></label>
                        <select name="doctor_id" id="doctor_id" class="form-control" required="">
                            <option value="" data-left="<?php echo admin_url() . 'assets/upload/user/none.png' ?>">เลือกแพทย์ </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="form-label">วันที่นัด <span class="text-danger">*</span></label>
                        <input type="text" name="date" id="date" class="form-control" placeholder="เลือกวันที่นัด" required>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">เวลานัด <span class="text-danger">*</span></label>
                        <select name="appoint_start" id="appoint_start" class="form-control form-control">
                            <option value="">เลือกเวลานัด</option>
                        </select>
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
        <button type="button" id="btn-form-modal" class="btn btn-primary">
            <i class="fa fa-save"></i> ตกลง
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times-circle"></i> ปิด</button>
    </div>
</form>

<script>
    $(function () {
        $('#date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
//        $('#doctor_id').selectator({useSearch: false});
//        $('#chatbot_time').bootstrapMaterialDatePicker({
//            format: 'HH:mm',
//            time: true,
//            date: false
//        });
    })
    $('#btn-form-modal').click(function () {
        if ($('#form-modal').parsley().validate() === true) {
            $('#btn-form-modal').prop('disabled', true)
            var formData = new FormData($('#form-modal')[0])
            $.ajax({
                url: service_base_url + 'appoint/add',
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

    function selected() {
        shop_id_pri = $('#shop_id_pri').val();
        appoint_start_tag = $('#appoint_start');
        appoint_start_tag.find('option').remove();
        doctor_tag = $('#doctor_id');
        doctor_tag.find('option').remove();
        $.ajax({
            url: service_base_url + 'appoint/selected',
            type: 'POST',
            dataType: 'json',
            data: {
                shop_id_pri: shop_id_pri,
            },
            success: function (response) {
                count_row1 = response.appoint_start_id.length;
                appoint_start_tag.append($("<option></option>").attr("value", "").text('เลือกเวลานัด'));
                for (i = 0; i < count_row1; i++) {
                    appoint_start_id = response.appoint_start_id[i];
                    appoint_start_name = response.appoint_start_name[i];
                    appoint_start_tag.append($("<option></option>").attr("value", appoint_start_id).text(appoint_start_name));
                }
                count_row2 = response.doctor_id.length;
                //doctor_tag.append($("<option></option>").attr("value", "").text('เลือกแพทย์'));
                for (i = 0; i < count_row2; i++) {
                    doctor_id = response.doctor_id[i];
                    doctor_name = response.doctor_name[i];
                    doctor_img = response.doctor_img[i];
                    doctor_subtitle = response.doctor_subtitle[i];
                    doctor_tag.append($("<option></option>").attr("value", doctor_id).attr("data-left", doctor_img).attr("data-subtitle", doctor_subtitle).text(doctor_name));

                }
                $('#doctor_id').selectator({useSearch: false});
            }
        });

    }
</script>