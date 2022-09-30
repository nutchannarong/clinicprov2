<?php

class Sitemap_model extends CI_Model
{
    public function getBlog($limit = null)
    {
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= now() AND now() <= article.article_end))');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        $this->db->order_by('article.article_create', 'desc');
        $this->db->order_by('article.article_start', 'desc');
        return $this->db->get();
    }

    public function getShopNature()
    {
        $this->db->select('*');
        $this->db->from('shop_nature');
        $this->db->where('shop_nature.shop_nature_status_id', 1);
        return $this->db->get();
    }

    public function getProduct()
    {
        $this->db->select('product.*');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('product.product_group_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->order_by('product.product_active_date', 'desc');
        return $this->db->get();
    }


    public function getShop()
    {
        $this->db->select('shop.*,shop_nature.shop_nature_name');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop.shop_nature_id = shop_nature.shop_nature_id');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->order_by('shop.shop_id');
        return $this->db->get();
    }

    public function getProductCategory()
    {
        $this->db->select('product_category.product_category_name');
        $this->db->from('product_category');
        $this->db->where('product_category.product_category_status_id', 1);
        return $this->db->get();
    }
}
