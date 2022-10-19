<?php

class Appoint_model extends CI_Model {

  //put your code here

  public function getAppoint($appoint_id_pri = null) {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->join('customer', 'appoint.customer_id_pri = customer.customer_id_pri');
    $this->db->join('user', 'appoint.user_id = user.user_id');
    $this->db->join('shop', 'appoint.shop_id_pri = shop.shop_id_pri');
    if ($appoint_id_pri != NULL) {
      $this->db->where('appoint.appoint_id_pri', $appoint_id_pri);
      $this->db->limit(1);
    }
    return $this->db->get();
  }

  public function getAppointByTel() {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->join('customer', 'appoint.customer_id_pri = customer.customer_id_pri');
    //$this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('user', 'appoint.user_id = user.user_id');
    //$this->db->where('online.online_id', $online_id);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('shop.shop_status_id', 1);
    $this->db->where('customer.customer_status_id', 1);
    $this->db->order_by('FIELD(appoint.appoint_status_id,1,2,0)');
    $this->db->order_by('appoint.appoint_date', 'DESC');
    $this->db->order_by('appoint.appoint_start', 'DESC');
    return $this->db->get();
  }

  public function countPagination($filter) {
    $this->db->select('appoint.appoint_id_pri');
    $this->db->from('appoint');
    $this->db->join('customer', 'appoint.customer_id_pri = customer.customer_id_pri');
    //$this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('user', 'appoint.user_id = user.user_id');
    //$this->db->where('online.online_id', $online_id);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('shop.shop_status_id', 1);
    $this->db->where('customer.customer_status_id', 1);

    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                appoint.appoint_id_pri LIKE '%" . $filter['searchtext'] . "%' OR 
                appoint.appoint_topic LIKE '%" . $filter['searchtext'] . "%' OR
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%' OR 
                user.user_fullname LIKE '%" . $filter['searchtext'] . "%' OR 
                appoint.appoint_tel LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }

