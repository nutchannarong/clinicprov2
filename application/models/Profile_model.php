<?php

class Profile_model extends CI_Model {

    public function getOnlineByID($online_id) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $online_id);
        return $this->db->get();
    }

    public function getOnlineByTelPass($tel, $pass) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_tel', $tel);
        $this->db->where('online.online_password', $pass);
        return $this->db->get();
    }

    public function getOnlineByEmail($online_email) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_email', $online_email);
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function getOnlineByEmailFB($facebook_id, $online_email) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.facebook_id', $facebook_id);
        $this->db->where('online.online_email', $online_email);
        $this->db->where('online.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    //action
    public function update($online_id, $data) {
        $this->db->where('online.online_id', $online_id);
        $this->db->update('online', $data);
    }

}
