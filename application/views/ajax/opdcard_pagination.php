<table class="table">
        <thead>
        <tr>
            <th width="8%">เลขที่</th>
            <th width="11%" >วันที่</th>
            <th width="20%">รายการตรวจ</th>
            <th >รายการรักษา / ใช้บริการ</th>
            <th > ชื่อคลินิก </th>
            <th class="text-center" width="15%">รูป (ก่อน / หลัง)</th>
            <th class="text-center" width="13%">ตัวเลือก</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($data->num_rows() > 0) {
            $i = $segment + 1;
            foreach ($data->result() as $row) {
                ?>
                <tr>
                    <td><?php echo $row->opd_code; ?></td>
                    <td> <div style="min-width: 100px"><?php echo $this->misc->date2thai($row->opd_date, '%d %m %y', 1)?></div></td>
                    <td>
                        <div style="min-width: 100px">
                        <?php
                        $checks = $this->opdcard_model->getOpdChecking($row->opd_id);
                        $j = 1;
                        if ($checks->num_rows() > 0) {
                            foreach ($checks->result() as $check) {
                                ?>
                                <?php
                                if ($j != 1) {
                                    echo '<br/>';
                                }
                                ?>
                                <label><?php echo $j . '. ' . $check->opdchecking_name . ' ' . ($check->opdchecking_code != null ? '( ' . $check->opdchecking_code . ' )' : ''); ?></label>
                                <?php
                                $j++;
                            }
                        }
                        ?>
                        </div>
                    </td>
                    <td>
                        <div style="min-width: 200px">
                            <?php
                            $courses = $this->opdcard_model->getOrderDetail($row->order_id_pri, 1);
                            $k = 1;
                            if ($courses->num_rows() > 0) {
                                foreach ($courses->result() as $course) {
                                    ?>
                                    <?php
                                    if ($k != 1) {
                                        echo '<br/>';
                                    }
                                    ?>
                                    <label class="text-primary"><?php echo $k . '. ' . $course->orderdetail_name; ?><span class="text-muted"><?php echo ' ' . $course->orderdetail_amount . ' ' . $course->orderdetail_unit; ?></span></label>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                            <?php
                            $drugs = $this->opdcard_model->getOrderDetail($row->order_id_pri, 2);
                            if ($drugs->num_rows() > 0) {
                                foreach ($drugs->result() as $drug) {
                                    ?>
                                    <?php
                                    if ($k != 1) {
                                        echo '<br/>';
                                    }
                                    ?>
                                    <label><?php echo $k . '. ' . $drug->orderdetail_name; ?><span class="text-muted"><?php echo ' ' . $drug->orderdetail_amount . ' ' . $drug->orderdetail_unit; ?></span></label>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td><div style="min-width: 100px"><a target="_blank" href="<?php echo base_url().'shop/'.$row->shop_id; ?>"><?php echo $row->shop_name; ?></a></div></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example" style="min-width: 120px">
                            <button type="button" class="btn btn-xs btn-danger" onclick="modalUpload('<?php echo $row->opd_id; ?>', '1')"><i class="fa fa-image me-2"></i> ก่อน</button>
                            <button type="button" class="btn btn-xs btn-dark" onclick="modalUpload('<?php echo $row->opd_id; ?>', '2')"><i class="fa fa-image me-2"></i> หลัง</button>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary" onclick="modalOpdView('<?php echo $row->opd_id; ?>')"><i class="fa fa-list me-2"></i> รายละเอียด</button>
                    </td>
                </tr>
                <?php
                $i++;
            }
        } else {
            ?>
            <tr>
                <td class="text-center" colspan="13"><i class="fa fa-info-circle text-danger me-2"></i>&nbsp;<span class="text-danger">ไม่พบข้อมูล</span></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
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
    td{
        font-size: 12px;
    }

    td label{
        font-size: 12px;
    }
</style>