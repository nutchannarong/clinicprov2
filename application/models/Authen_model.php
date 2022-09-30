<?php

class Authen_model extends CI_Model {

    public function getOnlineTel($online_tel) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_tel', $online_tel);
        $this->db->where('online.shop_id_pri IS NULL');
        return $this->db->get();
    }

    public function getOnlineByTelPass($tel, $pass) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_tel', $tel);
        $this->db->where('online.online_password', $pass);
        $this->db->where('online.shop_id_pri IS NULL');
        return $this->db->get();
    }

    public function getOnlineFB($facebook_id, $online_email) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.facebook_id', $facebook_id);
        $this->db->where('online.online_email', $online_email);
        $this->db->where('online.shop_id_pri IS NULL');
        return $this->db->get();
    }

    public function getAuthen($authen_tel) {
        $this->db->from('authen');
        $this->db->where('authen.authen_tel', $authen_tel);
        $this->db->order_by('authen.authen_id');
        return $this->db->get();
    }

    public function addAuthen($data) {
        $this->db->insert('authen', $data);
        return $this->db->insert_id();
    }

    public function updateAuthen($authen_id, $data) {
        $this->db->where('authen.authen_id', $authen_id);
        $this->db->update('authen', $data);
    }

    public function deleteAuthen($authen_id) {
        $this->db->where('authen.authen_id', $authen_id);
        $this->db->delete('authen');
    }

    public function deleteAuthenID($authen_id, $tel) {
        $this->db->where('authen.authen_id !=', $authen_id);
        $this->db->where('authen.authen_tel', $tel);
        $this->db->delete('authen');
    }

    public function addOnline($data) {
        $this->db->insert('online', $data);
        return $this->db->insert_id();
    }

    public function updateOnline($id, $data) {
        $this->db->where('online.online_id', $id);
        $this->db->update('online', $data);
    }

    public function getCustomer($online_id) {
        $this->db->from('customer');
        $this->db->where('customer.online_id', $online_id);
        $this->db->where('customer.online_id IS NOT NULL');
        $this->db->where('customer.customer_status_id', 1);
        return $this->db->get();
    }

    public function getCustomerShop($customer_tel) {
        $this->db->select('shop.shop_id_pri,shop.shop_name,shop.shop_nature,shop.shop_license,shop.shop_province,customer.customer_id_pri');
        $this->db->from('customer');
        $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
        $this->db->where('customer.customer_tel', $customer_tel);
        $this->db->where('customer.customer_status_id', 1);
        $this->db->where('shop.shop_status_id', 1);
        return $this->db->get();
    }

    public function checkLogin($online_id) {
        $this->db->select('authen_check_login.login_id');
        $this->db->from('authen_check_login');
        $this->db->where('authen_check_login.online_id', $online_id);
        $this->db->where('authen_check_login.status_id', 1);
        return $this->db->get()->num_rows();
    }

    //------ add Login Check-----------------
    public function addLoginCheck($online_id, $token) {
        $data = array(
            'online_id' => $online_id,
            'log_ip_address' => $this->input->ip_address(),
            'log_browser' => $this->getAgent(),
            'token' => $token,
            'status_id' => 1,
            'login_last_time' => $this->misc->getDate()
        );
        $this->db->insert('authen_check_login', $data);
    }

    //------ update Login Check-----------------
    public function updateLoginCheck($online_id) {
        $data = array(
            'status_id' => 0,
        );
        $this->db->where('authen_check_login.online_id', $online_id);
        $this->db->update('authen_check_login', $data);
    }

    public function getOnlineByID($online_id) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $online_id);
        $this->db->where('online.shop_id_pri IS NULL');
        return $this->db->get();
    }

    public function getAgent() {
        $this->load->library('user_agent');
        $agent = $this->agent->browser() . '/' . $this->agent->version();
        $agent = $agent . ' ' . $this->agent->platform();
        $agent = $agent . ' ' . $this->agent->mobile();
        return $agent;
    }

}
