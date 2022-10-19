<div class="modal-header">
    <h6 class="modal-title"><i class="fa fa-image me-2"></i>   รูป <?php echo $opdupload_type == 1 ? ' ( ก่อน ) ' : ' ( หลัง ) '; ?></h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
</div>
<div class="modal-body">
    <div class="row">
        <?php
        if ($images->num_rows() > 0) {
            foreach ($images->result() as $image) {
                ?>
                <div class="col-lg-4" id="array_<?php echo $image->opdupload_id; ?>" >
                    <div class="row">
                        <div class="col-lg-12" style="padding: 20px 20px 20px 20px;">
                            <a  id="image_a" href="<?php echo s3_url() . 'check/' . $image->opdupload_image; ?>" class="fancybox">
                                <img id="image_show" src="<?php echo s3_url() . 'check/' . $image->opdupload_image; ?>" class="img-thumbnail" width="100%" style="cursor:pointer; border: 1px solid whitesmoke">
                            </a> 
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-md-12 text-center" style="color: #999;">
                <br/>
                <i class="fa fa-info-circle me-2"></i> ไม่มีรูปภาพ
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle me-2"></i> ปิด</button>
</div>
<script>
    $(document).ready(function () {
        $('.fancybox').fancybox({
            padding: 0,
            helpers: {
                title: {
                    type: 'outside'
                }
            }
        });
    });
</script>