<div class="table-responsive" style="min-height: 50vh;">
  <table class="table">
    <thead>
      <tr>
        <th width="1%"># </th>
        <th>หัวข้อ </th>
        <th width="20%">คลินิก/แพทย์</th>
        <th width="17%">วันที่นัด</th>
        <th width="8%" class="text-center">สถานะ</th>
        <th width="25%" class="text-center">ตัวเลือก</th>
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
            <td>
              <div style="min-width: 100px"><?php echo $row->appoint_topic != '' ? $row->appoint_topic : '-'; ?></div>
            </td>
            <td>
              <div style="min-width: 100px"><a target="_blank" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>"><?php echo $row->shop_name; ?></a> <br><?php echo $row->user_fullname; ?></div>
            </td>
            <td>
              <div style="min-width: 100px"><?php echo $this->misc->date2thai($row->appoint_date, '%d %m %y', 1) . '<br> เวลา ' . $this->misc->date2thai($row->appoint_start, '%h:%i', 1) . ' - ' . $this->misc->date2thai($row->appoint_end, '%h:%i', 1); ?></div>
            </td>
            <td class="text-center">
              <?php if ($row->appoint_status_id == 1) { ?>
                <span class="badge fs-xs text-white bg-warning shadow-warning text-decoration-none"> รอดำเนินการ</span>
              <?php } elseif ($row->appoint_status_id == 2) { ?>
                <span class="badge fs-xs text-white bg-success shadow-success text-decoration-none"> เสร็จสิ้น</span>
              <?php } else { ?>
                <span class="badge fs-xs text-white bg-danger shadow-danger text-decoration-none"> ยกเลิก</span>
              <?php } ?>
            </td>
            <td class="text-center">
              <button type="button" <?php echo $row->appoint_status_id == 0 ? 'disabled' : ''; ?> class="btn btn-sm btn-danger" onclick="modalStatus('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-times"></i></button>
              <?php if ($row->appoint_status_id != 0) { ?>
                <button type="button" <?php echo $row->appoint_status_id == 0 ? 'disabled' : ''; ?> class="btn btn-sm btn-primary" onclick="modalView('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-eye"></i></button>
              <?php } else { ?>
                <button type="button" class="btn btn-sm btn-primary" onclick="modalEdit('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-eye"></i></button>
              <?php } ?>
              <?php if ($row->appoint_status_id == 1) { ?>
                <button type="button" class="btn btn-sm btn-info" onclick="modalEdit('<?php echo $row->appoint_id_pri; ?>')"><i class="fa fa-edit"></i></button>
              <?php } else { ?>
                <button type="button" class="btn btn-sm btn-info" disabled><i class="fa fa-edit"></i></button>
              <?php } ?>
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
    font-size: 14px;
  }

  td label {
    font-size: 14px;
  }
</style>