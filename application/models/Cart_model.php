<?php

class Cart_model extends CI_Model {

    public function getProductById($product_id) {
        $this->db->select('
            product.shop_id_pri,
            product.course_id_pri,
            product.drugorder_id_pri,
            product.product_id,
            product.product_name,
            product.product_type_id,
            product.product_group_id,
            product.product_amount,
            product.product_unit,
            product.product_cost,
            product.product_price,
            product.product_total,
            product.product_point,
            course.course_id,
            course.course_name,
            drug.drug_id,
            drug.drug_name
        ');
        $this->db->from('product');
        // shop
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        // $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        // course
        $this->db->join('course', 'course.course_id_pri = product.course_id_pri', 'LEFT');
        // drug
        $this->db->join('drugorder', 'drugorder.drugorder_id_pri = product.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drug.drug_id_pri = drugorder.drug_id_pri', 'LEFT');
        // where
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where('product.product_active_id', 1);
        $this->db->where('product.product_status_id', 1);
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

    public function getMyPoint() {
        $this->db->select('online.online_point');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getCart() {
        $this->db->select('*');
        $this->db->from('orderdetail_temp');
        $this->db->join('shop', 'shop.shop_id_pri = orderdetail_temp.shop_id_pri');
        $this->db->join('product', 'product.product_id = orderdetail_temp.product_id');
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->order_by('product.product_id', 'ASC');
        return $this->db->get();
    }

    public function getCustomerOnline() {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getOrderDrug($drugorder_id_pri) {
        $this->db->select('drugorder.drugordert_total');
        $this->db->from('drug');
        $this->db->join('drugorder', 'drugorder.drug_id_pri = drug.drug_id_pri');
        // $this->db->join('druglot', 'drugorder.druglot_id = druglot.druglot_id');
        $this->db->where('drug.drug_status_id', 1);
        $this->db->where('drugorder.drugorder_id_pri', $drugorder_id_pri);
        $this->db->where('drugorder.drugorder_status_id', 1);
        $this->db->where('drugorder.drugordert_total >', 0);
        $this->db->where('drugorder.drugorder_expdate >', date('Y-m-d'));
        $this->db->limit(1);
        return $this->db->get();
    }

    public function checkShopCart($shop_id_pri) {
        $this->db->select('orderdetail_temp.orderdetail_temp_id_pri');
        $this->db->from('orderdetail_temp');
        $this->db->where('orderdetail_temp.shop_id_pri != ', $shop_id_pri);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        return $this->db->get()->num_rows();
    }

    public function getShopById($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
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

    public function clearShopCart($shop_id_pri) {
        $this->db->where('orderdetail_temp.shop_id_pri != ', $shop_id_pri);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->delete('orderdetail_temp');
    }

}
