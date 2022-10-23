<?php

class Servingreview_model extends CI_Model {

  public function getPagination($filter, $params = array()) {
    if (empty($params)) {
      $this->db->select('servingreview.servingreview_id');
    } else {
      $this->db->select('
                servingreview.servingreview_id,
                servingreview.servingreview_image,
                servingreview.servingreview_comment,
                servingreview.servingreview_comment_date,
                servingreview.servingreview_reply,
                servingreview.servingreview_reply_date,
                servingreview.servingreview_rating,
                servingreview.servingreview_point,
                servingreview.servingreview_status_id,
                serving.serve_id,
                serve.serve_code,
                serving.serving_name,
                course.course_name,
                serving.serving_date
            ');
    }
    $this->db->from('servingreview');
    $this->db->join('serving', 'serving.serving_id = servingreview.serving_id');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->join('customer', 'customer.customer_id_pri = serving.customer_id_pri');
    $this->db->join('serve', 'serving.serve_id = serve.serve_id');
    if ($filter['searchtext'] != '') {
      $this->db->where("(
                serving.serve_id LIKE '%" . $filter['searchtext'] . "%' OR
                serve.serve_code LIKE '%" . $filter['searchtext'] . "%' OR
                serving.serving_name LIKE '%" . $filter['searchtext'] . "%'
            )");
    }
    $this->db->where('serving.shop_id_pri', $this->config->item('shop_id_pri'));
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('servingreview.servingreview_status_id !=', 2);
    if (empty($params)) {
      return $this->db->get()->num_rows();
    } else {
      if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
        $this->db->limit($params['limit'], $params['start']);
      } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
        $this->db->limit($params['limit']);
      }
      $this->db->order_by('servingreview.servingreview_status_id');
      $this->db->order_by('serving.serving_date', 'DESC');
      return $this->db->get();
    }
  }

  public function getServingReviewById($servingreview_id) {
    $this->db->select('
            servingreview.servingreview_id,
            servingreview.servingreview_image,
            servingreview.servingreview_comment,
            servingreview.servingreview_comment_date,
            servingreview.servingreview_reply,
            servingreview.servingreview_reply_date,
            servingreview.servingreview_rating,
            servingreview.servingreview_point,
            servingreview.servingreview_status_id,
            servingreview.servingreview_user,
            servingreview.servingreview_doctor,
            servingreview.servingreview_shop,
            serving.serve_id,
            serve.serve_code,
            serving.serving_name,
            course.course_name,
            serving.serving_date
        ');
    $this->db->from('servingreview');
    $this->db->join('serving', 'serving.serving_id = servingreview.serving_id');
    $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
    $this->db->join('customer', 'customer.customer_id_pri = serving.customer_id_pri');
    $this->db->join('serve', 'serving.serve_id = serve.serve_id');
    $this->db->where('serving.shop_id_pri', $this->config->item('shop_id_pri'));
    $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
    $this->db->where('servingreview.servingreview_status_id !=', 2);
    $this->db->where('servingreview.servingreview_id', $servingreview_id);
    return $this->db->get();
  }

  public function getShopPoint() {
    $this->db->select('shop.point_review');
    $this->db->from('shop');
    $this->db->where('shop.shop_id_pri', $this->config->item('shop_id_pri'));
    return $this->db->get();
  }

  public function getCurrentPoint() {
    $this->db->select('online.online_point');
    $this->db->from('online');
    //        $this->db->where('point.shop_id_pri', $this->config->item('shop_id_pri'));
    $this->db->where('online.online_id', $this->session->userdata('online_id'));
    return $this->db->get();
  }

  public function updateServingReview($servingreview_id, $data) {
    $this->db->where('servingreview.servingreview_id', $servingreview_id);
    $this->db->update('servingreview', $data);
  }

  public function updatePoint($data) {
    //        $this->db->where('point.shop_id_pri', $this->config->item('shop_id_pri'));
    $this->db->where('online.online_id', $this->session->userdata('online_id'));
    $this->db->update('online', $data);
  }

  public function getOnlineByID($online_id) {
    $this->db->select('*');
    $this->db->from('online');
    $this->db->where('online.online_id', $online_id);
    return $this->db->get();
  }
}
