<div class="modal-header">
    <h6 class="modal-title"><i class="fa fa-edit"></i> ตรวจสอบบริการ/คอร์ส</h6>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th >ชื่อคอร์ส</th>
                    <th width="12%">เลขที่ใบเสร็จ</th>
                    <?php if ($serving_status_id != 1) { ?>
                        <th width="20%">ผู้ใช้บริการ</th>
                        <th width="15%">เเพทย์</th>
                        <th width="12%">เลขที่บริการ</th>
                        <th width="13%">วันที่ใช้บริการ</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
		$i = 1;
                if ($rows->num_rows() > 0) {                 
                    foreach ($rows->result() as $row) {
                        if ($row->serving_type == 3) {
                            if ($serving_status_id == 1) {
                                if ($this->services_model->sum_servingdetail_book($row->serving_id)->row()->servingdetail_book_amount > 0) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i; ?></td>
                                        <td ><?php echo $row->course_name; ?></td>
                                        <td ><?php echo $row->order_id; ?></td>
                                        <?php
                                        if ($serving_status_id != 1) {
                                            $serving = $this->services_model->getserving($row->serving_id)->row();
                                            $customer = $this->services_model->getcustomer($serving->customer_id_pri)->row();
                                            ?>
                                            <td ><?php echo $row->serving_status_id != 1 ? $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname : "-"; ?></td>
                                            <?php $shop_id_customer = $this->services_model->get_serve_id($serving->serve_id)->row()->shop_id_customer; ?>
                                            <?php if ($shop_id_customer == null) { ?>
                                                <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname : ''; ?></td>
                                                <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->services_model->getserve($row->serve_id)->row()->serve_code : '-'; ?></td>
                                            <?php } else { ?>
                                                <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname . '<br>(' . $this->services_model->get_shop($serving->shop_id_pri)->row()->shop_name . ')' : ''; ?></td>
                                                <td class="text-center"><?php echo $row->serving_status_id != 1 ? 'ต่างสาขา': '-'; ?></td>
                                            <?php } ?>
                                            <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->misc->date2thai($row->serving_date, '%d %m %y', 1) : '-'; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td ><?php echo $row->course_name; ?></td>
                                    <td ><?php echo $row->order_id; ?></td>
                                    <?php
                                    if ($serving_status_id != 1) {
                                        $serving = $this->services_model->getserving($row->serving_id)->row();
                                        $customer = $this->services_model->getcustomer($serving->customer_id_pri)->row();
                                        ?>
                                        <td ><?php echo $row->serving_status_id != 1 ? $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname : "-"; ?></td>
                                        <?php $shop_id_customer = $this->services_model->get_serve_id($serving->serve_id)->row()->shop_id_customer; ?>
                                        <?php if ($shop_id_customer == null) { ?>
                                            <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname : ''; ?></td>
                                            <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->services_model->getserve($row->serve_id)->row()->serve_code : '-'; ?></td>
                                        <?php } else { ?>
                                            <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname . '<br>(' . $this->services_model->get_shop($serving->shop_id_pri)->row()->shop_name . ')' : ''; ?></td>
                                            <td class="text-center"><?php echo $row->serving_status_id != 1 ? 'ต่างสาขา' : '-'; ?></td>
                                        <?php } ?>
                                        <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->misc->date2thai($row->serving_date, '%d %m %y', 1) : '-'; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td ><?php echo $row->course_name; ?></td>
                                <td ><?php echo $row->order_id; ?></td>
                                <?php
                                if ($serving_status_id != 1) {
                                    $serving = $this->services_model->getserving($row->serving_id)->row();
                                    $customer = $this->services_model->getcustomer($serving->customer_id_pri)->row();
                                    ?>
                                    <td ><?php echo $row->serving_status_id != 1 ? $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname : "-"; ?></td>
                                    <?php $shop_id_customer = $this->services_model->get_serve_id($serving->serve_id)->row()->shop_id_customer; ?>
                                    <?php if ($shop_id_customer == null) { ?>
                                        <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname : ''; ?></td>
                                        <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->services_model->getserve($row->serve_id)->row()->serve_code : '-'; ?></td>
                                    <?php } else { ?>
                                        <td ><?php echo $serving->user_id != null ? $this->services_model->getuser($serving->user_id)->row()->user_fullname . '<br>(' . $this->services_model->get_shop($serving->shop_id_pri)->row()->shop_name . ')' : ''; ?></td>
                                        <td class="text-center"><?php echo $row->serving_status_id != 1 ? 'ต่างสาขา': '-'; ?></td>
                                    <?php } ?>
                                    <td class="text-center"><?php echo $row->serving_status_id != 1 ? $this->misc->date2thai($row->serving_date, '%d %m %y', 1) : '-'; ?></td>
                                <?php } ?>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                        <?php
                        if ($row->serving_type == 3) {
                            if ($serving_status_id == 1) {
                                if ($this->services_model->sum_servingdetail_book($row->serving_id)->row()->servingdetail_book_amount > 0) {
                                    $books = $this->services_model->getservingdetailbook($row->serving_id);
                                    foreach ($books->result() as $book) {
                                        ?>
                                        <tr>
                                            <td ></td>
                                            <td >
                                                <?php echo ' ' . $book->drug_name . ' ( ' . $book->drug_unit . ' )'; ?>
                                            </td>
                                            <td ><?php echo 'คงเหลือ'; ?></td>
                                            <td ><?php echo number_format($book->servingdetail_book_amount, 0); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } else if ($serving_status_id == 3) {
                                $books = $this->services_model->getservingdrug($row->serving_id);
                                foreach ($books->result() as $book) {
                                    ?>
                                    <tr>
                                        <td ></td>
                                        <td >
                                            <?php echo ' ' . $book->drug_name . ' ( ' . $book->drug_unit . ' )'; ?>
                                        </td>
                                        <td ><?php echo 'ใช้ไป'; ?></td>
                                        <td ><?php echo number_format($this->services_model->countservingdrug($book->servingdetail_book_id, $row->serving_id)->row()->servingdrug_drug_amount, 0); ?></td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                if ($row->serving_status_id == 1) {
                                    $books = $this->services_model->getservingdetailbook($row->serving_id);
                                    foreach ($books->result() as $book) {
                                        ?>
                                        <tr>
                                            <td ></td>
                                            <td >
                                                <?php echo ' ' . $book->drug_name . ' ( ' . $book->drug_unit . ' )'; ?>
                                            </td>
                                            <td ><?php echo 'คงเหลือ'; ?></td>
                                            <td ><?php echo number_format($book->servingdetail_book_amount, 0); ?></td>
                                            <td ><?php echo 'ใช้ไป'; ?></td>
                                            <td ><?php echo number_format($this->services_model->sumservingdetailbook($book->servingdetail_book_id)->row()->servingdrug_drug_amount, 0); ?></td>
                                            <td ></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    $books = $this->services_model->getservingdrug($row->serving_id);
                                    foreach ($books->result() as $book) {
                                        ?>
                                        <tr>
                                            <td ></td>
                                            <td >
                                                <?php echo ' ' . $book->drug_name . ' ( ' . $book->drug_unit . ' )'; ?>
                                            </td>
                                            <td ><?php echo 'ใช้ไป'; ?></td>
                                            <td ><?php echo number_format($this->services_model->countservingdrug($book->servingdetail_book_id, $row->serving_id)->row()->servingdrug_drug_amount, 0); ?></td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
//                            $i++;
                        }
                    }
                } if($i == 1) {
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
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> ปิด</button>
</div>
