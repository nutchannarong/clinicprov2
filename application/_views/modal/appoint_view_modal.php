<div class="modal-header">
    <h6 class="modal-title"><i class="fa fa-eye"></i>  รายละเอียดการนัดหมาย
        <?php if ($data->appoint_status_id == 1) { ?>
            <span class="badge badge-warning text-white"><i class="fa fa-warning"></i> รอดำเนินการ</span>
        <?php } elseif ($data->appoint_status_id == 2) { ?>
            <span class="badge badge-success text-white"><i class="fa fa-clock-o"></i> เสร็จสิ้น</span>
        <?php } else { ?>
            <span class="badge badge-danger text-white"><i class="fa fa-close"></i> ยกเลิก</span>
        <?php } ?>
    </h6>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="row form-group">
                <div class="col-lg-12">
                    <label class="control-label m-b-5" style="font-weight: bold;">หัวข้อ : </span></label>
                    <span style="font-size: 18px;"><?php echo $data->appoint_topic != '' ? $data->appoint_topic : ''; ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-12">
                    <label class="control-label m-b-5" style="font-weight: bold;">คลินิก : </span></label>
                    <span><?php echo $data->shop_name; ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6">
                    <label class="control-label m-b-5" style="font-weight: bold;">วันที่นัด : </span></label>
                    <span><?php echo $this->misc->date2thai($data->appoint_date, '%d %m %y', 1); ?></span>
                </div>
                <div class="col-lg-6">
                    <label class="control-label m-b-5" style="font-weight: bold;">เวลา : </span></label>
                    <span><?php echo $this->misc->date2thai($data->appoint_start, '%h:%i', 1) . ' - ' . $this->misc->date2thai($data->appoint_end, '%h:%i', 1); ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-12">
                    <label class="control-label m-b-5" style="font-weight: bold;">แพทย์ : </span></label>
                    <span><?php echo $data->user_fullname; ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-12">
                    <label class="control-label m-b-5" style="font-weight: bold;">หมายเหตุ : </span></label>
                    <span><?php echo $data->appoint_note; ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-12">
                    <label class="control-label m-b-5" style="font-weight: bold;">ข้อความ : </label>
                    <span><?php echo $data->appoint_sms; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> ปิด</button>
</div>
