<?php


class Productsearch extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productsearch_model');
    }

    public function getShopAmphoe()
    {
        $get_shop_amphoe = $this->productsearch_model->getShopAmphoe($this->input->post('shop_province'));
        if ($get_shop_amphoe->num_rows() > 0) {
            $i = 1;
            foreach ($get_shop_amphoe->result() as $item) {
                if ($i == 1) {
                    $data['data_shop_amphoe'][] = "<option value='' >ทั้งหมด</option>";
                }
                $selected = $this->input->post('shop_amphoe') == $item->shop_amphoe ? 'selected' : '';
                $data['data_shop_amphoe'][] = '<option value="' . $item->shop_amphoe . '" ' . $selected . '>' . $item->shop_amphoe . '</option>';
                $i++;
            }
            $data['status'] = true;
        } else {
            $data['data_shop_amphoe'][] = "<option value='' >ทั้งหมด</option>";
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function getShopDistrict()
    {
        $get_shop_district = $this->productsearch_model->getShopDistrict($this->input->post('shop_amphoe'));
        if ($get_shop_district->num_rows() > 0) {
            $i = 1;
            foreach ($get_shop_district->result() as $item) {
                if ($i == 1) {
                    $data['data_shop_district'][] = "<option value='' >ทั้งหมด</option>";
                }
                $selected = $this->input->post('shop_district') == $item->shop_district ? 'selected' : '';
                $data['data_shop_district'][] = '<option value="' . $item->shop_district . '" ' . $selected . '>' . $item->shop_district . '</option>';
                $i++;
            }
            $data['status'] = true;
        } else {
            $data['data_shop_district'][] = "<option value='' >ทั้งหมด</option>";
            $data['status'] = false;
        }
        echo json_encode($data);
    }
}