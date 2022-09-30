<div class="table-responsive" style="min-height: 50vh;">
    <table class="table">
        <thead>
            <tr>
                <th width="2%"># </th>
                <th >หัวข้อ </th>
                <th width="15%">คลินิก</th>
                <th width="15%">แพทย์</th>
                <th width="10%">วันที่นัด</th>
                <th width="10%" class="text-center">สถานะ</th>
                <th width="18%" class="text-right">ตัวเลือก</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($data->num_rows() > 0) {
                $i = $segment + 1;
                foreach ($data->result() as $row) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><div style="min-width: 100px"><?php echo $row->appoint_topic != '' ? $row->appoint_topic : '-'; ?></div></td>
                        <td><div style="min-width: 100px"><a target="_blank" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>"><?php echo $row->shop_name; ?></a></div></td>
                        <td ><?php echo $row->user_fullname; ?></td>
                        <td><div style="min-width: 100px"><?php echo $this->misc->date2thai($row->appoint_date, '%d %m %y', 1) . '<br> เวลา ' . $this->misc->date2thai($row->appoint_start, '%h:%i', 1) . ' - ' . $this->misc->date2thai($row->appoint_end, '%h:%i', 1); ?></div></td>
                        <td class="text-center">
                            <?php if ($row->appoint_status_id == 1) { ?>
                                <span class="badge badge-warning text-white"><i class="fa fa-warning"></i> รอดำเนินการ</span>
                            <?php } elseif ($row->appoint_status_id == 2) { ?>
                                <span class="badge badge-success text-white"><i class="fa fa-clock-o"></i> เสร็จสิ้น</span>
                            <?php } else { ?>
                                <span class="badge badge-danger text-white"><i class="fa fa-close"></i> ยกเลิก</span>
                            <?php } ?>
                        </td>
                        <td class="text-right">
                            <button type="button" <?php echo $row->appoint_status_id == 0 ? 'disabled' : ''; ?> class="btn btn-sm btn-danger" onclick="modalStatus('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-times"></i></button>
                            <?php if ($row->appoint_status_id != 0) { ?>
                                <button type="button" <?php echo $row->appoint_status_id == 0 ? 'disabled' : ''; ?> class="btn btn-sm btn-primary" onclick="modalView('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-eye"></i></button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-sm btn-primary" onclick="modalEdit('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-eye"></i></button>
                            <?php } ?>
                            <?php if ($row->appoint_status_id == 1) { ?>
                                <button type="button" class="btn btn-sm btn-info" onclick="modalEdit('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-edit"></i></button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-sm btn-info" disabled ><i class="fa fa-edit"></i></button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                ?>
                <tr>
                    <td class="text-center" colspan="13"><i class="fa fa-info-circle text-danger"></i>&nbsp;<span class="text-danger">ไม่พบข้อมูล</span></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
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
    td {
        font-size: 12px;
    }

    td label {
        font-size: 12px;
    }
</style>