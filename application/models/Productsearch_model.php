<?php

class Productsearch_model extends CI_Model
{
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
        $this->db->where_not_in('shop.shop_province', array(' ','-'));
        $this->db->group_by('shop.shop_province');
        return $this->db->get();
    }

    public function getShopAmphoe($shop_province)
    {
        $this->db->select('shop.shop_amphoe');
        $this->db->from('shop');
        $this->db->group_by('shop.shop_amphoe');
        $this->db->where('shop.shop_amphoe !=', '');
        $this->db->where('shop.shop_province', $shop_province);
        return $this->db->get();
    }

    public function getShopDistrict($shop_amphoe)
    {
        $this->db->select('shop.shop_district');
        $this->db->from('shop');
        $this->db->where('shop.shop_district !=', '');
        $this->db->where('shop.shop_amphoe', $shop_amphoe);
        $this->db->group_by('shop.shop_district');
        return $this->db->get();
    }

    public function getProductCategory()
    {
        $this->db->select('product_category.product_category_name,COUNT(product_category_map.product_category_id) AS count');
        $this->db->from('product_category');
        $this->db->join('product_category_map', 'product_category_map.product_category_id = product_category.product_category_id', 'left');
        $this->db->join('product', 'product.product_id = product_category_map.product_id', 'left');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri', 'left');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('product.product_group_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->where('product_category.product_category_status_id', 1);
        $this->db->group_by('product_category.product_category_id');
//        $this->db->order_by('count', 'DESC');
        return $this->db->get();
    }
}
