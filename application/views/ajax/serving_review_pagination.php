<table class="table">
    <thead>
        <tr>
            <th width="10%">เลขที่บริการ</th>
            <th width="10%">วันที่</th>
            <th width="20%">บริการ</th>
            <th width="10%">คะแนนริวิว</th>
            <th width="10%">รูปริวิว</th>
            <th width="20%">คอมเม้นต์</th>
            <th class="text-right" width="10%">สถานะ</th>
            <th class="text-right" width="10%">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($data->num_rows() > 0) {
            $i = $segment + 1;
            foreach ($data->result() as $row) {
                ?>
                <tr>
                    <td><?php echo $row->serve_code; ?></td>
                    <td><?php echo $this->misc->date2thai($row->serving_date, '%d %m %y', 1) ?></td>
                    <td><?php echo $row->course_name; ?></td>
                    <td>
                        <span style="color:#ffd333;"><?php echo $this->misc->rating($row->servingreview_rating); ?></span>
                    </td>
                    <td>
                        <a href="<?php echo admin_url() . 'assets/upload/servingreview/' . (!empty($row->servingreview_image) ? $row->servingreview_image : 'none.png'); ?>" class="fancybox">
                            <img src="<?php echo admin_url() . 'assets/upload/servingreview/' . (!empty($row->servingreview_image) ? $row->servingreview_image : 'none.png'); ?>" alt="" width="50">
                        </a>
                    </td>
                    <td><?php echo $row->servingreview_comment; ?></td>
                    <td class="text-right">
                        <?php if ($row->servingreview_status_id == 0) { ?>
                            <span class="badge badge-warning">รอรีวิว</span>
                        <?php } else if ($row->servingreview_status_id == 1) { ?>
                            <span class="badge badge-success">อนุมัติ</span>
                        <?php } else { ?>
                            <span class="badge badge-danger">ระงับ</span>
                        <?php } ?>
                    </td>
                    <td class="text-right">
                        <?php if ($row->servingreview_status_id == 0) { ?>
                            <button type="button" class="btn btn-sm btn-primary" onclick="servingReviewModal('<?php echo $row->servingreview_id; ?>')">เขียนรีวิว</button>
                        <?php } else { ?>
                            <button type="button" class="btn btn-sm btn-primary" disabled>เขียนรีวิว</button>
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
<script>
    $(function () {
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        })
    })
</script>