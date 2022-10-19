<div class="site__body mb-5">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3, 5);
                    if ($slides->num_rows() > 0) {
                        $s_r = 0;
                        foreach ($slides->result() as $slide_r) {
                            ?>
                            <a class="block-slideshow__item"
                               href="<?php echo($slide_r->slideshow_link != '' ? $slide_r->slideshow_link : 'javascript:void(0);'); ?>" <?php echo($slide_r->slideshow_open_link == 2 ? 'target="_blank"' : ''); ?>
                               title="<?php echo $slide_r->slideshow_name; ?>">
                                <span class="block-slideshow__item-image block-slideshow__item-image--desktop"
                                      style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image != '' ? $slide_r->slideshow_image : 'none.png'); ?>')"></span>
                                <span class="block-slideshow__item-image block-slideshow__item-image--mobile"
                                      style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image_half != '' ? $slide_r->slideshow_image_half : 'none-half.png'); ?>')"></span>
                            </a>
                            <?php
                            $s_r++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="block blog-view blog-view--layout--list">
        <div class="container mt-5">
            <div class="row">
                <div class="col-8 text-left" style="vertical-align: top;">
                    <span style="color: dodgerblue; font-weight: bold;"> ประเภท</span>
                    <?php
                    $naturename = '';
                    $k = 0;
                    $natures = $this->search_model->getNatureArray();
                    if ($natures->num_rows() > 0) {
                        foreach ($natures->result() as $nature) {
                            if ($k == 0) {
                                $naturename .= $nature->shop_nature_name;
                            } else {
                                $naturename .= ', ' . $nature->shop_nature_name;
                            }
                            $k++;
                        }
                    }
                    ?>
                    <span style="color: dodgerblue; font-weight: bold;" id="result-bar"><?php echo $naturename ?></span>
                </div>
                <div class="col-4 text-right">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#modalNature" class="custom_btn cta-1">เลือกประเภทคลินิก</a>
                </div>
            </div>
            <div style="margin-top: 30px;" class="row">
                <div class="col-md-12 col-sm-12 col-12">
                    <div id="map" class="gmaps" style="height: 600px;"></div>
                </div>
            </div>
            <div class="row" style="margin-top: 40px;">
                <div class="col-lg-8">
                </div>
                <div class="col-lg-4 col-12 text-right">
                    <div class="input-group">
                        <input id="searchtextshop" style="border: 1px solid #2063EF" type="text" placeholder="ค้นหาชื่อคลินิก" class="form-control">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-sm btn-info" onclick="ajax_pagination()" style="background-color: #2063EF; border-color: #2063EF;"><i class="fa fa-search me-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px;" id="result-pagination">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNature" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">เลือกประเภทคลินิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <style>
                    .sidbar-style {
                        list-style-type: none;
                        text-align: left!important;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }

                    .form-check {
                        display: inline-block;
                        padding: 1px 30px 1px 30px;
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
                        font-weight: bold;
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

                    .btn-place {
                        background-color: #F654A0 !important;
                        border-color: #e9588f;
                        border-radius: 5px;
                        font-size: 12px;
                        color: #fff !important;
                    }
                </style>
                <div class="sidbar-style row">               
                    <?php
                    if ($natures->num_rows() > 0) {
                        foreach ($natures->result() as $nature) {
                            ?>
                            <div class="form-check col-xl-6">
                                <input class="form-check-input" value="<?php echo $nature->shop_nature_id; ?>" name="modal_pro_nature_id" id="modal_nature_<?php echo $nature->shop_nature_id; ?>" type="checkbox">
                                <label class="form-check-label" for="modal_nature_<?php echo $nature->shop_nature_id; ?>"> <img src="<?php echo base_url() . 'assets/icon/' . $nature->shop_nature_id . '.png'; ?>" width="20">&nbsp;&nbsp;&nbsp;<?php echo $nature->shop_nature_name; ?></label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <!--                <div>
                                    <input type="text" class="js-range-slider" id="my_range" name="my_range" value="" />
                                </div>                -->
            </div>
            <div class="modal-footer" style="background-color: dodgerblue; text-align: center!important; display: block">
                <input type="hidden" id="lat" value="13.757736346376388" />
                <input type="hidden" id="long" value="100.50432259216905" />
                <a href="javascript:void(0);" onclick="ajax_pagination();" class="text-center" style="font-weight: bold; font-size: 18px; color: white; width: 100%;">ตกลง</a>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3&key=<?php echo $this->config->item('google_api'); ?>"></script>
<script src="<?php echo base_url(); ?>assets/plugin/gmaps/gmaps.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ion.rangeSlider.min.js"></script>

<script>

                    $('#searchtextshop').keypress(function (e) {
                        if (e.which == 13) {
                            ajax_pagination();
                        }
                    });

                    $(function () {
                        run_map();
                        ajax_pagination();
                    });

                    var map;

                    function run_map() {
                        map = new GMaps({
                            div: '#map',
                            zoom: 12,
                            center: {lat: 13.757736346376388, lng: 100.50432259216905}
                        });
                        var $jsonmap = $.getJSON(service_base_url + 'search/getmap');
                        $jsonmap.done(loadMap);
                        geo();
                    }

                    function loadMap(data) {
                        var items, markers_data = [];
                        if (data.length > 0) {
                            items = data;
                            for (var i = 0; i < items.length; i++) {
                                var item = items[i];
                                if (item.latlong !== '') {
                                    var icon = service_base_url + 'assets/img/m-location-icon.png';
                                    latlong = item.latlong.split(",");
                                    markers_data.push({
                                        lat: latlong[0],
                                        lng: latlong[1],
                                        title: item.name,
                                        animation: google.maps.Animation.DROP,
                                        infoWindow: {
                                            content: '<div class="row" style="width: 380px"><div class="col-3 text-center">\n\
<a href="' + service_base_url + 'shop/' + item.shop_id + '" target="_blank"><img src="' + item.image + '" class="card-img-top" style="height: 90px;width: 90px;" alt="' + item.name + '"></a>\n\
</div><div class="col-9 text-left"><p style="font-size: 15px;font-family: kanit;padding-left: 5px;padding-top:10px;">ชื่อร้าน : ' + item.name + '<br>' + item.nature + '</p>\n\
<div style="text-align: center;"><a href="https://maps.google.com/?daddr=' + item.latlong + '" target="_blank"><button type="button" class="btn btn-sm btn-danger btn-place" target="_blank">การนำทาง</button></a>&nbsp;&nbsp;<a href="tel:' + item.tel + '"><button type="button" class="btn btn-sm btn-danger btn-place">โทร</button></a></div></div></div>'
                                        }, icon: {
                                            url: icon
                                        }
                                    });
                                }
                            }
                        }
                        map.addMarkers(markers_data);
                    }

                    function geo() {
                        GMaps.geolocate({
                            success: function (position) {
                                map.setCenter(position.coords.latitude, position.coords.longitude);
                                map.addMarker({
                                    position: {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    },
                                    title: 'ตำแหน่งของคุณ',
                                    infoWindow: {
                                        content: 'ตำแหน่งของคุณ'
                                    },
                                    draggable: true,
                                    animation: google.maps.Animation.DROP,
                                    dragend: function (event) {
                                        var lat = event.latLng.lat();
                                        var lng = event.latLng.lng();
                                        map.setCenter(lat, lng);
                                        $('#lat').val(lat);
                                        $('#long').val(lng);
                                    }
                                });
                            },
                            error: function (error) {
                                console.log(error);
                            },
                            not_supported: function () {
                                alert("Your browser does not support geolocation");
                            }
                        });
                    }

                    //-------------------------------


                    function ajax_pagination() {
                        $('#result-pagination').html('<h6 class="text-center mt-5"> <i class="fa fa-spinner fa-spin fa-3x fa-fw me-2"></i></h6>');
                        var nature_id = new Array();
                        $("input:checkbox[name=modal_pro_nature_id]:checked").each(function () {
                            nature_id.push($(this).val());
                        });
                        $('#modalNature').modal('hide');
                        $.ajax({
                            url: service_base_url + 'search/ajax_pagination',
                            type: 'POST',
                            data: {
                                id: nature_id,
                                lat1: $('#lat').val(),
                                lon1: $('#long').val(),
                                searchtext: $('#searchtextshop').val(),
                            },
                            success: function (response) {
                                ajax_bar();
                                $('#result-pagination').html(response);
                            }
                        });
                    }

                    function ajax_bar() {
                        var nature_id = new Array();
                        $("input:checkbox[name=modal_pro_nature_id]:checked").each(function () {
                            nature_id.push($(this).val());
                        });
                        $.ajax({
                            url: service_base_url + 'search/ajax_bar',
                            type: 'POST',
                            data: {
                                id: nature_id
                            },
                            success: function (response) {
                                $('#result-bar').text(response);
                            }
                        });
                    }

</script>

<style>
    a.custom_btn {
        display: inline-block;
        color: #fff;
        background: #1D60ED ;
        text-align: center;
        padding: 14px 25px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
    }
    .modal-lg {
        max-width: 40%;
    }

    @media only screen and (max-width: 600px) {
        .modal-lg {
            max-width: 100%;
        }
    }
</style>

