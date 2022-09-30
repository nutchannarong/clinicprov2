<div class="reviews-view">
    <div class="reviews-view__list">
        <div class="reviews-list">
            <ol class="reviews-list__content">
                <?php
                if ($data->num_rows() > 0) {
                    $i = $segment + 1;
                    foreach ($data->result() as $row) {
                        ?>
                        <li class="reviews-list__item">
                            <div class="review">
                                <div class="review__body">
                                    <div class="review__avatar"><img src="<?php echo admin_url() . 'assets/upload/online/' .$row->online_image; ?>" alt=""></div>
                                    <div class="review__meta">
                                        <div class="review__author"><?php echo $row->online_fname.' '.$row->online_lname; ?></div>
                                        <div class="rating mt-1">
                                            <div class="rating__body">
                                                <div class="rating__star <?php echo $row->productreview_rating >= 1 ? 'rating__star--active' : ''; ?>"></div>
                                                <div class="rating__star <?php echo $row->productreview_rating >= 2 ? 'rating__star--active' : ''; ?>"></div>
                                                <div class="rating__star <?php echo $row->productreview_rating >= 3 ? 'rating__star--active' : ''; ?>"></div>
                                                <div class="rating__star <?php echo $row->productreview_rating >= 4 ? 'rating__star--active' : ''; ?>"></div>
                                                <div class="rating__star <?php echo $row->productreview_rating >= 5 ? 'rating__star--active' : ''; ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review__rating text-right">
                                        <div class="review__date"><i class="text-success fa fa-check-circle"> </i> <span class="text-dark">รีวิวที่ได้รับการตรวจสอบเเล้ว</span></div>
                                         <div class="review__date text-dark"><span class="">เยี่ยมชม </span> <?php echo $this->misc->date2thai($row->productreview_comment_date, '%d %m %y', 1)?></div>
                                    </div>
                                    <div class="review__content typography">
                                        <?php echo $row->productreview_comment; ?>
                                        <?php if($row->productreview_image != '' || $row->productreview_image != null){ ?>
                                            <br>
                                            <a href="<?php echo admin_url().'assets/upload/productreview/'.$row->productreview_image; ?>" class="productreview_image">
                                                <img src="<?php echo admin_url().'assets/upload/productreview/'.$row->productreview_image; ?>" alt="" width="100">
                                            </a>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if(($row->productreview_reply != '' || $row->productreview_reply != null) && $row->user_id != null){?>
                                <div class="review__body ml-2 mt-3">
                                    <div class=""><i class="fa fa-reply-all fa-flip-horizontal fa-flip-vertical text-secondary"></i> <img src="<?php echo admin_url() . 'assets/upload/user/' .$row->user_image; ?>" width="35"></div>
                                    <div class="review__meta ml-2">
                                        <div class="review__author"><?php echo $row->user_fullname; ?></div>
                                        <div class="review__date text-dark"> <?php echo $this->misc->date2thai($row->productreview_reply_date, '%d %m %y', 1)?></div>
                                    </div>
                                    <div class="ml-4 review__content typography">
                                        <?php echo $row->productreview_reply; ?>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                        </li>
                        <?php
                        $i++;
                    }
                } else {
                    ?>
                    <div class="text-center mt-5">
                        <h5 class="text-center" ><i class="fa fa-exclamation-triangle"></i> ไม่พบข้อมูล</h5>
                    </div>
                    <?php
                }
                ?>
            </ol>
        </div>
    </div>
</div>
<div class="row mt-5">
    <?php
    if ($count != 0) {
        ?>
        <div class="col-sm-4">
            แสดง <?php echo $segment + 1; ?> ถึง <?php echo $i - 1; ?> ทั้งหมด <?php echo($count); ?> รายการ
        </div>
        <div class="col-sm-8" style="float: right">
            <?php echo $links; ?>
        </div>
        <?php
    }
    ?>
</div>
<script>
    $(function () {
        $('.productreview_image').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        })
    })
</script>
<style>
    .pro-view-shop{
        position: absolute;
        top: 3%;
        right: 15%;
        color: black;
    }
</style>