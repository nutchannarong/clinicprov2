<?php

class Opdcard_model extends CI_Model {

  public function countPagination($filter) {
    $this->db->select('customer.customer_id_pri');
    $this->db->from('customer');
    $this->db->join('opd', 'opd.customer_id_pri = customer.customer_id_pri');
    $this->db->join('order', 'order.opd_id = opd.opd_id');
    $this->db->join('shop', 'order.shop_id_pri = shop.shop_id_pri');
    $this->db->join('user', 'opd.user_id = user.user_id');
    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                opd.opd_code LIKE '%" . $filter['searchtext'] . "%' OR 
                user.user_fullname LIKE '%" . $filter['searchtext'] . "%' OR 
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }
    $this->db->where("order.order_status_id", 1);
    $this->db->where('opd.opd_status_id', 6);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('customer.customer_status_id', 1);

    return $this->db->get()->num_rows();
  }

  public function getPagination($filter, $params = array()) {
    $this->db->select('*');
    $this->db->from('customer');
    $this->db->join('opd', 'opd.customer_id_pri = customer.customer_id_pri');
    $this->db->join('order', 'order.opd_id = opd.opd_id');
    $this->db->join('shop', 'order.shop_id_pri = shop.shop_id_pri');
    $this->db->join('user', 'opd.user_id = user.user_id');
    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                opd.opd_code LIKE '%" . $filter['searchtext'] . "%' OR 
                user.user_fullname LIKE '%" . $filter['searchtext'] . "%' OR 
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }
    $this->db->where("order.order_status_id", 1);
    $this->db->where('opd.opd_status_id', 6);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('customer.customer_status_id', 1);

    if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit'], $params['start']);
    } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit']);
    }
    $this->db->order_by('opd.opd_date', 'DESC');
    return $this->db->get();
  }

  public function getOpdChecking($opd_id) {
    $this->db->select('*');
    $this->db->from('opdchecking');
    $this->db->where('opdchecking.opd_id', $opd_id);
    $this->db->order_by('opdchecking.opdchecking_id');
    return $this->db->get();
  }

  public function getOrderDetail($order_id_pri = null, $orderdetail_type_id = null) {
    $this->db->select('*');
    $this->db->from('orderdetail');
    if ($order_id_pri != null) {
      $this->db->where('orderdetail.order_id_pri', $order_id_pri);
    }
    if ($orderdetail_type_id != null) {
      $this->db->where('orderdetail.orderdetail_type_id', $orderdetail_type_id);
    }
    $this->db->order_by('orderdetail.orderdetail_id_pri');
    return $this->db->get();
  }

  public function getOpdUpload($opd_id, $opdupload_type) {
    $this->db->select('*');
    $this->db->from('opdupload');
    $this->db->where('opdupload.opd_id', $opd_id);
    $this->db->where('opdupload.opdupload_type', $opdupload_type);
    $this->db->order_by('opdupload_sort');
    return $this->db->get();
  }

  // opd detail modal
  public function get_opdold($opd_id) {
    $this->db->select('*');
    $this->db->from('opd');
    $this->db->join('order', 'order.opd_id = opd.opd_id');
    $this->db->where('opd.opd_id', $opd_id);
    $this->db->where('opd.opd_status_id', 6);
    $this->db->where('order.order_status_id', 1);
    $this->db->order_by('opd.opd_date');
    return $this->db->get();
  }

  public function get_opdoldorderdetail($order_id_pri = null, $orderdetail_type_id = null) {
    $this->db->select('*');
    $this->db->from('orderdetail');
    if ($order_id_pri != null) {
      $this->db->where('orderdetail.order_id_pri', $order_id_pri);
    }
    if ($orderdetail_type_id != null) {
      $this->db->where('orderdetail.orderdetail_type_id', $orderdetail_type_id);
    }
    $this->db->order_by('orderdetail.orderdetail_id_pri');
    return $this->db->get();
  }

  public function get_opdolduser($opd_id) {
    $this->db->select('*');
    $this->db->from('opd');
    $this->db->join('user', 'opd.user_id = user.user_id');
    $this->db->where('opd.opd_id', $opd_id);
    $this->db->limit(1);
    return $this->db->get();
  }

  public function get_opdoldcustomer($customer_id_pri = null) {
    $this->db->select('*');
    $this->db->from('customer');
    $this->db->where('customer.customer_id_pri', $customer_id_pri);
    return $this->db->get();
  }

  public function get_opdoldshop($shop_id_pri) {
    $this->db->where('shop_id_pri', $shop_id_pri);
    $this->db->limit(1);
    return $this->db->get('shop')->row();
  }

  public function getuser($user_id = null) {
    $this->db->select('*');
    $this->db->from('user');
    if ($user_id != NULL) {
      $this->db->where('user.user_id', $user_id);
      $this->db->limit(1);
    } else {
      $this->db->where('user.user_status_id', 1);
    }
    return $this->db->get();
  }

  public function get_opdchecking($opd_id = null) {
    $this->db->select('*');
    $this->db->from('opdchecking');
    if ($opd_id != '') {
      $this->db->where('opdchecking.opd_id', $opd_id);
    }
    $this->db->order_by('opdchecking.opdchecking_id');
    return $this->db->get();
  }

  public function getOnlineByID($online_id) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $online_id);
    return $this->db->get();
  }
}
