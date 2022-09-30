<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Review extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('review_model');
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
            'title' => 'รีวิว',
            'description' => 'รีวิว',
            'keyword' => 'รีวิว',
            'meta' => $meta,
            'css' => array(),
            'js' => array()
        );
        $this->renderView('review_view', $data);
    }

    public function ajax_pagination() {
        $per_page = $this->input->post('per_page');
        $filter = array(
            'sort_rating' => $this->input->post('sort_rating'),
            'shop_province' => $this->input->post('shop_province'),
            'per_page' => $per_page
        );
        $count = $this->review_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('review/ajax_pagination');
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
            'data' => $this->review_model->getPagination($filter, array('start' => $segment, 'limit' => $per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/review_pagination', $data);
    }

}
