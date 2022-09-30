<form id="form-modal" method="post" action="#" onsubmit="return false" autocomplete="off">
    <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="form-label">ชื่อผู้ใช้งาน</label>
            <input type="text" name="tel" class="form-control form-control-sm" value="<?php echo $data->online_tel; ?>" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">รหัสผ่านเดิม</label>
            <input type="password" id="password_old" name="password_old" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
            <label class="form-label">รหัสผ่านใหม่</label>
            <input type="password" id="password" name="password" class="form-control form-control-sm" required>
        </div>
        <div class="form-group">
            <label class="form-label">ยืนยันรหัสผ่านใหม่</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control form-control-sm" onchange="checkPassword()" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-form-modal" class="btn btn-primary"><i id="fa-form-modal" class="fa fa-check"></i> ตกลง</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> ยกเลิก</button>
    </div>
</form>
<script>

    $('#form-modal').parsley()

    function checkPassword() {
        let password = $('#password').val()
        let password_confirm = $('#password_confirm').val()
        if (password.length >= 6 && password_confirm.length >= 6) {
            if (password == password_confirm) {
                $('#btn-form-modal').prop('disabled', false)
                notification('success', 'ทำรายการเรียบร้อยแล้ว', 'กดตกลงเพื่อเปลี่ยนรหัสผ่าน')
            } else {
                $('#btn-form-modal').prop('disabled', true)
                notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
            }
        } else {
            $('#btn-form-modal').prop('disabled', true)
            notification('error', 'ทำรายการไม่สำเร็จ', 'ระบุรหัสผ่านไม่ถูกต้อง')
        }
    }

    $('#btn-form-modal').click(function () {
        if ($('#form-modal').parsley().validate() === true) {
            $('#fa-form-modal').removeClass('fa-check').addClass('fa-spinner fa-spin')
            $('#btn-form-modal').prop('disabled', true)
            $.ajax({
                url: service_base_url + 'profile/editpassword',
                type: 'POST',
                data: $('#form-modal').serialize(),
                dataType: 'JSON',
                success: function (response) {
                    setTimeout(function () {
                        $('.modal').modal('hide')
                        notification(response.status, response.title, response.message)
                    }, 200)
                }
            })
        }
    })

</script>