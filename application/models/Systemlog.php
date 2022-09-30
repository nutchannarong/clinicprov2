<?php

/*
 * Class name : Systemlog
 * Author : Sakchai Kantada
 * Mail : sakchaiwebmaster@gmail.com
 */

class Systemlog extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->logs = $this->load->database('logs', TRUE);
    }

    public function addCustomerLogin($customer_id, $text) {
        $data = array(
            'admin_id' => NULL,
            'customer_id' => $customer_id,
            'log_text' => $text,
            'log_ip_address' => $this->input->ip_address(),
            'log_browser' => $this->getAgent(),
            'log_time' => $this->libs->getDate()
        );
        $this->logs->insert('log_customer_login', $data);
    }

    public function log_send_sms($text) {
        $data = array(
            'log_text' => $text,
            'log_time' => $this->libs->getDate()
        );
        $this->logs->insert('log_send_sms', $data);
    }

    public function log_send_email($text) {
        $data = array(
            'log_text' => $text,
            'log_time' => $this->libs->getDate()
        );
        $this->logs->insert('log_send_email', $data);
    }

    public function log_send_line($text) {
        $data = array(
            'log_text' => $text,
            'log_time' => $this->libs->getDate()
        );
        $this->logs->insert('log_send_line', $data);
    }

    public function getConfig() {
        $this->db->limit(1);
        return $this->db->get('config')->row();
    }

    public function getAgent() {
        $this->load->library('user_agent');
        $agent = $this->agent->browser() . '/' . $this->agent->version();
        $agent = $agent . ' ' . $this->agent->platform();
        $agent = $agent . ' ' . $this->agent->mobile();
        return $agent;
    }

    public function log_sms_credit($text, $shop_id_pri) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_sms_credit', $data);
    }

    public function log_send_sms_online($tel, $status) {
        $data = array(
            'log_tel' => $tel,
            'log_status_id' => $status,
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_send_sms_online', $data);
    }

    //log
    public function log_order($text, $shop_id_pri, $user_id) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'user_id' => $user_id,
            'log_ip_address' => $this->input->ip_address(),
            'log_browser' => $this->getAgent(),
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_order', $data);
    }

    public function log_orderpay($text, $shop_id_pri, $user_id) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'user_id' => $user_id,
            'log_ip_address' => $this->input->ip_address(),
            'log_browser' => $this->getAgent(),
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_orderpay', $data);
    }

    public function log_pointonline($text, $shop_id_pri, $online_id, $log_type, $log_point_last, $log_point, $log_point_balance) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'online_id' => $online_id,
            'log_type' => $log_type,
            'log_point_last' => $log_point_last,
            'log_point' => $log_point,
            'log_point_balance' => $log_point_balance,
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_pointonline', $data);
    }

    public function log_serving($text, $shop_id_pri, $user_id) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'user_id' => $user_id,
            'log_ip_address' => $this->input->ip_address(),
            'log_browser' => $this->getAgent(),
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_serving', $data);
    }

    public function log_bank($text, $shop_id_pri, $user_id, $shop_bank_id) {
        $data = array(
            'log_text' => $text,
            'shop_id_pri' => $shop_id_pri,
            'user_id' => $user_id,
            'shop_bank_id' => $shop_bank_id,
            'log_time' => $this->misc->getDate()
        );
        $this->logs->insert('log_bank', $data);
    }

}
