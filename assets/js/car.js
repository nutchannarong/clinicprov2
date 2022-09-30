$(function () {
    $("#year").change(function () {
        $("#result-car-year").html($(this).val());
    });
    $("#interest").change(function () {
        $("#result-car-interest").html($(this).val());
    });
    calculate()

    $('.slick-seller').slick({
        autoplay: true,
        autoplaySpeed: 2000
    });

    $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        auto: true,
        loop: true,
        thumbItem: 6,
        slideMargin: 0,
        enableDrag: false,
        controls : false,
        currentPagerPosition: 'left',
    });

    $('.fancybox').fancybox({
        padding: 0,
        helpers: {
            title: {
                type: 'outside'
            }
        }
    }).attr('data-fancybox', 'group1');


    $(".btn-img-3").click(function () {
        $(".btn-img-4").slideToggle();
        $(".btn-img-5").slideToggle();
        $(".btn-img-6").slideToggle();
        $(".btn-img-7").slideToggle();
    });

})



function favorite(car_id, customer_id) {
    $.ajax({
        url: service_base_url + 'cars/favorite',
        type: 'POST',
        data: {
            car_id: car_id,
            customer_id: customer_id
        },
        success: function () {
            location.reload()
        }
    });
}

function unFavorite(car_id, customer_id) {
    $.ajax({
        url: service_base_url + 'cars/unfavorite',
        type: 'POST',
        data: {
            car_id: car_id,
            customer_id: customer_id
        },
        success: function () {
            location.reload()
        }
    });
}

function setCarCompare(car_id) {
    $.ajax({
        url: service_base_url + 'cars/setcarcompare',
        type: 'POST',
        dataType: 'JSON',
        data: {
            car_id: car_id,
        },
        success: function (res) {
            location.reload()
        }
    });
}

function unSetCarCompare(car_id) {
    $.ajax({
        url: service_base_url + 'cars/unsetcarcompare',
        type: 'POST',
        dataType: 'JSON',
        data: {
            car_id: car_id,
        },
        success: function (res) {
            location.reload()
        }
    });
}

function carCompareLimit() {
    $.ajax({
        url: service_base_url + "cars/carcomparelimit",
        type: 'POST',
        data: {},
        success: function (response) {
            $('#result-modal .modal-content').html(response);
            $('#result-modal').modal('show', {backdrop: 'true'});
        }
    })
}


function unLogin() {
    $('#login_modal').modal('show', {backdrop: 'true'})
}

function calculate() {
    if ($('#car_price').val() != "") {
        // set data
        let car_price = parseFloat($('#car_price').val());
        let down_payment = parseFloat($('#down_payment').val());
        let total_price = 0;
        let interest = parseFloat($('#interest').val());
        let total_interest = 0;
        let year = parseInt($('#year').val());
        let month = 0;
        let total_all = 0;
        let total_per_month = 0;
        //process
        month = year * 12;

        if (down_payment > 0) {
            total_price = car_price - down_payment;
        } else {
            total_price = car_price;
            $('#down_payment').val('');
        }
        total_interest = (total_price * (interest / 100)) * year;
        total_all = total_price + total_interest;
        total_per_month = total_all / month;
        $("#total_per_month").html(priceFormat(total_per_month));
        $("#result_year").html(year);
        $("#result_month").html(month);
    }
}

function priceFormat(n) {
    let f = parseFloat(n);
    return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}