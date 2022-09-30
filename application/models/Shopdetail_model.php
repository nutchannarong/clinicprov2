<?php

/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */
class Shopdetail_model extends CI_Model {

    public function getShopByID($shop_id) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop.shop_nature_id = shop_nature.shop_nature_id');
//        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
//        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('shop.shop_id', $shop_id);
        return $this->db->get();
    }

    public function countPagination($filter) {
        $this->db->select('product.product_id');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where('product.shop_id_pri', $filter['shop_id_pri']);
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
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
        $this->db->where('product.shop_id_pri', $filter['shop_id_pri']);
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                product.product_name LIKE '%" . $filter['searchtext'] . "%' OR 
                product.product_detail LIKE '%" . $filter['searchtext'] . "%'
            ) ");
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

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }

        $this->db->order_by('product.product_active_date', 'desc');
        return $this->db->get();
    }

    public function getProductByShopID($shop_id_pri, $order_by) {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_site_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->where('product.shop_id_pri', $shop_id_pri);
        $this->db->limit(1);
        if ($order_by == 1) {
            $this->db->order_by('product.product_total', 'asc');
        } else {
            $this->db->order_by('product.product_update', 'desc');
        }
        return $this->db->get();
    }

// Doctor
    public function countDoctorPagination($filter) {
        $this->db->select('user.user_id');
        $this->db->from('user');
        $this->db->join('specialized', 'specialized.specialized_id = user.specialized_id', 'LEFT');
        $this->db->where('user.shop_id_pri', $filter['shop_id_pri']);
        $this->db->where_in("user.role_id", array(1, 3));
        $this->db->where('user.user_status_id', 1);
        $this->db->where('user.user_appoint_id', 1);
        return $this->db->get()->num_rows();
    }

    public function getDoctorPagination($filter, $params = array()) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('specialized', 'specialized.specialized_id = user.specialized_id', 'LEFT');
        $this->db->where('user.shop_id_pri', $filter['shop_id_pri']);
        $this->db->where_in("user.role_id", array(1, 3));
        $this->db->where('user.user_status_id', 1);
        $this->db->where('user.user_appoint_id', 1);
        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        return $this->db->get();
    }

    public function getSpecializedSub($user_id) {
        $this->db->select('*');
        $this->db->from('specialized_sub_map');
        $this->db->join('specialized_sub', 'specialized_sub.specialized_sub_id = specialized_sub_map.specialized_sub_id');
        $this->db->where('specialized_sub_map.user_id', $user_id);
        return $this->db->get();
    }

    public function getDoctorByID($user_id) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('specialized', 'specialized.specialized_id = user.specialized_id', 'LEFT');
        $this->db->where('user.user_id', $user_id);
        $this->db->where_in("user.role_id", array(1, 3));
        $this->db->where('user.user_status_id', 1);
        return $this->db->get();
    }

    public function getDoctorStudy($user_id) {
        $this->db->select('*');
        $this->db->from('user_study_th');
        $this->db->where('user_study_th.user_id', $user_id);
        return $this->db->get();
    }

    public function getDoctorDiploma($user_id) {
        $this->db->select('*');
        $this->db->from('user_diploma_th');
        $this->db->where('user_diploma_th.user_id', $user_id);
        return $this->db->get();
    }

    public function getDoctorLanguage($user_id) {
        $this->db->select('*');
        $this->db->from('user_language_map');
        $this->db->join('user_language', 'user_language.user_language_id = user_language_map.user_language_id');
        $this->db->where('user_language_map.user_id', $user_id);
        return $this->db->get();
    }

    public function getSectionDayByUserID($user_id) {
        $this->db->select('*');
        $this->db->from('user_sectionday_map');
        $this->db->join('sectionday', 'sectionday.sectionday_id = user_sectionday_map.sectionday_id');
        $this->db->where('user_sectionday_map.user_id', $user_id);
        return $this->db->get();
    }

    public function getSectionTimeByUserID($user_id, $type) {
        $this->db->select('*');
        $this->db->from('user_section_map');
        $this->db->join('section', 'section.section_id = user_section_map.section_id');
        $this->db->where('user_section_map.user_id', $user_id);
        if ($type == 'desc') {
            $this->db->order_by('section.section_sort', 'desc');
        } else {
            $this->db->order_by('section.section_sort', 'asc');
        }
        $this->db->limit(1);
        return $this->db->get();
    }

    public function getAppointShop($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('customer');
//        $this->db->join('online', 'customer.online_id = online.online_id');
        $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
//        $this->db->where('online.online_id', $online_id);
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('customer.customer_status_id', 1);
        $this->db->where('customer.online_id IS NOT NULL');
//        $this->db->group_by('shop.shop_id_pri');
//        $this->db->order_by('shop.shop_name');
        return $this->db->get();
    }

