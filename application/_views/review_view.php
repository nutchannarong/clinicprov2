<div class="site__body">
    <div class="block block-slideshow">
        <div class="container-fluid p-0">
            <div class="block-slideshow__carousel">
                <div class="owl-carousel">
                    <?php
                    $slides = $this->global_model->getSlide(3,3);
                    if ($slides->num_rows() > 0) {
                        $s_r = 0;
                        foreach ($slides->result() as $slide_r) {
                            ?>
                            <a class="block-slideshow__item"
                               href="<?php echo($slide_r->slideshow_link != '' ? $slide_r->slideshow_link : 'javascript:void(0);'); ?>" <?php echo($slide_r->slideshow_open_link == 2 ? 'target="_blank"' : ''); ?>
                               title="<?php echo $slide_r->slideshow_name; ?>">
                                <span class="block-slideshow__item-image block-slideshow__item-image--desktop" style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image != '' ? $slide_r->slideshow_image : 'none.png'); ?>')"></span>
                                <span class="block-slideshow__item-image block-slideshow__item-image--mobile" style="background-image: url('<?php echo app_admin_url() . 'assets/upload/slideshow/' . ($slide_r->slideshow_image_half != '' ? $slide_r->slideshow_image_half : 'none-half.png'); ?>')"></span>
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
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 mt-2">
                    <div class="card pl-2 pr-2 pt-2">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="row p-0">
                                    <div class="col col-xl-1 pr-0" style="margin-top: 10px;">
                                        เรียงโดย :
                                    </div>
                                    <div class="col col-xl-4 mt-2">
                                        <select id="sort_rating" class="form-control form-control-sm" onchange="ajax_pagination()">
                                            <option value="">รีวิวทั้งหมด</option>
                                            <option value="ASC">รีวิว: จากน้อยไปมาก</option>
                                            <option value="DESC">รีวิว: มากไปน้อย</option>
                                        </select>
                                    </div>
                                    <div class="col col-4 mt-2">
                                        <div class="form-group">
                                            <select id="shop_province" class="form-control form-control-sm" onchange="ajax_pagination()">
                                                <option value=''>พื้นที่จังหวัด</option>
                                                <?php
                                                $get_shop_province = $this->review_model->getShopProvince();
                                                if ($get_shop_province->num_rows() > 0) {
                                                    foreach ($get_shop_province->result() as $row_shop_province) {
                                                        ?>
                                                        <option value="<?php echo $row_shop_province->shop_province; ?>"><?php echo $row_shop_province->shop_province; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="row">
                                    <div class="col pr-0 text-right" style="margin-top: 10px;">เเสดง :</div>
                                    <div class="col-3 mt-2">
                                        <select id="per_page" class="form-control form-control-sm" onchange="ajax_pagination();">
                                            <option value="6">6</option>
                                            <option value="12">12</option>
                                            <option value="18" selected="">18</option>
                                            <option value="24">24</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div id="result-pagination"></div>
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
            url: service_base_url + 'review/ajax_pagination',
            type: 'POST',
            data: {
                sort_rating : $('#sort_rating').val(),
                shop_province: $('#shop_province').val(),
                per_page : $('#per_page').val()
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }
</script>