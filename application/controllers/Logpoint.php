<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logpoint extends CI_Controller
{
    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('logpoint_model');
        $this->load->library('ajax_pagination');
        $this->logs = $this->load->database('logs', TRUE);
    }

    public function index() {
        $data = array(
            'title'       => ' ประวัติการใช้แต้ม ',
            'description' => ' ประวัติการใช้แต้ม ',
            'keyword'     => ' ประวัติการใช้แต้ม ',
            'meta'        => array(),
            'css'         => array(),
            'js'          => array(),
        );
        $this->renderView('logpoint_view', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->logpoint_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('logpoint/ajax_pagination');
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
            'data'    => $this->logpoint_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count'   => $count,
            'segment' => $segment,
            'links'   => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/logpoint_pagination', $data);
    }
}