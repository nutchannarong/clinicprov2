<?php

/**
 * Description of Setting_model
 * @author SakchaiCM
 */
class Setting_model extends CI_Model {

    public function getSettingSms() {
        $this->db->limit(1);
        return $this->db->get('setting_email')->row();
    }

    public function editSettingSms($data) {
        $this->db->update('setting_email', $data);
    }

    public function getShop($shop_id_pri) {
        $this->db->select('*');
        $this->db->from('shop');
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        $this->db->limit(1);
        return $this->db->get();
    }

    public function updateShop($shop_id_pri, $data) {
        $this->db->where('shop_id_pri', $shop_id_pri);
        $this->db->update('shop', $data);
    }

}
