<table class="table">
    <thead>
        <tr>
            <th width="10%">เลขที่</th>
            <th width="30%">สินค้า</th>
            <th width="20%">ชื่อคลินิก</th>
            <th class="text-right" width="12%">จำนวน</th>
            <th class="text-right" width="12%">ราคา</th>
            <th class="text-right" width="12%">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        $count = 0;
        $is_error = 0;
        if ($cart->num_rows() > 0) {
            $i = 1;
            $drug_cart_qty = array();
            foreach ($cart->result() as $row) {
                // check drug
                $mark_error = 0;
                if (!empty($row->drugorder_id_pri)) {
                    $drug_stock_qty = 0;
                    $get_order_drug = $this->cart_model->getOrderDrug($row->drugorder_id_pri);
                    if ($get_order_drug->num_rows() > 0) {
                        $drug_stock_qty = $get_order_drug->row()->drugordert_total;
                    }
                    if (empty($drug_cart_qty[$row->drugorder_id_pri])) {
                        $drug_cart_qty[$row->drugorder_id_pri] = 0;
                    }
                    $drug_cart_qty[$row->drugorder_id_pri] += $row->orderdetail_temp_amount;
                    $check_drug_stock_qty = $drug_stock_qty - $drug_cart_qty[$row->drugorder_id_pri];
                    if ($check_drug_stock_qty < 0) {
                        $is_error = 1;
                        $mark_error = 1;
                    }
                }
                // check promotion birthdate
                if ($row->product_group_id == 2) {
                    if ($month_birthdate != $month_current) {
                        $is_error = 1;
                        $mark_error = 1;
                    }
                }
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row->orderdetail_temp_name; ?> <?php echo $mark_error == 1 ? '<b class="text-danger">( สินค้าหมด หรือโปรโมชั่นหมด )</b>' : ''; ?></td>
                    <td>
                        <div style="min-width: 100px">
                            <a target="_blank" href="<?php echo base_url() . 'shop/' . $row->shop_id; ?>"><?php echo $row->shop_name; ?></a>
                        </div>
                    </td>
                    <td class="text-right"><?php echo $row->orderdetail_temp_amount . ' ' . $row->orderdetail_temp_unit; ?></td>
                    <td class="text-right">
                        <?php
                        if ($row->orderdetail_temp_price > $row->orderdetail_temp_total) {
                            ?>
                            <span style="text-decoration: line-through;" class="text-secondary">฿<?php echo number_format($row->orderdetail_temp_price, 2); ?> บาท</span><br>
                            <?php
                        }
                        ?>
                        ฿<?php echo number_format($row->orderdetail_temp_total, 2); ?> บาท
                    </td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="Basic example" style="min-width: 120px">
                            <button type="button" id="btn_cart_<?php echo $row->orderdetail_temp_id_pri; ?>" class="btn btn-xs btn-primary" onclick="addToCart('<?php echo $row->product_id; ?>', '<?php echo $row->orderdetail_temp_id_pri; ?>')"><i class="fa fa-shopping-basket me-2"></i> สั่งซื้อ</button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="modalDelete('<?php echo $row->orderdetail_temp_id_pri; ?>')"><i class="fa fa-trash me-2"></i> ลบ</button>
                        </div>
                    </td>
                </tr>
                <?php
                $i++;
                $count++;
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
<input type="hidden" id="count" value="<?php echo $count; ?>">
<input type="hidden" id="is_cart_error" value="<?php echo $is_error; ?>">
<style>
    td{
        font-size: 12px;
    }

    td label{
        font-size: 12px;
    }
</style>