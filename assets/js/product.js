$(function () {

    $(function () {
        review()
        allowCart()
    })

    $('input[type=radio][name=opt_id]').change(function () {
        let amt = parseInt($('#opt_amt').val())
        let max = parseInt($(this).attr('data-opt-amt'))
        $('#avb_amt').text(max)
        $('#opt_amt').attr('max', max)
        if (amt >= max) {
            $('#opt_amt').val(max)
        }
        allowCart()
    })

    $('#opt_amt').change(function () {
        let amt = parseInt($(this).val())
        let max = parseInt($(this).attr('max'))
        if (amt >= max) {
            $(this).val(max)
        }
        allowCart()
    })

    function allowCart() {
        let p_id = $('#p_id').val()
        let opt_id = $('input[type=radio][name=opt_id]:checked').val()
        let opt_amt = $('#opt_amt').val()
        if (p_id && opt_id && opt_amt) {
            $('#btn_atc').attr('disabled', false)
            $('#btn_bn').attr('disabled', false)
        } else {
            $('#btn_atc').attr('disabled', true)
            $('#btn_bn').attr('disabled', true)
        }
    }

    $('#btn_atc').click(function () {
        $('#btn_atc').addClass('btn-loading').attr('disabled', true)
        $('#btn_bn').addClass('btn-loading').attr('disabled', true)
        let p_id = $('#p_id').val()
        let opt_id = $('input[type=radio][name=opt_id]:checked').val()
        let opt_amt = $('#opt_amt').val()
        if (p_id && opt_id && opt_amt) {
            $.ajax({
                url: service_base_url + 'product/addtocart',
                type: 'POST',
                data: {
                    p_id: p_id,
                    opt_id: opt_id,
                    opt_amt: opt_amt
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.http_code == 200) {
                        $('#count_cart_nav').text(response.count_cart)
                        $('#count_cart_modal').text(response.count_cart)
                        $('#add_cart_success_modal').modal('show', {backdrop: 'true'})
                    } else if (response.http_code == 401) {
                        $('#btn_atc').removeClass('btn-loading').attr('disabled', false)
                        $('#btn_bn').removeClass('btn-loading').attr('disabled', false)
                        $('#login_modal').modal('show', {backdrop: 'true'})
                    } else {
                        $('#add_cart_error_modal').modal('show', {backdrop: 'true'})
                    }
                }
            })
        } else {
            $('#add_cart_error_modal').modal('show', {backdrop: 'true'})
        }
    })

    $('#btn_bn').click(function () {
        $('#btn_atc').addClass('btn-loading').attr('disabled', true)
        $('#btn_bn').addClass('btn-loading').attr('disabled', true)
        let p_id = $('#p_id').val()
        let opt_id = $('input[type=radio][name=opt_id]:checked').val()
        let opt_amt = $('#opt_amt').val()
        if (p_id && opt_id && opt_amt) {
            $.ajax({
                url: service_base_url + 'product/addtocart',
                type: 'POST',
                data: {
                    p_id: p_id,
                    opt_id: opt_id,
                    opt_amt: opt_amt
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.http_code == 200) {
                        window.location.replace(service_base_url + 'cart')
                    } else if (response.http_code == 401) {
                        $('#btn_atc').removeClass('btn-loading').attr('disabled', false)
                        $('#btn_bn').removeClass('btn-loading').attr('disabled', false)
                        $('#login_modal').modal('show', {backdrop: 'true'})
                    } else {
                        $('#add_cart_error_modal').modal('show', {backdrop: 'true'})
                    }
                }
            })
        } else {
            $('#add_cart_error_modal').modal('show', {backdrop: 'true'})
        }
    })

    $('#btn_fav').click(function () {
        let p_id = $('#p_id').val()
        if (p_id) {
            $.ajax({
                url: service_base_url + 'product/addtofavorite',
                type: 'POST',
                data: {
                    p_id: p_id
                },
                dataType: 'JSON',
                success: function (response) {
                    if (response.http_code == 200) {
                        if (response.action == 'added') {
                            $('#svg_fav').css('fill', 'red')
                        } else {
                            $('#svg_fav').css('fill', '')
                        }
                    } else if (response.http_code == 401) {
                        $('#login_modal').modal('show', {backdrop: 'true'})
                    } else {
                        location.reload()
                    }
                }
            })
        }
    })

    function review() {
        $('#result-pagination').html('<div style="text-align:center padding:80px"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>')
        $.ajax({
            url: service_base_url + 'product/review',
            type: 'POST',
            data: {
                p_id: $('#p_id').val()
            },
            success: function (response) {
                $('#result-pagination').html(response)
            }
        })
    }

    function priceformat(n) {
        let f = parseFloat(n)
        return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')
    }

    $('.slick-seller').slick({
        autoplay: true,
        autoplaySpeed: 5000
    })

})