<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Productbirthdate extends CI_Controller
{
    public $per_page = 10;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('productbirthdate_model');
        $this->load->library('ajax_pagination');
    }

    public function index()
    {
        $data = array(
            'title' => ' บริการเเนะนำ ',
            'description' => ' บริการเเนะนำ ',
            'keyword' => ' บริการเเนะนำ ',
            'css' => array('ribbon.css'),
            'js' => array(),
            'data' => $this->productbirthdate_model->getOnlineByID($this->session->userdata('online_id'))->row()
        );
        $this->renderView('productbirthdate_view', $data);
    }

    public function ajax_pagination()
    {
        $online_point = $this->global_model->getOnlineByID($this->session->userdata('online_id'))->row()->online_point;
        $filter = array(
            'searchtext' => $this->input->post('searchtext'),
            'shop_nature_id' => $this->input->post('shop_nature_id'),
            'product_category_id' => $this->input->post('product_category_id'),
            'shop_province' => $this->input->post('shop_province'),
            'online_point' => $online_point
        );
//        echo "<pre>";
//        print_r($filter);
//        echo "</pre>";
        $count = $this->productbirthdate_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('productbirthdate/ajax_pagination');
        $config['total_rows'] = $count;
        $config['per_page'] = $this->per_page;
        $config['additional_param'] = $this->ajax_pagination->filterParams($filter);
        $config['num_links'] = 4;
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);
        $segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        if ($segment > 0 && $count <= $segment) {
            $segment = $segment - $this->per_page;
        }
        $data = array(
            'data' => $this->productbirthdate_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/productbirthdate_pagination', $data);
    }
}