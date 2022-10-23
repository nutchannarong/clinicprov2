<div class="table-responsive" style="min-height: 50vh;">
  <table class="table">
    <thead>
      <tr>
        <th width="5%">#</th>
        <th width="20%">วันที่</th>
        <th width="20%"> ประเภทรายการ</th>
        <th width="10%" class="text-right">แต้มล่าสุด</th>
        <th width="10%" class="text-right">+ - แต้ม</th>
        <th width="10%" class="text-right">คงเหลือ</th>
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
            <td><?php echo $this->misc->date2thai($row->log_time, '%d %m %y, %h:%i:%s', 1); ?></td>
            <td><?php echo $row->log_text; ?></td>
            <td class="text-right"><?php echo number_format($row->log_point_last); ?></td>
            <td class="text-right"><?php echo number_format($row->log_point); ?></td>
            <td class="text-right"><?php echo number_format($row->log_point_balance); ?></td>
            <td>
              <div style="min-width: 100px"><a target="_blank" href="<?php echo base_url() . 'shop/' . $this->logpoint_model->get_shop($row->shop_id_pri)->row()->shop_id; ?>"><?php echo $this->logpoint_model->get_shop($row->shop_id_pri)->row()->shop_name; ?></a></div>
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
<div class="row mt-5">
  <?php
  if ($count != 0) {
  ?>
    <div class="col-sm-4">
      แสดง <?php echo $segment + 1; ?> ถึง <?php echo $i - 1; ?> ทั้งหมด <?php echo ($count); ?> รายการ
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