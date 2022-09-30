<?php

class Search extends CI_Controller {

    public $per_page = 9;

    public function __construct() {
        parent::__construct();
        $this->load->model('search_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {

        $meta = array(
            'og:site_name' => $this->config->item('app_title'),
            'og:url' => base_url(),
            'og:title' => $this->config->item('app_title'),
            'og:locale' => 'th_th',
            'og:description' => $this->config->item('app_description'),
            'og:image' => base_url() . 'assets/img/thumbnail.jpg',
            'og:image:width' => '560',
            'og:image:height' => '420',
            'og:type' => 'article',
        );
        $data = array(
            'title' => 'ค้นหาคลินิก',
            'description' => 'ค้นหาคลินิก',
            'keyword' => 'ค้นหาคลินิก',
            'meta' => $meta,
            'css' => array('google-vector-map.css', 'ion.rangeSlider.css'),
            'js' => array(),
        );

        $this->renderView('search/search_view', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'id' => $this->input->post('id') == '' ? array() : $this->input->post('id'),
            'searchtext' => $this->input->post('searchtext'),
        );

        if (count($filter['id']) > 0) {
            $id = "[" . join(',', $filter['id']) . "]";
        } else {
            $id = "[]";
        }
//        echo "<pre>";
//        print_r($filter);
//        echo "</pre>";

        $count = $this->search_model->count_pagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('search/ajax_pagination');
        $config['total_rows'] = $count;
        $config['additional_param'] = "{'lat1' : '" . $this->input->post('lat1') . "', 'lon1' : '" . $this->input->post('lon1') . "', 'searchtext' : '" . $this->input->post('searchtext') . "', 'id[]' : " . $id . "}";
        $config['per_page'] = $this->per_page;
        $config['num_links'] = 4;
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);
        $segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data = array(
            'datas' => $this->search_model->get_pagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links(),
            'lat1' => $this->input->post('lat1'),
            'lon1' => $this->input->post('lon1'),
        );
        $this->load->view('search/search_pagination', $data);
    }

    public function ajax_bar() {
        $data = array(
            'datas' => $this->search_model->getNatureArray($this->input->post('id')),
        );
        $this->load->view('search/search_bar', $data);
    }

    public function getMap() {
        $id = $this->input->post('id');
        $shopdata = array();
        $shops = $this->search_model->getShopByNature($id);
        if ($shops->num_rows() > 0) {
            foreach ($shops->result() as $shop) {
                $shopdata[] = array(
                    'id' => $shop->shop_id_pri,
                    'shop_id' => $shop->shop_id,
                    'name' => $shop->shop_name,
                    'nature' => $shop->shop_nature,
                    'tel' => $shop->shop_tel,
                    'address' => $shop->shop_address,
                    'district' => $shop->shop_district,
                    'amphoe' => $shop->shop_amphoe,
                    'province' => $shop->shop_province,
                    'zipcode' => $shop->shop_zipcode,
                    'image' => admin_url() . 'assets/upload/shop/' . $shop->shop_image,
                    'latlong' => $shop->shop_latlong
                );
            }
        }
        echo json_encode($shopdata);
    }

}
