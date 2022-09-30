<?php

class Auth {

    public function __construct() {
        $CI = & get_instance();
        if ($CI->session->userdata('lang') == '' || $CI->session->userdata('lang') == NULL) {
            $sessiondata = array(
                'lang' => 'th'
            );
            $CI->session->set_userdata($sessiondata);
        }
    }

    public function isLogin() {
        $CI = & get_instance();
        if ($CI->session->userdata('islogin') != 1) {
            redirect(base_url() . 'login');
        }
    }

}
