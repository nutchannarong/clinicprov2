<?php

/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/14/2020
 * Time: 15:07
 */

class Logpoint_model extends CI_Model {
    public function countPagination($filter) {
        $this->logs->select('log_pointonline.log_id');
        $this->logs->from('log_pointonline');
        //$this->logs->join('shop', 'shop.shop_id_pri = log_pointonline.shop_id_pri', 'left');
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                log_pointonline.log_text LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point_last LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point_balance LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        $this->logs->where('log_pointonline.online_id', $this->session->userdata('online_id'));
        return $this->logs->get()->num_rows();
    }

    public function getPagination($filter, $params = array()) {
        //$this->db->select('log_pointonline.*,shop.shop_id,shop.shop_name');
        $this->logs->select('log_pointonline.*');
        $this->logs->from('log_pointonline');
        //$this->logs->join('shop', 'shop.shop_id_pri = log_pointonline.shop_id_pri', 'left');
        if ($filter['searchtext'] != '') {
            $this->logs->where(" (
                log_pointonline.log_text LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point_last LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point LIKE '%" . $filter['searchtext'] . "%' OR
                log_pointonline.log_point_balance LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        $this->logs->where('log_pointonline.online_id', $this->session->userdata('online_id'));

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->logs->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->logs->limit($params['limit']);
        }
        $this->logs->order_by('log_pointonline.log_time', 'desc');
        return $this->logs->get();
    }

    public function get_shop($shop_id_pri = null) {
        if ($shop_id_pri != null) {
            $this->db->where('shop.shop_id_pri', $shop_id_pri);
        }
        return $this->db->get('shop');
    }
}
