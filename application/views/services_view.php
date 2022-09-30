<div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php $this->load->view('layout/navbar-account', array('navacc' => 'services')); ?>
                        </div>
                        <div class="col-12 col-xl-9 mb-5">
                            <div class="card">
                                <div class="card-header pb-2">
                                    <div class="row">
                                        <div class="col-xl">
                                            <h5 class="mt-2"><?php echo $title; ?></h5>
                                        </div>
                                        <div class="col-xl-4 text-right ">
                                            <div class="input-group">
                                                <input type="text" id="searchtext" class="form-control font-page "
                                                       placeholder="กรอกคำค้นหา...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="ajax_pagination()"><i
                                                                class="fa fa-search"></i> ค้นหา
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-divider"></div>
                                <div class="card-body card-body--padding--2">
                                    <div id="result-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="result-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" id='modal-content'></div>
    </div>
</div>

<div id="result-modal-lg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id='modal-content-lg'></div>
    </div>
</div>
<script>
    $(function () {
        ajax_pagination();
    })
    function ajax_pagination() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.ajax({
            url: service_base_url + 'services/ajax_pagination',
            type: 'POST',
            data: {
                searchtext: $('#searchtext').val(),

            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }
    function viewModal(course_id_pri,serving_status_id) {
        $('.modal-content').html('');
        $.ajax({
            url: service_base_url + 'services/viewmodal',
            type: 'POST',
            data: {
                course_id_pri: course_id_pri,
                serving_status_id : serving_status_id
            },
            success: function (response) {
                $('#result-modal-lg .modal-content').html(response);
                $('#result-modal-lg').modal('show', {backdrop: 'true'});
            }
        });
    }
</script>
<style>
    [dir=ltr] .product-tabs__item:first-child {
        margin-left: 0px;
    }
    .font-page {
        font-size: 13px !important;
    }
</style>
