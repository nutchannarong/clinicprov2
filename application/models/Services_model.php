<?php

/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */
class Services_model extends CI_Model {

  public function countPagination($filter) {
    $this->db->select('customer.customer_id_pri');
    $this->db->from('customer');
    //$this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
    $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->where_in("serving.serving_status_id", array(1, 2));
    //$this->db->where('serving.serving_status_id !=', 0);
    $this->db->where('order.order_status_id', 1);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('customer.customer_status_id', 1);
    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%' OR 
                course.course_id LIKE '%" . $filter['searchtext'] . "%' OR 
                course.course_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }
    $this->db->group_by('course.course_id_pri');
    return $this->db->get()->num_rows();
  }

  public function getPagination($filter, $params = array()) {
    $this->db->select('*');
    $this->db->from('customer');
    //$this->db->join('online', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
    $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->where_in("serving.serving_status_id", array(1, 2));
    //$this->db->where('serving.serving_status_id !=', 0);
    $this->db->where('order.order_status_id', 1);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('customer.customer_status_id', 1);
    if ($filter['searchtext'] != '') {
      $this->db->where(" (
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%' OR 
                course.course_id LIKE '%" . $filter['searchtext'] . "%' OR 
                course.course_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
    }
    $this->db->group_by('course.course_id_pri');

    if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit'], $params['start']);
    } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
      $this->db->limit($params['limit']);
    }
    $this->db->order_by('serving.course_id_pri');
    return $this->db->get();
  }

  public function countServiceTotal($customer_id_pri, $course_id_pri) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->join('customer', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
    $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->where("serving.serving_status_id !=", 0);
    $this->db->where('order.order_status_id', 1);
    $this->db->where('customer.customer_id_pri', $customer_id_pri);
    $this->db->where('course.course_id_pri', $course_id_pri);
    return $this->db->get();
  }

  public function countServiceWait($customer_id_pri, $course_id_pri) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->join('customer', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
    $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->where_in("serving.serving_status_id", array(1, 2));
    $this->db->where('order.order_status_id', 1);
    $this->db->where('customer.customer_id_pri', $customer_id_pri);
    $this->db->where('course.course_id_pri', $course_id_pri);
    return $this->db->get();
  }

  public function countServiceSuccess($customer_id_pri, $course_id_pri) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->join('customer', 'customer.online_id = online.online_id');
    $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
    $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
    $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->where("serving.serving_status_id", 3);
    $this->db->where('order.order_status_id', 1);
    $this->db->where('customer.customer_id_pri', $customer_id_pri);
    $this->db->where('course.course_id_pri', $course_id_pri);
    return $this->db->get();
  }

  public function getUser($user_id = null) {
    $this->db->select('*');
    $this->db->from('user');
    if ($user_id != NULL) {
      $this->db->where('user.user_id', $user_id);
    }
    return $this->db->get();
  }

  public function getServe($serve_id = null) {
    $this->db->select('*');
    $this->db->from('serve');
    if ($serve_id != NULL) {
      $this->db->where('serve.serve_id', $serve_id);
    }
    return $this->db->get();
  }

  public function get_serving($course_id_pri, $serving_status_id = null) {
    $this->db->select('*');
    $this->db->from('serving');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->join('order', 'serving.order_id_pri = order.order_id_pri');
    $this->db->join('customer', 'serving.customer_id_pri = customer.customer_id_pri');
    $this->db->where('order.order_status_id', 1);
    $this->db->where('course.course_id_pri', $course_id_pri);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    if ($serving_status_id != NULL) {
      if ($serving_status_id == 1) {
        //$this->db->where('serving.serving_status_id <=', 2);
        $this->db->where('serving.serving_status_id', 1);
      } elseif ($serving_status_id == 3) {
        $this->db->where('serving.serving_status_id', 3);
      }
    }
    $this->db->where('serving.serving_status_id !=', 0);
    $data = date('Y-m-d');
    $this->db->where("(serving.serving_end > '$data' OR serving.serving_end` IS NULL)");
    $this->db->order_by('serving.serving_modify');
    return $this->db->get();
  }

  public function sum_servingdetail_book_customer($course_id_pri) {
    $this->db->select('sum(servingdetail_book.servingdetail_book_amount) AS servingdetail_book_amount');
    $this->db->from('servingdetail_book');
    $this->db->join('customer', 'servingdetail_book.customer_id_pri = customer.customer_id_pri');
    $this->db->join('course', 'servingdetail_book.course_id_pri = course.course_id_pri');
    $this->db->where('servingdetail_book.course_id_pri', $course_id_pri);
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->group_by('servingdetail_book.serving_id,servingdetail_book.course_id_pri');
    $this->db->having('sum(servingdetail_book.servingdetail_book_amount) = 0');
    return $this->db->get();
  }

  public function sum_servingdetail_book($serving_id) {
    $this->db->select('sum(servingdetail_book.servingdetail_book_amount) AS servingdetail_book_amount');
    $this->db->from('servingdetail_book');
    $this->db->where('servingdetail_book.serving_id', $serving_id);
    return $this->db->get();
  }

  public function getserving($serving_id = null) {
    $this->db->select('*');
    $this->db->from('serving');
    if ($serving_id != NULL) {
      $this->db->where('serving.serving_id', $serving_id);
    }
    return $this->db->get();
  }

  public function getcustomer($customer_id_pri = null) {
    $this->db->select('*');
    $this->db->from('customer');
    if ($customer_id_pri != NULL) {
      $this->db->where('customer.customer_id_pri', $customer_id_pri);
    }
    return $this->db->get();
  }

  public function get_serve_id($serve_id = null) {
    $this->db->select('*');
    $this->db->from('serve');
    if ($serve_id != '') {
      $this->db->where('serve.serve_id', $serve_id);
      $this->db->limit(1);
    }
    return $this->db->get();
  }

  public function getservingdetailbook($serving_id = null) {
    $this->db->select('*');
    $this->db->from('servingdetail_book');
    $this->db->join('drug', 'servingdetail_book.drug_id_pri = drug.drug_id_pri');
    if ($serving_id != NULL) {
      $this->db->where('servingdetail_book.serving_id', $serving_id);
    }
    return $this->db->get();
  }

  public function sumservingdetailbook($servingdetail_book_id) {
    $this->db->select('IFNULL(Sum(servingdrug.servingdrug_drug_amount),0) AS servingdrug_drug_amount');
    $this->db->from('servingdetail_book');
    $this->db->join('servingdrug', 'servingdrug.servingdetail_book_id = servingdetail_book.servingdetail_book_id');
    $this->db->where('servingdetail_book.servingdetail_book_id', $servingdetail_book_id);
    return $this->db->get();
  }

  public function getservingdrug($serving_id = null) {
    $this->db->select('*');
    $this->db->from('servingdrug');
    $this->db->join('drug', 'servingdrug.drug_id_pri = drug.drug_id_pri');
    if ($serving_id != NULL) {
      $this->db->where('servingdrug.serving_id', $serving_id);
    }
    return $this->db->get();
  }

  public function countservingdrug($servingdetail_book_id, $serving_id) {
    $this->db->select('IFNULL(Sum(servingdrug.servingdrug_drug_amount),0) AS servingdrug_drug_amount');
    $this->db->from('servingdrug');
    $this->db->where('servingdrug.servingdetail_book_id', $servingdetail_book_id);
    $this->db->where('servingdrug.serving_id', $serving_id);
    return $this->db->get();
  }

  public function getOnlineByID($online_id) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $online_id);
    return $this->db->get();
  }
}
