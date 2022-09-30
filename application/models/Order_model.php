<?php

class Order_model extends CI_Model {

    public function getPagination($filter, $params = array()) {
        if (empty($params)) {
            $this->db->select('order.order_id_pri');
        } else {
            $this->db->select('
                order.order_id_pri,
                order.order_id,
                order.order_status_id,
                order.order_point,
                order.order_totalpay,
                order.order_create,
                shop.shop_id,
                shop.shop_name
            ');
        }
        $this->db->from('order');
        $this->db->join('shop', 'shop.shop_id_pri = order.shop_id_pri');
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                order.order_id LIKE '%" . $filter['searchtext'] . "%' OR
                order.customer_name LIKE '%" . $filter['searchtext'] . "%' OR
                order.customer_tel LIKE '%" . $filter['searchtext'] . "%' OR
                order.customer_email LIKE '%" . $filter['searchtext'] . "%' OR
                shop.shop_id LIKE '%" . $filter['searchtext'] . "%' OR
                shop.shop_name LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        $this->db->where('order.online_id', $this->session->userdata('online_id'));
        if (empty($params)) {
            return $this->db->get()->num_rows();
        } else {
            if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
                $this->db->limit($params['limit']);
            }
            $this->db->order_by('order.order_create', 'DESC');
            return $this->db->get();
        }
    }

