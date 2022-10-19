<div class="modal-header">
    <h6 class="modal-title">รีวิวหลังการใช้บริการ &nbsp;<span style="color: #de4463;"> (รีวิวการใช้บริการเพื่อรับคะแนน <?php echo $this->config->item('point_review');?> แต้ม)</span></h6>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></button>
</div>
<div class="modal-body">
    <form id="form-review" method="post" action="#" onsubmit="return false" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="servingreview_id" value="<?php echo $data->servingreview_id; ?>">
        <div class="row">
            <div class="col-md-3">
                <label>รูปภาพ</label>
                <img id="preview_image" src="<?php echo admin_url() . 'assets/upload/servingreview/none.png'; ?>" width="100%">
                <input type="file" id="review_image" name="review_image" accept="image/*" onchange="previewImage(event)" style="display: none">
                <label for="review_image" class="btn btn-info btn-sm btn-block m-t-10"><i class="fa fa-image me-2"></i> เลือกรูปภาพ</label>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label>ให้คะเเนนโดยรวม :</label>
                        <div class="mb-4">
                            <span class="review_rating"></span>
                            <input type="text" name="review_rating" id="review_rating" class="d-none" value="<?php echo $data->servingreview_rating; ?>" required>
                        </div>

                        <label>ให้คะเเนน (หมอ) :</label>
                        <div>
                            <span class="rating_doctor"></span>
                            <input type="text" name="review_rating_doctor" id="review_rating_doctor" class="d-none" value="<?php echo $data->servingreview_doctor; ?>" required>
                        </div>
                    </div> 
                    <div class="col-md-6 col-sm-12">
                        <label>ให้คะเเนน (พนักงาน) :</label>
                        <div class="mb-4">
                            <span class="rating_user"></span>
                            <input type="text" name="review_rating_user" id="review_rating_user" class="d-none" value="<?php echo $data->servingreview_user; ?>" required>
                        </div>
                        
                        <label>ให้คะเเนน (ความสะอาดภายในร้าน) :</label>
                        <div>
                            <span class="rating_shop"></span>
                            <input type="text" name="review_rating_shop" id="review_rating_shop" class="d-none" value="<?php echo $data->servingreview_shop; ?>" required>
                        </div>
                    </div>
                </div>    
                <hr>
                <label class="mt-2">ความคิดเห็น</label>
                <textarea name="review_comment" class="form-control" rows="5"><?php echo $data->servingreview_comment; ?></textarea>                                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2 text-right">

            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" id="btn-form-review" class="btn btn-primary"><i id="fa-form-review" class="fas fa-check me-2"></i> ตกลง</button>
    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times me-2"></i> ยกเลิก</button>
</div>
<script>
    $('#form-review').parsley();

    $('.review_rating').starRating({
        initialRating: parseInt($('#review_rating').val()),
        strokeColor: 'yellow',
        totalStars: 5,
        useFullStars: true,
        starSize: 25,
        disableAfterRate: false,
        callback: function (currentRating) {
            $('#review_rating').val(parseInt(currentRating))
        }
    })


    $('.rating_user').starRating({
        initialRating: parseInt($('#review_rating_user').val()),
        strokeColor: 'yellow',
        totalStars: 5,
        useFullStars: true,
        starSize: 25,
        disableAfterRate: false,
        callback: function (currentRating) {
            $('#review_rating_user').val(parseInt(currentRating))
        }
    })

    $('.rating_doctor').starRating({
        initialRating: parseInt($('#review_rating_doctor').val()),
        strokeColor: 'yellow',
        totalStars: 5,
        useFullStars: true,
        starSize: 25,
        disableAfterRate: false,
        callback: function (currentRating) {
            $('#review_rating_doctor').val(parseInt(currentRating))
        }
    })

    $('.rating_shop').starRating({
        initialRating: parseInt($('#review_rating_shop').val()),
        strokeColor: 'yellow',
        totalStars: 5,
        useFullStars: true,
        starSize: 25,
        disableAfterRate: false,
        callback: function (currentRating) {
            $('#review_rating_shop').val(parseInt(currentRating))
        }
    })

    var previewImage = function (event) {
        var output = document.getElementById('preview_image')
        output.src = URL.createObjectURL(event.target.files[0])
        output.onload = function () {
            URL.revokeObjectURL(output.src)
        }
    }

    $('#btn-form-review').click(function () {
        if ($('#form-review').parsley().validate() === true) {
            $('#fa-form-review').removeClass('fa-check').addClass('fa-spinner fa-spin')
            $('#btn-form-review').prop('disabled', true)
            var formData = new FormData($('#form-review')[0])
            $.ajax({
                url: service_base_url + 'servingreview/processreview',
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
                        $('.modal').modal('hide')
                        $('#fa-form-review').removeClass('fa-spinner fa-spin').addClass('fa-check')
                        $('#btn-form-review').prop('disabled', false)
                        notification(response.status, response.title, response.message)
                        ajaxPagination()
                    }, 200)
                }
            })
        }
    })
</script>