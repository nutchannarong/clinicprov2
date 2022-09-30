<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Productdetail extends CI_Controller {

    public $per_page = 5;

    public function __construct() {
        parent::__construct();
        $this->load->model('productdetail_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        redirect(base_url() . 'promotions');
    }

    public function show($product_slug = null) {
        $get_product = $this->productdetail_model->getProductBySlug(urldecode($product_slug));
        if ($get_product->num_rows() == 1) {
            $row_product = $get_product->row_array();
            $meta = array(
                'og:site_name' => 'โปรโมชั่น ' . $row_product['product_name'] . ' - ' . $this->config->item('app_title'),
                'og:url' => base_url() . 'promotion/' . $row_product['product_slug'],
                'og:title' => 'โปรโมชั่น ' . $row_product['product_name'] . ' - ' . $this->config->item('app_title'),
                'og:locale' => 'th_th',
                'og:description' => 'โปรโมชั่น ' . $row_product['product_name'] . ' ' . $this->config->item('app_description'),
                'og:image' => admin_url() . 'assets/upload/product/' . $row_product['product_image'],
                'og:image:width' => '560',
                'og:image:height' => '420',
                'og:type' => 'article'
            );
            $get_map_cat = $this->productdetail_model->getProductMapCategory($row_product['product_id']);
            $keyword_cat = '';
            $count_map_cat = $get_map_cat->num_rows();
            $c = 1;
            foreach ($get_map_cat->result() as $row_c) {
                $keyword_cat = $keyword_cat . $row_c->product_category_name . ($count_map_cat != $c ? ',' : '');
                $c++;
            }
            $this->productdetail_model->updateProduct($row_product['product_id'], array('product_view' => $row_product['product_view'] + 1));
            $data = array(
                'title' => $row_product['product_name'],
                'description' => $row_product['product_name'],
                'keyword' => $row_product['product_name'] . ',' . $keyword_cat,
                'meta' => $meta,
                'css' => array('ribbon.css', 'star-rating-svg.css'),
                'js' => array('jquery.star-rating-svg.js'),
                'row_product' => $row_product
            );
            $this->renderView('product_detail_view', $data);
        } else {
            redirect(base_url('promotions'));
        }
    }

    // product review
    public function getReviewForm() {
        $data = array(
            'product_id' => $this->input->post('product_id')
        );
        $this->load->view('ajax/product_review_form', $data);
    }

    public function processReview() {
        $review_image = '';
        if (!empty($_FILES['review_image']['tmp_name'])) {
            $headers = array(
                'Authorization: Bearer Token Value',
                'Content-type: multipart/form-data'
            );
            $post = array(
                'product_id' => $this->input->post('product_id'),
                'online_id' => $this->session->userdata('online_id'),
                'fileupload' => curl_file_create($_FILES['review_image']['tmp_name'], $_FILES['review_image']['type'], $_FILES['review_image']['name'])
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, admin_url() . 'uploadfile/review');
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
        $data = array(
            'product_id' => $this->input->post('product_id'),
            'productreview_image' => $review_image,
            'online_id' => $this->session->userdata('online_id'),
            'productreview_comment' => $this->input->post('review_comment'),
            'productreview_comment_date' => date('Y-m-d H:i:s'),
            'user_id' => null,
            'productreview_reply' => '',
            'productreview_reply_date' => null,
            'productreview_rating' => $this->input->post('review_rating'),
            'productreview_status_id' => 1
        );
        $review_id = $this->productdetail_model->insertReview($data);
        if ($review_id) {
            // add point
            $add_point = $this->config->item('point_reply');
            $current_point = $this->productdetail_model->getCurrentPoint()->row()->online_point;
            $sum_point = $add_point + $current_point;
            $data = array(
                'online_point' => $sum_point
            );
            $this->productdetail_model->updateOnline($data);
            $get_review_rating = $this->productdetail_model->getReviewRating($this->input->post('product_id'));
            $n_review = $get_review_rating->num_rows();
            if ($n_review > 0) {
                $sum_all_rating = 0;
                foreach ($get_review_rating->result() as $row) {
                    $sum_all_rating += $row->productreview_rating;
                }
                $product_rating = $sum_all_rating / $n_review;
            } else {
                $product_rating = 0;
            }
            $data = array(
                'product_rating' => $product_rating,
                'product_update' => date('Y-m-d H:i:s')
            );
            $this->productdetail_model->updateProduct($this->input->post('product_id'), $data);
            $this->systemlog->log_pointonline('เพิ่มแต้มรีวิว', $this->input->post('shop_id_pri'), $this->session->userdata('online_id'), 1, $current_point, $add_point, $sum_point);
            $json = array(
                'status' => 'success',
                'title' => 'สำเร็จ',
                'message' => 'รีวิวสินค้าเรียบร้อยเเล้ว'
            );
        } else {
            $json = array(
                'status' => 'error',
                'title' => 'เกิดข้อผิดพลาด',
                'message' => 'ข้อมูลรีวิวไม่ถูกต้อง'
            );
        }
        echo json_encode($json);
    }

    public function ajax_pagination() {
        $filter = array(
            'product_id' => $this->input->post('product_id')
        );
        $count = $this->productdetail_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('productdetail/ajax_pagination');
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
            'data' => $this->productdetail_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/product_review_pagination', $data);
    }

}