// Shop Sub
    public function getShop($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        return $this->db->get();
    }

    public function countShopSubPagination($filter) {
        $this->db->select('shop.shop_id_pri');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
//        $this->db->where('shop.shop_mother_id', $filter['shop_id_pri']);
//        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        if ($filter['shop_mother_id'] != null) {
            $this->db->where("(shop.shop_mother_id = " . $filter['shop_mother_id'] . " OR shop.shop_id_pri = " . $filter['shop_mother_id'] . ") AND shop.shop_id_pri != " . $filter['shop_id_pri']);
        } else {
            $this->db->where('shop.shop_mother_id', $filter['shop_id_pri']);
        }
        return $this->db->get()->num_rows();
    }

    public function getShopSubPagination($filter, $params = array()) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
//        $this->db->where('shop.shop_mother_id', $filter['shop_id_pri']);
//        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        if ($filter['shop_mother_id'] != null) {
            $this->db->where("(shop.shop_mother_id = " . $filter['shop_mother_id'] . " OR shop.shop_id_pri = " . $filter['shop_mother_id'] . ") AND shop.shop_id_pri != " . $filter['shop_id_pri']);
        } else {
            $this->db->where('shop.shop_mother_id', $filter['shop_id_pri']);
        }
        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        return $this->db->get();
    }

    public function checkSectionday($day, $user_id) {
        $this->db->select('*');
        $this->db->from('user_sectionday_map');
        //$this->db->join('sectionday', 'user_sectionday_map.sectionday_id = sectionday.sectionday_id');
        $this->db->where('user_sectionday_map.sectionday_id', $day);
        $this->db->where('user_sectionday_map.user_id', $user_id);
        return $this->db->get();
    }

    public function getsection($shop_id_pri, $section_id = null) {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->where('section.shop_id_pri', $shop_id_pri);
        if ($section_id != null) {
            $this->db->where('section.section_id', $section_id);
            $this->db->limit(1);
        } else {
            $this->db->where('section.section_status_id', 1);
        }
        $this->db->order_by('section.section_sort');
        return $this->db->get();
    }

    public function checkSection($time, $user_id) {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('user_section_map', 'user_section_map.section_id = section.section_id');
        //$this->db->where('section.shop_id_pri', $this->session->userdata('shop_id_pri'));
        $this->db->where('section.section_time', $time);
        $this->db->where('user_section_map.user_id', $user_id);
        $this->db->where('section.section_status_id', 1);
        return $this->db->get();
    }

    public function checkAppointDoctor($shop_id_pri, $user_id, $appoint_date, $appoint_start) {
        $this->db->select('*');
        $this->db->from('appoint');
        $this->db->where('appoint.shop_id_pri', $shop_id_pri);
        $this->db->where('appoint.user_id', $user_id);
        $this->db->where('appoint.appoint_date', $appoint_date);
        $this->db->where('appoint.appoint_start', $appoint_start);
        $this->db->where('appoint.appoint_status_id !=', 0);
        return $this->db->get();
    }

    public function checkAppointCustomer($shop_id_pri, $appoint_date, $customer_id_pri) {
        $this->db->select('*');
        $this->db->from('appoint');
        $this->db->where('appoint.shop_id_pri', $shop_id_pri);
        $this->db->where('appoint.appoint_date', $appoint_date);
        $this->db->where('appoint.customer_id_pri', $customer_id_pri);
        $this->db->where('appoint.appoint_status_id', 1);
        return $this->db->get();
    }

    public function checkAppointCustomerTime($shop_id_pri, $appoint_date, $appoint_start, $customer_id_pri) {
        $this->db->select('*');
        $this->db->from('appoint');
        $this->db->where('appoint.shop_id_pri', $shop_id_pri);
        $this->db->where('appoint.appoint_date', $appoint_date);
        $this->db->where('appoint.appoint_start', $appoint_start);
        $this->db->where('appoint.customer_id_pri', $customer_id_pri);
        $this->db->where('appoint.appoint_status_id !=', 0);
        return $this->db->get();
    }

    public function getDoctorByShop($user_id) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('shop', 'shop.shop_id_pri = user.shop_id_pri');
        $this->db->where('user.user_id', $user_id);
        return $this->db->get();
    }

    public function getOnline() {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getCustomer($customer_tel, $shop_id_pri) {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
        $this->db->where('customer.customer_tel', $customer_tel);
        $this->db->where('customer.customer_status_id', 1);
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        $this->db->limit(1);
        return $this->db->get();
    }

    public function addAppoint($data) {
        $this->db->insert('appoint', $data);
    }

}
