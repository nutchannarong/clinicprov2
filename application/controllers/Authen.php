<?php

class Authen extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('authen_model');
  }

  public function index() {
    if ($this->session->userdata('islogin') == 1) {
      redirect(base_url() . 'profile');
    }
    if ($this->input->get('ref') != '') {
      $this->session->set_userdata(array('ref_online_id' => $this->input->get('ref')));
    } else {
      $this->session->set_userdata(array('ref_online_id' => ''));
    }
    $meta = array(
      'og:site_name' => $this->config->item('app_title'),
      'og:url' => base_url() . 'authen',
      'og:title' => 'เข้าสู่ระบบ ' . $this->config->item('app_title'),
      'og:locale' => 'th_th',
      'og:description' => 'เข้าสู่ระบบ' . $this->config->item('app_description'),
      'og:image' => base_url() . 'assets/img/thumbnail.jpg',
      'og:image:width' => '560',
      'og:image:height' => '420',
      'og:type' => 'article',
    );
    $data = array(
      'title' => 'เข้าสู่ระบบ',
      'description' => 'เข้าสู่ระบบ',
      'keyword' => 'เข้าสู่ระบบ',
      'meta' => $meta,
      'css' => array(),
      'js' => array(),
    );
    $this->renderView('authen_login_view', $data);
  }

  public function doAuthen() {
    $tel = str_replace('+66', '0', $this->input->post('tel'));
    //        if ($tel == '0981816769') {
    //            $sessiondata = array(
    //                'doauthen' => true,
    //                'tel' => $tel
    //            );
    //            $this->session->set_userdata($sessiondata);
    //            redirect(base_url() . 'authen/otp');
    //        } else 
    if (!empty($tel)) {
      //check online status
      $onlines1 = $this->authen_model->getOnlineTel($tel);
      if ($onlines1->num_rows() == 1) {
        $online1 = $onlines1->row();
        if ($online1->online_status_id == 2) {
          $text = 'ผู้ใช้งานนี้ถูกระงับ !';
          $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
          redirect(base_url() . 'authen');
        }

        if ($online1->online_password != NULL) {
          $sessiondata = array(
            'doauthen' => true,
            'tel' => $tel
          );
          $this->session->set_userdata($sessiondata);
          redirect(base_url() . 'authen/password');
        }
      }

      //$this->db->trans_start();           
      $authens = $this->authen_model->getAuthen($tel);
      if ($authens->num_rows() > 0) {
        if ($authens->num_rows() == 1) {
          $authen = $authens->row();
          if ($authen->authen_status == 0) {
            if ($authen->authen_count >= 5) {
              $this->authen_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
              $text = 'เบอร์โทรของท่านถูกระงับ !';
              $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
              redirect(base_url() . 'authen');
            } else {
              $otp = $this->sendSMSOTP($tel);
              if ($otp != 0) {
                $this->authen_model->updateAuthen($authen->authen_id, array(
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
                redirect(base_url() . 'authen/otp');
              } else {
                $text = 'เบอร์โทรไม่ถูกต้อง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
              }
            }
          } else {
            $text = 'เบอร์โทรของท่านถูกระงับ !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
        } else {
          $authen = $authens->row();
          $this->authen_model->deleteAuthenID($authen->authen_id, $tel);
          if ($authen->authen_status == 0) {
            if ($authen->authen_count >= 5) {
              $this->authen_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
              $text = 'เบอร์โทรของท่านถูกระงับ !';
              $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
              redirect(base_url() . 'authen');
            } else {
              $otp = $this->sendSMSOTP($tel);
              if ($otp != 0) {
                $this->authen_model->updateAuthen($authen->authen_id, array(
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
                redirect(base_url() . 'authen/otp');
              } else {
                $text = 'เบอร์โทรไม่ถูกต้อง !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                redirect(base_url() . 'authen');
              }
            }
          } else {
            $text = 'เบอร์โทรของท่านถูกระงับ !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
        }
      } else {
        $onlines = $this->authen_model->getOnlineTel($tel);
        if ($onlines->num_rows() == 1) {
          $online = $onlines->row();
          if ($online->online_status_id != 2) {
            $otp = $this->sendSMSOTP($online->online_tel);
            if ($otp != 0) {
              $this->authen_model->addAuthen(array(
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
              redirect(base_url() . 'authen/otp');
            } else {
              $text = 'เบอร์โทรไม่ถูกต้อง !';
              $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
              redirect(base_url() . 'authen');
            }
          } else {
            $text = 'ผู้ใช้งานนี้ถูกระงับ !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
        } else {
          $otp = $this->sendSMSOTP($tel);
          if ($otp != 0) {
            $this->authen_model->addAuthen(array(
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
            redirect(base_url() . 'authen/otp');
          } else {
            $text = 'เบอร์โทรไม่ถูกต้อง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
        }
      }
      //$this->db->trans_complete();
    } else {
      redirect(base_url() . 'authen');
    }
  }

  public function otp() {
    $doauthen = $this->session->userdata('doauthen');
    $tel = $this->session->userdata('tel');
    //        if ($doauthen == true && $tel == '0981816769') {
    //            $meta = array(
    //                'og:site_name' => $this->config->item('app_title'),
    //                'og:url' => base_url() . 'authen/otp',
    //                'og:title' => 'ยืนยัน OTP ' . $this->config->item('app_title'),
    //                'og:locale' => 'th_th',
    //                'og:description' => 'ยืนยัน OTP' . $this->config->item('app_description'),
    //                'og:image' => base_url() . 'assets/img/thumbnail.jpg',
    //                'og:image:width' => '560',
    //                'og:image:height' => '420',
    //                'og:type' => 'article',
    //            );
    //            $data = array(
    //                'title' => 'ยืนยัน OTP',
    //                'description' => 'ยืนยัน OTP',
    //                'keyword' => 'ยืนยัน OTP',
    //                'meta' => $meta,
    //                'css' => array(),
    //                'js' => array(),
    //                'tel' => $tel
    //            );
    //            $this->renderView('authen_otp_view', $data);
    //        } else 
    if ($doauthen == true && $tel != '') {
      $authens = $this->authen_model->getAuthen($tel);
      if ($authens->num_rows() == 1) {
        $meta = array(
          'og:site_name' => $this->config->item('app_title'),
          'og:url' => base_url() . 'authen/otp',
          'og:title' => 'ยืนยัน OTP ' . $this->config->item('app_title'),
          'og:locale' => 'th_th',
          'og:description' => 'ยืนยัน OTP' . $this->config->item('app_description'),
          'og:image' => base_url() . 'assets/img/thumbnail.jpg',
          'og:image:width' => '560',
          'og:image:height' => '420',
          'og:type' => 'article',
        );
        $data = array(
          'title' => 'ยืนยัน OTP ' . $this->config->item('app_title'),
          'description' => 'ยืนยัน OTP' . $this->config->item('app_description'),
          'keyword' => 'ยืนยัน OTP, ' . $this->config->item('app_keyword'),
          'meta' => $meta,
          'css' => array(),
          'js' => array(),
          'tel' => $tel
        );
        $this->renderView('authen_otp_view', $data);
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

  public function doOTP() {
    $tel = str_replace('+66', '0', $this->input->post('tel'));
    $otp = $this->input->post('otp');
    if (!empty($tel) && !empty($otp) && $this->session->userdata('doauthen') == true) {
      $authens = $this->authen_model->getAuthen($tel);
      if ($authens->num_rows() == 1) {
        $authen = $authens->row();
        if ($authen->authen_otp == $otp) {
          if ($authen->authen_status == 0) {
            if ($authen->authen_otp_expire >= date('Y-m-d H:i:s')) {
              $this->authen_model->deleteAuthen($authen->authen_id);
              $datas = $this->authen_model->getOnlineTel($tel);
              if ($datas->num_rows() == 1) {
                //เบอร์เก่า
                $data = $datas->row();
                if ($data->online_status_id == 0) {
                  //ไม่มีในรายชื่อลูกค้า ไปสมัคร
                  $customershop = $this->authen_model->getCustomerShop($tel);
                  if ($customershop->num_rows() > 0) {
                    //ซิงข้อมูล (ลูกค้าเก่าคลินิค) 3
                    $this->authen_model->updateLoginCheck($data->online_id);
                    $this->authen_model->addLoginCheck($data->online_id, NULL);
                    $sessiondata = array(
                      'online_id' => $data->online_id
                    );
                    $this->session->set_userdata($sessiondata);
                    redirect(base_url() . 'register/sync');
                  } else {
                    //ไม่มีในรายชื่อลูกค้า ไม่ได้ซิงข้อมูล เช็คสถานะยืนยันข้อมูล 2
                    $this->authen_model->updateLoginCheck($data->online_id);
                    $this->authen_model->addLoginCheck($data->online_id, NULL);
                    $sessiondata = array(
                      'online_id' => $data->online_id
                    );
                    $this->session->set_userdata($sessiondata);
                    redirect(base_url() . 'register');
                  }
                } else if ($data->online_status_id == 1) {
                  //สมัครแล้ว 1
                  if ($data->online_password == NULL) {
                    //สร้างรหัสผ่าน
                    redirect(base_url() . 'authen/createpassword');
                  }

                  $this->session->unset_userdata('doauthen');
                  $this->session->unset_userdata('tel');
                  $this->session->unset_userdata('ref_online_id');

                  $this->authen_model->updateLoginCheck($data->online_id);
                  $this->authen_model->addLoginCheck($data->online_id, NULL);

                  $sessiondata = array(
                    'islogin' => 1,
                    'online_id' => $data->online_id,
                    'online_tel' => $data->online_tel,
                    'online_birthdate' => $data->online_birthdate,
                    'online_fname' => $data->online_fname,
                    'online_lname' => $data->online_lname,
                    'online_point' => $data->online_point,
                    'online_image' => $data->online_image != null ? $data->online_image : 'none.png'
                  );
                  $this->session->set_userdata($sessiondata);
                  redirect(base_url());
                } else {
                  $text = 'ผู้ใช้งานนี้ถูกระงับ !';
                  $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                  redirect(base_url() . 'authen');
                }
              } else {
                //เบอร์ใหม่
                $data = array(
                  'online_tel' => $tel,
                  'online_password' => NULL,
                  'online_status_id' => 0,
                  'online_create' => $this->misc->getdate(),
                  'online_update' => $this->misc->getdate()
                );
                $online_id = $this->authen_model->addOnline($data);
                $customershop = $this->authen_model->getCustomerShop($tel);
                if ($customershop->num_rows() > 0) {
                  //ซิงข้อมูล (ลูกค้าเก่าคลินิค) 3
                  $this->authen_model->updateLoginCheck($online_id);
                  $this->authen_model->addLoginCheck($online_id, NULL);
                  $sessiondata = array(
                    'online_id' => $online_id
                  );
                  $this->session->set_userdata($sessiondata);
                  redirect(base_url() . 'register/sync');
                } else {
                  //ไม่มีในรายชื่อลูกค้า ไปสมัคร 2
                  $this->authen_model->updateLoginCheck($online_id);
                  $this->authen_model->addLoginCheck($online_id, NULL);
                  $sessiondata = array(
                    'online_id' => $online_id
                  );
                  $this->session->set_userdata($sessiondata);
                  redirect(base_url() . 'register');
                }
              }
            } else {
              $this->authen_model->deleteAuthen($authen->authen_id);
              $text = 'OTP หมดอายุแล้ว !';
              $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
              redirect(base_url() . 'authen');
            }
          } else {
            $text = 'เบอร์โทรของท่านถูกระงับ !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
        } else {
          if ($authen->authen_count >= 5) {
            $this->authen_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
            $text = 'เบอร์โทรของท่านถูกระงับ !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          } else {
            $this->authen_model->updateAuthen($authen->authen_id, array('authen_count' => $authen->authen_count + 1));
            $text = 'OTP ไม่ถุกต้อง !';
            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
            redirect(base_url() . 'authen');
          }
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

  public function createPassword() {
    if ($this->session->userdata('islogin') == 1) {
      redirect(base_url() . 'profile');
    }
    $doauthen = $this->session->userdata('doauthen');
    $tel = $this->session->userdata('tel');
    if ($doauthen == true && $tel != '') {
      $onlines1 = $this->authen_model->getOnlineTel($tel);
      if ($onlines1->num_rows() == 1) {
        $online1 = $onlines1->row();
        if ($online1->online_password == NULL) {
          $meta = array(
            'og:site_name' => $this->config->item('app_title'),
            'og:url' => base_url() . 'authen',
            'og:title' => 'สร้างรหัสผ่าน ' . $this->config->item('app_title'),
            'og:locale' => 'th_th',
            'og:description' => 'สร้างรหัสผ่าน' . $this->config->item('app_description'),
            'og:image' => base_url() . 'assets/img/thumbnail.jpg',
            'og:image:width' => '560',
            'og:image:height' => '420',
            'og:type' => 'article',
          );
          $data = array(
            'title' => 'สร้างรหัสผ่าน',
            'description' => 'สร้างรหัสผ่าน',
            'keyword' => 'สร้างรหัสผ่าน',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
            'tel' => $tel
          );
          $this->renderView('authen_password_view', $data);
        } else {
          $text = 'กรุณาลองใหม่ ไม่พบรหัสผ่าน';
          $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
          redirect(base_url() . 'authen');
        }
      } else {
        $text = 'กรุณาลองใหม่ ไม่พบผู้ใช้งาน';
        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
        redirect(base_url() . 'authen');
      }
    } else {
      $text = 'กรุณาลองใหม่อีกครั้ง';
      $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
      redirect(base_url() . 'authen');
    }
  }

  public function doCreatePassword() {
    $doauthen = $this->session->userdata('doauthen');
    $tel = $this->session->userdata('tel');
    $password = trim($this->input->post('password'));

    if ($doauthen == true && $tel != '') {
      $datas = $this->authen_model->getOnlineTel($tel);
      if ($datas->num_rows() == 1) {
        $data = $datas->row();
        if ($data->online_status_id == 1) {
          $update = array(
            'online_password' => hash('sha256', $tel . $password),
            'online_update' => $this->libs->getDate()
          );
          $this->authen_model->updateOnline($data->online_id, $update);

          $this->session->unset_userdata('doauthen');
          $this->session->unset_userdata('tel');

          $sessiondata = array(
            'islogin' => 1,
            'online_id' => $data->online_id,
            'online_tel' => $data->online_tel,
            'online_birthdate' => $data->online_birthdate,
            'online_fname' => $data->online_fname,
            'online_lname' => $data->online_lname,
            'online_point' => $data->online_point,
            'online_image' => $data->online_image != null ? $data->online_image : 'none.png'
          );
          $this->session->set_userdata($sessiondata);
          redirect(base_url());
        } else {
          $text = 'ผิดพลาดสถานะผู้ใช้งาน !';
          $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
          redirect(base_url() . 'authen');
        }
      } else {
        $text = 'รหัสผ่านไม่ถูกต้อง !';
        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
        redirect(base_url() . 'authen');
      }
    } else {
      $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
      $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
      redirect(base_url() . 'authen');
    }
  }

  public function password() {
    if ($this->session->userdata('islogin') == 1) {
      redirect(base_url() . 'profile');
    }
    $doauthen = $this->session->userdata('doauthen');
    $tel = $this->session->userdata('tel');
    if ($doauthen == true && $tel != '') {
      $onlines1 = $this->authen_model->getOnlineTel($tel);
      if ($onlines1->num_rows() == 1) {
        $online1 = $onlines1->row();
        if ($online1->online_password != NULL) {
          $meta = array(
            'og:site_name' => $this->config->item('app_title'),
            'og:url' => base_url() . 'authen',
            'og:title' => 'เข้าสู่ระบบ ' . $this->config->item('app_title'),
            'og:locale' => 'th_th',
            'og:description' => 'เข้าสู่ระบบ' . $this->config->item('app_description'),
            'og:image' => base_url() . 'assets/img/thumbnail.jpg',
            'og:image:width' => '560',
            'og:image:height' => '420',
            'og:type' => 'article',
          );
          $data = array(
            'title' => 'เข้าสู่ระบบ',
            'description' => 'เข้าสู่ระบบ',
            'keyword' => 'เข้าสู่ระบบ',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
            'tel' => $tel
          );
          $this->renderView('authen_login_password_view', $data);
        } else {
          $text = 'กรุณาลองใหม่ ไม่พบรหัสผ่าน';
          $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
          redirect(base_url() . 'authen');
        }
      } else {
        $text = 'กรุณาลองใหม่ ไม่พบผู้ใช้งาน';
        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
        redirect(base_url() . 'authen');
      }
    } else {
      $text = 'กรุณาลองใหม่อีกครั้ง';
      $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
      redirect(base_url() . 'authen');
    }
  }

  public function doPassword() {
    $doauthen = $this->session->userdata('doauthen');
    $tel = $this->session->userdata('tel');
    $password = trim($this->input->post('password'));

    if ($doauthen == true && $tel != '') {
      $pass = hash('sha256', $tel . $password);
      $datas = $this->authen_model->getOnlineByTelPass($tel, $pass);
      if ($datas->num_rows() == 1) {
        $data = $datas->row();
        if ($data->online_status_id == 1) {
          $this->session->unset_userdata('doauthen');
          $this->session->unset_userdata('tel');

          $sessiondata = array(
            'islogin' => 1,
            'online_id' => $data->online_id,
            'online_tel' => $data->online_tel,
            'online_birthdate' => $data->online_birthdate,
            'online_fname' => $data->online_fname,
            'online_lname' => $data->online_lname,
            'online_point' => $data->online_point,
            'online_image' => $data->online_image != null ? $data->online_image : 'none.png'
          );
          $this->session->set_userdata($sessiondata);
          redirect(base_url());
        } else {
          $text = 'ผิดพลาดสถานะผู้ใช้งาน !';
          $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
          redirect(base_url() . 'authen');
        }
      } else {
        $text = 'รหัสผ่านไม่ถูกต้อง !';
        $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
        redirect(base_url() . 'authen');
      }
    } else {
      $text = 'ผิดพลาด ลองใหม่อีกครั้ง !';
      $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
      redirect(base_url() . 'authen');
    }
  }

  public function sendOTP() {
    $doauthen = $this->session->userdata('doauthen');
    $tel = str_replace('+66', '0', $this->input->post('tel'));
    if ($doauthen == true) {
      if (!empty($tel)) {
        $authens = $this->authen_model->getAuthen($tel);
        if ($authens->num_rows() > 0) {
          if ($authens->num_rows() == 1) {
            $authen = $authens->row();
            if ($authen->authen_status == 0) {
              if ($authen->authen_count >= 5) {
                $this->authen_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                $text = 'เบอร์โทรของท่านถูกระงับ !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                $status = false;
              } else {
                $otp = $this->sendSMSOTP($tel);
                if ($otp != 0) {
                  $this->authen_model->updateAuthen($authen->authen_id, array(
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
            $this->authen_model->deleteAuthenID($authen->authen_id, $tel);
            if ($authen->authen_status == 0) {
              if ($authen->authen_count >= 5) {
                $this->authen_model->updateAuthen($authen->authen_id, array('authen_status' => 1));
                $text = 'เบอร์โทรของท่านถูกระงับ !';
                $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
                $status = false;
              } else {
                $otp = $this->sendSMSOTP($tel);
                if ($otp != 0) {
                  $this->authen_model->updateAuthen($authen->authen_id, array(
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
          $onlines = $this->authen_model->getOnlineTel($tel);
          if ($onlines->num_rows() == 1) {
            $online = $onlines->row();
            if ($online->online_status_id != 2) {
              $otp = $this->sendSMSOTP($online->online_tel);
              if ($otp != 0) {
                $this->authen_model->addAuthen(array(
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
            if ($otp != 0) {
              $this->authen_model->addAuthen(array(
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
    $shop_id_pri = 1;
    $this->systemlog->log_send_sms_online($tel, 1);
    $shop = $this->setting_model->getShop($shop_id_pri)->row();
    $data_shop = array(
      'shop_sms_sum' => $shop->shop_sms_sum + 1,
      'shop_sms_all' => $shop->shop_sms_all - 1,
    );
    $this->setting_model->updateShop($shop_id_pri, $data_shop);
    $this->systemlog->log_sms_credit('- ลบเครดิต 1 (Web App)', $shop_id_pri);
    return $otp;
    // } else {
    //     return 0;
    // }
  }

  //    public function doLoginFacebook() {
  //        $facebook_id = $this->input->post('facebook_id');
  //        $facebook_email = $this->input->post('facebook_email');
  //
  //        $onlines = $this->authen_model->getOnlineFB($facebook_id, $facebook_email);
  //        if ($onlines->num_rows() == 1) {
  //            $online = $onlines->row();
  //
  //            $this->session->unset_userdata('doauthen');
  //            $this->session->unset_userdata('tel');
  //            $this->session->unset_userdata('ref_online_id');
  //
  //            $this->authen_model->updateLoginCheck($online->online_id);
  //            $this->authen_model->addLoginCheck($online->online_id, NULL);
  //            $row = $online;
  //            $sessiondata = array(
  //                'islogin' => 1,
  //                'online_id' => $row->online_id,
  //                'online_tel' => $row->online_tel,
  //                'online_birthdate' => $row->online_birthdate,
  //                'online_fname' => $row->online_fname,
  //                'online_lname' => $row->online_lname,
  //                'online_point' => $row->online_point,
  //                'online_image' => $row->online_image != null ? $row->online_image : 'none.png'
  //            );
  //            $this->session->set_userdata($sessiondata);
  //            redirect(base_url());
  //        } else {
  //            $text = 'ไม่สามารถเข้าผ่าน Facebook ได้';
  //            $this->session->set_flashdata('flash_message_form', '<div class="col-lg-12" style="padding: 7px; font-size: 14px; border: 2px solid #f77474;"><i class="fa fa-times-circle" style="color: #D33E3E;"></i>&nbsp;' . $text . '</div>');
  //            redirect(base_url() . 'authen');
  //        }
  //    }
  //    public function Login() {
  //        $row = $this->authen_model->getOnlineByID(1)->row();
  //        $sessiondata = array(
  //            'islogin' => 1,
  //            'online_id' => $row->online_id,
  //            'online_tel' => $row->online_tel,
  //            'online_birthdate' => $row->online_birthdate,
  //            'online_fname' => $row->online_fname,
  //            'online_lname' => $row->online_lname,
  //            'online_point' => $row->online_point,
  //            'online_image' => $row->online_image != null ? $row->online_image : 'none.png'
  //        );
  //        $this->session->set_userdata($sessiondata);
  //        redirect(base_url());
  //    }

  public function Logout() {
    $this->session->unset_userdata(array('islogin', 'online_id', 'online_tel', 'online_birthdate', 'online_fname', 'online_lname', 'online_point', 'online_image'));
    redirect(base_url() . 'authen');
  }
}
