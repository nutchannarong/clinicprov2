<link href='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css' rel='stylesheet' />
<link href='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.css' rel='stylesheet' />

<script src='https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/core@4.4.0/locales-all.js'></script>
<script src='https://unpkg.com/@fullcalendar/interaction@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js'></script>
<script src='https://unpkg.com/@fullcalendar/list@4.4.0/main.min.js'></script>
<style>
    .calendatevent {
        border-radius: 0px;
        border: none;
        cursor: move;
        font-size: 13px;
        margin: 1px -1px 0 -1px;
        padding: 2px 2px;
    }
</style>
<div class="site__body">
    <div class="block mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-12 col-xl-3 d-flex">
                            <?php $this->load->view('layout/navbar-account', array('navacc' => 'appoint')); ?>
                        </div>
                        <div class="col-12 col-xl-9 mb-5">
                            <div class="product__tabs product-tabs product-tabs--layout--full">
                                <ul class="product-tabs__list" style="padding-top: 20px;">
                                    <li class="product-tabs__item product-tabs__item--active"><a href="#list-appoint">รายการนัดหมาย</a></li>
                                    <li class="product-tabs__item "><a href="#tab-calendar">ตารางนัดหมายประจำวัน</a></li>
                                </ul>
                                <div class="product-tabs__content view_calendar" >
                                    <div class="product-tabs__pane product-tabs__pane--active" id="list-appoint">
                                        <div class="row mb-2">
                                            <div class="col-xl-6">
                                                <button class="btn btn-primary mb-2" onclick="modalAdd()"> <i class="fa fa-plus-circle"></i> เพิ่มการนัดหมาย</button>
                                            </div>
                                            <div class="col-xl-6 text-right">
                                                <div class="input-group">
                                                    <input type="text" id="searchtext" class="form-control " placeholder="กรอกคำค้นหา...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" onclick="ajax_pagination()"><i class="fa fa-search"></i> ค้นหา</button>
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <div id="result-pagination"></div>
                                    </div>
                                    <div class="product-tabs__pane" id="tab-calendar">
                                        <div id="result_page_calendar">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="calendar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        loadPageListAppoint();
    });

    function ajax_pagination() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.ajax({
            url: service_base_url + 'appoint/ajax_pagination',
            type: 'POST',
            data: {
                searchtext: $('#searchtext').val(),
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }

    function loadPageListAppoint() {
        $('#result-pagination').html('<div style="margin-left: 350px; padding:80px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
        $.ajax({
            url: service_base_url + 'appoint/ajax_pagination',
            type: 'POST',
            data: {
                searchtext: $('#searchtext').val(),
            },
            success: function (response) {
                $('#result-pagination').html(response);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var initialLocaleCode = 'th';
        var calendarEl = document.getElementById('calendar');

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var today = new Date($.now());

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            locale: initialLocaleCode,
            buttonIcons: false, // show the prev/next text
            navLinks: true, // can click day/week names to navigate views
            eventLimit: true,
            eventClick: function (info) {
                var eventObj = info.event;
                console.log(eventObj);
//                console.log(eventObj.id);
                modalView(eventObj.id);
            },
            events: service_base_url + 'appoint/calendarjson'
        });
        calendar.render();
    });

    function modalView(appoint_id_pri) {
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'appoint/viewmodal',
            type: 'POST',
            data: {
                appoint_id_pri: appoint_id_pri,
            },
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

    function modalAdd() {
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'appoint/modaladd',
            type: 'POST',
            data: {},
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

    function modalCancel(chatbot_id) {
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'appoint/modalcancel',
            type: 'POST',
            data: {
                chatbot_id: chatbot_id
            },
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

    function modalEdit(appoint_id_pri) {
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'appoint/modaledit',
            type: 'POST',
            data: {
                appoint_id_pri: appoint_id_pri,
            },
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

    function modalStatus(appoint_id_pri) {
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'appoint/modalStatus',
            type: 'POST',
            data: {
                appoint_id_pri: appoint_id_pri,
            },
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

</script>
<style>
    [dir=ltr] .product-tabs__item:first-child {
        margin-left: 0px;
    }
    .product-tabs--layout--full .product-tabs__pane--active {
        padding: 20px;
    }


    @media only screen and (max-width: 600px) {
        .view_calendar{
            overflow: scroll;
        }
    }
</style>