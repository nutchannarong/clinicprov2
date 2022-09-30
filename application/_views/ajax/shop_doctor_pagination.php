<div class="row">
    <?php
    if ($data->num_rows() > 0) {
        $i = $segment + 1;
        foreach ($data->result() as $row) {
            ?>
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card p-2 mt-2">
                    <div class="row">
                        <div class="col-4 text-center mt-2">
                            <img src="<?php echo admin_url() . "assets/upload/user/" . $row->user_image; ?>"
                                 alt="<?php echo $row->user_fullname; ?>" class="img-circle" width="80%">
                            <br>
                        </div>
                        <div class="col-8 mt-2">
                            <h5 class="text-primary"><?php echo $row->user_fullname; ?></h5>
                            <p class="text-primary">
                                <?php
                                //$specialized = '';
                                if ($row->specialized_id != null) {
                                    echo '( ' . $row->specialized_name . ' )';
                                }
                                $get_specialized_sub = $this->shopdetail_model->getSpecializedSub($row->user_id);
                                if ($get_specialized_sub->num_rows() > 0) {
                                    foreach ($get_specialized_sub->result() as $row_specialized_sub) {
                                        ?>
                                                                <!--                                        <span class="text-primary" style="font-size: 12px;">
                                                                                                    <i class="fas fa-circle" style="font-size: 8px;"></i>
                                        <?php //echo $row_specialized_sub->specialized_sub_name; ?>
                                                                                                </span>-->
                                        <?php
                                    }
                                }
                                ?>
                            </p>
                            <p> <?php echo $row->user_address; ?></p>
                            <a target="_blank" href="<?php echo base_url() . 'doctor/' . $row->user_id; ?>"
                               class="btn btn-primary"> ดูประวัติ</a>
                               <?php
                               if ($this->session->userdata('islogin') == 1) {
                                   $check_appoint = $this->shopdetail_model->getAppointShop($shop_id_pri);
                                   if ($check_appoint->num_rows() == 1) {
                                       if ($row->user_appoint_id == 1) {
                                           $get_section_day = $this->shopdetail_model->getSectionDayByUserID($row->user_id);
                                           if ($get_section_day->num_rows() > 0) {
                                               $get_open_time = $this->shopdetail_model->getSectionTimeByUserID($row->user_id, 'asc');
                                               $get_close_time = $this->shopdetail_model->getSectionTimeByUserID($row->user_id, 'desc');
                                               if ($get_open_time->num_rows() == 1 && $get_close_time->num_rows() == 1) {
                                                   ?>
                                                <a target="_blank" href="<?php echo base_url() . 'doctor/' . $row->user_id; ?>"
                                                   class="btn btn-success btn-disabled"> นัดหมาย</a>
                                                   <?php
                                               } else {
                                                   ?>
                                                <!--<a href="javascript:void(0)" class="btn btn-secondary btn-disabled"> นัดหมาย</a>-->
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <!--<a href="javascript:void(0)" class="btn btn-secondary btn-disabled"> นัดหมาย</a>-->
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <!--<a href="javascript:void(0)" class="btn btn-secondary btn-disabled"> นัดหมาย</a>-->
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <!--<a href="javascript:void(0)" class="btn btn-secondary btn-disabled"> นัดหมาย</a>-->
                                <?php }
                                ?>
                            <?php } else {
                                ?>
                                <!--<a href="javascript:void(0)" class="btn btn-secondary btn-disabled"> นัดหมาย</a>-->
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    } else {
        ?>
        <div class="col">
            <h5 class="text-center mt-5"><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
        </div>
        <?php
    }
    ?>
</div>
<div class="row mt-5">
    <?php
    if ($count != 0) {
        ?>
        <div class="col-sm-4">
            แสดง <?php echo $segment + 1; ?> ถึง <?php echo $i - 1; ?> ทั้งหมด <?php echo($count); ?> รายการ
        </div>
        <div class="col-sm-8" style="float: right">
            <?php echo $links; ?>
        </div>
        <?php
    }
    ?>
</div>
<style>
    .pro-view-shop {
        position: absolute;
        top: 3%;
        right: 10%;
        color: black;
    }

    .pro-birthday {
        position: absolute;
        bottom: 10%;
        right: 10%;
        color: black;
    }
</style>