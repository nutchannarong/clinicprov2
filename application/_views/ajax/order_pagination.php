<table class="table">
    <thead>
        <tr>
            <th width="10%">เลขที่</th>
            <th width="10%" >วันที่</th>
            <th width="30%">รายการ</th>
            <th width="20%">คลินิก</th>
            <th class="text-right" width="10%">แต้มที่ได้รับ</th>
            <th class="text-right" width="10%">ราคา</th>
            <th class="text-right" width="10%">สถานะ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($data->num_rows() > 0) {
            $i = $segment + 1;
            foreach ($data->result() as $row) {
                ?>
                <tr>
                    <td><?php echo $row->order_id; ?></td>
                    <td><div style="min-width: 100px"><?php echo $this->misc->date2thai($row->order_create, '%d %m %y', 1) ?></div></td>
                    <td>
                        <div style="min-width: 200px">
                            <?php
                            $get_order_detail = $this->order_model->getOrderDetail($row->order_id_pri);
                            $cnt = 1;
                            if ($get_order_detail->num_rows() > 0) {
                                foreach ($get_order_detail->result() as $order_detail) {
                                    ?>
                                    <label class="text-secondary"><?php echo $cnt . '. ' . $order_detail->orderdetail_name; ?><span class="text-muted"><?php echo ' ' . $order_detail->orderdetail_amount . ' ' . $order_detail->orderdetail_unit; ?></span></label>
                                    <br />
                                    <?php
                                    $cnt++;
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td><a target="_blank" href="<?php echo base_url('shop/' . $row->shop_id); ?>"><?php echo $row->shop_name; ?></a></td>
                    <td class="text-right">
                        <?php
                        if ($row->order_status_id == 1) {
                            echo empty($row->order_point) ? '-' : $row->order_point;
                        } else {
                            echo empty($row->order_point) ? '-' : '<span style="text-decoration: line-through;">' . $row->order_point . '</span>';
                        }
                        ?>
                    </td>
                    <td class="text-right"><?php echo number_format($row->order_totalpay, 2); ?></td>
                    <td class="text-right">
                        <?php if ($row->order_status_id == 1) { ?>
                            <span class="badge badge-success">สำเร็จ</span>
                        <?php } else { ?>
                            <span class="badge badge-danger">ยกเลิก</span>
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
    .fa {
        line-height: 17px;
    }
</style>