<?php
/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */

class Productbirthdate_model extends CI_Model
{
    public function countPagination($filter)
    {
        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        $this->db->select('product.product_id');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        if ($filter['product_category_id'] != '') {
            $this->db->join('product_category_map', 'product_category_map.product_id = product.product_id', 'left');
            $this->db->join('product_category', 'product_category.product_category_id = product_category_map.product_category_id');
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }
        if ($filter['shop_nature_id'] != '') {
            $this->db->where('shop_nature.shop_nature_id', $filter['shop_nature_id']);
        }
        if ($filter['product_category_id'] != '') {
            $this->db->where('product_category.product_category_id', $filter['product_category_id']);
        }
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        //$this->db->where('product.product_group_id', 2);
        if($month_birthdate != $month_current){
            $this->db->where('product.product_group_id', 1);     
            $this->db->where('product.product_total <=', $filter['online_point']); 
        }else{
            $this->db->where('(product.product_group_id = 2 OR product.product_total <= '.$filter['online_point'].')');    
        }
        $this->db->where("product.product_end >", date('Y-m-d'));
        //$this->db->where('product.product_total <=', $filter['online_point']); 
        $this->db->group_by('product.product_id');
        $this->db->order_by('product.product_group_id', 'DESC');
        $this->db->order_by('product.product_total','ASC');
        return $this->db->get()->num_rows();
    }

    public function getPagination($filter, $params = array())
    {
        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        if ($filter['product_category_id'] != '') {
            $this->db->join('product_category_map', 'product_category_map.product_id = product.product_id', 'left');
            $this->db->join('product_category', 'product_category.product_category_id = product_category_map.product_category_id');
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        if ($filter['shop_province'] != '') {
            $this->db->where('shop.shop_province', $filter['shop_province']);
        }
        if ($filter['shop_nature_id'] != '') {
            $this->db->where('shop_nature.shop_nature_id', $filter['shop_nature_id']);
        }
        if ($filter['product_category_id'] != '') {
            $this->db->where('product_category.product_category_id', $filter['product_category_id']);
        }
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        if($month_birthdate != $month_current){
            $this->db->where('product.product_group_id', 1);     
            $this->db->where('product.product_total <=', $filter['online_point']); 
        }else{
            $this->db->where('(product.product_group_id = 2 OR product.product_total <= '.$filter['online_point'].')');    
        }
        $this->db->where("product.product_end >", date('Y-m-d'));
        //$this->db->where('product.product_total <=', $filter['online_point']); 
        $this->db->group_by('product.product_id');
        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->order_by('product.product_group_id', 'DESC');
        $this->db->order_by('product.product_total','ASC');
        return $this->db->get();
    }

    public function getShopNature()
    {
        $this->db->select('*');
        $this->db->from('shop_nature');
        $this->db->where('shop_nature.shop_nature_status_id', 1);
        return $this->db->get();
    }

    public function getShopProvince()
    {
        $this->db->select('shop.shop_province');
        $this->db->from('shop');
        $this->db->where_not_in('shop.shop_province', array('','-'));
        $this->db->group_by('shop.shop_province');
        return $this->db->get();
    }

    public function getProductCategory()
    {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('product_category.product_category_status_id', 1);
        return $this->db->get();
    }
}