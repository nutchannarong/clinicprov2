<?php
/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 6/8/2020
 * Time: 9:45
 */

class Review_model extends CI_Model
{
    public function countPagination($filter) {
        $this->db->select('IFNULL(AVG(productreview.productreview_rating),0) AS rating, IFNULL(COUNT(productreview.productreview_rating),0) AS count_rating ,shop.shop_id');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('product', 'product.shop_id_pri = shop.shop_id_pri', 'left');
        $this->db->join('productreview', 'productreview.product_id = product.product_id', 'left');

        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('(productreview.productreview_status_id = 1 OR productreview.productreview_status_id IS NULL)');

        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }

        $this->db->group_by('shop.shop_id_pri');
        return $this->db->get()->num_rows();
    }

    public function getPagination($filter, $params = array()) {
        $this->db->select('IFNULL(AVG(productreview.productreview_rating),0) AS rating,IFNULL(COUNT(productreview.productreview_rating),0) AS count_rating,shop.*,shop_nature.shop_nature_name');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('product', 'product.shop_id_pri = shop.shop_id_pri', 'left');
        $this->db->join('productreview', 'productreview.product_id = product.product_id', 'left');

        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('(productreview.productreview_status_id = 1 OR productreview.productreview_status_id IS NULL)');

        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }

        $this->db->group_by('shop.shop_id_pri');

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }

        if ($filter['sort_rating'] != '') {
            $this->db->order_by('rating', $filter['sort_rating']);
        }

        return $this->db->get();
    }

    public function getShopProvince() {
        $this->db->select('shop.shop_province');
        $this->db->from('shop');
        $this->db->where_not_in('shop.shop_province', array('','-'));
        $this->db->group_by('shop.shop_province');
        return $this->db->get();

    }
}