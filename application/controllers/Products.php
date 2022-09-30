<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('products_model');
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
            'title' => 'โปรโมชั่น',
            'description' => 'โปรโมชั่น',
            'keyword' => 'โปรโมชั่น',
            'meta' => $meta,
            'css' => array('ribbon.css'),
            'js' => array(),
        );
        $this->renderView('products_view', $data);
    }

    public function ajax_pagination() {
        $per_page = $this->input->post('per_page');
        $get_location = $this->products_model->getLocationProvince($this->input->post('location'));
        if ($get_location->num_rows() == 1) {
            $row_location = $get_location->row();
            $location = $row_location->province_name_th;
        } else {
            $location = '';
        }

        $filter = array(
            'searchtext' => $this->input->post('searchtext'),
            'sort_product_percent' => $this->input->post('sort_product_percent'),
            'sort_rating' => $this->input->post('sort_rating'),
            'sort_price' => $this->input->post('sort_price'),
            'per_page' => $per_page,
            'location' => $location,
            'shop_province' => $this->input->post('shop_province'),
            'shop_amphoe' => $this->input->post('shop_amphoe'),
            'shop_district' => $this->input->post('shop_district'),
            'nature_name' => $this->input->post('nature_name'),
            'category_name' => $this->input->post('category_name'),
            'min_discount' => $this->input->post('min_discount'),
            'max_discount' => $this->input->post('max_discount'),
            'min_price' => $this->input->post('min_price'),
            'max_price' => $this->input->post('max_price')
        );
//        echo "<pre>";
//        print_r($filter);
//        echo "</pre>";
        $count = $this->products_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('products/ajax_pagination');
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page;
        $config['additional_param'] = $this->ajax_pagination->filterParams($filter);
        $config['num_links'] = 4;
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);
        $segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($segment > 0 && $count <= $segment) {
            $segment = $segment - $per_page;
        }
        $data = array(
            'data' => $this->products_model->getPagination($filter, array('start' => $segment, 'limit' => $per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/products_pagination', $data);
    }

}
