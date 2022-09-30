<?php

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('register_model');
    }

    public function index() {
        if ($this->session->userdata('islogin') == 1) {
            redirect(base_url() . 'profile');
        }
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        $online_id = $this->session->userdata('online_id');

        if ($doauthen == true && $tel != '' && $online_id != '') {
            $online = $this->register_model->getOnline($online_id);
            if ($online->num_rows() == 1) {
                $meta = array(
                    'og:site_name' => $this->config->item('app_title'),
                    'og:url' => base_url() . 'register',
                    'og:title' => 'สมัครสมาชิก ' . $this->config->item('app_title'),
                    'og:locale' => 'th_th',
                    'og:description' => 'สมัครสมาชิก' . $this->config->item('app_description'),
                    'og:image' => base_url() . 'assets/img/thumbnail.jpg',
                    'og:image:width' => '560',
                    'og:image:height' => '420',
                    'og:type' => 'article',
                );
                $data = array(
                    'title' => 'สมัครสมาชิก',
                    'description' => 'สมัครสมาชิก',
                    'keyword' => 'สมัครสมาชิก',
                    'meta' => $meta,
                    'css_full' => array('plugin/datepicker/datepicker.css'),
                    'js_full' => array('plugin/datepicker/bootstrap-datepicker.js', 'plugin/datepicker/bootstrap-datepicker-thai.js', 'plugin/datepicker/bootstrap-datepicker.th.js'),
                );
                $this->renderView('register_view', $data);
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
        }
    }

    public function doRegister() {
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        $online_id = $this->session->userdata('online_id');
        $ref_online_id = $this->session->userdata('ref_online_id');

        if ($doauthen == true && $tel != '' && $online_id != '') {
            $online = $this->register_model->getOnline($online_id);
            
            $password = $this->input->post('password');
            $password_confirm = $this->input->post('password_confirm');
            
            if ($online->num_rows() == 1 && $password == $password_confirm) {
                $register = array(
                    'online_password' => hash('sha256', $tel . $password),
                    'online_idcard' => $this->input->post('idcard'),
                    'online_prefix' => $this->input->post('prefix'),
                    'online_fname' => $this->input->post('fname'),
                    'online_lname' => $this->input->post('lname'),
                    'online_gender' => $this->input->post('gender'),
                    'online_blood' => $this->input->post('blood'),
                    'online_email' => $this->input->post('email'),
                    'online_birthdate' => $this->input->post('birthdate'),
                    'online_address' => $this->input->post('address'),
                    'online_district' => $this->input->post('district'),
                    'online_amphoe' => $this->input->post('amphoe'),
                    'online_province' => $this->input->post('province'),
                    'online_zipcode' => $this->input->post('zipcode'),
                    'online_allergic' => $this->input->post('allergic'),
                    'online_disease' => $this->input->post('disease'),
                    'online_image' => 'none.png',
                    'online_comment' => NULL,
                    'online_status_id' => 1,
                    'guide_id' => ($ref_online_id != '' ? $ref_online_id : NULL),
                    'online_update' => $this->libs->getDate()
                );
                $this->register_model->updateOnline($online_id, $register);

                $this->session->unset_userdata('doauthen');
                $this->session->unset_userdata('tel');
                $this->session->unset_userdata('ref_online_id');

                $result = $this->register_model->getOnline($online_id);
                $row = $result->row();
                $sessiondata = array(
                    'islogin' => 1,
                    'online_id' => $row->online_id,
                    'online_tel' => $row->online_tel,
                    'online_birthdate' => $row->online_birthdate,
                    'online_fname' => $row->online_fname,
                    'online_lname' => $row->online_lname,
                    'online_point' => $row->online_point,
                    'online_image' => $row->online_image != null ? $row->online_image : 'none.png'
                );
                $this->session->set_userdata($sessiondata);
                redirect(base_url());
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
        }
    }

    public function sync() {
        if ($this->session->userdata('islogin') == 1) {
            redirect(base_url() . 'profile');
        }
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        $online_id = $this->session->userdata('online_id');

        if ($doauthen == true && $tel != '' && $online_id != '') {
            $online = $this->register_model->getOnline($online_id);
            if ($online->num_rows() == 1) {
                $customers = $this->register_model->getCustomerShop($tel);
                if ($customers->num_rows() > 0) {
                    $meta = array(
                        'og:site_name' => $this->config->item('app_title'),
                        'og:url' => base_url() . 'register/sync',
                        'og:title' => 'ซิงค์ข้อมูล ' . $this->config->item('app_title'),
                        'og:locale' => 'th_th',
                        'og:description' => 'ซิงค์ข้อมูล' . $this->config->item('app_description'),
                        'og:image' => base_url() . 'assets/img/thumbnail.jpg',
                        'og:image:width' => '560',
                        'og:image:height' => '420',
                        'og:type' => 'article',
                    );
                    $data = array(
                        'title' => 'ซิงค์ข้อมูล',
                        'description' => 'ซิงค์ข้อมูล',
                        'keyword' => 'ซิงค์ข้อมูล',
                        'meta' => $meta,
                        'customers' => $customers
                    );
                    $this->renderView('register_sync_view', $data);
                } else {
                    $text = 'ซิงค์ข้อมูลไม่สำเร็จ !';
                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                    redirect(base_url() . 'authen');
                }
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
        }
    }

    public function doSync() {
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        $online_id = $this->session->userdata('online_id');
        $ref_online_id = $this->session->userdata('ref_online_id');

        if ($doauthen == true && $tel != '' && $online_id != '') {
            $online = $this->register_model->getOnline($online_id);
            
            $password = $this->input->post('password');
            $password_confirm = $this->input->post('password_confirm');
            
            if ($online->num_rows() == 1 && $password == $password_confirm) {
                $customers = $this->register_model->getCustomer($this->input->post('customer_id_pri'));
                if ($customers->num_rows() == 1) {
                    $customer = $customers->row();
                    $register = array(
                        'online_password' => hash('sha256', $tel . $password),
                        'online_idcard' => $customer->customer_idcard,
                        'online_prefix' => $customer->customer_prefix,
                        'online_fname' => $customer->customer_fname,
                        'online_lname' => $customer->customer_lname,
                        'online_gender' => $customer->customer_gender,
                        'online_blood' => $customer->customer_blood,
                        'online_email' => $customer->customer_email,
                        'online_birthdate' => $customer->customer_birthdate,
                        'online_address' => $customer->customer_address,
                        'online_district' => $customer->customer_district,
                        'online_amphoe' => $customer->customer_amphoe,
                        'online_province' => $customer->customer_province,
                        'online_zipcode' => $customer->customer_zipcode,
                        'online_allergic' => $customer->customer_allergic,
                        'online_disease' => $customer->customer_disease,
                        'online_comment' => $customer->customer_comment,
                        'online_image' => 'none.png',
                        'online_status_id' => 1,
                        'guide_id' => ($ref_online_id != '' ? $ref_online_id : NULL),
                        'online_update' => $this->misc->getdate()
                    );
                    $this->register_model->updateOnline($online_id, $register);

                    $this->session->unset_userdata('doauthen');
                    $this->session->unset_userdata('tel');
                    $this->session->unset_userdata('ref_online_id');

                    $result = $this->register_model->getOnline($online_id);
                    $row = $result->row();
                    $sessiondata = array(
                        'islogin' => 1,
                        'online_id' => $row->online_id,
                        'online_tel' => $row->online_tel,
                        'online_birthdate' => $row->online_birthdate,
                        'online_fname' => $row->online_fname,
                        'online_lname' => $row->online_lname,
                        'online_point' => $row->online_point,
                        'online_image' => $row->online_image != null ? $row->online_image : 'none.png'
                    );
                    $this->session->set_userdata($sessiondata);
                    redirect(base_url());
                } else {
                    $text = 'ซิงค์ข้อมูลไม่สำเร็จ !';
                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                    redirect(base_url() . 'authen');
                }
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
        }
    }

}
