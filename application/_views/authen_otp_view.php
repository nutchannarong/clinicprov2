<div class="site__body">
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md"></div>
                <div class="col-md-5 mt-2 d-flex">
                    <div class="card flex-grow-1 mb-md-0 mr-0 mr-lg-3 ml-0 ml-lg-4">
                        <div class="card-body card-body--padding--2">
                            <h3 class="text-center">กรุณากรอกรหัสยืนยัน OTP</h3>
                            <p class=" card-title text-secondary text-center" style="font-size: 15px">รหัส OTP
                                จะถูกส่งไปที่หมายเลขโทรศัพท์ของคุณผ่าน SMS</p>
                            <form class="account-menu__form" id="form-otp" method="post" action="<?php echo base_url() . 'authen/dootp'; ?>" autocomplete="off">
                                <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                                <div class="text-center" id="flash_message_form_otp">

                                </div>
                                <div class="form-group">
                                    <input id="otp" name="otp" type="number" class="form-control" placeholder="กรอกรหัส OTP" autocomplete="new-username" required="">
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-block text-white btn-circle" style="background: #1A79FF"> เข้าสู่ระบบ</button>
                                </div>
                                <hr>
                                <div class="account-menu__form-link">
                                    <p class="text-center">
                                        <span id="count_down"></span>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md"></div>
            </div>
        </div>
    </div>
    <div class="block-space block-space--layout--before-footer"></div>
</div>
<script>
    $(function () {
        countDown()
        $('#form-otp').parsley();
        document.getElementById("otp").focus();
    });

    $('#flash_message_form_otp').delay(5000).fadeOut(1000);

    function countDown() {
        let timeleft = 10;
        let downloadTimer = setInterval(function () {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                $('#count_down').html('ไม่ได้รับรหัส ? <br> <a href="javascript:void(0)" onclick="sendOtp()" class="text-primary"> ส่งอีกครั้ง </a> หรือ <a href="<?php echo base_url() . 'authen'; ?>" class="text-primary">กรอกเบอร์โทรศัพท์ใหม่</a>')
            } else {
                $('#count_down').html('กรุณารอ ' + timeleft + ' วินาทีก่อนกดส่งอีกครั้ง')
            }
            timeleft -= 1;
        }, 1000);
    }

    function sendOtp() {
        $.ajax({
            url: service_base_url + 'authen/sendotp',
            type: 'POST',
            dataType: "JSON",
            data: {
                tel: '<?php echo $tel; ?>'
            },
            success: function (data) {
                if (data.status) {
                    countDown()
                } else {
                    location.href = service_base_url + 'authen';
                }
            }
        });
    }
</script>