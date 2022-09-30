<?php
/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */

class Products_model extends CI_Model
{
    public function countPagination($filter) {
        $this->db->select('product.product_id');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        if ($filter['category_name'] != '') {
            $this->db->join('product_category_map', 'product_category_map.product_id = product.product_id', 'left');
            $this->db->join('product_category', 'product_category.product_category_id = product_category_map.product_category_id');
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        if ($filter['location'] != '') {
            $this->db->where('shop.shop_province', $filter['location']);
        }
        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }
        if ($filter['shop_amphoe'] != '') {
            $this->db->where('shop.shop_amphoe', $filter['shop_amphoe']);
        }
        if ($filter['shop_district'] != '') {
            $this->db->where('shop.shop_district', $filter['shop_district']);
        }
        if ($filter['nature_name'] != '') {
            $array = explode(',', $filter['nature_name']);
            $this->db->where_in('shop_nature.shop_nature_name', $array);
        }
        if ($filter['category_name'] != '') {
            $array_category = explode(',', $filter['category_name']);
            $this->db->where_in('product_category.product_category_name', $array_category);
        }
        if ($filter['min_discount'] != '' && $filter['max_discount'] != '') {
            $this->db->where("product.product_percent >=", $filter['min_discount']);
            $this->db->where("product.product_percent <=", $filter['max_discount']);
        }
        if ($filter['min_price'] != '' && $filter['max_price'] != '') {
            $this->db->where("product.product_total >=", $filter['min_price']);
            $this->db->where("product.product_total <=", $filter['max_price']);
        }
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }

        $this->db->group_by('product.product_id');
        return $this->db->get()->num_rows();
    }

    public function getPagination($filter, $params = array()) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        if ($filter['category_name'] != '') {
            $this->db->join('product_category_map', 'product_category_map.product_id = product.product_id', 'left');
            $this->db->join('product_category', 'product_category.product_category_id = product_category_map.product_category_id');
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        if ($filter['location'] != '') {
            $this->db->where('shop.shop_province', $filter['location']);
        }
        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }
        if ($filter['shop_amphoe'] != '') {
            $this->db->where('shop.shop_amphoe', $filter['shop_amphoe']);
        }
        if ($filter['shop_district'] != '') {
            $this->db->where('shop.shop_district', $filter['shop_district']);
        }
        if ($filter['nature_name'] != '') {
            $array = explode(',', $filter['nature_name']);
            $this->db->where_in('shop_nature.shop_nature_name', $array);
        }
        if ($filter['category_name'] != '') {
            $array_category = explode(',', $filter['category_name']);
            $this->db->where_in('product_category.product_category_name', $array_category);
        }
        if ($filter['min_discount'] != '' && $filter['max_discount'] != '') {
            $this->db->where("product.product_percent >=", $filter['min_discount']);
            $this->db->where("product.product_percent <=", $filter['max_discount']);
        }
        if ($filter['min_price'] != '' && $filter['max_price'] != '') {
            $this->db->where("product.product_total >=", $filter['min_price']);
            $this->db->where("product.product_total <=", $filter['max_price']);
        }
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }

        $this->db->group_by('product.product_id');

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        // sort data
        if ($filter['sort_product_percent'] != '') {
            $this->db->order_by('product.product_percent', $filter['sort_product_percent']);
        }
        if ($filter['sort_rating'] != '') {
            $this->db->order_by('product.product_rating', $filter['sort_rating']);
        }
        if ($filter['sort_price'] != '') {
            $this->db->order_by('product.product_price', $filter['sort_price']);
        }
        $this->db->order_by('product.product_active_date', 'desc');
        return $this->db->get();
    }

    public function getLocationProvince($province_name_en) {
        $this->db->select('province.province_name_th');
        $this->db->from('province');
        $this->db->where('province.province_name_en', $province_name_en);
        return $this->db->get();
    }
}