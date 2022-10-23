<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Servingreview extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('servingreview_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        $data = array(
            'title'       => ' รีวิวหลังการใช้บริการ ',
            'description' => ' รีวิวหลังการใช้บริการ ',
            'keyword'     => ' รีวิวหลังการใช้บริการ ',
            'meta'        => array(),
            'css'         => array('star-rating-svg.css'),
            'css_full'    => array(),
            'js'          => array('jquery.star-rating-svg.js'),
            'js_full'     => array(),
            'js_import'   => array(),
            'data' => $this->servingreview_model->getOnlineByID($this->session->userdata('online_id'))->row()
        );
        $this->renderView('serving_review_view', $data);
    }

    public function ajaxPagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->servingreview_model->getPagination($filter, array());
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('servingreview/ajaxpagination');
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
            'data'    => $this->servingreview_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count'   => $count,
            'segment' => $segment,
            'links'   => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/serving_review_pagination', $data);
    }

    public function servingReviewModal() {
        $get_serving_review = $this->servingreview_model->getServingReviewById($this->input->post('servingreview_id'));
        if ($get_serving_review->num_rows() == 1) {
            $data = array(
                'data' => $get_serving_review->row()
            );
            $this->load->view('modal/serving_review_modal', $data);
        } else {
            echo '';
        }
    }

    public function processReview() {
        $get_serving_review = $this->servingreview_model->getServingReviewById($this->input->post('servingreview_id'));
        if ($get_serving_review->num_rows() == 1) {
            $serving_review = $get_serving_review->row();
            if ($serving_review->servingreview_status_id == 0) {
                $review_image = '';
                if (!empty($_FILES['review_image']['tmp_name'])) {
                    $headers = array(
                        'Authorization: Bearer Token Value',
                        'Content-type: multipart/form-data'
                    );
                    $post = array(
                        'servingreview_id' => $this->input->post('servingreview_id'),
                        'fileupload'       => curl_file_create($_FILES['review_image']['tmp_name'], $_FILES['review_image']['type'], $_FILES['review_image']['name'])
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, admin_url() . 'uploadfile/servingreview');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $result = curl_exec($ch);
                    $result = json_decode($result);
                    curl_close($ch);
                    if ($result->status == 'success') {
                        $review_image = $result->file_name;
                    }
                }
                $point_review = $this->config->item('point_review');
                $data = array(
                    'servingreview_image'        => $review_image,
                    'online_id'                  => $this->session->userdata('online_id'),
                    'servingreview_comment'      => $this->input->post('review_comment'),
                    'servingreview_comment_date' => date('Y-m-d H:i:s'),
                    'servingreview_rating'       => $this->input->post('review_rating'),
                    'servingreview_user'       => $this->input->post('review_rating_user'),
                    'servingreview_doctor'       => $this->input->post('review_rating_doctor'),
                    'servingreview_shop'       => $this->input->post('review_rating_shop'),
                    'servingreview_point'        => $point_review,
                    'servingreview_status_id'    => 1
                );
                $this->servingreview_model->updateServingReview($this->input->post('servingreview_id'), $data);
                // add point
                $add_point = $point_review;
                $current_point = $this->servingreview_model->getCurrentPoint()->row()->online_point;
                $sum_point = $add_point + $current_point;
                $data_point = array(
                    'online_point' => $sum_point
                );
                $this->servingreview_model->updatePoint($data_point);
                $this->systemlog->log_pointonline('เพิ่มแต้มรีวิว'.' ('.$serving_review->serve_code.')', $this->config->item('shop_id_pri'), $this->session->userdata('online_id'), 1, $current_point, $add_point, $sum_point);
                $json = array(
                    'status'  => 'success',
                    'title'   => 'สำเร็จ',
                    'message' => 'รีวิวสินค้าเรียบร้อยเเล้ว'
                );
            } else {
                $json = array(
                    'status'  => 'error',
                    'title'   => 'เกิดข้อผิดพลาด',
                    'message' => 'ไม่สามารถแก้ไขรีวิวนี้ได้'
                );
            }
        } else {
            $json = array(
                'status'  => 'error',
                'title'   => 'เกิดข้อผิดพลาด',
                'message' => 'ไม่พบข้อมูลรีวิวนี้'
            );
        }
        echo json_encode($json);
    }

}
