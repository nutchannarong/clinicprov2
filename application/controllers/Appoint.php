<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appoint extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('appoint_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        $data = array(
            'title' => ' ปฏิทินนัดหมาย ',
            'description' => ' ปฏิทินนัดหมาย ',
            'keyword' => ' ปฏิทินนัดหมาย ',
            'meta' => array(),
            'css_full' => array('plugin/datepicker/datepicker.css', 'plugin/selectator-master/fm.selectator.jquery.css', 'plugin/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'),
            'js_full' => array('plugin/datepicker/bootstrap-datepicker.js', 'plugin/datepicker/bootstrap-datepicker-thai.js', 'plugin/datepicker/bootstrap-datepicker.th.js', 'plugin/moment/moment.js', 'plugin/selectator-master/fm.selectator.jquery.js', 'plugin/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js'),
        );
        $this->renderView('appoint_view', $data);
    }

    public function calendarjson() {
        $defaultEvents = array();
        $datas = $appoints = $this->appoint_model->getAppointByTel();
        if ($datas->num_rows() > 0) {
            foreach ($datas->result() as $data) {
                $description = 'คลินิก : ' . $data->shop_name . ' หัวข้อนัดหมาย : ' . $data->appoint_topic;
                $backgroundColor = '#d60000';
                $borderColor = '#d60000';
                if ($data->appoint_status_id == 1) {
                    $backgroundColor = '#f6c026';
                    $borderColor = '#f6c026';
                } else if ($data->appoint_status_id == 2) {
                    $backgroundColor = '#05d79c';
                    $borderColor = '#05d79c';
                }
                $defaultEvents[] = array(
                    'title' => $data->appoint_topic . ' ' . $description,
                    'start' => $data->appoint_date . ' ' . $data->appoint_start,
                    'end' => $data->appoint_date . ' ' . $data->appoint_end,
                    'id' => $data->appoint_id_pri,
                    //'description' => $description,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                    'classNames' => 'calendatevent',
                );
            }
        }
        print_r(json_encode($defaultEvents));
    }

    public function viewModal() {
        $data = array(
            'data' => $this->appoint_model->getAppoint($this->input->post('appoint_id_pri'))->row(),
        );
        $this->load->view('modal/appoint_view_modal', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->appoint_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('appoint/ajax_pagination');
        $config['total_rows'] = $count;
        $config['per_page'] = $this->per_page;
        $config['additional_param'] = $this->ajax_pagination->filterParams($filter);
        $config['num_links'] = 4;
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);
        $segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($segment > 0 && $count <= $segment) {
            $segment = $segment - $this->per_page;
        }
        $data = array(
            'data' => $this->appoint_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/appoint_pagination', $data);
    }

    public function loadPageListAppoint() {
        $data = array(
            'data' => $this->appoint_model->getChartBot()
        );
        $this->load->view('ajax/appoint_page', $data);
    }

    public function modalAdd() {
        $this->load->view('modal/appoint_add_modal');
    }

    public function add() {
        $dataonline = $this->appoint_model->getOnline()->row();
        $customer = $this->appoint_model->getCustomer($this->session->userdata('online_tel'), $this->input->post('shop_id_pri'));
        if ($customer->num_rows() == 1) {
            $customer_id_pri = $customer->row()->customer_id_pri;
            $appoint_tel = $dataonline->online_tel;
            $appoint_date = $this->input->post('date');
            $user_id = $this->input->post('doctor_id');
            $appoint_start = $this->input->post('appoint_start') . ':00';
            $shop_id_pri = $this->input->post('shop_id_pri');
            //เช็ควันของหมอ 
            $day = date('N', strtotime($appoint_date));
            if ($this->appoint_model->checkSectionday($day, $user_id)->num_rows() == 1) {
                //เช็คเวลาของหมอ  
                if ($this->appoint_model->checkSection($this->input->post('appoint_start'), $user_id)->num_rows() == 1) {
                    //เช็คเวลา หมอว่างไหม
                    if ($this->appoint_model->checkAppointDoctor($shop_id_pri, $user_id, $appoint_date, $appoint_start)->num_rows() == 0) {
                        //เช็คสถานะ ของผู้ป่วย 1 คน สถานะรอได้ 4 ครั้ง ต่อวัน 
                        if ($this->appoint_model->checkAppointCustomer($shop_id_pri, $appoint_date, $customer_id_pri)->num_rows() < 4) {
                            //เช็คเวลาไม่ซ้ำ
                            if ($this->appoint_model->checkAppointCustomerTime($shop_id_pri, $appoint_date, $appoint_start, $customer_id_pri)->num_rows() == 0) {
                                //เพิ่ม
                                $dataappoint = array(
                                    'shop_id_pri' => $this->input->post('shop_id_pri'),
                                    'online_id' => $dataonline->online_id,
                                    'appoint_online_type' => 'ClinicPro',
                                    'user_id' => $user_id,
                                    'customer_id_pri' => $customer_id_pri,
                                    'appoint_tel' => $appoint_tel,
                                    'appoint_topic' => $this->input->post('appoint_topic'),
                                    'appoint_date' => $appoint_date,
                                    'appoint_start' => $this->input->post('appoint_start'),
                                    'appoint_end' => date("H:i:s", strtotime($this->input->post('appoint_start') . ":00") + (60 * 30)),
                                    'appoint_note' => $this->input->post('appoint_note'),
                                    'appoint_status_id' => 1,
                                    'appoint_status_sms' => 1,
                                    'appoint_create' => $this->misc->getdate(),
                                    'appoint_update' => $this->misc->getdate()
//                            'chatbot_name' => $dataonline->online_prefix . ' ' . $dataonline->online_fname . ' ' . $dataonline->online_lname,
//                            'chatbot_type' => 3,
//                            'chatbot_phone' => $dataonline->online_tel,
//                            'chatbot_day' => $this->input->post('chatbot_day'),
//                            'chatbot_time' => $this->misc->setDate($this->input->post('chatbot_time'), '%h:%i', 1),
//                            'chatbot_topic' => $this->input->post('chatbot_topic'),
//                            'chatbot_status_id' => 1,
//                            'chatbot_active_id' => 1,
//                            'chatbot_create' => $this->misc->getDate(),
//                            'chatbot_update' => $this->misc->getDate(),
                                );
                                $this->appoint_model->addAppoint($dataappoint);
                                $json = array(
                                    'status' => 'success',
                                    'title' => 'สำเร็จ!',
                                    'message' => 'ทำรายการเรียบร้อยเเล้ว'
                                );
                            } else {
                                $json = array(
                                    'status' => 'error',
                                    'title' => 'ท่านได้เลือกวันและเวลานัดนี้ไปแล้ว',
                                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                                );
                            }
                        } else {
                            $json = array(
                                'status' => 'error',
                                'title' => 'ท่านนัดหมายเกิน 4 เวลาใน 1 วัน',
                                'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                            );
                        }
                    } else {
                        $json = array(
                            'status' => 'error',
                            'title' => 'แพทย์ไม่ว่างให้บริการ',
                            'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                        );
                    }
                } else {
                    $json = array(
                        'status' => 'error',
                        'title' => 'ไม่สามารถนัดเวลาที่เลือกได้',
                        'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                    );
                }
            } else {
                $json = array(
                    'status' => 'error',
                    'title' => 'ไม่สามารถนัดวันที่เลือกได้',
                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                );
            }
        } else {
            $json = array(
                'status' => 'error',
                'title' => 'ผิดพลาด',
                'message' => 'ผิดพลาดไม่สามารถทำรายการได้'
            );
        }
        echo json_encode($json);
    }

    public function modalEdit() {
        $data = array(
            'data' => $this->appoint_model->getAppoint($this->input->post('appoint_id_pri'))->row(),
        );
        $this->load->view('modal/appoint_edit_modal', $data);
    }

    public function edit() {
        $dataonline = $this->appoint_model->getOnline()->row();
        $customer = $this->appoint_model->getCustomer($this->session->userdata('online_tel'), $this->input->post('shop_id_pri'));
        if ($customer->num_rows() == 1) {
            $customer_id_pri = $customer->row()->customer_id_pri;
            $appoint_tel = $dataonline->online_tel;
            $appoint_date = $this->input->post('date');
            $user_id = $this->input->post('doctor_id');
            $appoint_start = $this->input->post('appoint_start') . ':00';
            $shop_id_pri = $this->input->post('shop_id_pri');
            //เช็ควันของหมอ 
            $day = date('N', strtotime($appoint_date));
            if ($this->appoint_model->checkSectionday($day, $user_id)->num_rows() == 1) {
                //เช็คเวลาของหมอ  
                if ($this->appoint_model->checkSection($this->input->post('appoint_start'), $user_id)->num_rows() == 1) {
                    //เช็คเวลา หมอว่างไหม
                    if ($this->appoint_model->checkAppointDoctor($shop_id_pri, $user_id, $appoint_date, $appoint_start)->num_rows() == 0) {
                        //เช็คสถานะ ของผู้ป่วย 1 คน สถานะรอได้ 4 ครั้ง ต่อวัน 
                        if ($this->appoint_model->checkAppointCustomer($shop_id_pri, $appoint_date, $customer_id_pri)->num_rows() < 4) {
                            //เช็คเวลาไม่ซ้ำ
                            if ($this->appoint_model->checkAppointCustomerTime($shop_id_pri, $appoint_date, $appoint_start, $customer_id_pri)->num_rows() == 0) {
                                //เพิ่ม
                                $dataappoint = array(
                                    'user_id' => $user_id,
                                    'appoint_topic' => $this->input->post('appoint_topic'),
                                    'appoint_date' => $appoint_date,
                                    'appoint_start' => $this->input->post('appoint_start'),
                                    'appoint_end' => date("H:i:s", strtotime($this->input->post('appoint_start') . ":00") + (60 * 30)),
                                    'appoint_note' => $this->input->post('appoint_note'),
                                    'appoint_status_id' => 1,
                                    'appoint_status_sms' => 1,
                                    'appoint_update' => $this->misc->getdate()
                                );
                                $this->appoint_model->updateAppoint($this->input->post('appoint_id_pri'), $dataappoint);
                                $json = array(
                                    'status' => 'success',
                                    'title' => 'สำเร็จ!',
                                    'message' => 'ทำรายการเรียบร้อยเเล้ว'
                                );
                            } else {
                                $json = array(
                                    'status' => 'error',
                                    'title' => 'ท่านได้เลือกวันและเวลานัดนี้ไปแล้ว',
                                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                                );
                            }
                        } else {
                            $json = array(
                                'status' => 'error',
                                'title' => 'ท่านนัดหมายเกิน 4 เวลาใน 1 วัน',
                                'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                            );
                        }
                    } else {
                        $json = array(
                            'status' => 'error',
                            'title' => 'แพทย์ไม่ว่างให้บริการ',
                            'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                        );
                    }
                } else {
                    $json = array(
                        'status' => 'error',
                        'title' => 'ไม่สามารถนัดเวลาที่เลือกได้',
                        'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                    );
                }
            } else {
                $json = array(
                    'status' => 'error',
                    'title' => 'ไม่สามารถนัดวันที่เลือกได้',
                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
                );
            }
        } else {
            $json = array(
                'status' => 'error',
                'title' => 'ผิดพลาด',
                'message' => 'ผิดพลาดไม่สามารถทำรายการได้'
            );
        }
        echo json_encode($json);
    }

    public function modalStatus() {
        $data = array(
            'data' => $this->appoint_model->getAppoint($this->input->post('appoint_id_pri'))->row(),
        );
        $this->load->view('modal/appoint_status_modal', $data);
    }

    public function status() {
        $appoint = $this->appoint_model->getAppoint($this->input->post('appoint_id_pri'));
        if ($appoint->num_rows() > 0) {
            $appoint = $appoint->row();
            $data = array(
                'appoint_status_id' => 0,
                'appoint_comment' => $this->input->post('appoint_comment'),
                'appoint_update' => $this->misc->getdate()
            );
            $this->appoint_model->updateAppoint($appoint->appoint_id_pri, $data);
            $json = array(
                'status' => 'success',
                'title' => 'สำเร็จ!',
                'message' => 'ทำรายการเรียบร้อยเเล้ว'
            );
        } else {
            $json = array(
                'status' => 'error',
                'title' => 'ผิดพลาด',
                'message' => 'ผิดพลาดไม่สามารถทำรายการได้'
            );
        }
        echo json_encode($json);
    }

    public function modalCancel() {
        $data = array(
            'chatbot_id' => $this->input->post('chatbot_id')
        );
        $this->load->view('modal/appoint_cancel_modal', $data);
    }

    public function cancel() {
        $dataappoint = array(
            'chatbot_status_id' => 0,
            'chatbot_create' => $this->misc->getDate(),
            'chatbot_update' => $this->misc->getDate()
        );
        $this->appoint_model->updateChatBot($this->input->post('chatbot_id'), $dataappoint);
        $json = array(
            'status' => 'success',
            'title' => 'สำเร็จ!',
            'message' => 'ทำรายการเรียบร้อยเเล้ว'
        );
        echo json_encode($json);
    }

    public function selected() {
        $doctors = $this->appoint_model->getdoctorappoint($this->input->post('shop_id_pri'))->result();
        $doctor_id = array();
        $doctor_name = array();
        $doctor_img = array();
        $doctor_subtitle = array();
        $i = 0;
        foreach ($doctors as $doctor) {
            $doctor_id[$i] = $doctor->user_id;
            $doctor_name[$i] = $doctor->user_fullname;
            $doctor_img[$i] = admin_url() . 'assets/upload/user/' . (!empty($doctor->user_image) ? $doctor->user_image : 'none.png');
            $specialized = '';
            if ($doctor->specialized_id != null) {
                $specialized = $this->appoint_model->getspecialized($doctor->specialized_id)->row()->specialized_name;
            }
            $doctor_subtitle[$i] = $specialized;
            $i++;
        }
        $return["doctor_id"] = $doctor_id;
        $return["doctor_name"] = $doctor_name;
        $return["doctor_img"] = $doctor_img;
        $return["doctor_subtitle"] = $doctor_subtitle;
        $sections = $this->appoint_model->getsection(1)->result();
        $appoint_start_id = array();
        $appoint_start_name = array();
        $i = 0;
        foreach ($sections as $section) {
            $appoint_start_id[$i] = $section->section_time;
            $appoint_start_name[$i] = $section->section_time;
            $i++;
        }
        $return["appoint_start_id"] = $appoint_start_id;
        $return["appoint_start_name"] = $appoint_start_name;

        print json_encode($return);
    }

}
