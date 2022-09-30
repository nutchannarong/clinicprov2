<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet'/>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>

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
<input type="hidden" id="user_id" value="<?php echo $row_doctor->user_id; ?>">
<div class="site__body mb-5">
    <div class="block-split mt-5">
        <div class="container">
            <div class="card p-2">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <div class="row">
                            <div class="col-4 text-center mt-2">
                                <img src="<?php echo admin_url() . "assets/upload/user/" . $row_doctor->user_image; ?>"
                                     alt="<?php echo $row_doctor->user_fullname; ?>" class="img-circle" width="70%">
                                <br>
                            </div>
                            <div class="col-8 mt-2">
                                <h3 class="text-primary"><?php echo $row_doctor->user_fullname; ?></h3>
                                <p class="text-primary" style="font-size: 16px">
                                    <?php
                                    echo $row_doctor->specialized_name;
                                    $get_specialized_sub = $this->shopdetail_model->getSpecializedSub($row_doctor->user_id);
                                    if ($get_specialized_sub->num_rows() > 0) {
                                        foreach ($get_specialized_sub->result() as $row_specialized_sub) {
                                            ?>
                                        <li class="text-primary ml-3"><?php echo $row_specialized_sub->specialized_sub_name; ?></li>
                                        <?php
                                    }
                                }
                                ?>
                                </p>
                                <p class="text-secondary mt-3"> <?php echo $row_doctor->user_address; ?></p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12 ml-lg-5">
                            <h5 class="text-primary"><i class="fas fa-graduation-cap"></i> การศึกษา</h5>
                            <?php
                            $get_doctor_study = $this->shopdetail_model->getDoctorStudy($row_doctor->user_id);
                            if ($get_doctor_study->num_rows() > 0) {
                                foreach ($get_doctor_study->result() as $row_doctor_study) {
                                    ?>
                                    <li style="font-size: 14px;"
                                        class="ml-5"> <?php echo $row_doctor_study->user_study_th_name; ?></li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                <li style="font-size: 14px;"
                                    class="ml-5">ไม่พบข้อมูล</td>
                                </li>
                                <?php
                            }
                            ?>
                            <h5 class="text-primary"><i class="fa fa-certificate" aria-hidden="true"></i> วุฒิบัตร</h5>
                            <p>
                                <?php
                                $get_doctor_diploma = $this->shopdetail_model->getDoctorDiploma($row_doctor->user_id);
                                if ($get_doctor_diploma->num_rows() > 0) {
                                    foreach ($get_doctor_diploma->result() as $row_doctor_diploma) {
                                        ?>
                                    <li style="font-size: 14px;"
                                        class="ml-5"> <?php echo $row_doctor_diploma->user_diploma_th_name; ?></li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                <li style="font-size: 14px;"
                                    class="ml-5">ไม่พบข้อมูล</td>
                                </li>
                                <?php
                            }
                            ?>
                            </p>
                            <h5 class="text-primary"><i class="fa fa-globe" aria-hidden="true"></i> ภาษา</h5>
                            <p>
                                <?php
                                $get_doctor_language = $this->shopdetail_model->getDoctorLanguage($row_doctor->user_id);
                                if ($get_doctor_language->num_rows() > 0) {
                                    foreach ($get_doctor_language->result() as $row_doctor_language) {
                                        ?>
                                    <li style="font-size: 14px;"
                                        class="ml-5"> <?php echo $row_doctor_language->user_language_name; ?></li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                <li style="font-size: 14px;"
                                    class="ml-5">ไม่พบข้อมูล</td>
                                </li>
                                <?php
                            }
                            ?>
                            </p>
                            <h5 class="text-primary"><i class="fa fa-clock"></i> เวลาทำงาน</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="40%" class="text-white">วัน</th>
                                            <th width="60%" class="text-white">เวลา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $get_section_day = $this->shopdetail_model->getSectionDayByUserID($row_doctor->user_id);
                                        if ($get_section_day->num_rows() > 0) {
                                            // set time
                                            $get_open_time = $this->shopdetail_model->getSectionTimeByUserID($row_doctor->user_id, 'asc');
                                            $get_close_time = $this->shopdetail_model->getSectionTimeByUserID($row_doctor->user_id, 'desc');
                                            if ($get_open_time->num_rows() == 1 && $get_close_time->num_rows() == 1) {
                                                $open_time = date('H:i:s', strtotime($get_open_time->row()->section_time));
                                                $close_time = date('H:i:s', strtotime($get_close_time->row()->section_time) + 60 * 60);
                                                $time = $get_open_time->row()->section_time . " - " . $get_close_time->row()->section_time . ' น.';
                                            } else {
                                                //echo $open_time = '00:00:00';
                                                //echo $close_time = '24:00:00';
                                                $time = "-";
                                            }
                                            foreach ($get_section_day->result() as $row_section_day) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $row_section_day->sectionday_name_th; ?></td>
                                                    <td><?php echo $time; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="5" class="text-center">ไม่พบข้อมูล</td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <?php
                        if ($this->session->userdata('islogin') == 1) {
                            $check_appoint = $this->shopdetail_model->getAppointShop($row_doctor->shop_id_pri);
                            if ($check_appoint->num_rows() == 1) {
                                if ($row_doctor->user_appoint_id == 1) {
                                    ?>
                                    <div class="ml-2" id="calendar"></div>
                                    <?php
                                }
                            }
                        }
                        ?>
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

    })

    document.addEventListener('DOMContentLoaded', function () {
        var initialLocaleCode = 'th';
        var calendarEl = document.getElementById('calendar');
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var today = new Date($.now());

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridThreeDay',
            allDaySlot: false,
            nowIndicator: false,
            displayEventEnd: false,
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },
            views: {
                timeGridThreeDay: {
                    type: 'timeGrid',
                    duration: {days: 3},
                    buttonText: '3 day'
                },
            },
            slotMinTime: '<?php echo $open_time; ?>',
            slotMaxTime: '<?php echo $close_time; ?>',
            locale: initialLocaleCode,
            buttonIcons: true, // show the prev/next text
            navLinks: false, // can click day/week names to navigate views
            eventLimit: true,
            eventColor: '#28a745',
            events: service_base_url + 'shopdetail/appointdoctor/' + $('#user_id').val(),
            eventClick: function (info) {
                var eventObj = info.event;
                //console.log((new Date(eventObj.start)).toISOString().slice(0, 10));
                //console.log(eventObj.id, eventObj.start);
                modalAdd(eventObj.id, (new Date(eventObj.start)).toISOString().slice(0, 10), eventObj.start);
            },
        });
        calendar.setOption('height', '650px');
        calendar.render();
    });

    function modalAdd(user_id, date, start) {
        console.log(start);
        //var formDate = $.fullCalendar.formatDate(start, 'MM-dd-yyyy');
        //console.log(formDate);
        $('#modal-content').html('');
        $.ajax({
            url: service_base_url + 'shopdetail/modaladd',
            type: 'POST',
            data: {
                user_id: user_id,
                date: date,
                start: start
            },
            success: function (response) {
                $('#result-modal #modal-content').html(response);
                $('#result-modal').modal('show', {backdrop: 'true'});
            }
        });
    }

</script>
<style>
    .lightSlider ul {
        list-style: none outside none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .lightSlider li {
        display: block;
        float: left;
        margin-right: 6px;
        cursor: pointer;
    }

    .lightSlider img {
        display: block;
        max-height: 460px;
        width: 100%;
    }

    .btn-outline-primary {
        border: 1px solid #0069FD;
        color: #0069FD;
    }

    .pro-view {
        position: absolute;
        top: 3%;
        right: 3%;
        color: black;
    }
</style>