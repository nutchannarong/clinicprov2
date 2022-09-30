<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('services_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        $data = array(
            'title' => 'การใช้บริการ/คอร์ส',
            'description' => 'การใช้บริการ/คอร์ส',
            'keyword' => 'การใช้บริการ/คอร์ส',
            'css' => array(),
            'js' => array(),
        );
        $this->renderView('services_view', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext'),
        );
//        echo "<pre>";
//        print_r($filter);
//        echo "</pre>";
        $count = $this->services_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('services/ajax_pagination');
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
            'data' => $this->services_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/services_pagination', $data);
    }

    public function viewModal() {
        $data = array(
            'rows' => $this->services_model->get_serving($this->input->post('course_id_pri'), $this->input->post('serving_status_id')),
            'serving_status_id' => $this->input->post('serving_status_id'),
            'course_id_pri' => $this->input->post('course_id_pri'),
        );
        $this->load->view('modal/services_view_modal', $data);
    }

}
