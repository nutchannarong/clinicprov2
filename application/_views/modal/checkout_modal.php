<form id="form_checkout" method="post" action="#" onsubmit="return false" autocomplete="off">
    <div class="modal-header">
        <h6 class="modal-title">ชำระเงิน</h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label text-bold m-t-5">รายการ</label>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-notmal" width="70%">สินค้า</th>
                                    <th class="text-notmal text-right" width="30%">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $shop_id_pri = '';
                                $is_error = 0;
                                $is_drug = 0;
                                $product_price = 0;
                                $product_point = 0;
                                $drug_cart_qty = array();
                                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                                $month_current = date('m');
                                $cart_cnt = $cart->num_rows();
                                if ($cart_cnt > 0) {
                                    $i = 1;
                                    foreach ($cart->result() as $row) {
                                        if ($is_drug == 0 && $row->product_type_id == 2) {
                                            $is_drug = 1;
                                        }
                                        // check drug
                                        $mark_error = 0;
                                        if ($row->drugorder_id_pri != null || $row->drugorder_id_pri != '') {
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
                                        // shop shipping
                                        if ($shop_id_pri == '') {
                                            $shop_id_pri = $row->shop_id_pri;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <div style="float: left;">
                                                    <img src="<?php echo admin_url() . 'assets/upload/product/' . $row->product_image; ?>" alt="<?php echo $row->orderdetail_temp_name; ?>" class="img_product_table">
                                                </div>
                                                <div class="text_product_table">
                                                    <?php echo $row->orderdetail_temp_name; ?> x 1 <?php echo $mark_error == 1 ? '<b class="text-danger">( สินค้าหมด หรือโปรโมชั่นหมด )</b>' : ''; ?><br />
                                                    <small><?php echo $row->shop_name; ?></small>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                if ($row->orderdetail_temp_price > $row->orderdetail_temp_total) {
                                                    ?>
                                                    <span style="text-decoration: line-through;" class="text-secondary"><?php echo number_format($row->orderdetail_temp_price, 2); ?> บาท</span><br>
                                                    <?php
                                                }
                                                ?>
                                                <span class="text-price"><?php echo number_format($row->orderdetail_temp_total, 2); ?> บาท</span>
                                            </td>
                                        </tr>
                                        <?php
                                        $product_price += $row->orderdetail_temp_total;
                                        $product_point += $row->orderdetail_temp_point;
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
                        <input type="hidden" id="is_drug" value="<?php echo $is_drug; ?>">
                        <input type="hidden" id="is_error" value="<?php echo $is_error; ?>">
                        <input type="hidden" id="is_payment" value="<?php echo $is_error == 0 ? 1 : 2; ?>">
                    </div>
                </div>
                <div class="row m-t-15">
                    <div class="col-lg-12">
                        <label class="form-label text-bold m-t-5">ประเภทการจัดส่ง</label>
                        <div>
                            <button type="button" id="shipping_0" class="btn btn-primary" onclick="setShipping('0')">รับที่คลินิค</button>
                            <button type="button" id="shipping_1" class="btn btn-secondary" onclick="setShipping('1')" disabled>จัดส่งถึงบ้าน</button>
                            <input type="hidden" id="shipping_type_id" name="shipping_type_id" value="0">
                        </div>
                    </div>
                </div>
                <div class="row m-t-15">
                    <div class="col-lg-12">
                        <label class="form-label text-bold m-t-5">ข้อมูลการจัดส่ง</label>
                        <div id="form_shipping_0" class="row">
                            <?php $shop = $this->cart_model->getShopById($shop_id_pri)->row(); ?>
                            <div class="col-3 mt-2 text-center">
                                <img src="<?php echo admin_url() . 'assets/upload/shop/' . $shop->shop_image; ?>" alt="" width="100%" onerror="this.onerror=null;this.src='<?php echo admin_url() . 'assets/upload/shop/none.png'; ?>';" class="text-center">
                            </div>
                            <div class="col-6 mt-2">
                                <span>ชื่อร้าน : <?php echo $shop->shop_name; ?></span><br>
                                <span>เลขที่ใบอนุญาติ : <?php echo $shop->shop_license; ?></span><br>
                                <span>โทร : <?php echo $shop->shop_tel; ?></span><br>
                                <span>อีเมล : <?php echo $shop->shop_email; ?></span><br>
                                <span>ที่อยู่ : <?php echo $shop->shop_address; ?> ตำบล<?php echo $shop->shop_district; ?> อำเภอ<?php echo $shop->shop_amphoe; ?> จังหวัด<?php echo $shop->shop_province; ?> รหัสไปรษณีย์ <?php echo $shop->shop_zipcode; ?></span><br>
                                <?php
                                $get_shop_rating = $this->global_model->getShopReviewByID($shop_id_pri);
                                if ($get_shop_rating->num_rows() == 1) {
                                    $row_shop_rating = $get_shop_rating->row();
                                    $shop_rating_total = $row_shop_rating->rating;
                                    $count_review_product = $row_shop_rating->count_rating;
                                } else {
                                    $shop_rating_total = 0;
                                    $count_review_product = 0;
                                }
                                ?>
                                <span style="color:#ffd333;"><?php echo $this->misc->rating(round($shop_rating_total)); ?></span>&nbsp;
                                <span><?php echo number_format(round($shop_rating_total)); ?> จาก <?php echo number_format($count_review_product); ?> รีวิว</span>
                            </div>
                            <div class="col-3 mt-2">
                                <a target="_blank" href="<?php echo 'https://maps.google.com/?daddr=' . $shop->shop_latlong; ?>" class="btn btn-primary btn-block"> นำทาง</a>
                                <a href="tel:<?php echo $shop->shop_tel; ?>" class="btn btn-primary btn-block"> โทร</a>
                            </div>
                        </div>
                        <div id="form_shipping_1" class="row" style="display: none;">
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">คำนำหน้า</label>
                                <select name="prefix" id="prefix" class="form-control" required>
                                    <option value="นาย" <?php echo $customer->online_fname == 'นาย' ? 'selected' : ''; ?>>นาย</option>
                                    <option value="นางสาว" <?php echo $customer->online_fname; ?>>นางสาว</option>
                                    <option value="นาง" <?php echo $customer->online_fname; ?>>นาง</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">ชื่อ</label>
                                <input type="text" name="fname" id="fname" value="<?php echo $customer->online_fname; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">นามสกุล</label>
                                <input type="text" name="lname" id="lname" value="<?php echo $customer->online_lname; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">เบอร์โทร</label>
                                <input type="text" name="phone" id="phone" value="<?php echo $customer->online_tel; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label m-t-5">ที่อยู่</label>
                                <input type="text" name="address" id="address" value="<?php echo $customer->online_address; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">ตำบล</label>
                                <input type="text" name="sub_district" id="sub_district" value="<?php echo $customer->online_district; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">อำเภอ</label>
                                <input type="text" name="district" id="district" value="<?php echo $customer->online_amphoe; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">จังหวัด</label>
                                <input type="text" name="province" id="province" value="<?php echo $customer->online_province; ?>" class="form-control" autocomplete="new" required>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label m-t-5">รหัสไปรษณีย์</label>
                                <input type="text" name="zipcode" id="zipcode" value="<?php echo $customer->online_zipcode; ?>" class="form-control" autocomplete="new" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row m-t-10">
                    <div class="col-lg-12">
                        <label class="form-label text-bold m-t-5">สรุปรายการ</label>
                    </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-lg-6">
                        <label class="form-label">รวมราคาสินค้า</span>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="" style="font-weight: bold;"><?php echo number_format($product_price, 2); ?> บาท</span>
                        <input type="hidden" id="product_price" name="product_price" value="<?php echo $product_price; ?>">
                    </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-lg-6">
                        <label class="form-label">แต้มที่ได้รับ</label>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="" style="font-weight: bold;"><?php echo $product_point; ?> แต้ม</span>
                    </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-lg-6">
                        <label class="form-label">ใช้แต้ม</label>
                    </div>
                    <div class="col-lg-6 text-right">
                        <input type="text" name="use_point" id="use_point" min="0" max="<?php echo $my_point; ?>" class="form-control type-number" onclick="this.select()" <?php echo ($my_point <= 0 || $is_error == 1 || $cart_cnt == 0) ? 'disabled' : ''; ?>>
                        <small class="">คุณมีแต้มคงเหลือ <?php echo $my_point; ?> แต้ม</small>
                    </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-lg-6">
                        <label class="form-label">ยอดชำระ</label>
                    </div>
                    <div class="col-lg-6 text-right">
                        <span class="" style="font-weight: bold;"><span id="payment_price"><?php echo number_format($product_price, 2); ?></span> บาท</span>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-lg-12">
                        <label class="form-label text-bold m-t-5">ช่องทางการชำระเงิน</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <img src="<?php echo base_url() . 'assets/img/visa_mastercard.png'; ?>" height="40">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="" class="m-b-5">
                            <div class="form-row">
                                <div class="col-md-12 m-b-5">
                                    <label>Card number</label>
                                    <input type="text" id="card_number" class="form-control" value="" placeholder="•••• •••• •••• ••••" autocomplete="new" <?php echo ($is_error == 1 || $cart_cnt == 0) ? 'disabled' : 'required'; ?> />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 m-b-5">
                                    <label>Name on card</label>
                                    <input type="text" id="card_name" class="form-control" value="" placeholder="Full name" autocomplete="new" <?php echo ($is_error == 1 || $cart_cnt == 0) ? 'disabled' : 'required'; ?> />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 m-b-5">
                                    <label>Expiry date</label>
                                    <input type="text" id="card_expiry_date" class="form-control" value="" placeholder="MM/YY" autocomplete="new" <?php echo ($is_error == 1 || $cart_cnt == 0) ? 'disabled' : 'required'; ?> />
                                </div>
                                <div class="col-md-6 m-b-5">
                                    <label>Security code</label>
                                    <input type="password" id="card_security_code" class="form-control" value="" placeholder="•••" autocomplete="new" <?php echo ($is_error == 1 || $cart_cnt == 0) ? 'disabled' : 'required'; ?> />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="checkout__agree form-group">
                                        <div class="form-check">
                                            <span class="input-check form-check-input">
                                                <span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox" id="is_agree" data-parsley-error-message="*** อ่านและยอมรับข้อตกลงและเงื่อนไข" checked required>
                                                    <span class="input-check__box"></span>
                                                    <span class="input-check__icon"><svg xmlns="http://www.w3.org/2000/svg" width="9px" height="7px">
                                                        <path d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                            <label class="form-check-label" for="is_agree">
                                                ฉันได้อ่านและยอมรับ "<a target="_blank" href="<?php echo base_url('conditions'); ?>">ข้อตกลงและเงื่อนไข</a>"
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="form_checkout_btn" class="btn btn-primary btn-block" <?php echo ($is_error == 1 || $cart_cnt == 0) ? 'disabled' : ''; ?>>ชำระเงิน</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    .text-notmal {
        font-weight: normal !important;
    }
    .text-bold {
        font-weight: bold !important;
    }
    .img_product_table {
        width: 50px;
        height: 50px;
    }
    .text_product_table {
        font-size: 15px;
        margin-left: 60px;
    }
    .text-price {
        font-size: 15px;
    }
    .type-number {
        text-align: right;
    }
</style>
<script>

    $(function () {
        new Cleave('.type-number', {
            numeral: true,
            numeralPositiveOnly: true,
            rawValue: true,
            delimiter: ''
        })
        new Formatter(document.getElementById('card_number'), {
            'pattern': '{{9999}} {{9999}} {{9999}} {{9999}}'
        })
        new Formatter(document.getElementById('card_expiry_date'), {
            'pattern': '{{99}}/{{99}}'
        })
        new Formatter(document.getElementById('card_security_code'), {
            'pattern': '{{999}}'
        })
        if ($('#is_drug').val() == 1) {
            $('#shipping_1').prop('disabled', false)
        }
    })

    $.Thailand({
        database: service_base_url + 'assets/js/thailand-db/db.json',
        $district: $('#form_checkout [name="sub_district"]'),
        $amphoe: $('#form_checkout [name="district"]'),
        $province: $('#form_checkout [name="province"]'),
        $zipcode: $('#form_checkout [name="zipcode"]')
    })

    $('#form_checkout').keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault()
        }
    })

    $('#use_point').change(function () {
        let use_point = parseInt($(this).val())
        let max_point = parseInt($(this).attr('max'))
        let product_price = parseFloat($('#product_price').val())
        if (use_point >= max_point) {
            use_point = max_point
            if (use_point > product_price) {
                use_point = Math.ceil(product_price)
            }
        } else {
            if (use_point > product_price) {
                use_point = Math.ceil(product_price)
            }
        }
        let payment_price = product_price - use_point
        $('#use_point').val(use_point)
        $('#payment_price').text(priceFormat(payment_price))
        if (payment_price > 0 && $('#is_error').val() == 0) {
            // use some point
            $('#is_payment').val(1)
            $('#card_number').prop('required', true).prop('disabled', false)
            $('#card_name').prop('required', true).prop('disabled', false)
            $('#card_expiry_date').prop('required', true).prop('disabled', false)
            $('#card_security_code').prop('required', true).prop('disabled', false)
        } else {
            // use all point or error
            $('#is_payment').val(2)
            $('#card_number').val('')
            $('#card_name').val('')
            $('#card_expiry_date').val('')
            $('#card_security_code').val('')
            $('#card_number').prop('required', false).prop('disabled', true).parsley().validate()
            $('#card_name').prop('required', false).prop('disabled', true).parsley().validate()
            $('#card_expiry_date').prop('required', false).prop('disabled', true).parsley().validate()
            $('#card_security_code').prop('required', false).prop('disabled', true).parsley().validate()
        }
    })

    function setShipping(id) {
        if (id == '0') {
            $('#shipping_type_id').val(0)
            $('#form_shipping_0').show()
            $('#form_shipping_1').hide()
            $('#shipping_0').removeClass('btn-secondary').addClass('btn-primary')
            $('#shipping_1').removeClass('btn-primary').addClass('btn-secondary')
            $('#prefix').prop('required', false)
            $('#fname').prop('required', false)
            $('#lname').prop('required', false)
            $('#phone').prop('required', false)
            $('#address').prop('required', false)
            $('#sub_district').prop('required', false)
            $('#district').prop('required', false)
            $('#province').prop('required', false)
            $('#zipcode').prop('required', false)
        } else {
            $('#shipping_type_id').val(1)
            $('#form_shipping_0').hide()
            $('#form_shipping_1').show()
            $('#shipping_0').removeClass('btn-primary').addClass('btn-secondary')
            $('#shipping_1').removeClass('btn-secondary').addClass('btn-primary')
            $('#prefix').prop('required', true)
            $('#fname').prop('required', true)
            $('#lname').prop('required', true)
            $('#phone').prop('required', true)
            $('#address').prop('required', true)
            $('#sub_district').prop('required', true)
            $('#district').prop('required', true)
            $('#province').prop('required', true)
            $('#zipcode').prop('required', true)
        }
    }

    function priceFormat(n) {
        let f = parseFloat(n)
        return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
    }

    // payment nut
    $('#form_checkout_btn').click(function () {
        if ($('#form_checkout').parsley().validate() === true) {
            Swal.fire({
                title: 'กำลังทำรายการชำระเงิน',
                html: '<i class="fa fa-circle-notch fa-spin fa-spin fa-3x"></i><div class="mt-2">กรุณารอสักครู่ ระบบกำลังทำรายการชำระเงิน</div>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            })
            $('#form_checkout_btn').addClass('btn-loading').attr('disabled', true)
            let getForm = document.getElementById('form_checkout')
            let formData = new FormData(getForm)
            let is_error = $('#is_error').val()
            let is_payment = $('#is_payment').val()
            if (is_payment == 1 && is_error == 0) {
                let check_use_point = parseInt($('#use_point').val())
                if (isNaN(check_use_point) == true) {
                    check_use_point = 0;
                }
                let check_product_price = parseFloat($('#product_price').val())
                let check_payment_price = check_product_price - check_use_point
                if (check_payment_price == 0 || check_payment_price >= 50) {
                    let card_expiry_date = $('#card_expiry_date').val()
                    let split_card_expiry_date = card_expiry_date.split('/')
                    var cardObject = {
                        name: $('#card_name').val(),
                        number: $('#card_number').val(),
                        expiration_month: split_card_expiry_date[0],
                        expiration_year: split_card_expiry_date[1],
                        security_code: $('#card_security_code').val()
                    }
                    Omise.setPublicKey(pb_key)
                    Omise.createToken('card', cardObject, function (status_code, response) {
                        if (status_code === 200) {
                            formData.append('product_price', $('#product_price').val())
                            formData.append('use_point', $('#use_point').val())
                            formData.append('omise_token', response.id)
                            $.ajax({
                                url: service_base_url + 'order/cardpayment',
                                type: 'POST',
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                cache: false,
                                success: function (response) {
                                    //console.log(response)
                                    if (response.status == 'pending') {
                                        window.location.href = response.message;
//                                        formData.append('charge_id', response.charge_id)
//                                        $.ajax({
//                                            url: service_base_url + 'order/addorder',
//                                            type: 'POST',
//                                            data: formData,
//                                            dataType: 'JSON',
//                                            processData: false,
//                                            contentType: false,
//                                            cache: false,
//                                            success: function (response) {
//                                                if (response.status == 'success') {
//                                                    showSuccess(response.order_id_pri)
//                                                } else {
//                                                    showError('เกิดข้อผิดพลาด ไม่สามารถเพิ่มรายการสั่งซื้อได้')
//                                                }
//                                            },
//                                            error: function (jqXHR, textStatus, errorThrown) {
//                                                showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
//                                            }
//                                        })
                                    } else {
                                        showError('ตัดบัตรไม่สำเร็จ กรุณาตรวจสอบบัตรอีกครั้ง')
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
                                }
                            })
                        } else {
                            showError('ข้อมูลบัตรไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง')
                        }
                    })
                } else {
                    showError('ตัดบัตรไม่สำเร็จ กรุณาชำระยอดเงินตั้งแต่ 50 บาท ขึ้นไป')
                }
            } else if (is_payment == 2 && is_error == 0) {
                $.ajax({
                    url: service_base_url + 'order/addorder',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response) {
                        if (response.status == 'success') {
                            showSuccess(response.order_id_pri)
                        } else {
                            showError('ข้อมูลแต้มส่วนลดไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง')
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
                    }
                })
            } else {
                showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
            }
        }
    })

//    // payment tom
//    $('#form_checkout_btn').click(function () {
//        if ($('#form_checkout').parsley().validate() === true) {
//            Swal.fire({
//                title: 'กำลังทำรายการชำระเงิน',
//                html: '<i class="fa fa-circle-notch fa-spin fa-spin fa-3x"></i><div class="mt-2">กรุณารอสักครู่ ระบบกำลังทำรายการชำระเงิน</div>',
//                allowOutsideClick: false,
//                showCancelButton: false,
//                showConfirmButton: false
//            })
//            $('#form_checkout_btn').addClass('btn-loading').attr('disabled', true)
//            let getForm = document.getElementById('form_checkout')
//            let formData = new FormData(getForm)
//            let is_error = $('#is_error').val()
//            let is_payment = $('#is_payment').val()
//            if (is_payment == 1 && is_error == 0) {
//                //let check_use_point = parseInt($('#use_point').val())
//                let check_use_point = parseInt($('#use_point').val())
//                if (isNaN(check_use_point) == true) {
//                    check_use_point = 0;
//                }
//                let check_product_price = parseFloat($('#product_price').val())
//                let check_payment_price = check_product_price - check_use_point
//                if (check_payment_price == 0 || check_payment_price >= 50) {
//                    let card_expiry_date = $('#card_expiry_date').val()
//                    let split_card_expiry_date = card_expiry_date.split('/')
//                    var cardObject = {
//                        name: $('#card_name').val(),
//                        number: $('#card_number').val(),
//                        expiration_month: split_card_expiry_date[0],
//                        expiration_year: split_card_expiry_date[1],
//                        security_code: $('#card_security_code').val()
//                    }
//                    Omise.setPublicKey(pb_key)
//                    Omise.createToken('card', cardObject, function (status_code, response) {
//                        if (status_code === 200) {
//                            $.ajax({
//                                url: service_base_url + 'order/cardpayment',
//                                type: 'POST',
//                                data: {
//                                    product_price: $('#product_price').val(),
//                                    use_point: $('#use_point').val(),
//                                    omise_token: response.id
//                                },
//                                dataType: 'JSON',
//                                success: function (response) {
//                                    if (response.status == 'success') {
//                                        formData.append('charge_id', response.charge_id)
//                                        $.ajax({
//                                            url: service_base_url + 'order/addorder',
//                                            type: 'POST',
//                                            data: formData,
//                                            dataType: 'JSON',
//                                            processData: false,
//                                            contentType: false,
//                                            cache: false,
//                                            success: function (response) {
//                                                if (response.status == 'success') {
//                                                    showSuccess(response.order_id_pri)
//                                                } else {
//                                                    showError('เกิดข้อผิดพลาด ไม่สามารถเพิ่มรายการสั่งซื้อได้')
//                                                }
//                                            },
//                                            error: function (jqXHR, textStatus, errorThrown) {
//                                                showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
//                                            }
//                                        })
//                                    } else {
//                                        showError('ตัดบัตรไม่สำเร็จ กรุณาตรวจสอบบัตรอีกครั้ง')
//                                    }
//                                },
//                                error: function (jqXHR, textStatus, errorThrown) {
//                                    showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
//                                }
//                            })
//                        } else {
//                            showError('ข้อมูลบัตรไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง')
//                        }
//                    })
//                } else {
//                    showError('ตัดบัตรไม่สำเร็จ กรุณาชำระยอดเงินตั้งแต่ 50 บาท ขึ้นไป')
//                }
//            } else if (is_payment == 2 && is_error == 0) {
//                $.ajax({
//                    url: service_base_url + 'order/addorder',
//                    type: 'POST',
//                    data: formData,
//                    dataType: 'JSON',
//                    processData: false,
//                    contentType: false,
//                    cache: false,
//                    success: function (response) {
//                        if (response.status == 'success') {
//                            showSuccess(response.order_id_pri)
//                        } else {
//                            showError('ข้อมูลแต้มส่วนลดไม่ถูกต้อง กรุณาตรวจสอบข้อมูลอีกครั้ง')
//                        }
//                    },
//                    error: function (jqXHR, textStatus, errorThrown) {
//                        showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
//                    }
//                })
//            } else {
//                showError('เกิดข้อผิดพลาด ไม่สามารถทำรายการชำระเงินได้')
//            }
//        }
//    })

    function showSuccess(id) {
        Swal.close()
        Swal.fire({
            title: 'ทำรายการชำระเงินเรียบร้อยแล้ว',
            html: '<i class="fa fa-check fa-3x"></i><div class="mt-2">ทำรายการสั่งซื้อของคุณเรียบร้อยแล้ว</div>',
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: '<i class="fa fa-shopping-cart"></i> ไปยังหน้ารายการสั่งซื้อ',
            preConfirm: () => {
                window.location.href = service_base_url + 'order?id=' + id
            }
        })
    }

    function showError(message) {
        Swal.close()
        Swal.fire({
            title: 'ทำรายการชำระเงินไม่สำเร็จ',
            html: '<i class="fa fa-times fa-3x"></i><div class="mt-2">' + message + '</div>',
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: '<i class="fa fa-shopping-cart"></i> กลับไปหน้าชำระเงิน',
            preConfirm: () => {
                location.reload()
            }
        })
    }

</script>