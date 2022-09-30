<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('cart_model');
    }

    public function index() {
        $data = array(
            'title'       => ' ตะกร้าสินค้า ',
            'description' => ' ตะกร้าสินค้า ',
            'keyword'     => ' ตะกร้าสินค้า ',
            'meta'        => array(),
            'css'         => array('jquery.Thailand.min.css'),
            'css_full'    => array('plugin/sweetalert2/dist/sweetalert2.min.css'),
            'js'          => array('formatter.js', 'thailand-db/dependencies/JQL.min.js', 'thailand-db/dependencies/typeahead.bundle.js', 'thailand-db/jquery.Thailand.min.js'),
            'js_full'     => array('plugin/cleave/cleave.min.js', 'plugin/sweetalert2/dist/sweetalert2.all.min.js'),
            'js_import'   => array('https://cdn.omise.co/omise.js'),
        );
        $this->renderView('cart_view', $data);
    }

    public function getCart() {
        $data = array(
            'cart' => $this->cart_model->getCart()
        );
        $this->load->view('ajax/cart_table', $data);
    }

    public function addToCart($product_id = null) {
        $get_product = $this->cart_model->getProductById($product_id);
        if ($get_product->num_rows() == 1 && !empty($this->session->userdata('online_id'))) {
            $product = $get_product->row();
            // check product shop
            if ($this->cart_model->checkShopCart($product->shop_id_pri) > 0) {
                $this->cart_model->clearShopCart($product->shop_id_pri);
            }
            // check product type
            if ($product->product_type_id == 1) {
                $odt_id = $product->course_id;
                $orderdetail_temp_discount = ($product->product_price - $product->product_total);
            } else {
                $odt_id = $product->drug_id;
                $orderdetail_temp_discount = ($product->product_price - $product->product_total) / $product->product_amount;
            }
            // check promotion birthdate
            $is_error = 0;
            if ($product->product_group_id == 2) {
                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                $month_current = date('m');
                if ($month_birthdate != $month_current) {
                    $is_error = 1;
                }
            }
            if ($is_error == 0) {
                $data = array(
                    'shop_id_pri'                => $product->shop_id_pri,
                    'user_id'                    => null,
                    'online_id'                  => $this->session->userdata('online_id'),
                    'opd_id'                     => null,
                    'course_id_pri'              => $product->course_id_pri,
                    'drugorder_id_pri'           => $product->drugorder_id_pri,
                    'opdchecking_id'             => null,
                    'codes_id'                   => null,
                    'product_id'                 => $product->product_id,
                    'orderdetail_temp_type_id'   => $product->product_type_id,
                    'orderdetail_temp_id'        => $odt_id,
                    'orderdetail_temp_name'      => $product->product_name,
                    'orderdetail_temp_amount'    => $product->product_amount,
                    'orderdetail_temp_unit'      => $product->product_unit,
                    'orderdetail_temp_cost'      => $product->product_cost,
                    'orderdetail_temp_price'     => $product->product_price,
                    'orderdetail_temp_discount'  => $orderdetail_temp_discount,
                    'orderdetail_temp_total'     => $product->product_total,
                    'orderdetail_temp_point'     => $product->product_point,
                    'orderdetail_temp_direction' => null,
                    'teams_id'                   => null,
                    'orderdetail_temp_modify'    => date('Y-m-d H:i:s')
                );
                $cart_id = $this->cart_model->insertCart($data);
                redirect('cart');
            } else {
                echo 'ไม่สามารถเพิ่มรายการนี้ได้';
            }
        } else {
            echo 'ไม่สามารถเพิ่มรายการนี้ได้';
        }
    }

    public function addToCartAjax() {
        $get_product = $this->cart_model->getProductById($this->input->post('product_id'));
        if ($get_product->num_rows() == 1 && !empty($this->session->userdata('online_id'))) {
            $product = $get_product->row();
            // check product shop
            if ($this->cart_model->checkShopCart($product->shop_id_pri) > 0) {
                $this->cart_model->clearShopCart($product->shop_id_pri);
            }
            // check product type
            if ($product->product_type_id == 1) {
                $odt_id = $product->course_id;
            } else {
                $odt_id = $product->drug_id;
            }
            // check promotion birthdate
            $is_error = 0;
            if ($product->product_group_id == 2) {
                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                $month_current = date('m');
                if ($month_birthdate != $month_current) {
                    $is_error = 1;
                }
            }
            if ($is_error == 0) {
                $data = array(
                    'shop_id_pri'                => $product->shop_id_pri,
                    'user_id'                    => null,
                    'online_id'                  => $this->session->userdata('online_id'),
                    'opd_id'                     => null,
                    'course_id_pri'              => $product->course_id_pri,
                    'drugorder_id_pri'           => $product->drugorder_id_pri,
                    'opdchecking_id'             => null,
                    'codes_id'                   => null,
                    'product_id'                 => $product->product_id,
                    'orderdetail_temp_type_id'   => $product->product_type_id,
                    'orderdetail_temp_id'        => $odt_id,
                    'orderdetail_temp_name'      => $product->product_name,
                    'orderdetail_temp_amount'    => $product->product_amount,
                    'orderdetail_temp_unit'      => $product->product_unit,
                    'orderdetail_temp_cost'      => $product->product_cost,
                    'orderdetail_temp_price'     => $product->product_price,
                    'orderdetail_temp_discount'  => null,
                    'orderdetail_temp_total'     => $product->product_total,
                    'orderdetail_temp_point'     => $product->product_point,
                    'orderdetail_temp_direction' => null,
                    'teams_id'                   => null,
                    'orderdetail_temp_modify'    => date('Y-m-d H:i:s')
                );
                $cart_id = $this->cart_model->insertCart($data);
                $json = array(
                    'status'  => 'success',
                    'title'   => 'ทำรายกายสำเร็จ',
                    'message' => 'เพิ่มรายการเรียบร้อยแล้ว'
                );
            } else {
                $json = array(
                    'status'  => 'error',
                    'title'   => 'ทำรายการไม่สำเร็จ',
                    'message' => 'ไม่สามารถเพิ่มรายการนี้ได้'
                );
            }
        } else {
            $json = array(
                'status'  => 'error',
                'title'   => 'ทำรายการไม่สำเร็จ',
                'message' => 'ไม่สามารถเพิ่มรายการนี้ได้'
            );
        }
        echo json_encode($json);
    }

    public function deleteCart() {
        if (!empty($this->input->post('odt_id'))) {
            $this->cart_model->deleteCart($this->input->post('odt_id'));
            $json = array(
                'status'  => 'success',
                'title'   => 'ทำรายกายสำเร็จ',
                'message' => 'ลบรายการเรียบร้อยแล้ว'
            );
        } else {
            $json = array(
                'status'  => 'error',
                'title'   => 'ทำรายการไม่สำเร็จ',
                'message' => 'ไม่สามารถลบรายการนี้ได้'
            );
        }
        echo json_encode($json);
    }

    // checkout
    public function checkoutModal() {
        $data = array(
            'cart'     => $this->cart_model->getCart(),
            'my_point' => $this->cart_model->getMyPoint()->row()->online_point,
            'customer' => $this->cart_model->getCustomerOnline()->row()
        );
        $this->load->view('modal/checkout_modal', $data);
    }

    public function test() {
        print_r($this->input->post());
    }

}
