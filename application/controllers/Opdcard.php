<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opdcard extends CI_Controller
{
    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('opdcard_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        $data = array(
            'title'       => ' ประวัติการรักษา OPD ',
            'description' => ' ประวัติการรักษา OPD ',
            'keyword'     => ' ประวัติการรักษา OPD ',
            'meta'        => array(),
            'css_full'    => array(),
            'js_full'     => array(),
            'data' => $this->opdcard_model->getOnlineByID($this->session->userdata('online_id'))->row()
        );
        $this->renderView('opdcard_view', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->opdcard_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('opdcard/ajax_pagination');
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
            'data'    => $this->opdcard_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count'   => $count,
            'segment' => $segment,
            'links'   => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/opdcard_pagination', $data);
    }

    public function opdUploadModal() {
        $data = array(
            'images'         => $this->opdcard_model->getOpdUpload($this->input->post('opd_id'), $this->input->post('opdupload_type')),
            'opdupload_type' => $this->input->post('opdupload_type'),
        );
        $this->load->view('modal/opdupload_view_modal', $data);
    }

    public function opdDetailModal() {
        $data = array(
            'opd_id' => $this->input->post('opd_id'),
        );
        $this->load->view('modal/opdcard_detail_modal', $data);
    }

}