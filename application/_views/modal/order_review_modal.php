<?php
if ($data->num_rows() > 0) {
    $row_p_r = $data->row();
    $product_review_rating = $row_p_r->product_review_rating;
    $product_review_content = $row_p_r->product_review_content;
} else {
    $product_review_rating = "";
    $product_review_content = "";
}
?>
<form id="form-modal" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="order_product_list_id" value="<?php echo $order_product_list_id; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <div class="modal-header">
        <h4 class="modal-title"> รีวิวสินค้า</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <label > ให้คะเเนน :</label>
                <div class="col-md-5" style="padding-top: 5px; padding-left: 0px;">
                    <span class="my-rating-1"></span>
                    <input type="text" name="product_review_rating" id="product_review_rating" class="d-none" value="<?php echo $product_review_rating; ?>" required>
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <label>ความคิดเห็น</label>
                <textarea name="product_review_content" class="form-control" rows="5"><?php echo $product_review_content; ?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-form-modal" class="btn btn-primary"><i id="fa-form-modal" class="fas fa-check"></i> ตกลง</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle"></i> ยกเลิก</button>
    </div>
</form>
    <script>
        $('#form-modal').parsley();

        $('.my-rating-1').starRating({
            initialRating: parseInt($('#product_review_rating').val()),
            strokeColor: 'yellow',
            totalStars: 5,
            useFullStars: true,
            starSize: 25,
            disableAfterRate: false,
            callback: function(currentRating){
                $('#product_review_rating').val(parseInt(currentRating))
            }
        })

        $('#btn-form-modal').click(function () {
            if ($('#form-modal').parsley().validate() === true) {
                $('#fa-form-modal').removeClass('fa-check').addClass('fa-spinner fa-spin')
                $('#btn-form-modal').prop('disabled', true)
                var formData = new FormData($('#form-modal')[0])
                $.ajax({
                    url: service_base_url + 'orders/processreview',
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    // file
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response) {
                        setTimeout(function () {
                            reloadPagination()
                            $('.modal').modal('hide')
                            notification(response.status, response.title, response.message)
                        }, 200)
                    }
                })
            }
        })
    </script>