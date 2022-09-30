<style>
    td{
        border: 0px solid black;
        padding-bottom: 2px;
    }
    p{
        font-size: 13px;
        margin-bottom: 2px;
    }
</style>
<div class="modal-header">
    <h6 class="modal-title"><i class="fa fa-eye"></i> รายละเอียดประวัติการรักษา OPD</h6>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <?php
                    $data = $this->opdcard_model->get_opdold($opd_id)->row();
                    $checks = $this->opdcard_model->get_opdoldorderdetail($data->order_id_pri, 3);
                    $drugs = $this->opdcard_model->get_opdoldorderdetail($data->order_id_pri, 2);
                    $courses = $this->opdcard_model->get_opdoldorderdetail($data->order_id_pri, 1);
                    $user = $this->opdcard_model->get_opdolduser($data->opd_id)->row();
                    $customer = $this->opdcard_model->get_opdoldcustomer($data->customer_id_pri)->row();
                    $shop = $this->opdcard_model->get_opdoldshop($data->shop_id_pri);
                    ?>
                    <table  style="border-collapse: collapse;width: 100%;">
                        <tr>
                            <td width="20%" style="font-size: 10pt;vertical-align: bottom; font-weight:bold;text-align: left;"><?php echo 'HN : ' . $customer->customer_id; ?></td>
                            <td rowspan="2" style="font-size: 14pt;font-weight:bold; text-align: center;">ใบตรวจรักษาผู้ป่วย (OPD) <?php echo ' ' . $shop->shop_name; ?></td>
                            <td width="24%" style="font-size: 8pt;vertical-align: bottom;text-align: right;">( พิมพ์เมื่อ : <?php echo $this->misc->date2thai($this->misc->getdate(), '%d %m %y', 1) . ' - ' . $this->misc->date2thai($this->misc->getdate(), '%h:%i:%s') . ' ) '; ?></td>
                        </tr>
                        <tr>
                            <td width="15%" rowspan="2" style="font-size:10pt;vertical-align: bottom;font-weight:bold;text-align: left"><?php echo 'VN : ' . $data->opd_code; ?></td>
                            <td style="font-size: 10pt;font-weight:bold;vertical-align: top;text-align: right;">วันที่ <?php echo $this->misc->date2thai($data->opd_date, '%d %m %y'); ?></td>
                        </tr>
                    </table>
                    <table style="border-collapse: collapse;width: 100%;">
                        <tr>
                            <td width="27%" style="text-align: left;"><p> 	ชื่อ : <?php echo $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname; ?></p></td>
                            <?php
                            if ($customer->customer_birthdate != '0000-00-00' || $customer->customer_birthdate != null) {
                                $date_1 = date_create($customer->customer_birthdate);
                                $date_2 = date_create(date('Y-m-d'));
                                $diff = $date_1->diff($date_2);
                                if ($diff->format('%y') == '0') {
                                    $age = 'อายุ : ' . $diff->format('%m ' . 'เดือน' . ' %d ' . 'วัน');
                                } else {
                                    $age ='อายุ : ' . $diff->format('%y ' . '	ปี' . ' %m ' . 'เดือน' . ' %d ' . 'วัน');
                                }
                            } else {
                                $age = ' ';
                            }
                            ?>
                            <td width="9%" style="text-align: left;"><p><?php echo 'เพศ : ' . $customer->customer_gender; ?></p></td>
                            <td width="30%" style="text-align: left;"><p><?php echo $age . '&nbsp;&nbsp;&nbsp;' . 'กรุ๊ปเลือด' . ' : ' . $customer->customer_blood; ?></p></td>
                            <td width="34%" style="text-align: right;"><p><?php echo 'สถานพยาบาล : ' . $shop->shop_name; ?></p></td>
                        </tr>
                        <tr>
                            <td width="27%" style="text-align: left;"><p><?php echo 'เลขบัตรประชาชน : '; ?><?php echo $customer->customer_idcard != null ? $customer->customer_idcard : ' '; ?></p></td>
                            <td colspan="2" style="text-align: left;"><p><?php echo 'ที่อยู่ : ' . $customer->customer_address . ' ' . $customer->customer_district . ' ' . $customer->customer_amphoe . ' ' . $customer->customer_province . ' ' . $customer->customer_zipcode; ?></p></td>
                            <td width="34%" style="text-align: right;"><p><?php echo 'ลักษณะการให้บริการ : ' . $shop->shop_nature; ?></p></td>
                        </tr>
                        <tr>
                            <td width="27%" style="text-align: left;"><p><?php echo 'เบอร์โทรผู้ป่วย : '; ?><?php echo $customer->customer_tel != null ? $customer->customer_tel : ' '; ?></p></td>
                            <td colspan="2" style="text-align: left;"><p><?php echo 'โรคประจำตัว : '; ?><?php echo $customer->customer_disease != null ? $customer->customer_disease : 'ไม่มีประวัติ'; ?></p></td>
                            <td width="34%" style="text-align: right;"><p><?php echo 'เลขที่ใบอนุญาต : ' . $shop->shop_license; ?></p></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: left;"><p><?php echo 'แพ้ยา : '; ?><?php echo $customer->customer_allergic != null ? $customer->customer_allergic : 'ไม่มีประวัติการแพ้ยา'; ?></p></td>
                            <td style="text-align: right;" colspan="2"><p><?php echo 'ที่อยู่สถานพยาบาล : ' . $shop->shop_address . ' ' . $shop->shop_district . ' ' . $shop->shop_amphoe . ' ' . $shop->shop_province . ' ' . $shop->shop_zipcode . ' ' . 'โทร ' . $shop->shop_tel; ?></p></td>
                        </tr>
                    </table>
                    <table style="border-collapse: collapse;width: 100%;" class="text-left">
                        <tr>
                            <td width="50%" style="border-top: 1px solid black;border-right: 1px solid black;vertical-align: top;padding-left: 0px;">
                                <p><span style="font-weight: bold;text-decoration:underline;">ข้อมูลทั่วไป </span><span> (ซักประวัติโดย : <?php echo ($data->opd_check_user_id != null) ? $this->opdcard_model->getuser($data->opd_check_user_id)->row()->user_fullname : $this->opdcard_model->getuser($data->user_id)->row()->user_fullname; ?> )</span></p>
                                <table style="border-collapse: collapse;width: 100%;">
                                    <tr>
                                        <td>
                                            <p><span style="font-weight: bold">T : </span><span><?php echo $data->opd_t != null ? $data->opd_t : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> C.</span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">P : </span><span><?php echo $data->opd_p != null ? $data->opd_p : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> /min.</span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">RR : </span><span><?php echo $data->opd_rr != null ? $data->opd_rr : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> /min.</span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">BP : </span><span><?php echo $data->opd_bp != null ? $data->opd_bp : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> mmHg</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p><span style="font-weight: bold">หนัก : </span><span><?php echo $data->opd_w != null ? $data->opd_w : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> กก.</span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">สูง : </span><span><?php echo $data->opd_h != null ? $data->opd_h : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> ซม.</span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">BMI : </span><span><?php echo $data->opd_bmi != null ? $data->opd_bmi : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> </span></p>
                                        </td>
                                        <td>
                                            <p><span style="font-weight: bold">FBS : </span><span><?php echo $data->opd_fbs != null ? $data->opd_fbs : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></span><span style="font-weight: bold"> mg/dl</span></p>
                                        </td>
                                    </tr>
                                </table>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">อาการสำคัญ / ประวัติปัจจุบัน / ประวัติในอดีต</p>
                                <p><span style="font-weight: bold">CC : </span><span><?php echo $data->opd_cc != null ? $data->opd_cc : '<br/>'; ?></span></p>
                                <p><span style="font-weight: bold">HPI : </span><span><?php echo $data->opd_hpi != null ? $data->opd_hpi : '<br/>'; ?></span></p>
                                <p><span style="font-weight: bold">PMH : </span><span><?php echo $data->opd_pmh != null ? $data->opd_pmh : '<br/>'; ?></span></p>
                                <p><span style="font-weight: bold">สูบบุหรี่ : </span><span>
                                        <?php
                                        if ($data->opd_fag == 1) {
                                            echo 'ไม่สูบ';
                                        } elseif ($data->opd_fag == 2) {
                                            echo 'สูบบางครั้ง';
                                        } elseif ($data->opd_fag == 3) {
                                            echo 'สูบ';
                                        } else {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        }
                                        ?>
                                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span style="font-weight: bold">ดื่มสุรา : </span><span>
                                        <?php
                                        if ($data->opd_alcohol == 1) {
                                            echo 'ไม่ดื่ม';
                                        } elseif ($data->opd_alcohol == 2) {
                                            echo 'ดื่มบางครั้ง';
                                        } elseif ($data->opd_alcohol == 3) {
                                            echo 'ดื่ม';
                                        } else {
                                            echo '';
                                        }
                                        ?>
                                    </span>
                                </p>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">การตรวจร่างกาย</p>
                                <p><span style="font-weight: bold">PE : </span><span><?php echo $data->opd_pe != null ? $data->opd_pe : '<br/>'; ?></span></p>
                                <p><span style="font-weight: bold">GA : </span><span><?php echo $data->opd_ga != null ? $data->opd_ga : '<br/>'; ?></span></p>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">หมายเหตุ</p>
                                <p><?php echo $data->opd_comment != null ? $data->opd_comment : '<br/>'; ?></p>
                            </td>
                            <td style="border-top: 1px solid black;border-left: 1px solid black;vertical-align: top;padding-left: 10px;">
                                <p><span style="font-weight: bold;text-decoration:underline;">การวินิฉัยโรค</span>
                                <p><span style="font-weight: bold">DX : </span><span><?php echo $data->opd_dx != null ? $data->opd_dx : '<br/>'; ?></span></p>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p><span style="font-weight: bold;text-decoration:underline;">รายการตรวจ</span>
                                </p>
                                <?php
                                $j = 1;
                                $checks = $this->opdcard_model->get_opdchecking($data->opd_id);
                                if ($checks->num_rows() > 0) {
                                    foreach ($checks->result() as $check) {
                                        ?>
                                        <p><?php echo $j . '. ' . $check->opdchecking_name . ' ' . ($check->opdchecking_code != null ? '( ' . $check->opdchecking_code . ' )' : ''); ?></p>
                                        <?php
                                        $j++;
                                    }
                                } else {
                                    echo '<br/>';
                                    echo '<br/>';
                                }
                                ?>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">รายการรักษา</p>
                                <?php
                                $k = 1;
                                if ($courses->num_rows() > 0) {
                                    foreach ($courses->result() as $course) {
                                        ?>
                                        <p><?php echo $k . '. ' . $course->orderdetail_name; ?></p>
                                        <?php
                                        $k++;
                                    }
                                } else {
                                    echo '<br/>';
                                    echo '<br/>';
                                }
                                ?>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">รายการยา/อุปกรณ์</p>
                                <?php
                                $l = 1;
                                if ($drugs->num_rows() > 0) {
                                    foreach ($drugs->result() as $drug) {
                                        ?>
                                        <p><?php echo $l . '. ' . $drug->orderdetail_name; ?><span class="text-muted"><?php echo ' ' . $drug->orderdetail_amount . ' ' . $drug->orderdetail_unit; ?></span> <span><?php echo ' ( ' . $drug->orderdetail_direction . ' )'; ?></span></p>
                                        <?php
                                        $l++;
                                    }
                                } else {
                                    echo '<br/>';
                                    echo '<br/>';
                                }
                                ?>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;text-decoration:underline;">หมายเหตุ</p>
                                <p><?php echo $data->order_comment != null ? $data->order_comment : '<br/>'; ?></p>
                                <hr style="margin-top: 4px;margin-bottom: 4px;"/>
                                <p style="font-weight: bold;"><?php echo 'แพทย์ (ผู้ดำเนินการ) : ' . $user->user_fullname; ?></p>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> ปิด</button>
</div>