    return $this->db->get()->num_rows();
  }

  public function getPagination($filter, $params = array()) {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->join('customer', 'appoint.customer_id_pri = customer.customer_id_pri');
    //$this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('user', 'appoint.user_id = user.user_id');
    //$this->db->where('online.online_id', $online_id);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('shop.shop_status_id', 1);
    $this->db->where('customer.customer_status_id', 1);

    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                appoint.appoint_id_pri LIKE '%" . $filter['searchtext'] . "%' OR 
                appoint.appoint_topic LIKE '%" . $filter['searchtext'] . "%' OR
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%' OR 
                user.user_fullname LIKE '%" . $filter['searchtext'] . "%' OR 
                appoint.appoint_tel LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }

    if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit'], $params['start']);
    } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit']);
    }
    $this->db->order_by('FIELD(appoint.appoint_status_id,1,2,0)');
    $this->db->order_by('appoint.appoint_date', 'DESC');
    $this->db->order_by('appoint.appoint_start', 'DESC');
    return $this->db->get();
  }

  public function getChartBot() {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->join('chatbot', 'chatbot.online_id = `online`.online_id');
    $this->db->join('shop', 'chatbot.shop_id_pri = shop.shop_id_pri');
    $this->db->where('online.online_id', $this->session->userdata('online_id'));
    $this->db->where('chatbot.chatbot_status_id', 1);
    $this->db->where('chatbot.chatbot_active_id', 1);
    $this->db->where('shop.shop_status_id', 1);
    $this->db->order_by('chatbot.chatbot_create', 'DESC');
    return $this->db->get();
  }

  public function getAppointShop() {
    $this->db->select('*');
    $this->db->from('customer');
    //        $this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    //        $this->db->where('online.online_id', $online_id);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('shop.shop_status_id', 1);
    $this->db->where('shop.shop_proactive_id', 1);
    $this->db->where('customer.customer_status_id', 1);
    $this->db->where('customer.online_id IS NOT NULL');
    $this->db->group_by('shop.shop_id_pri');
    $this->db->order_by('shop.shop_name');
    return $this->db->get();
  }

  public function getOnline() {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $this->session->userdata('online_id'));
    return $this->db->get();
  }

  public function getCustomer($customer_tel, $shop_id_pri) {
    $this->db->select('*');
    $this->db->from('customer');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->where('customer.customer_tel', $customer_tel);
    $this->db->where('customer.customer_status_id', 1);
    $this->db->where('shop.shop_id_pri', $shop_id_pri);
    $this->db->limit(1);
    return $this->db->get();
  }

  // action

  public function addAppoint($data) {
    $this->db->insert('appoint', $data);
  }

  public function updateAppoint($appoint_id_pri, $data) {
    $this->db->where('appoint.appoint_id_pri', $appoint_id_pri);
    $this->db->update('appoint', $data);
  }

  public function getdoctor($shop_id_pri, $user_id = null) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user.shop_id_pri', $shop_id_pri);
    $this->db->where('user.role_id !=', 2);
    $this->db->where('user.role_id !=', 4);
    if ($user_id != null) {
      $this->db->where('user.user_id', $user_id);
      $this->db->limit(1);
    } else {
      $this->db->where('user.user_status_id', 1);
    }
    return $this->db->get();
  }

  public function getdoctorappoint($shop_id_pri) {
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user.shop_id_pri', $shop_id_pri);
    $this->db->where('user.role_id !=', 2);
    $this->db->where('user.role_id !=', 4);
    $this->db->where('user.user_status_id', 1);
    $this->db->where('user.user_appoint_id', 1);
    return $this->db->get();
  }

  public function getsection($shop_id_pri, $section_id = null) {
    $this->db->select('*');
    $this->db->from('section');
    $this->db->where('section.shop_id_pri', $shop_id_pri);
    if ($section_id != null) {
      $this->db->where('section.section_id', $section_id);
      $this->db->limit(1);
    } else {
      $this->db->where('section.section_status_id', 1);
    }
    $this->db->order_by('section.section_sort');
    return $this->db->get();
  }

  public function checkAppointDoctor($shop_id_pri, $user_id, $appoint_date, $appoint_start) {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->where('appoint.shop_id_pri', $shop_id_pri);
    $this->db->where('appoint.user_id', $user_id);
    $this->db->where('appoint.appoint_date', $appoint_date);
    $this->db->where('appoint.appoint_start', $appoint_start);
    $this->db->where('appoint.appoint_status_id !=', 0);
    return $this->db->get();
  }

  public function checkAppointCustomer($shop_id_pri, $appoint_date, $customer_id_pri) {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->where('appoint.shop_id_pri', $shop_id_pri);
    $this->db->where('appoint.appoint_date', $appoint_date);
    $this->db->where('appoint.customer_id_pri', $customer_id_pri);
    $this->db->where('appoint.appoint_status_id', 1);
    return $this->db->get();
  }

  public function checkAppointCustomerTime($shop_id_pri, $appoint_date, $appoint_start, $customer_id_pri) {
    $this->db->select('*');
    $this->db->from('appoint');
    $this->db->where('appoint.shop_id_pri', $shop_id_pri);
    $this->db->where('appoint.appoint_date', $appoint_date);
    $this->db->where('appoint.appoint_start', $appoint_start);
    $this->db->where('appoint.customer_id_pri', $customer_id_pri);
    $this->db->where('appoint.appoint_status_id !=', 0);
    return $this->db->get();
  }

  public function checkSectionday($day, $user_id) {
    $this->db->select('*');
    $this->db->from('user_sectionday_map');
    //$this->db->join('sectionday', 'user_sectionday_map.sectionday_id = sectionday.sectionday_id');
    $this->db->where('user_sectionday_map.sectionday_id', $day);
    $this->db->where('user_sectionday_map.user_id', $user_id);
    return $this->db->get();
  }

  public function checkSection($time, $user_id) {
    $this->db->select('*');
    $this->db->from('section');
    $this->db->join('user_section_map', 'user_section_map.section_id = section.section_id');
    //$this->db->where('section.shop_id_pri', $this->session->userdata('shop_id_pri'));
    $this->db->where('section.section_time', $time);
    $this->db->where('user_section_map.user_id', $user_id);
    $this->db->where('section.section_status_id', 1);
    return $this->db->get();
  }

  public function getspecialized($specialized_id) {
    $this->db->select('*');
    $this->db->from('specialized');
    $this->db->where('specialized.specialized_id', $specialized_id);
    return $this->db->get();
  }

  public function getOnlineByID($online_id) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $online_id);
    return $this->db->get();
  }
}
