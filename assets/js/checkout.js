$(function () {

    $('#order_form').parsley()

    $(function () {

    })

    // order
    $('#order_btn').click(function () {
        $('#order_btn').addClass('btn-loading').attr('disabled', true)
        if ($('#order_form').parsley().validate() === true) {
            $.ajax({
                url: service_base_url + 'checkout/addorder',
                type: 'POST',
                data: $('#order_form').serialize(),
                dataType: 'JSON',
                success: function (response) {
                    if (response.http_code == 200) {
                        window.location.href = service_base_url + 'payment/' + response.order_payment_id
                    } else {
                        $('#order_btn').removeClass('btn-loading').attr('disabled', false)
                    }
                }
            })
        } else {
            $('#order_btn').removeClass('btn-loading').attr('disabled', false)
        }
    })

})