<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('profile_model');
    }

    public function index() {
        $data = array(
            'title' => 'ข้อมูลส่วนตัว',
            'description' => 'ข้อมูลส่วนตัว',
            'keyword' => 'ข้อมูลส่วนตัว',
            'meta' => array(),
            'css_full' => array('plugin/datepicker/datepicker.css'),
            'js_full' => array('plugin/datepicker/bootstrap-datepicker.js', 'plugin/datepicker/bootstrap-datepicker-thai.js', 'plugin/datepicker/bootstrap-datepicker.th.js'),
            'data' => $this->profile_model->getOnlineByID($this->session->userdata('online_id'))->row()
        );
        $this->renderView('profile_view', $data);
    }

    public function update() {
        $data = array(
            'online_prefix' => $this->input->post('online_prefix'),
            'online_fname' => $this->input->post('online_fname'),
            'online_lname' => $this->input->post('online_lname'),
            'online_blood' => $this->input->post('online_blood'),
            'online_gender' => $this->input->post('online_gender'),
            'online_idcard' => $this->input->post('online_idcard'),
            'online_email' => $this->input->post('online_email'),
            'online_address' => $this->input->post('online_address'),
            'online_district' => $this->input->post('online_district'),
            'online_amphoe' => $this->input->post('online_amphoe'),
            'online_province' => $this->input->post('online_province'),
            'online_zipcode' => $this->input->post('online_zipcode'),
            'subscribe_id' => ($this->input->post('subscribe_id') != '' ? $this->input->post('subscribe_id') : 0),
            'online_update' => $this->misc->getdate()
        );
        $this->profile_model->update($this->session->userdata('online_id'), $data);
        $sessiondata = array(
            'online_fname' => $data['online_fname'],
            'online_lname' => $data['online_lname']
        );
        $this->session->set_userdata($sessiondata);
        $this->session->set_flashdata('flash_message', 'success,Success,' . 'บันทึกข้อมูลเเล้ว');
        redirect(base_url() . 'profile');
    }

    // password
    public function modalEditPassword() {
        $getUser = $this->profile_model->getOnlineByID($this->session->userdata('online_id'));
        if ($getUser->num_rows() == 1) {
            $data = array(
                'data' => $getUser->row()
            );
            $this->load->view('modal/profile_edit_password_modal', $data);
        }
    }

    public function editPassword() {
        $tel = $this->input->post('tel');
        $password_old = $this->input->post('password_old');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');
        $get_user = $this->profile_model->getOnlineByTelPass($tel, hash('sha256', $tel . $password_old));

        if ($get_user->num_rows() == 1 && $password == $password_confirm) {
            $data = array(
                'online_password' => hash('sha256', $tel . $password),
                'online_update' => date('Y-m-d H:i:s')
            );
            $this->profile_model->update($this->session->userdata('online_id'), $data);

            $json = array(
                'status' => 'success',
                'title' => 'ทำรายการสำเร็จ!',
                'message' => 'แก้ไขรหัสผ่านเรียบร้อยแล้ว'
            );
        } else {
            $json = array(
                'status' => 'error',
                'title' => 'เกิดข้อผิดพลาด!',
                'message' => 'แก้ไขรหัสผ่านไม่สำเร็จ'
            );
        }
        echo json_encode($json);
    }
    
//    public function linkFacebook() {
//        $facebook_id = $this->input->post('link_facebook_id');
//        $facebook_email = $this->input->post('link_facebook_email');
//
//        $result = $this->profile_model->getOnlineByEmail($facebook_email);
//        if ($result->num_rows() == 1) {
//            $data = array(
//                'facebook_id' => $facebook_id,
//                'online_update' => $this->libs->getdate()
//            );
//            $this->profile_model->update($this->session->userdata('online_id'), $data);
//            $this->session->set_flashdata('flash_message', 'success,Success,' . 'บันทึกเชื่อมต่อ Facebook เเล้ว');
//            redirect(base_url() . 'profile');
//        } else {
//            $this->session->set_flashdata('flash_message', 'warning,Warning,' . 'เชื่อมต่อไม่สำเร็จ เนื่องจากอีเมลไม่ตรงกัน');
//            redirect(base_url() . 'profile');
//        }
//    }
//
//    public function unlinkFacebook() {
//        $facebook_id = $this->input->post('unlink_facebook_id');
//        $facebook_email = $this->input->post('unlink_facebook_email');
//
//        $result = $this->profile_model->getOnlineByEmailFB($facebook_id, $facebook_email);
//        if ($result->num_rows() == 1) {
//            $data = array(
//                'facebook_id' => NULL,
//                'online_update' => $this->libs->getdate()
//            );
//            $this->profile_model->update($this->session->userdata('online_id'), $data);
//            $this->session->set_flashdata('flash_message', 'success,Success,' . 'ยกเลิกเชื่อมต่อ Facebook เเล้ว');
//            redirect(base_url() . 'profile');
//        } else {
//            $this->session->set_flashdata('flash_message', 'warning,Warning,' . 'เชื่อมต่อไม่สำเร็จ เนื่องจากอีเมลไม่ตรงกัน');
//            redirect(base_url() . 'profile');
//        }
//    }

}
