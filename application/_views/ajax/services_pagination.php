<div class="table-responsive" style="min-height: 50vh;">
    <table class="table">
        <thead>
        <tr>
            <th width="5%"># </th>
            <th width="10%">เลขที่ </th>
            <th width="25%">ชื่อคอร์ส</th>
            <th width="10%" class="text-center"> คอร์สทั้งหมด</th>
            <th width="10%" class="text-center">รอใช้บริการ</th>
            <th width="10%" class="text-center">ใช้บริการ</th>
            <th width="15%">ชื่อคลินิก</th>
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
                    <td><?php echo $row->course_id; ?></td>
                    <td><?php echo $row->course_name; ?></td>
                    <td class="text-center"><a href="javascript:void(0)" onclick="viewModal('<?php echo $row->course_id_pri;?>')"><?php echo number_format($this->services_model->get_serving($row->course_id_pri)->num_rows()); ?></a></td>
                    <?php $sum_servingdetail_book = $this->services_model->sum_servingdetail_book_customer($row->course_id_pri)->num_rows(); ?>
                    <td class="text-center"><a href="javascript:void(0)" class="text-warning" onclick="viewModal('<?php echo $row->course_id_pri;?>','1')"><?php echo number_format($this->services_model->get_serving($row->course_id_pri, 1)->num_rows() - $sum_servingdetail_book); ?></a></td>
                    <td class="text-center"><a href="javascript:void(0)" class="text-success" onclick="viewModal('<?php echo $row->course_id_pri;?>','3')"><?php echo number_format($this->services_model->get_serving($row->course_id_pri, 3)->num_rows()); ?></a></td>
                    <td><div style="min-width: 100px"><a target="_blank" href="<?php echo base_url().'shop/'.$row->shop_id; ?>"><?php echo $row->shop_name; ?></a></div></td>
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