    public function getOrderDetail($order_id_pri) {
        $this->db->select('
            orderdetail.orderdetail_name,
            orderdetail.orderdetail_amount,
            orderdetail.orderdetail_total,
            orderdetail.orderdetail_point,
            orderdetail.orderdetail_unit
        ');
        $this->db->from('orderdetail');
        $this->db->where('orderdetail.order_id_pri', $order_id_pri);
        return $this->db->get();
    }

    //
    public function getCartCheck() {
        $this->db->select('
            orderdetail_temp.drugorder_id_pri,
            orderdetail_temp.orderdetail_temp_amount,
            orderdetail_temp.orderdetail_temp_total,
            orderdetail_temp.orderdetail_temp_point,
            product.product_group_id
        ');
        $this->db->from('orderdetail_temp');
        $this->db->join('product', 'product.product_id = orderdetail_temp.product_id');
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getOrderDrugCheck($drugorder_id_pri) {
        $this->db->select('
            drugorder.drugordert_total
        ');
        $this->db->from('drug');
        $this->db->join('drugorder', 'drugorder.drug_id_pri = drug.drug_id_pri');
        $this->db->where('drug.drug_status_id', 1);
        $this->db->where('drugorder.drugorder_id_pri', $drugorder_id_pri);
        $this->db->where('drugorder.drugorder_status_id', 1);
        $this->db->where('drugorder.drugordert_total >', 0);
        $this->db->where('drugorder.drugorder_expdate >', date('Y-m-d'));
        $this->db->limit(1);
        return $this->db->get();
    }

    public function getOnline() {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getCharge($charge_id) {
        $this->db->select('*');
        $this->db->from('charge');
        $this->db->where('charge.charge_id', $charge_id);
        return $this->db->get();
    }

    public function getOnlineCharge($online_id, $charge_id) {
        $this->db->select('*');
        $this->db->from('charge');
        $this->db->where('charge.online_id', $online_id);
        $this->db->where('charge.charge_id', $charge_id);
        return $this->db->get();
    }

    public function insertCharge($data) {
        $this->db->insert('charge', $data);
        return $this->db->insert_id();
    }

    public function updateCharge($charge_id, $data) {
        $this->db->where('charge.charge_id', $charge_id);
        $this->db->update('charge', $data);
    }

    /////////////////////
    public function get_orderdetail_temp() {
        $this->db->select('*');
        $this->db->from('orderdetail_temp');
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getorderdrug($drugorder_id_pri) {
        $this->db->select('*');
        $this->db->from('drug');
        $this->db->join('drugorder', 'drugorder.drug_id_pri = drug.drug_id_pri');
        $this->db->join('druglot', 'drugorder.druglot_id = druglot.druglot_id');
        $this->db->where('drugorder.drugorder_id_pri', $drugorder_id_pri);
        $this->db->where('drug.drug_status_id', 1);
        $this->db->where('drugorder.drugorder_status_id', 1);
        $this->db->where('drugorder.drugordert_total >', 0);
        $this->db->where('drugorder.drugorder_expdate >', date("Y-m-d"));
        $this->db->limit(1);
        return $this->db->get();
    }

    public function get_drug($drug_id_pri) {
        $this->db->select('*');
        $this->db->from('drug');
        $this->db->where('drug.drug_id_pri', $drug_id_pri);
        $this->db->limit(1);
        return $this->db->get();
    }

    public function getdrug_drugorder($drugorder_id_pri) {
        $this->db->select('*');
        $this->db->from('drugorder');
        $this->db->where('drugorder.drugorder_id_pri', $drugorder_id_pri);
        $this->db->limit(1);
        return $this->db->get();
    }

    public function get_user($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->join('user', 'user.shop_id_pri = shop.shop_id_pri');
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        $this->db->where('user.user_type_id', 1);
        $this->db->limit(1);
        return $this->db->get()->row()->user_id;
    }

    public function get_online() {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function get_guide($guide_id) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $guide_id);
        return $this->db->get();
    }

    public function get_customer_online($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('customer.shop_id_pri', $shop_id_pri);
        $this->db->where('customer.online_id', $this->session->userdata('online_id'));
        $this->db->limit(1);
        return $this->db->get();
    }

    public function get_customer_tel($customer_tel, $shop_id_pri) {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('customer.customer_tel', $customer_tel);
        $this->db->where('customer.shop_id_pri', $shop_id_pri);
        $this->db->order_by('customer.customer_id_pri');
        $this->db->limit(1);
        return $this->db->get();
    }

    public function get_customer_group($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('customer_group');
        $this->db->where('customer_group.shop_id_pri', $shop_id_pri);
        $this->db->where('customer_group.customer_group_default', 1);
        return $this->db->get()->row()->customer_group_id;
    }

    public function get_customer($customer_id_pri = null) {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->join('customer_group', 'customer.customer_group_id = customer_group.customer_group_id');
        if ($customer_id_pri != '') {
            $this->db->where('customer.customer_id_pri', $customer_id_pri);
        }
        return $this->db->get();
    }

    public function get_shop_bank($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('shop_bank');
        $this->db->where('shop_bank.shop_id_pri', $shop_id_pri);
        $this->db->where('shop_bank.shop_bank_default', 3);
        return $this->db->get()->row()->shop_bank_id;
    }

    public function insert_customer($data) {
        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }

    public function insert_customer_tag_map($data) {
        $this->db->insert('customer_tag_map', $data);
    }

    public function insert_logcustomer($data) {
        $this->logs->insert('log_customer', $data);
    }

    public function insert_order($data) {
        $this->db->insert('order', $data);
        return $this->db->insert_id();
    }

    public function update_customer($customer_id_pri, $data) {
        $this->db->where('customer.customer_id_pri', $customer_id_pri);
        $this->db->update('customer', $data);
    }

    public function update_online($online_id, $data) {
        $this->db->where('online.online_id', $online_id);
        $this->db->update('online', $data);
    }

    public function update_drugorder($drugorder_id_pri, $data) {
        $this->db->where('drugorder.drugorder_id_pri', $drugorder_id_pri);
        $this->db->update('drugorder', $data);
    }

    public function update_order($order_id_pri, $data) {
        $this->db->where('order.order_id_pri', $order_id_pri);
        $this->db->update('order', $data);
    }

    //เพิ่มรายการ
    public function insert_orderdetail($data) {
        $this->db->insert('orderdetail', $data);
        return $this->db->insert_id();
    }

    //เพิ่มประวัติยา
    public function insertdrughistory($data) {
        $this->db->insert('drughistory', $data);
    }

    //เพิ่มฉลากยา
    public function insert_drugsticker($data) {
        $this->db->insert('drugsticker', $data);
    }

    //orderlist
    public function get_order($order_id_pri) {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('customer', 'order.customer_id_pri = customer.customer_id_pri');
        $this->db->join('customer_group', 'customer.customer_group_id = customer_group.customer_group_id');
        $this->db->where('order.order_id_pri', $order_id_pri);
        $this->db->limit(1);
        return $this->db->get();
    }

    //shopbank
    public function getshopbank($shop_bank_id = null) {
        $this->db->select('*');
        $this->db->from('shop_bank');
        $this->db->where('shop_bank.shop_bank_id', $shop_bank_id);
        $this->db->limit(1);
        return $this->db->get();
    }

    public function get_orderdetail($order_id_pri = null) {
        $this->db->select('*');
        $this->db->from('orderdetail');
        if ($order_id_pri != '') {
            $this->db->where('orderdetail.order_id_pri', $order_id_pri);
        }
        return $this->db->get();
    }

    public function getcourse($course_id_pri = null) {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->where('course.course_id_pri', $course_id_pri);
        $this->db->order_by('course.course_id');
        return $this->db->get();
    }

    public function get_courset3($course_id_pri) {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->join('coursedrug', 'coursedrug.course_id_pri = course.course_id_pri');
        $this->db->where('course.course_id_pri', $course_id_pri);
        $this->db->where('course.course_type', 3);
        return $this->db->get();
    }

    public function update_shopbank($shop_bank_id, $data) {
        $this->db->where('shop_bank.shop_bank_id', $shop_bank_id);
        $this->db->update('shop_bank', $data);
    }

    public function insert_orderpay($data) {
        $this->db->insert('orderpay', $data);
    }

    public function insert_serving($data) {
        $this->db->insert('serving', $data);
        return $this->db->insert_id();
    }

    public function insert_servingdetail_book($data) {
        $this->db->insert('servingdetail_book', $data);
    }

    //doc_setting--->
    public function getDocSetting($shop_id_pri) {
        $this->db->where('shop_id_pri', $shop_id_pri);
        $this->db->limit(1);
        return $this->db->get('doc_setting')->row();
    }

    public function updateDocSetting($data, $shop_id_pri) {
        $this->db->where('shop_id_pri', $shop_id_pri);
        $this->db->update('doc_setting', $data);
    }

    //ลบ cart
    public function delete_orderdetail_temp_alltype($shop_id_pri) {
        $this->db->where('orderdetail_temp.shop_id_pri', $shop_id_pri);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->delete('orderdetail_temp');
    }

    public function getProductById($product_id) {
        $this->db->select('product.*,shop.*,shop_nature.shop_nature_name');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'course.course_id_pri = product.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'drugorder.drugorder_id_pri = product.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drug.drug_id_pri = drugorder.drug_id_pri', 'LEFT');
        $this->db->where('product.product_active_id', 1);
        $this->db->where('product.product_status_id', 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('product.product_end >', date('Y-m-d'));
        $this->db->where('product.product_id', $product_id);
        $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }
        return $this->db->get();
    }

    public function insertCart($data) {
        $this->db->insert('orderdetail_temp', $data);
        return $this->db->insert_id();
    }

    public function deleteCart($odt_id) {
        $this->db->where('orderdetail_temp.orderdetail_temp_id_pri', $odt_id);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->delete('orderdetail_temp');
    }

    // review
//    public function getOrderReview($order_id_pri) {
//        $this->db->select('
//            orderdetail.orderdetail_name,
//            orderdetail.orderdetail_amount,
//            orderdetail.orderdetail_total,
//            orderdetail.orderdetail_point,
//            orderdetail.orderdetail_unit,
//        ');
//        $this->db->from('orderdetail');
//        $this->db->where('orderdetail.order_id_pri', $order_id_pri);
//        return $this->db->get();
//    }
//    public function insertReview($data) {
//        $this->db->insert('productreview', $data);
//        return $this->db->insert_id();
//    }
//
//    public function updateReview($product_review_id, $data) {
//        $this->db->where('productreview.productreview_id', $product_review_id);
//        $this->db->update('productreview', $data);
//    }
}
