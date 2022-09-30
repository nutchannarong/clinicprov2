<div class="site__body mb-5">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3,2);
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
    <div class="block mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 order-2 order-md-1">
                <div class="row">
                    <div class="col-xl-12 mt-2">
                        <div class="card p-2">
                            <div class="row">
                                    <div class="col-xl-8">
                                        <div class="row p-0">
                                            <div class="col text-right pr-0" style="margin-top: 10px;">
                                                เรียงโดย :
                                            </div>
                                            <div class="col-6 col-xl-2 mt-2">
                                                <button class="btn btn-sm btn-product-percent product-percent" onclick="sortProductPerCent()">ส่วนลด</button>
                                                <input type="hidden" id="sort_product_percent">
                                            </div>
                                            <div class="col-6 col-xl-4 mt-2">
                                                <select id="sort_rating" class="form-control form-control-sm" onchange="sortProductRating()">
                                                    <option value="">รีวิวทั้งหมด</option>
                                                    <option value="ASC">รีวิว: จากน้อยไปมาก</option>
                                                    <option value="DESC">รีวิว: มากไปน้อย</option>
                                                </select>
                                            </div>
                                            <div class="col-6 col-xl-4 mt-2">
                                                <select id="sort_price" class="form-control form-control-sm" onchange="sortProductPrice()">
                                                    <option value="">ราคาทั้งหมด</option>
                                                    <option value="ASC">ราคา: จากน้อยไปมาก</option>
                                                    <option value="DESC">ราคา: มากไปน้อย</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col pr-0 text-right" style="margin-top: 10px;">เเสดง :</div>
                                            <div class="col-3 mt-2">
                                                <select id="per_page" class="form-control form-control-sm" onchange="ajax_pagination();">
                                                    <option value="4">4</option>
                                                    <option value="8">8</option>
                                                    <option value="16" selected="">16</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-2 mb-5">
                        <div id="result-pagination"></div>
                    </div>
                </div>
                </div>
                <div class="col-xl-3 order-1 order-md-2">
                    <?php $this->load->view('layout/navbar-search-product'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        ajax_pagination();
    })

    function ajax_pagination() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.ajax({
            url: service_base_url + 'products/ajax_pagination',
            type: 'POST',
            data: {
                searchtext: getParams('search'),
                sort_product_percent: $('#sort_product_percent').val(),
                sort_rating : $('#sort_rating').val(),
                sort_price : $('#sort_price').val(),
                per_page : $('#per_page').val(),
                location : getParams('location'),
                shop_province: getParams('shop_province'),
                shop_amphoe:getParams('shop_amphoe'),
                shop_district : getParams('shop_district'),
                nature_name : getParams('nature_name'),
                category_name :getParams('category_name'),
                min_discount :getParams('min_discount'),
                max_discount :getParams('max_discount'),
                min_price : getParams('min_price'),
                max_price : getParams('max_price'),
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }
// SORT DATA PRODUCT
    function sortProductPerCent() {
        if($('#sort_product_percent').val() == ''){
            $('#sort_product_percent').val('DESC');
            $('.btn-product-percent').removeClass('product-percent');
            $('.btn-product-percent').addClass('product-percent-active');
        }else{
            $('#sort_product_percent').val('');
            $('.btn-product-percent').removeClass('product-percent-active');
            $('.btn-product-percent').addClass('product-percent');
        }

        $('#sort_rating').val('');
        $('#sort_price').val('');
        ajax_pagination()
    }

    function sortProductRating(){
        // remove sort_product_percent
        $('#sort_product_percent').val('');
        $('.btn-product-percent').removeClass('product-percent-active');
        $('.btn-product-percent').addClass('product-percent');
        // remove sort_price
        $('#sort_price').val('');
        ajax_pagination()
    }

    function sortProductPrice() {
        // remove sort_product_percent
        $('#sort_product_percent').val('');
        $('.btn-product-percent').removeClass('product-percent-active');
        $('.btn-product-percent').addClass('product-percent');
        // remove sort_rating
        $('#sort_rating').val('');
        ajax_pagination()
    }

</script>

<style>
    .product-percent{
       border: 1px solid #fc4f1f;
        color: #fc4f1f;
    }
    .product-percent-active{
        background: #fc4f1f ;
        color: #FFFFFF;
    }
</style>