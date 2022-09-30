<?php

class Forget extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('forget_model');
    }

    public function index() {
        if ($this->session->userdata('islogin') == 1) {
            redirect(base_url() . 'profile');
        }
        $meta = array(
            'og:site_name' => $this->config->item('app_title'),
            'og:url' => base_url() . 'forget',
            'og:title' => 'ลืมรหัสผ่าน ' . $this->config->item('app_title'),
            'og:locale' => 'th_th',
            'og:description' => 'ลืมรหัสผ่าน' . $this->config->item('app_description'),
            'og:image' => base_url() . 'assets/img/thumbnail.jpg',
            'og:image:width' => '560',
            'og:image:height' => '420',
            'og:type' => 'article',
        );
        $data = array(
            'title' => 'ลืมรหัสผ่าน',
            'description' => 'ลืมรหัสผ่าน',
            'keyword' => 'ลืมรหัสผ่าน',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
        );
        $this->renderView('forget_view', $data);
    }

    public function createPassword() {
        if ($this->session->userdata('islogin') == 1) {
            redirect(base_url() . 'profile');
        }
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        if ($doauthen == true && $tel != '') {
            $onlines1 = $this->forget_model->getOnlineTel($tel);
            if ($onlines1->num_rows() == 1) {
                $online1 = $onlines1->row();
                $meta = array(
                    'og:site_name' => $this->config->item('app_title'),
                    'og:url' => base_url() . 'forget',
                    'og:title' => 'เปลี่ยนรหัสผ่าน ' . $this->config->item('app_title'),
                    'og:locale' => 'th_th',
                    'og:description' => 'เปลี่ยนรหัสผ่าน' . $this->config->item('app_description'),
                    'og:image' => base_url() . 'assets/img/thumbnail.jpg',
                    'og:image:width' => '560',
                    'og:image:height' => '420',
                    'og:type' => 'article',
                );
                $data = array(
                    'title' => 'เปลี่ยนรหัสผ่าน',
                    'description' => 'เปลี่ยนรหัสผ่าน',
                    'keyword' => 'เปลี่ยนรหัสผ่าน',
                    'meta' => $meta,
                    'css' => array(),
                    'js' => array(),
                    'tel' => $tel
                );
                $this->renderView('forget_password_view', $data);
            } else {
                $text = 'กรุณาลองใหม่ ไม่พบผู้ใช้งาน';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'forget');
            }
        } else {
            $text = 'กรุณาลองใหม่อีกครั้ง';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'forget');
        }
    }

    public function doCreatePassword() {
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        $password = trim($this->input->post('password'));

        if ($doauthen == true && $tel != '') {
            $datas = $this->forget_model->getOnlineTel($tel);
            if ($datas->num_rows() == 1) {
                $data = $datas->row();
                if ($data->online_status_id == 1) {
                    $update = array(
                        'online_password' => hash('sha256', $tel . $password),
                        'online_update' => $this->libs->getDate()
                    );
                    $this->forget_model->updateOnline($data->online_id, $update);

                    $this->session->unset_userdata('doauthen');
                    $this->session->unset_userdata('tel');

                    $text = 'เปลี่ยนรหัสผ่านใหม่เรียบร้อยเเล้ว';
                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #2ec1ac;"><i class="fa fa-check-circle" style="color: #2ec1ac;"></i>&nbsp;' . $text . '</div>');
                    redirect(base_url() . 'authen');
                } else {
                    $text = 'ผิดพลาดสถานะผู้ใช้งาน !';
                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                    redirect(base_url() . 'forget');
                }
            } else {
                $text = 'รหัสผ่านไม่ถูกต้อง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'forget');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'forget');
        }
    }

    public function doForget() {
        $tel = str_replace('+66', '0', $this->input->post('tel'));
        if (!empty($tel)) {
            //check online status
            $onlines1 = $this->forget_model->getOnlineTel($tel);
            if ($onlines1->num_rows() == 1) {
                $online1 = $onlines1->row();
                if ($online1->online_status_id == 2) {
                    $text = 'ผู้ใช้งานนี้ถูกระงับ !';
                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                    redirect(base_url() . 'forget');
                } else {
                    //$this->db->trans_start();
                    $authens = $this->forget_model->getAuthen($tel);
                    if ($authens->num_rows() > 0) {
                        if ($authens->num_rows() == 1) {
                            $authen = $authens->row();
                            if ($authen->authen_status == 0) {
                                if ($authen->authen_count >= 5) {
                                    $this->forget_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                                    $text = 'เบอร์โทรของท่านถูกระงับ !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                } else {
                                    $otp = $this->sendSMSOTP($tel);
                                    if ($otp == 1) {
                                        $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget');
                                    } else if ($otp != 0) {
                                        $this->forget_model->updateAuthen($authen->authen_id, array(
                                            'authen_otp' => $otp,
                                            'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                            'authen_count' => $authen->authen_count + 1
                                        ));
                                        $sessiondata = array(
                                            'doauthen' => true,
                                            'tel' => $tel
                                        );
                                        $this->session->set_userdata($sessiondata);
                                        $text = 'กรอกรหัส OTP !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget/otp');
                                    } else {
                                        $text = 'เบอร์โทรไม่ถูกต้อง !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget');
                                    }
                                }
                            } else {
                                $text = 'เบอร์โทรของท่านถูกระงับ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            }
                        } else {
                            $authen = $authens->row();
                            $this->forget_model->deleteAuthenID($authen->authen_id, $tel);
                            if ($authen->authen_status == 0) {
                                if ($authen->authen_count >= 5) {
                                    $this->forget_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                                    $text = 'เบอร์โทรของท่านถูกระงับ !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                } else {
                                    $otp = $this->sendSMSOTP($tel);
                                    if ($otp == 1) {
                                        $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget');
                                    } else if ($otp != 0) {
                                        $this->forget_model->updateAuthen($authen->authen_id, array(
                                            'authen_otp' => $otp,
                                            'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                            'authen_count' => $authen->authen_count + 1
                                        ));
                                        $sessiondata = array(
                                            'doauthen' => true,
                                            'tel' => $tel
                                        );
                                        $this->session->set_userdata($sessiondata);
                                        $text = 'กรอกรหัส OTP !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget/otp');
                                    } else {
                                        $text = 'เบอร์โทรไม่ถูกต้อง !';
                                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                        redirect(base_url() . 'forget');
                                    }
                                }
                            } else {
                                $text = 'เบอร์โทรของท่านถูกระงับ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            }
                        }
                    } else {
                        $onlines = $this->forget_model->getOnlineTel($tel);
                        if ($onlines->num_rows() == 1) {
                            $online = $onlines->row();
                            if ($online->online_status_id != 2) {
                                $otp = $this->sendSMSOTP($online->online_tel);
                                if ($otp == 1) {
                                    $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                } else if ($otp != 0) {
                                    $this->forget_model->addAuthen(array(
                                        'authen_tel' => $tel,
                                        'authen_otp' => $otp,
                                        'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                        'authen_count' => 0,
                                    ));
                                    $sessiondata = array(
                                        'doauthen' => true,
                                        'tel' => $tel
                                    );
                                    $this->session->set_userdata($sessiondata);
                                    $text = 'กรอกรหัส OTP !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget/otp');
                                } else {
                                    $text = 'เบอร์โทรไม่ถูกต้อง !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                }
                            } else {
                                $text = 'ผู้ใช้งานนี้ถูกระงับ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            }
                        } else {
                            $otp = $this->sendSMSOTP($tel);
                            if ($otp == 1) {
                                $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            } else if ($otp != 0) {
                                $this->forget_model->addAuthen(array(
                                    'authen_tel' => $tel,
                                    'authen_otp' => $otp,
                                    'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                    'authen_count' => 0,
                                ));
                                $sessiondata = array(
                                    'doauthen' => true,
                                    'tel' => $tel
                                );
                                $this->session->set_userdata($sessiondata);
                                redirect(base_url() . 'forget/otp');
                            } else {
                                $text = 'เบอร์โทรไม่ถูกต้อง !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            }
                        }
                    }
                    //$this->db->trans_complete();
                }
            } else {
                $text = 'ไม่พบเบอร์โทรนี้ !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'forget');
            }
        } else {
            $text = 'ไม่พบข้อมูลเบอร์โทร !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'forget');
        }
    }

    public function otp() {
        $doauthen = $this->session->userdata('doauthen');
        $tel = $this->session->userdata('tel');
        if ($doauthen == true && $tel != '') {
            $authens = $this->forget_model->getAuthen($tel);
            if ($authens->num_rows() == 1) {
                $meta = array(
                    'og:site_name' => $this->config->item('app_title'),
                    'og:url' => base_url() . 'forget/otp',
                    'og:title' => 'ยืนยัน OTP เพื่อเปลี่ยนรหัสผ่าน' . $this->config->item('app_title'),
                    'og:locale' => 'th_th',
                    'og:description' => 'ยืนยัน OTP เพื่อเปลี่ยนรหัสผ่าน' . $this->config->item('app_description'),
                    'og:image' => base_url() . 'assets/img/thumbnail.jpg',
                    'og:image:width' => '560',
                    'og:image:height' => '420',
                    'og:type' => 'article',
                );
                $data = array(
                    'title' => 'ยืนยัน OTP เพื่อเปลี่ยนรหัสผ่าน ' . $this->config->item('app_title'),
                    'description' => 'ยืนยัน OTP เพื่อเปลี่ยนรหัสผ่าน' . $this->config->item('app_description'),
                    'keyword' => 'ยืนยัน OTP, ' . $this->config->item('app_keyword'),
                    'meta' => $meta,
                    'css' => array(),
                    'js' => array(),
                    'tel' => $tel
                );
                $this->renderView('forget_otp_view', $data);
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'forget');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'forget');
        }
    }

    public function doOTP() {
        $tel = str_replace('+66', '0', $this->input->post('tel'));
        $otp = $this->input->post('otp');
        if (!empty($tel) && !empty($otp) && $this->session->userdata('doauthen') == true) {
            $authens = $this->forget_model->getAuthen($tel);
            if ($authens->num_rows() == 1) {
                $authen = $authens->row();
                if ($authen->authen_otp == $otp) {
                    if ($authen->authen_status == 0) {
                        if ($authen->authen_otp_expire >= date('Y-m-d H:i:s')) {

                            $this->forget_model->deleteAuthen($authen->authen_id);
                            $datas = $this->forget_model->getOnlineTel($tel);
                            if ($datas->num_rows() == 1) {
                                //เบอร์เก่า
                                $data = $datas->row();
                                if ($data->online_status_id == 1) {
                                    //เปลี่ยนรหัสผ่าน
                                    redirect(base_url() . 'forget/createpassword');
                                } else {
                                    $text = 'สถานะผู้ใช้งานผิดพลาด';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                }
                            }
                        } else {
                            $this->forget_model->deleteAuthen($authen->authen_id);
                            $text = 'OTP หมดอายุแล้ว !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                            redirect(base_url() . 'forget');
                        }
                    } else {
                        $text = 'เบอร์โทรของท่านถูกระงับ !';
                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                        redirect(base_url() . 'forget');
                    }
                } else {
                    if ($authen->authen_count >= 5) {
                        $this->forget_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                        $text = 'เบอร์โทรของท่านถูกระงับ !';
                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                        redirect(base_url() . 'forget');
                    } else {
                        $this->forget_model->updateAuthen($authen->authen_id, array('authen_count' => $authen->authen_count + 1));
                        $text = 'OTP ไม่ถุกต้อง !';
                        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                        redirect(base_url() . 'forget');
                    }
                }
            } else {
                $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'forget');
            }
        } else {
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'forget');
        }
    }

    public function sendOTP() {
        $doauthen = $this->session->userdata('doauthen');
        $tel = str_replace('+66', '0', $this->input->post('tel'));
        if ($doauthen == true) {
            if (!empty($tel)) {
                $authens = $this->forget_model->getAuthen($tel);
                if ($authens->num_rows() > 0) {
                    if ($authens->num_rows() == 1) {
                        $authen = $authens->row();
                        if ($authen->authen_status == 0) {
                            if ($authen->authen_count >= 5) {
                                $this->forget_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                                $text = 'เบอร์โทรของท่านถูกระงับ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                $status = false;
                            } else {
                                $otp = $this->sendSMSOTP($tel);
                                if ($otp == 1) {
                                    $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                } else if ($otp != 0) {
                                    $this->forget_model->updateAuthen($authen->authen_id, array(
                                        'authen_otp' => $otp,
                                        'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                        'authen_count' => $authen->authen_count + 1
                                    ));
                                    $sessiondata = array(
                                        'doauthen' => true,
                                        'tel' => $tel
                                    );
                                    $this->session->set_userdata($sessiondata);
                                    $text = 'กรอกรหัส OTP !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                    $status = true;
                                } else {
                                    $text = 'เบอร์โทรไม่ถูกต้อง !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    $status = false;
                                }
                            }
                        } else {
                            $text = 'เบอร์โทรของท่านถูกระงับ !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                            $status = false;
                        }
                    } else {
                        $authen = $authens->row();
                        $this->forget_model->deleteAuthenID($authen->authen_id, $tel);
                        if ($authen->authen_status == 0) {
                            if ($authen->authen_count >= 5) {
                                $this->forget_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                                $text = 'เบอร์โทรของท่านถูกระงับ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                $status = false;
                            } else {
                                $otp = $this->sendSMSOTP($tel);
                                if ($otp == 1) {
                                    $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    redirect(base_url() . 'forget');
                                } else if ($otp != 0) {
                                    $this->forget_model->updateAuthen($authen->authen_id, array(
                                        'authen_otp' => $otp,
                                        'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                        'authen_count' => $authen->authen_count + 1
                                    ));
                                    $sessiondata = array(
                                        'doauthen' => true,
                                        'tel' => $tel
                                    );
                                    $this->session->set_userdata($sessiondata);
                                    $text = 'กรอกรหัส OTP !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                    $status = true;
                                } else {
                                    $text = 'เบอร์โทรไม่ถูกต้อง !';
                                    $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                    $status = false;
                                }
                            }
                        } else {
                            $text = 'เบอร์โทรของท่านถูกระงับ !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                            $status = false;
                        }
                    }
                } else {
                    $onlines = $this->forget_model->getOnlineTel($tel);
                    if ($onlines->num_rows() == 1) {
                        $online = $onlines->row();
                        if ($online->online_status_id != 2) {
                            $otp = $this->sendSMSOTP($online->online_tel);
                            if ($otp == 1) {
                                $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                redirect(base_url() . 'forget');
                            } else if ($otp != 0) {
                                $this->forget_model->addAuthen(array(
                                    'authen_tel' => $tel,
                                    'authen_otp' => $otp,
                                    'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                    'authen_count' => 0,
                                ));
                                $sessiondata = array(
                                    'doauthen' => true,
                                    'tel' => $tel
                                );
                                $this->session->set_userdata($sessiondata);
                                $text = 'กรอกรหัส OTP !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #24a19c;"><i class="fa fa-history" style="color: #24a19c;"></i>&nbsp;' . $text . '</div>');
                                $status = true;
                            } else {
                                $text = 'เบอร์โทรไม่ถูกต้อง !';
                                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                                $status = false;
                            }
                        } else {
                            $text = 'เบอร์โทรของท่านถูกระงับ !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                            $status = false;
                        }
                    } else {
                        $otp = $this->sendSMSOTP($tel);
                        if ($otp == 1) {
                            $text = 'เครดิต SMS ของร้านค้าไม่เพียงพอ !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                            redirect(base_url() . 'forget');
                        } else if ($otp != 0) {
                            $this->forget_model->addAuthen(array(
                                'authen_tel' => $tel,
                                'authen_otp' => $otp,
                                'authen_otp_expire' => date('Y-m-d H:i:s', strtotime("+3 min")),
                                'authen_count' => 0,
                            ));
                            $sessiondata = array(
                                'doauthen' => true,
                                'tel' => $tel
                            );
                            $this->session->set_userdata($sessiondata);
                            $status = true;
                        } else {
                            $status = false;
                            $text = 'เบอร์โทรไม่ถูกต้อง !';
                            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                        }
                    }
                }
            } else {
                $status = false;
                $text = 'เบอร์โทรไม่ถูกต้อง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            }
        } else {
            $status = false;
            $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
        }

        $data = array(
            'status' => $status
        );
        echo json_encode($data);
    }

    private function sendSMSOTP($tel) {
        $this->load->model('setting_model');
        $shop_id_pri = $this->config->item('shop_id_pri');
        $shop = $this->setting_model->getShop($shop_id_pri)->row();
        if ($shop->shop_sms_all > 0) {
            $this->load->library('thsms');
            $sms = new thsms();
            $datasms = $this->setting_model->getSettingSms();
            $sms->username = $datasms->sms_username;
            $sms->password = $datasms->sms_password;
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $text = $otp . ' (OTP Clinic Pro มีอายุการใช้งาน 3 นาที)';
            $creditsend = $sms->send($datasms->sms_tel, $tel, $text);
            // if ($creditsend[1] == 'OK') {
                $data = array(
                    'sms_credit' => $creditsend[3],
                );
                $this->setting_model->editSettingSms($data);

//            $action_text = '(SMSOTP ระบบส่ง) ' . $text . ' ส่งไปยัง ' . $tel;
                $this->systemlog->log_send_sms_online($tel, 1);

                $data_shop = array(
                    'shop_sms_sum' => $shop->shop_sms_sum + 1,
                    'shop_sms_all' => $shop->shop_sms_all - 1,
                );
                $this->setting_model->updateShop($shop_id_pri, $data_shop);
                $this->systemlog->log_sms_credit('- ลบเครดิต 1 (Clinic Site Forget Password)', $shop_id_pri);
                return $otp;
            // } else {
            //     return 0;
            // }
        } else {
            return 1;
        }
    }

}
