<?php

class Register_model extends CI_Model {

  public function getOnlineTel($online_tel) {
    $this->db->select('online.online_id,online.online_tel,online.online_status_id');
    $this->db->from('online');
    $this->db->where('online.online_tel', $online_tel);
    $this->db->where('online.shop_id_pri IS NULL');
    return $this->db->get();
  }

  public function updateOnline($id, $data) {
    $this->db->where('online.online_id', $id);
    $this->db->update('online', $data);
  }

  public function updateCustomer($id, $data) {
    $this->db->where('customer.customer_id_pri', $id);
    $this->db->update('customer', $data);
  }

  public function getCustomer($id) {
    $this->db->select('*');
    $this->db->from('customer');
    $this->db->where('customer_id_pri', $id);
    return $this->db->get();
  }

  public function getOnline($online_id) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $online_id);
    $this->db->where('online.shop_id_pri IS NULL');
    return $this->db->get();
  }

  public function getCustomerShop($customer_tel) {
    $this->db->select('shop.shop_id,shop.shop_id_pri,shop.shop_name,shop.shop_nature,shop.shop_license,shop.shop_province,shop.shop_image,customer.customer_id_pri,customer.customer_fname,customer.customer_lname');
    $this->db->from('customer');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->where('customer.customer_tel', $customer_tel);
    $this->db->where('customer.customer_status_id', 1);
    $this->db->where('shop.shop_status_id', 1);
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
}
