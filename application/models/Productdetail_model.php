<?php

/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */
class Productdetail_model extends CI_Model {

    public function getProductBySlug($product_slug) {
        $this->db->select('product.*,shop.*,shop_nature.shop_nature_name');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->where('product.product_slug', $product_slug);

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }

        return $this->db->get();
    }

    public function getProductByShopID($shop_id_pri, $product_id) {
        $this->db->select('product.*,shop.*,shop_nature.shop_nature_name');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->where('product.shop_id_pri', $shop_id_pri);
        $this->db->where('product.product_id !=', $product_id);

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }

        $this->db->limit(8);
        $this->db->order_by('product.product_active_date', 'desc');
        return $this->db->get();
    }

    public function getProductCategory($product_id) {
        $this->db->select('product_category.product_category_name');
        $this->db->join('product_category_map', 'product_category_map.product_category_id = product_category.product_category_id');
        $this->db->from('product_category');
        $this->db->where('product_category.product_category_status_id', 1);
        $this->db->where('product_category_map.product_id', $product_id);
        return $this->db->get();
    }

    // product review

    public function countPagination($filter) {
        $this->db->select('productreview.productreview_id');
        $this->db->from('productreview');
        $this->db->join('online', 'online.online_id = productreview.online_id');
        $this->db->join('user', 'user.user_id = productreview.user_id', 'left');
        $this->db->where('productreview.product_id', $filter['product_id']);
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get()->num_rows();
    }

    public function getPagination($filter, $params = array()) {
        $this->db->select('productreview.*,online.online_image,online.online_fname,online.online_lname,user.user_id,user.user_image,user.user_fullname');
        $this->db->from('productreview');
        $this->db->join('online', 'online.online_id = productreview.online_id');
        $this->db->join('user', 'user.user_id = productreview.user_id', 'left');
        $this->db->where('productreview.product_id', $filter['product_id']);
        $this->db->where('productreview.productreview_status_id', 1);

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->order_by('productreview_comment_date', 'DESC');
        return $this->db->get();
    }

    
    public function countProductReview($product_id) {
        $this->db->select('productreview.productreview_id');
        $this->db->from('productreview');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get()->num_rows();
    }

    public function sumProductReview($product_id) {
        $this->db->select_sum('productreview.productreview_rating');
        $this->db->from('productreview');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get();
    }
   
    
    public function getProductReviewByID($product_id) {
        $this->db->select('*');
        $this->db->from('productreview');
        $this->db->join('online', 'online.online_id = productreview.online_id');
        $this->db->join('user', 'user.user_id = productreview.user_id', 'left');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get();
    }

    public function checkShopCart($shop_id_pri) {
        $this->db->select('orderdetail_temp.orderdetail_temp_id_pri');
        $this->db->from('orderdetail_temp');
        $this->db->where('orderdetail_temp.shop_id_pri != ', $shop_id_pri);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        return $this->db->get()->num_rows();
    }

    //action
    public function updateProduct($product_id, $data) {
        $this->db->where('product.product_id', $product_id);
        $this->db->update('product', $data);
    }

    // review
    public function checkOrdered($product_id) {
        $this->db->select('orderdetail.orderdetail_id_pri');
        $this->db->from('orderdetail');
        $this->db->join('order', 'order.order_id_pri = orderdetail.order_id_pri');
        $this->db->where('orderdetail.product_id', $product_id);
        $this->db->where('order.online_id', $this->session->userdata('online_id'));
        return $this->db->get()->num_rows();
    }

    public function checkReviewed($product_id) {
        $this->db->select('productreview.productreview_id');
        $this->db->from('productreview');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.online_id', $this->session->userdata('online_id'));
        return $this->db->get()->num_rows();
    }

    public function getReviewRating($product_id) {
        $this->db->select('productreview.productreview_rating');
        $this->db->from('productreview');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.productreview_rating != ', '');
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get();
    }

    public function getCurrentPoint() {
        $this->db->select('online.online_point');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getReview($product_id) {
        $this->db->select('*');
        $this->db->from('productreview');
//        $this->db->join('online', 'online.online_id = productreview.online_id');
//        $this->db->join('user', 'user.user_id = productreview.user_id');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function insertReview($data) {
        $this->db->insert('productreview', $data);
        return $this->db->insert_id();
    }

    public function updateOnline($data) {
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        $this->db->update('online', $data);
    }

    public function getProductMapCategory($product_id) {
        $this->db->select('*');
        $this->db->from('product_category_map');
        $this->db->join('product_category', 'product_category.product_category_id = product_category_map.product_category_id');
        $this->db->where('product_category_map.product_id', $product_id);
        return $this->db->get();
    }
    
}
