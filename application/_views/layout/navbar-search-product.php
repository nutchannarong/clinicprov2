<div class="row">
    <div class="col-xl-12 mt-2">
        <div class="card" style="border: 5px solid #007BFF; min-height: 350px">
            <div class="card-body">
                <h5 class="pt-3 pb-3 filters-header">ตัวกรองการค้นหา</h5>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row mt-2 mb-3">
                            <div class="col-4 col-xl-4 pr-0">
                                <img src="<?php echo base_url() . 'assets/img/icon/location.png'; ?>"></div>
                            <div class="col-8 col-xl-8 pl-0">
                                <?php if ($this->input->get('location') != '') { ?>
                                    <button class="btn btn-primary btn-sm" onclick="cancelLocation()">รอบตัวฉัน</button>
                                    <?php
                                } else {
                                    ?>
                                    <button class="btn btn-outline-primary btn-sm " onclick="getLocation()" style="border: 1px #007BFF solid;">
                                        รอบตัวฉัน
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-xl-4 mt-2 pr-0">จังหวัด :</div>
                            <div class="col-8 col-xl-8 pl-0">
                                <select id="shop_province" class="form-control">
                                    <option value=''>ทั้งหมด</option>
                                    <?php
                                    $get_shop_province = $this->productsearch_model->getShopProvince();
                                    if ($get_shop_province->num_rows() > 0) {
                                        foreach ($get_shop_province->result() as $row_shop_province) {
                                            ?>
                                            <option value="<?php echo $row_shop_province->shop_province; ?>" <?php echo $this->input->get('shop_province') == $row_shop_province->shop_province ? 'selected' : ''; ?>><?php echo $row_shop_province->shop_province ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-xl-4 mt-2 pr-0">อำเภอ :</div>
                            <div class="col-8 col-xl-8 pl-0">
                                <select id="shop_amphoe" class="form-control">
                                    <option value="">ทั้งหมด</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 col-xl-4 mt-2 pr-0">ตำบล :</div>
                            <div class="col-8 col-xl-8 pl-0">
                                <select id="shop_district" class="form-control">
                                    <option value="">ทั้งหมด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <span class="text-primary">ประเภทบริการ</span>
                        <div class="sidbar-style row">
                            <?php
                            $get_nature_name = $this->input->get('nature_name');
                            $array_nature_name = explode(',', $get_nature_name);
                            $i_sr = 1;
                            $get_shop_nature = $this->productsearch_model->getShopNature();
                            if ($get_shop_nature->num_rows() > 0) {
                                foreach ($get_shop_nature->result() as $row_shop_nature) {
                                    ?>
                                    <div class="form-check col-12">
                                        <input class="form-check-input" id="nature_<?php echo $i_sr; ?>" type="checkbox" onclick="setNature('<?php echo $row_shop_nature->shop_nature_name; ?>')" <?php echo in_array($row_shop_nature->shop_nature_name, $array_nature_name) ? 'checked' : null; ?>>
                                        <label class="form-check-label" for="nature_<?php echo $i_sr; ?>"><?php echo $row_shop_nature->shop_nature_name; ?></label>
                                    </div>
                                    <?php
                                    $i_sr++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-12">
                        <span class="text-primary">หมวดหมู่บริการ</span>
                        <div class="sidbar-style row" style="max-height:300px; overflow-y: scroll; ">
                            <?php
                            $get_category_name = $this->input->get('category_name');
                            $array_category_name = explode(',', $get_category_name);
                            $i_p_c = 1;
                            $get_product_category = $this->productsearch_model->getProductCategory();
                            if ($get_product_category->num_rows() > 0) {
                                foreach ($get_product_category->result() as $row_product_category) {
                                    ?>
                                    <div class="form-check col-12">
                                        <input  id="category_<?php echo $i_p_c; ?>" type="checkbox" onclick="setCategory('<?php echo $row_product_category->product_category_name; ?>')" <?php echo in_array($row_product_category->product_category_name, $array_category_name) ? 'checked' : null; ?>>
                                        <label  for="category_<?php echo $i_p_c; ?>"><?php echo $row_product_category->product_category_name; ?></label>
                                    </div>
                                    <?php
                                    $i_p_c++;
                                }
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="filter filter--opened" data-collapse-item>
                                    <div class="filter__body" data-collapse-content>
                                        <div class="filter__container">
                                            <?php
                                            $filter_min_discount = $this->input->get('min_discount');
                                            $filter_max_discount = $this->input->get('max_discount');
                                            $check_min_discount = isset($filter_min_discount) ? $filter_min_discount : 0;
                                            $check_max_discount = isset($filter_max_discount) ? $filter_max_discount : 100;
                                            ?>
                                            <div class="filter-product-discount"
                                                 data-min="0"
                                                 data-max="100"
                                                 data-from="<?php echo $check_min_discount; ?>"
                                                 data-to="<?php echo $check_max_discount; ?>">
                                                <div class="row">
                                                    <div class="col-4 mt-3"><span class="text-primary"> ส่วนลด %</span></div>
                                                    <div class="col-8">
                                                        <div class="filter-price__title-button" style="float: right">
                                                            <div class="filter-price__title">
                                                                <span class="min_discount"><?php echo number_format($check_min_discount); ?></span> %
                                                                –
                                                                <span class="max_discount"><?php echo number_format($check_max_discount); ?> </span> %
                                                            </div>
                                                            <input type="hidden" id="min_discount_check" value="0">
                                                            <input type="hidden" id="max_discount_check" value="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="filter-price__slider"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <span class="text-primary"> ราคา</span>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <span> เริ่มต้น</span>
                                        <input type="number" id="min_price" class="form-control form-control-sm mt-2" onchange="setMinPrice()" value="<?php echo $this->input->get('min_price'); ?>">
                                    </div>
                                    <div class="col-6">
                                        <span > สิ้นสุด</span>
                                        <input type="number" id="max_price" class="form-control form-control-sm mt-2" onchange="setMaxPrice()" value="<?php echo $this->input->get('max_price'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-block" onclick="reload()" style="border-radius: 0px">ค้นหา</button>
        </div>
    </div>
</div>
<script>

    $(function () {
        getShopAmphoe();
        getShopDistrict();
    })

    $("#shop_province").change(function () {
        if ($("#shop_province").val() != '') {
            addParams('shop_province', $("#shop_province").val())
            delParams('shop_amphoe');
            delParams('shop_district');
        } else {
            delParams('shop_province');
            delParams('shop_amphoe');
            delParams('shop_district');
        }
        getShopAmphoe();
        getShopDistrict();
    });

    $("#shop_amphoe").change(function () {
        if ($("#shop_amphoe").val() != '') {
            addParams('shop_amphoe', $("#shop_amphoe").val());
            delParams('shop_district');
        } else {
            delParams('shop_amphoe');
            delParams('shop_district');
        }
        getShopDistrict();
    });

    $("#shop_district").change(function () {
        if ($("#shop_district").val() != '') {
            addParams('shop_district', $("#shop_district").val())
        } else {
            delParams('shop_district');
        }
    });

    function getShopAmphoe() {
        $.ajax({
            url: service_base_url + 'productsearch/getshopamphoe',
            type: 'POST',
            dataType: "JSON",
            data: {
                shop_province: getParams('shop_province'),
                shop_amphoe: getParams('shop_amphoe')
            },
            success: function (data) {
                if (data.status) {
                    $('#shop_amphoe').html(data.data_shop_amphoe);
                } else {
                    $('#shop_amphoe').html(data.data_shop_amphoe);
                }
            }
        });
    }

    function getShopDistrict() {
        $.ajax({
            url: service_base_url + 'productsearch/getshopdistrict',
            type: 'POST',
            dataType: "JSON",
            data: {
                shop_amphoe: getParams('shop_amphoe'),
                shop_district: getParams('shop_district')
            },
            success: function (data) {
                if (data.status) {
                    $('#shop_district').html(data.data_shop_district);
                } else {
                    $('#shop_district').html(data.data_shop_district);
                }
            }
        });
    }

    function setNature(nature_name) {
        //get query string
        let get_nature_name = getParams('nature_name');
        // check
        if (get_nature_name != '' && get_nature_name != null) {
            // split array
            let array_nature_name = getParams('nature_name').split(",");
            // check data in array
            if (array_nature_name.includes(nature_name)) {
                array_nature_name = array_nature_name.filter(item => item !== nature_name);
                // check array length
                if (array_nature_name.length > 0) {
                    addParams('nature_name', array_nature_name.join())
                } else {
                    delParams('nature_name')
                }
            } else {
                array_nature_name.push(nature_name)
                addParams('nature_name', array_nature_name.join())
            }
        } else {
            addParams('nature_name', nature_name)
        }
    }

    function setCategory(category_name) {
        //get query string
        let get_category_name = getParams('category_name');
        // check
        if (get_category_name != '' && get_category_name != null) {
            // split array
            let array_category_name = getParams('category_name').split(",");
            // check data in array
            if (array_category_name.includes(category_name)) {
                array_category_name = array_category_name.filter(item => item !== category_name);
                // check array length
                if (array_category_name.length > 0) {
                    addParams('category_name', array_category_name.join())
                } else {
                    delParams('category_name')
                }
            } else {
                array_category_name.push(category_name)
                addParams('category_name', array_category_name.join())
            }
        } else {
            addParams('category_name', category_name)
        }
    }

    function setMinPrice() {
        let min_price = $("#min_price").val();
        if (min_price != '' && min_price >= 0) {
            addParams('min_price', min_price)
        } else {
            $("#min_price").val(0)
            delParams('min_price')
        }
    }

    function setMaxPrice() {
        let max_price = $("#max_price").val();
        if (max_price != '' && max_price >= 0) {
            addParams('max_price', max_price)
        } else {
            $("#max_price").val(0)
            delParams('max_price')

        }
    }

    // location
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
        }
    }

    function cancelLocation() {
        delParams('location')
        reload()
    }

    function successFunction(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        $.ajax({
            url: 'https://geocode.xyz',
            data: {
                // auth: '465830894777799738059x5805',
                locate: lat + ',' + lng,
                json: '1'
            },
            success: function (res) {
                addParams('location', res.region)
                reload()
            }
        })
    }

    function errorFunction() {
        console.log("Can not get location")
    }

    function reload() {
        let url = new URL(document.location);
        let query_string = url.search;
        location.href = service_base_url + 'promotions' + query_string;
    }

    function priceFormat(n) {
        let f = parseFloat(n);
        return f.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    }

    function getParams(params) {
        let url = new URL(document.location);
        let query_string = url.search;
        let search_params = new URLSearchParams(query_string);
        return search_params.get(params);
    }

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
</script>
<style>
    .filters-header {
        background: #007BFF;
        color: #FFFFFF;
        margin-top: -10px;
        margin-left: -20px
    }

    hr {
        background: #007BFF;
    }

    .sidbar-style {
        list-style-type: none;
        text-align: left !important;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .form-check {
        display: inline-block;
        padding: 1px 15px 1px 15px;
    }

    .form-check-input {
        display: none;
    }

    .form-check-label {
        border: 1px solid lavender;
        padding: 4px 10px 2px 10px;
        display: block;
        position: relative;
        margin: 0px 0px 4px 0px;
        cursor: pointer;
        font-weight: 300;
        font-size: 15px;
    }

    :checked + .form-check-label {
        border-color: dodgerblue;
        padding: 4px 10px 2px 10px;
        color: dodgerblue;
    }

    :checked + .form-check-label:before {
        background-color: dodgerblue;
        border-color: dodgerblue;
        z-index: 100;
    }
</style>