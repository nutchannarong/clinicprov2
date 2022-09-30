$(function () {
    //dealer
    delParams('searchdealer');
    delParams('geo_id');
    delParams('province_id');
    $("#searchdealer").blur(function () {
        if ($("#searchdealer").val() != "") {
            addParams('searchdealer', $("#searchdealer").val())
        } else {
            delParams('searchdealer');
        }
    });
    $("#geo_id").change(function () {
        if ($("#geo_id").val() != "") {
            addParams('geo_id', $("#geo_id").val())
        } else {
            delParams('geo_id');
        }
    });
    $("#province_id").change(function () {
        if ($("#province_id").val() != "") {
            addParams('province_id', $("#province_id").val())
        } else {
            delParams('province_id');
        }
    });
});


// set params
function addParams(params, value) {
    let url = new URL(document.location);
    let query_string = url.search;
    let search_params = new URLSearchParams(query_string);
    //add params
    search_params.set(params, value);
    url.search = search_params.toString();
    let new_url = url.toString();
    // add new url
    history.pushState({}, null, new_url);
}

function delParams(params) {
    let url = new URL(document.location);
    let query_string = url.search;
    let search_params = new URLSearchParams(query_string);
    // del params
    search_params.delete(params);
    // change the search property of the main url
    url.search = search_params.toString();
    // the new url string
    let new_url = url.toString();
    history.pushState({}, null, new_url);
}

function getParams(params) {
    let url = new URL(document.location);
    let query_string = url.search;
    let search_params = new URLSearchParams(query_string);
    return search_params.get(params);
}

function priceFormat(n) {
    let f = parseFloat(n);
    return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}

// car lists
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
            $("#count_car_compare").html(res.count_car_compare);
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
            $("#count_car_compare").html(res.count_car_compare);
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

// dealer list
function LoadProvince() {
    $.ajax({
        url: service_base_url + "home/loadprovince",
        type: "POST",
        dataType: "JSON",
        data: {
            geo_id: $('#geo_id').val()
        },
        success: function (res) {
            if (res.status) {
                $('#province_id').html(res.province);
            } else {
                $('#province_id').html(res.province);
            }
        }
    });
}

function pushDealerSearch() {
    let url = new URL(document.location);
    let query_string = url.search;
    location.href = service_base_url + 'dealers' + query_string;
}