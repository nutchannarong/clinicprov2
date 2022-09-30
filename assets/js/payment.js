$(function () {

    $(function () {

        if ($('#card_payment_form').length) {
            new Formatter(document.getElementById('card_number'), {
                'pattern': '{{9999}} {{9999}} {{9999}} {{9999}}'
            })
            new Formatter(document.getElementById('card_expiry_date'), {
                'pattern': '{{99}}/{{99}}'
            })
            new Formatter(document.getElementById('card_security_code'), {
                'pattern': '{{999}}'
            })
        }

        if ($('#payment_alert_form').length) {
            var cleave_1 = new Cleave('#payment_alert_price', {
                numeral: true,
                delimiter: ','
            })
            $('#payment_alert_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            })
            $('#payment_alert_slip').change(function () {
                readURL(this)
            })
        }

    })

    // login
    $('#login_a').click(function () {
        $('#login_modal').modal('show', {backdrop: 'true'})
    })

    // change payment type
    $('#payment_type_id').change(function () {
        let payment_type_id = $(this).val()
        if (payment_type_id != '') {
            $.ajax({
                url: service_base_url + 'payment/changepayment',
                type: 'POST',
                data: {
                    order_payment_id: $('#order_payment_id').val(),
                    payment_type_id: payment_type_id
                },
                success: function () {
                    location.reload()
                }
            })
        }
    })

    // payment alert
    $('#payment_alert_btn').click(function () {
        if ($('#payment_alert_form').parsley().validate() === true) {
            $('#card_payment_btn').addClass('btn-loading').attr('disabled', true)
            var form_data = $('#payment_alert_form')[0]
            var post_data = new FormData(form_data)
            $.ajax({
                url: service_base_url + 'payment/paymentalert',
                type: 'POST',
                data: post_data,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status_code == 200) {
                        $('#payment_result').html('<div class="alert alert-lg alert-success">แจ้งชำระเงินเรียบร้อยแล้ว</div>')
                    } else {
                        $('#payment_result').html('<div class="alert alert-lg alert-danger">แจ้งชำระเงินไม่สำเร็จ <a href="javascript:void(0)" onclick="location.reload()" >ลองใหม่อีกครั้ง</a></div>')
                    }
                }
            })
        }
    })

    // omise
    $('#card_payment_btn').click(function () {
        if ($('#card_payment_form').parsley().validate() === true) {
            Swal.fire({
                title: 'ทำรายการชำระเงิน',
                html: '<i class="fa fa-circle-notch fa-spin fa-spin fa-3x"></i><div class="mt-2">กรุณารอสักครู่ ระบบกำลังทำรายการชำระเงิน</div>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            })
            $('#card_payment_btn').addClass('btn-loading').attr('disabled', true)
            let card_expiry_date = $('#card_expiry_date').val()
            let split_card_expiry_date = card_expiry_date.split('/')
            var cardObject = {
                name: $('#card_name').val(),
                number: $('#card_number').val(),
                expiration_month: split_card_expiry_date[0],
                expiration_year: split_card_expiry_date[1],
                security_code: $('#card_security_code').val()
            }
            Omise.setPublicKey('pkey_test_588i5hfwbdoddcvm7tg')
            Omise.createToken('card', cardObject, function (status_code, response) {
                Swal.close()
                if (status_code === 200) {
                    $.ajax({
                        url: service_base_url + 'payment/cardpayment',
                        type: 'POST',
                        data: {
                            order_payment_id: $('#order_payment_id').val(),
                            omise_token: response.id
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.status_code == 200) {
                                $('#payment_result').html('<div class="alert alert-lg alert-success">ชำระเงินเรียบร้อยแล้ว</div>')
                            } else {
                                $('#payment_result').html('<div class="alert alert-lg alert-danger">ชำระเงินไม่สำเร็จ <a href="javascript:void(0)" onclick="location.reload()" >ลองใหม่อีกครั้ง</a></div>')
                            }
                        }
                    })
                } else {
                    $('#payment_result').html('<div class="alert alert-lg alert-danger">ชำระเงินไม่สำเร็จ <a href="javascript:void(0)" onclick="location.reload()" >ลองใหม่อีกครั้ง</a></div>')
                }
            })
        }
    })

})

function selectBank(bank_id) {
    let this_id = 'bank_id_' + bank_id
    if ($('#' + this_id).is(':checked')) {
        $('input[name="bank_id[]"]').each(function () {
            let check_id = $(this).attr('id')
            if (this_id != check_id) {
                $('#' + check_id).prop('checked', false)
            }
        });
    } else {
        $('#' + this_id).prop('checked', true)
    }
}

function setTime() {
    let h = $('#select_h').val()
    let m = $('#select_m').val()
    $('#payment_alert_time').val(h + ':' + m)
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
            $('#payment_alert_slip_preview').attr('src', e.target.result)
        }
        reader.readAsDataURL(input.files[0])
    }
}
