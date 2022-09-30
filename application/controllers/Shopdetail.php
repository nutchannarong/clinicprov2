<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Shopdetail extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        $this->load->model('shopdetail_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        redirect(base_url() . 'shops');
    }

    public function show($shop_id = null) {
        $get_shop = $this->shopdetail_model->getShopByID($shop_id);
        if ($get_shop->num_rows() == 1) {
            $row_shop = $get_shop->row_array();
            $meta = array(
                'og:site_name' => 'คลินิก ' . $row_shop['shop_name'] . ' - ' . $this->config->item('app_title'),
                'og:url' => base_url() . 'shop/' . $row_shop['shop_id'],
                'og:title' => 'คลินิก ' . $row_shop['shop_name'] . ' - ' . $this->config->item('app_title'),
                'og:locale' => 'th_th',
                'og:description' => 'คลินิก ' . $row_shop['shop_name'] . ' ' . $this->config->item('app_description'),
                'og:image' => admin_url() . 'assets/upload/shop/' . $row_shop['shop_image'],
                'og:image:width' => '560',
                'og:image:height' => '420',
                'og:type' => 'article'
            );
            $data = array(
                'title' => $row_shop['shop_name'],
                'description' => $row_shop['shop_name'],
                'keyword' => $row_shop['shop_name'],
                'meta' => $meta,
                'css' => array('ribbon.css'),
                'js' => array(),
                'css_full' => array('plugin/lightslider/dist/css/lightslider.css'),
                'js_full' => array('plugin/lightslider/dist/js/lightslider.js'),
                'row_shop' => $row_shop
            );
            $this->renderView('shop_detail_view', $data);
        } else {
            redirect(base_url('shops'));
        }
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext'),
            'shop_id_pri' => $this->input->post('shop_id_pri')
        );
        $count = $this->shopdetail_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('shopdetail/ajax_pagination');
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
            'data' => $this->shopdetail_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/shop_products_pagination', $data);
    }

    public function ajax_doctor_pagination() {
        $filter = array(
            'shop_id_pri' => $this->input->post('shop_id_pri')
        );
        $count = $this->shopdetail_model->countDoctorPagination($filter);
        $config['div'] = 'result-doctor-pagination';
        $config['base_url'] = base_url('shopdetail/ajax_doctor_pagination');
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
            'data' => $this->shopdetail_model->getDoctorPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'shop_id_pri' => $this->input->post('shop_id_pri'),
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/shop_doctor_pagination', $data);
    }

    public function doctor($user_id = null) {
        $get_doctor = $this->shopdetail_model->getDoctorByID($user_id);
        if ($get_doctor->num_rows() == 1) {
            $row_doctor = $get_doctor->row();
            $meta = array(
                'og:site_name' => 'เเพทย์ ' . $row_doctor->user_fullname . ' - ' . $this->config->item('app_title'),
                'og:url' => base_url() . 'doctor/' . $row_doctor->user_id,
                'og:title' => 'เเพทย์ ' . $row_doctor->user_fullname . ' - ' . $this->config->item('app_title'),
                'og:locale' => 'th_th',
                'og:description' => 'เเพทย์ ' . $row_doctor->user_fullname . ' ' . $this->config->item('app_description'),
                'og:image' => admin_url() . "assets/upload/user/" . $row_doctor->user_image,
                'og:image:width' => '560',
                'og:image:height' => '420',
                'og:type' => 'article'
            );
            $data = array(
                'title' => $row_doctor->user_fullname,
                'description' => $row_doctor->user_fullname,
                'keyword' => $row_doctor->user_fullname,
                'meta' => $meta,
                'css' => array(),
                'js' => array(),
                'css_full' => array(),
                'js_full' => array(),
                'row_doctor' => $row_doctor
            );
            $this->renderView('shop_detail_doctor_view', $data);
        } else {
            redirect(base_url('shops'));
        }
    }

    // shop sub mother
    public function ajax_shop_sub_pagination() {
        $shop_mother_id = $this->shopdetail_model->getShop($this->input->post('shop_id_pri'))->row()->shop_mother_id;
        $filter = array(
            'shop_id_pri' => $this->input->post('shop_id_pri'),
            'shop_mother_id' => $shop_mother_id
        );
        $count = $this->shopdetail_model->countShopSubPagination($filter);
        $config['div'] = 'result-shop-sub-pagination';
        $config['base_url'] = base_url('shopdetail/ajax_shop_sub_pagination');
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
            'data' => $this->shopdetail_model->getShopSubPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/shop_sub_pagination', $data);
    }

    public function appointdoctor($user_id) {
        $doctor = $this->shopdetail_model->getDoctorByID($user_id);
        if ($doctor->num_rows() == 1) {
            $doctor = $doctor->row();
            $datestart = date("Y-m-d");
            $datestr = str_replace('-', '/', $datestart);
            //$dateend = date('Y-m-d', strtotime($datestr . "+30 days"));
            $adddays = 0;
            $i = 0;
            $t = 0;
            $appoint = array();
            while ($adddays < 31) {
                $checkday = date('Y-m-d', strtotime($datestr . "+$adddays days"));
                $day = date('N', strtotime($checkday));
                if ($this->shopdetail_model->checkSectionday($day, $user_id)->num_rows() == 1) {
                    $timechecks = $this->shopdetail_model->getsection($doctor->shop_id_pri);
                    if ($timechecks->num_rows() > 0) {
                        foreach ($timechecks->result() as $timecheck) {
                            $appoint_start = $timecheck->section_time . ':00';
                            $appoint_end = date("H:i:s", strtotime($appoint_start) + (60 * 30));
                            if ($this->shopdetail_model->checkSection($timecheck->section_time, $user_id)->num_rows() == 1) {
                                if ($this->shopdetail_model->checkAppointDoctor($doctor->shop_id_pri, $user_id, $checkday, $appoint_start)->num_rows() == 0) {
                                    $appoint[$t] = array(
                                        'title' => "จองนัดหมาย",
                                        'start' => "$checkday" . " " . "$appoint_start",
                                        'end' => "$checkday" . " " . "$appoint_end",
                                        'id' => $user_id,
                                    );
                                    $t++;
                                }
                            }
                        }
                    }
                    $i++;
                }
                $adddays++;
            }
            $return = $appoint;
            print json_encode($return);
        }
    }

    public function modalAdd() {
        $user_id = $this->input->post('user_id');
        $daystart = explode(" ", $this->input->post('start'));
        $start = explode(":", $daystart[4]);
        $data = array(
            'data' => $this->shopdetail_model->getDoctorByShop($user_id)->row(),
            'date' => $this->input->post('date'),
            'appoint_start' => $start[0] . ':' . $start[1],
        );
        $this->load->view('modal/shop_appoint_add_modal', $data);
    }

    public function add_appoint() {
        $dataonline = $this->shopdetail_model->getOnline()->row();
        $customer = $this->shopdetail_model->getCustomer($this->session->userdata('online_tel'), $this->input->post('shop_id_pri'));
        if ($customer->num_rows() == 1) {
            $customer_id_pri = $customer->row()->customer_id_pri;
            $appoint_tel = $dataonline->online_tel;
            $appoint_date = $this->input->post('date');
            $user_id = $this->input->post('doctor_id');
            $appoint_start = $this->input->post('appoint_start') . ':00';
            $shop_id_pri = $this->input->post('shop_id_pri');
            //เช็ควันของหมอ 
            $day = date('N', strtotime($appoint_date));
            if ($this->shopdetail_model->checkSectionday($day, $user_id)->num_rows() == 1) {
                //เช็คเวลาของหมอ  
                if ($this->shopdetail_model->checkSection($this->input->post('appoint_start'), $user_id)->num_rows() == 1) {
                    //เช็คเวลา หมอว่างไหม
                    if ($this->shopdetail_model->checkAppointDoctor($shop_id_pri, $user_id, $appoint_date, $appoint_start)->num_rows() == 0) {
                        //เช็คสถานะ ของผู้ป่วย 1 คน สถานะรอได้ 4 ครั้ง ต่อวัน 
                        if ($this->shopdetail_model->checkAppointCustomer($shop_id_pri, $appoint_date, $customer_id_pri)->num_rows() < 4) {
                            //เช็คเวลาไม่ซ้ำ
                            if ($this->shopdetail_model->checkAppointCustomerTime($shop_id_pri, $appoint_date, $appoint_start, $customer_id_pri)->num_rows() == 0) {
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
                                );
                                $this->shopdetail_model->addAppoint($dataappoint);
//                                $json = array(
//                                    'status' => 'success',
//                                    'title' => 'สำเร็จ!',
//                                    'message' => 'ทำรายการเรียบร้อยเเล้ว'
//                                );
                                $this->session->set_flashdata('flash_message', 'success,นัดหมายสำเร็จ,ทำรายการเรียบร้อยเเล้ว');
                                redirect(base_url() . 'appoint');
                            } else {
//                                $json = array(
//                                    'status' => 'error',
//                                    'title' => 'ท่านได้เลือกวันและเวลานัดนี้ไปแล้ว',
//                                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
//                                );
                                $this->session->set_flashdata('flash_message', 'error,ท่านได้เลือกวันและเวลานัดนี้ไปแล้ว,กรุณาตรวจสอบการนัดของท่าน');
                                redirect(base_url() . 'shopdetail/doctor/' . $user_id);
                            }
                        } else {
//                            $json = array(
//                                'status' => 'error',
//                                'title' => 'ท่านนัดหมายเกิน 2 เวลาใน 1 วัน',
//                                'message' => 'กรุณาตรวจสอบการนัดของท่าน'
//                            );
                            $this->session->set_flashdata('flash_message', 'error,ท่านนัดหมายเกิน 4 เวลาใน 1 วัน,กรุณาตรวจสอบการนัดของท่าน');
                            redirect(base_url() . 'shopdetail/doctor/' . $user_id);
                        }
                    } else {
//                        $json = array(
//                            'status' => 'error',
//                            'title' => 'แพทย์ไม่ว่างให้บริการ',
//                            'message' => 'กรุณาตรวจสอบการนัดของท่าน'
//                        );
                        $this->session->set_flashdata('flash_message', 'error,แพทย์ไม่ว่างให้บริการ,กรุณาตรวจสอบการนัดของท่าน');
                        redirect(base_url() . 'shopdetail/doctor/' . $user_id);
                    }
                } else {
//                    $json = array(
//                        'status' => 'error',
//                        'title' => 'ไม่สามารถนัดเวลาที่เลือกได้',
//                        'message' => 'กรุณาตรวจสอบการนัดของท่าน'
//                    );
                    $this->session->set_flashdata('flash_message', 'error,ไม่สามารถนัดเวลาที่เลือกได้,กรุณาตรวจสอบการนัดของท่าน');
                    redirect(base_url() . 'shopdetail/doctor/' . $user_id);
                }
            } else {
//                $json = array(
//                    'status' => 'error',
//                    'title' => 'ไม่สามารถนัดวันที่เลือกได้',
//                    'message' => 'กรุณาตรวจสอบการนัดของท่าน'
//                );
                $this->session->set_flashdata('flash_message', 'error,ไม่สามารถนัดวันที่เลือกได้,กรุณาตรวจสอบการนัดของท่าน');
                redirect(base_url() . 'shopdetail/doctor/' . $user_id);
            }
        } else {
//            $json = array(
//                'status' => 'error',
//                'title' => 'ผิดพลาด',
//                'message' => 'ผิดพลาดไม่สามารถทำรายการได้'
//            );
            $this->session->set_flashdata('flash_message', 'error,ผิดพลาด,ผิดพลาดไม่สามารถทำรายการได้');
            redirect(base_url());
        }
        //echo json_encode($json);
    }

}
