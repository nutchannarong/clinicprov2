<?php

class Search_model extends CI_Model {

    public function count_pagination($filter) {
        $this->db->select('shop.shop_id_pri');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop.shop_nature_id = shop_nature.shop_nature_id');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        if (count($filter['id']) > 0) {
            $this->db->where_in('shop.shop_nature_id', $filter['id']);
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
//        $this->db->order_by('shop.shop_id');
        return $this->db->get()->num_rows();
    }

    public function get_pagination($filter, $params = array()) {
        $this->db->select('shop.*,shop_nature.shop_nature_name');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop.shop_nature_id = shop_nature.shop_nature_id');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        if (count($filter['id']) > 0) {
            $this->db->where_in('shop.shop_nature_id', $filter['id']);
        }
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
//        $this->db->order_by("shop.shop_proactive_id = '2'");
//        $this->db->order_by("shop.shop_proactive_id = '0'");
//        $this->db->order_by("shop.shop_proactive_id = '1'");
        $this->db->order_by('shop.shop_id', 'asc');
        return $this->db->get();
    }

    public function getShopMap() {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        return $this->db->get();
    }

    public function getShopByNature($id = null) {
        $this->db->select('shop.*,shop_nature.shop_nature_name');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop.shop_nature_id = shop_nature.shop_nature_id');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        if ($id != null) {
            $this->db->where_in('shop.shop_nature_id', $id);
        }
        $this->db->order_by('shop.shop_id');
        return $this->db->get();
    }

    public function countShopCustomer($id) {
        $this->db->select('customer_id_pri');
        $this->db->from('customer');
        $this->db->where('shop_id_pri', $id);
        $this->db->where('customer_status_id', 1);
        return $this->db->get();
    }

    public function countShopCourse($id) {
        $this->db->select('course_id_pri');
        $this->db->from('course');
        $this->db->where('shop_id_pri', $id);
        $this->db->where('course_status_id', 1);
        return $this->db->get();
    }

    public function getShopID($shop_id_pri = null) {
        $this->db->select('*');
        $this->db->from('shop');
        if ($shop_id_pri != null) {
            $this->db->where('shop.shop_id_pri', $shop_id_pri);
            $this->db->limit(1);
        } else {
            $this->db->where('shop.shop_status_id', 1);
            $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        }
        return $this->db->get();
    }

    public function getPromotionByShop($id) {
        $this->db->select('pro.*,shop.*');
        $this->db->from('pro');
        $this->db->join('course', 'pro.course_id_pri = course.course_id_pri');
        $this->db->join('shop', 'pro.shop_id_pri = shop.shop_id_pri');
        $this->db->where('shop.shop_id_pri', $id);
        $this->db->where("pro.pro_active_id", 1);
        $this->db->where("pro.pro_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        $this->db->where("pro.pro_end >", date('Y-m-d'));
        $this->db->order_by('pro.pro_active_date', 'desc');
        return $this->db->get();
    }

    public function getNatureArray($shop_nature_id = null) {
        $this->db->select('*');
        $this->db->from('shop_nature');
        if ($shop_nature_id != null) {
            $this->db->where_in('shop_nature.shop_nature_id', $shop_nature_id);
        } else {
            $this->db->where('shop_nature.shop_nature_status_id', 1);
        }
        return $this->db->get();
    }

    public function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }

}
