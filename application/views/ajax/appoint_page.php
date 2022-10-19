<div class="table-responsive" style="min-height: 50vh;">
    <table class="table">
        <thead>
        <tr>
            <th width="5%"># </th>
            <th width="20%">หัวข้อ </th>
            <th width="15%">คลินิก</th>
            <th width="25%">วันที่นัด</th>
            <th width="10%" class="text-center">สถานะ</th>
            <th width="20%" class="text-right">ตัวเลือก</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($data->num_rows() > 0) {
            $i = 1;
            foreach ($data->result() as $row) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><div style="min-width: 100px"><?php echo $row->chatbot_topic; ?> </div></td>
                    <td><div style="min-width: 100px"><a target="_blank" href="<?php echo base_url().'shop/'.$row->shop_id; ?>"><?php echo $row->shop_name; ?></a></div></td>
                    <td><div style="min-width: 100px"><?php echo $this->misc->date2thai($row->chatbot_day, '%d %m %y', 1).' เวลา '.$row->chatbot_time; ?></div></td>
                    <td class="text-center">
                        <?php if ($row->chatbot_status_id == 1) { ?>
                            <span class="badge badge-warning text-white"><i class="fa fa-warning me-2"></i> รอดำเนินการ</span>
                        <?php } elseif ($row->chatbot_status_id == 2) { ?>
                            <span class="badge badge-success text-white"><i class="fa fa-clock-o me-2"></i> เสร็จสิ้น</span>
                        <?php } else { ?>
                            <span class="badge badge-danger text-white"><i class="fa fa-close me-2"></i> ยกเลิก</span>
                        <?php } ?>
                    </td>
                    <td class="text-right">
                        <button class="btn btn-danger btn-sm" onclick="modalCancel('<?php echo $row->chatbot_id; ?>')"> <i class="fa fa-times-circle me-2"></i> ยกเลิก</button>
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
</div>
<style>
    td {
        font-size: 12px;
    }

    td label {
        font-size: 12px;
    }
</style>