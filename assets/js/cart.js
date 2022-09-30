$(function () {

    //$(function () {
    //
    //})

    //$(window).focus(function () {
    //    location.reload(true)
    //})

    // update
    $('.input-number__add').click(function () {
        $('.input_cart').addClass('input_cart_disabled')
        $('#checkout_btn').addClass('btn-loading').attr('disabled', true)
        updateOnce($(this).data('cart_id'))
    })

    $('.input-number__sub').click(function () {
        $('.input_cart').addClass('input_cart_disabled')
        $('#checkout_btn').addClass('btn-loading').attr('disabled', true)
        updateOnce($(this).data('cart_id'))
    })

    function updateOnce(cart_id) {
        let cart_price = parseFloat($('#cart_amount_' + cart_id).data('cart_price'))
        let cart_amount = parseInt($('#cart_amount_' + cart_id).val())
        $.ajax({
            url: service_base_url + 'cart/updatecart',
            type: 'POST',
            data: {
                cart_id: cart_id,
                cart_price: cart_price,
                cart_amount: cart_amount
            },
            dataType: 'JSON',
            success: function (response) {
                if (response.http_code == 200) {
                    updateAll()
                } else {
                    location.reload()
                }
            }
        })
    }

    function updateAll() {
        let check = $('.cart_ids').length
        if (check == 0) {
            $('#checkout_btn').attr('disabled', true)
            location.reload()
        } else {
            let payment_price_total = 0;
            $('.cart_ids').each(function () {
                let cart_id = $(this).data('cart_id')
                let price = parseFloat($('#cart_amount_' + cart_id).data('cart_price'))
                let amount = parseInt($('#cart_amount_' + cart_id).val())
                let price_total = price * amount
                payment_price_total += price_total
                $('#cart_price_total_' + cart_id).text(priceformat(price_total))
            })
            $('#payment_price_total').text(priceformat(payment_price_total))
            setTimeout(function () {
                $('.input_cart').removeClass('input_cart_disabled')
                $('#checkout_btn').removeClass('btn-loading').attr('disabled', false)
            }, 200)
        }
    }

    // remove
    $('.cart-table__remove').click(function () {
        let cart_id = $(this).data('cart_id')
        let dealer_id = $(this).data('dealer_id')
        $('#rm_cart_id').val(cart_id)
        $('#rm_dealer_id').val(dealer_id)
        $('#rm_cart_modal').modal('show', {backdrop: 'true'})
    })

    $('#rm_cart_btn').click(function () {
        let cart_id = $('#rm_cart_id').val()
        let dealer_id = $('#rm_dealer_id').val()
        if (cart_id != '') {
            $('#rm_cart_btn').addClass('btn-loading').attr('disabled', true)
            $.ajax({
                url: service_base_url + 'cart/removecart',
                type: 'POST',
                data: {
                    cart_id: cart_id
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.http_code == 200) {
                        $('#rm_cart_btn').removeClass('btn-loading').attr('disabled', false)
                        $('#tr_cart_' + cart_id).remove()
                        let check = $('.cart_dealer_' + dealer_id).length
                        if (check == 0) {
                            $('#div_dealer_' + dealer_id).remove()
                        }
                        $('#rm_cart_modal').modal('hide')
                        updateAll()
                    } else {
                        location.reload()
                    }
                }
            })
        } else {
            location.reload()
        }
    })

    function priceformat(n) {
        let f = parseFloat(n)
        return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
    }

    // checkout
    $('#checkout_btn').click(function () {
        $('#checkout_btn').addClass('btn-loading').attr('disabled', true)
        window.location.replace(service_base_url + 'checkout');
    })

})