<?php
if ($data->num_rows() > 0) {
    $i = $segment + 1;
    foreach ($data->result() as $row) {
        ?>
        <div class="posts-list__item">
            <div class="post-card post-card--layout--list">
                <div class="post-card__image">
                    <a href="<?php echo app_admin_url() . "assets/upload/article/" . $row->article_thumbnail; ?>" class="fancybox">
                        <?php if ($row->article_thumbnail != "") { ?>
                            <img class="img-fluid" src="<?php echo app_admin_url() . "assets/upload/article/" . $row->article_thumbnail; ?>" width="100%">
                        <?php } else { ?>
                            <img class="img-fluid" src="<?php echo app_admin_url() . "assets/upload/article/none.png" ?>" width="100%">
                        <?php } ?>
                    </a>
                </div>
                <div class="post-card__content">
                    <div class="post-card__title">
                        <h2>
                            <a href="<?php echo base_url() . "blog/detail/" . $row->article_slug; ?>">
                                <?php echo $row->article_title; ?>
                            </a>
                        </h2>
                    </div>
                    <div class="post-card__date">
                        <?php echo $this->libs->date2Thai($row->article_create, '%d %m %y') ?>
                    </div>
                    <div class="post-card__excerpt">
                        <div class="typography">
                            <?php echo $row->article_excerpt; ?>
                        </div>
                    </div>
                    <div class="post__tags tags tags--sm pt-5">
                        <?php
                        if ($row->article_keyword != '') {
                            ?>
                            <div class="tags__list">
                                <b>แท็ก : </b>
                                <?php
                                $keyword = explode(',', $row->article_keyword);
                                foreach ($keyword as $k_list) {
                                    ?>
                                    <a href="<?php echo base_url() . "blog/detail/" . $row->article_slug; ?>"><?php echo $k_list; ?></a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="post-card__more">
                        <a href="<?php echo base_url() . "blog/detail/" . $row->article_slug; ?>" class="btn btn-secondary btn-sm">อ่านเพิ่มเติม</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $i++;
    }
} else {
    ?>
    <div class="text-center mt-5">
        <h5 class="text-center"><i class="fa fa-exclamation-triangle me-2"></i> ไม่พบข้อมูล</h5>
    </div>
    <?php
}
?>
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
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        })
    })
</script>