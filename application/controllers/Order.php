<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('islogin') != 1) {
            redirect(base_url() . 'authen');
        }
        $this->load->model('order_model');
        $this->load->library('ajax_pagination');
        $this->logs = $this->load->database('logs', TRUE);
    }

    public function index() {
        $data = array(
            'title' => ' ประวัติการสั่งซื้อ ',
            'description' => ' ประวัติการสั่งซื้อ ',
            'keyword' => ' ประวัติการสั่งซื้อ ',
            'meta' => array(),
            'css' => array('jquery.Thailand.min.css'),
            'css_full' => array('plugin/sweetalert2/dist/sweetalert2.min.css'),
            'js' => array('formatter.js', 'thailand-db/dependencies/JQL.min.js', 'thailand-db/dependencies/typeahead.bundle.js', 'thailand-db/jquery.Thailand.min.js'),
            'js_full' => array('plugin/cleave/cleave.min.js', 'plugin/sweetalert2/dist/sweetalert2.all.min.js'),
            'js_import' => array('https://cdn.omise.co/omise.js'),
            'data' => $this->order_model->getOnlineByID($this->session->userdata('online_id'))->row()
        );
        $this->renderView('order_view', $data);
    }

    public function ajaxPagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->order_model->getPagination($filter, array());
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('order/ajaxpagination');
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
            'data' => $this->order_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/order_pagination', $data);
    }

    public function cardPayment2() {
        if (!empty($this->session->userdata('online_id'))) {
            $get_cart = $this->order_model->getCartCheck();
            if ($get_cart->num_rows() > 0) {
                // check drug and promotion
                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                $month_current = date('m');
                $is_drug_error = 0;
                $is_promotion_error = 0;
                $product_price_checked = 0;
                $drug_cart_qty = array();
                foreach ($get_cart->result() as $cart) {
                    $product_price_checked += $cart->orderdetail_temp_total;
                    if (!empty($cart->drugorder_id_pri)) {
                        $drug_stock_qty = 0;
                        $get_order_drug_check = $this->order_model->getOrderDrugCheck($cart->drugorder_id_pri);
                        if ($get_order_drug_check->num_rows() == 1) {
                            $drug_stock_qty = $get_order_drug_check->row()->drugordert_total;
                        }
                        if (empty($drug_cart_qty[$cart->drugorder_id_pri])) {
                            $drug_cart_qty[$cart->drugorder_id_pri] = 0;
                        }
                        $drug_cart_qty[$cart->drugorder_id_pri] += $cart->orderdetail_temp_amount;
                        $check_drug_stock_qty = $drug_stock_qty - $drug_cart_qty[$cart->drugorder_id_pri];
                        if ($check_drug_stock_qty < 0) {
                            $is_drug_error = 1;
                        }
                    }
                    // check promotion birthdate
                    if ($cart->product_group_id == 2) {
                        if ($month_birthdate != $month_current) {
                            $is_promotion_error = 1;
                        }
                    }
                }
                // post data
                $product_price = $this->input->post('product_price');
                $use_point = !empty($this->input->post('use_point')) ? intval($this->input->post('use_point')) : 0;
                $omise_token = $this->input->post('omise_token');
                // check point
                $is_point_error = 0;
                if ($use_point > 0) {
                    $online = $this->order_model->getOnline()->row();
                    if ($online->online_point >= $use_point) {
                        $is_point_error = 0;
                        // add used point
                    } else {
                        $is_point_error = 1;
                    }
                }
                // omise charge
                $amount = ($product_price_checked - $use_point) * 100;
                if ($is_drug_error == 0 && $is_promotion_error == 0 && $is_point_error == 0 && $product_price == $product_price_checked && $amount >= 5000 && !empty($omise_token)) {
                    require_once APPPATH . 'third_party/omise-php/lib/Omise.php';
                    define('OMISE_API_VERSION', $this->config->item('OMISE_API_VERSION'));
                    define('OMISE_PUBLIC_KEY', $this->config->item('OMISE_PUBLIC_KEY'));
                    define('OMISE_SECRET_KEY', $this->config->item('OMISE_SECRET_KEY'));
                    // charge
                    $charge = OmiseCharge::create(
                                    array(
                                        'amount' => $amount,
                                        'currency' => 'THB',
                                        'card' => $omise_token
                                    )
                    );
                    if ($charge['status'] == 'successful') {
                        $charge_data = array(
                            'online_id' => $this->session->userdata('online_id'),
                            'charge_chrg_id' => $charge['id'],
                            'charge_chrg_amount' => $charge['amount'],
                            'charge_chrg_fee' => $charge['fee'],
                            'charge_chrg_fee_vat' => $charge['fee_vat'],
                            'charge_chrg_net' => $charge['net'],
                            'charge_card_name' => $charge['card']['name'],
                            'charge_card_last_digit' => $charge['card']['last_digits'],
                            'charge_card_bank' => $charge['card']['bank'],
                            'charge_card_brand' => $charge['card']['brand'],
                            'charge_create' => date('Y-m-d H:i:s')
                        );
                        $charge_id = $this->order_model->insertCharge($charge_data);
                        $response = array(
                            'status' => 'success',
                            'message' => 'ชำระเงินเรียบร้อยแล้ว',
                            'charge_id' => $charge_id
                        );
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => 'ชำระเงินไม่สำเร็จ',
                            'charge_id' => null
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'สินค้าหรือแต้มมีจำนวนไม่เพียงพอ',
                        'charge_id' => null
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'ไม่มีรายการสินค้าในตะกร้า',
                    'charge_id' => null
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบเพื่อทำรายการ',
                'charge_id' => null
            );
        }
        echo json_encode($response);
    }

    public function addOrder2() {
        if (!empty($this->session->userdata('online_id'))) {
            // post address data
            $shipping_type_id = $this->input->post('shipping_type_id');
            $prefix = $this->input->post('prefix');
            $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
            $phone = $this->input->post('phone');
            $address = $this->input->post('address');
            $sub_district = $this->input->post('sub_district');
            $district = $this->input->post('district');
            $province = $this->input->post('province');
            $zipcode = $this->input->post('zipcode');
            // post order data
            $product_price = $this->input->post('product_price');
            $use_point = !empty($this->input->post('use_point')) ? intval($this->input->post('use_point')) : 0;
            $charge_id = $this->input->post('charge_id');
            // get cart
            $product_point = 0;
            $get_cart = $this->order_model->getCartCheck();
            if ($get_cart->num_rows() > 0) {
                // check drug and promotion
                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                $month_current = date('m');
                $is_promotion_error = 0;
                $is_drug_error = 0;
                $product_price_checked = 0;
                $drug_cart_qty = array();
                foreach ($get_cart->result() as $cart) {
                    $product_price_checked += $cart->orderdetail_temp_total;
                    $product_point += $cart->orderdetail_temp_point;
                    if (!empty($cart->drugorder_id_pri)) {
                        $drug_stock_qty = 0;
                        $get_order_drug_check = $this->order_model->getOrderDrugCheck($cart->drugorder_id_pri);
                        if ($get_order_drug_check->num_rows() == 1) {
                            $drug_stock_qty = $get_order_drug_check->row()->drugordert_total;
                        }
                        if (empty($drug_cart_qty[$cart->drugorder_id_pri])) {
                            $drug_cart_qty[$cart->drugorder_id_pri] = 0;
                        }
                        $drug_cart_qty[$cart->drugorder_id_pri] += $cart->orderdetail_temp_amount;
                        $check_drug_stock_qty = $drug_stock_qty - $drug_cart_qty[$cart->drugorder_id_pri];
                        if ($check_drug_stock_qty < 0) {
                            $is_drug_error = 1;
                        }
                    }
                    // check promotion birthdate
                    if ($cart->product_group_id == 2) {
                        if ($month_birthdate != $month_current) {
                            $is_promotion_error = 1;
                        }
                    }
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'ไม่มีรายการสินค้าในตะกร้า',
                    'charge_id' => null
                );
            }
            // check card or point payment
            $is_payment_error = 0;
            if (!empty($charge_id)) {
                // card payment ( ignore is_drug_error )
                $get_charge = $this->order_model->getCharge($charge_id);
                if ($get_charge->num_rows() == 1) {
                    $charge = $get_charge->row();
                    $amount = ($product_price_checked - $use_point) * 100;
                    if ($charge->charge_chrg_amount >= $amount) {
                        $is_payment_error = 0;
                        // do something
                    } else {
                        $is_payment_error = 1;
                        $response = array(
                            'status' => 'error',
                            'message' => 'ยอดชำระเงินไม่ถูกต้อง',
                            'charge_id' => null
                        );
                    }
                } else {
                    $is_payment_error = 1;
                    $response = array(
                        'status' => 'error',
                        'message' => 'รายการชำระเงินไม่ถูกต้อง',
                        'charge_id' => null
                    );
                }
            } else {
                // point payment
                $online = $this->order_model->getOnline()->row();
                if ($online->online_point >= $use_point && $use_point >= $product_price_checked) {
                    $is_payment_error = 0;
                    // add used point
                } else {
                    $is_payment_error = 1;
                }
            }

            // nut code below //
            if ($is_payment_error == 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'ชำระเงินไม่สำเร็จ',
                    'order_id_pri' => null,
                );
            } else if ($is_drug_error == 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'ยาในรอบสต๊อกที่เลือกไม่พอจ่าย',
                    'order_id_pri' => null,
                );
            } else if ($is_promotion_error == 1) {
                $response = array(
                    'status' => 'error',
                    'message' => 'เงื่อนไขโปรโมชั่นไม่ถูกต้อง',
                    'order_id_pri' => null,
                );
            } else {
                // เช็ค customer
                $online = $this->order_model->get_online()->row();
                $shop_id_pri = $this->order_model->get_orderdetail_temp()->row(0)->shop_id_pri;
                $user_id = $this->order_model->get_user($shop_id_pri);
                $customer_onlines = $this->order_model->get_customer_online($shop_id_pri);
                // เป็นลูกค้าแล้ว(ซิงข้อมูลแล้ว)
                if ($customer_onlines->num_rows() == 1) {
                    $customer = $customer_onlines->row();
                } else {
                    $customer_onlines = $this->order_model->get_customer_tel($online->online_tel, $shop_id_pri);
                    // เป็นลูกค้าแล้ว(ยังไม่ซิงข้อมูล)
                    if ($customer_onlines->num_rows() == 1) {
                        $customer = $customer_onlines->row();
                        $datacustomer = array(
                            'online_id' => $online->online_id,
                            'customer_update' => $this->misc->getdate()
                        );
                        $this->order_model->update_customer($customer->customer_id_pri, $datacustomer);
                        //echo 'update';
                    } else {
                        $datacustomer = array(
                            'online_id' => $this->session->userdata('online_id'),
                            'customer_id' => '',
                            'shop_id_pri' => $shop_id_pri,
                            'user_id' => $user_id,
                            'customer_group_id' => $this->order_model->get_customer_group($shop_id_pri),
                            'customer_idcard' => $online->online_idcard,
                            'customer_prefix' => $online->online_prefix,
                            'customer_fname' => $online->online_fname,
                            'customer_lname' => $online->online_lname,
                            'customer_gender' => $online->online_gender,
                            'customer_blood' => $online->online_blood,
                            'customer_email' => $online->online_email,
                            'customer_tel' => $online->online_tel,
                            'customer_birthdate' => $online->online_birthdate,
                            'customer_address' => $online->online_address,
                            'customer_district' => $online->online_district,
                            'customer_amphoe' => $online->online_amphoe,
                            'customer_province' => $online->online_province,
                            'customer_zipcode' => $online->online_zipcode,
                            'customer_comment' => $online->online_comment,
                            'customer_allergic' => $online->online_allergic,
                            'customer_disease' => $online->online_disease,
                            'customer_image' => 'none.png',
                            'customer_point' => 0,
                            'customer_status_id' => 1,
                            'customer_tags' => '#ClinicPRO',
                            'customer_create' => $this->misc->getdate(),
                            'customer_update' => $this->misc->getdate()
                        );
                        $customer_id_pri = $this->order_model->insert_customer($datacustomer);
                        $datacustomertags = array(
                            'customer_id_pri' => $customer_id_pri,
                            'customer_tag_id' => 1,
                        );
                        $this->order_model->insert_customer_tag_map($datacustomertags);
                        if ($customer_id_pri > 0) {
                            $shop = $this->order_model->getDocSetting($shop_id_pri);
                            $customer_id = $shop->customer_id_default . sprintf('%0' . $shop->customer_number_digit . 'd', $shop->customer_number_default);
                            $this->order_model->update_customer($customer_id_pri, array('customer_id' => $customer_id));
                            $this->order_model->updateDocSetting(array('customer_number_default' => $shop->customer_number_default += 1), $shop_id_pri);
                        }
                        $customer = $this->order_model->get_customer_online($shop_id_pri)->row();
                        $logdata = array(
                            'log_status_id' => 1,
                            'customer_id_pri' => $customer_id_pri,
                            'shop_id_pri' => $shop_id_pri,
                            'user_id' => $user_id,
                            'customer_id' => $customer_id,
                            'customer_group_id' => $this->order_model->get_customer_group($shop_id_pri),
                            'customer_idcard' => $online->online_idcard,
                            'customer_prefix' => $online->online_prefix,
                            'customer_fname' => $online->online_fname,
                            'customer_lname' => $online->online_lname,
                            'customer_gender' => $online->online_gender,
                            'customer_blood' => $online->online_blood,
                            'customer_email' => $online->online_email,
                            'customer_tel' => $online->online_tel,
                            'customer_birthdate' => $online->online_birthdate,
                            'customer_address' => $online->online_address,
                            'customer_district' => $online->online_district,
                            'customer_amphoe' => $online->online_amphoe,
                            'customer_province' => $online->online_province,
                            'customer_zipcode' => $online->online_zipcode,
                            'customer_comment' => $online->online_comment,
                            'customer_allergic' => $online->online_allergic,
                            'customer_disease' => $online->online_disease,
                            'customer_status_id' => 1,
                            'log_user_id' => $user_id,
                            'log_ip_address' => $this->input->ip_address(),
                            'log_browser' => $this->systemlog->getAgent(),
                            'log_time' => $this->misc->getdate()
                        );
                        $this->order_model->insert_logcustomer($logdata);
                        //echo 'add';
                    }
                }
                //echo '<pre>';
                //print_r($customer);
                //echo '</pre>';
                // เพิ่ม Order
                if ($shipping_type_id == 1) {
                    $customer_name = $prefix . ' ' . $fname . '  ' . $lname;
                    $customer_tel = $phone;
                    $customer_email = $customer->customer_email;
                    $customer_address = $address;
                    $customer_district = $sub_district;
                    $customer_amphoe = $district;
                    $customer_province = $province;
                    $customer_zipcode = $zipcode;
                } else {
                    $customer_name = $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname;
                    $customer_tel = $customer->customer_tel;
                    $customer_email = $customer->customer_email;
                    $customer_address = $customer->customer_address;
                    $customer_district = $customer->customer_district;
                    $customer_amphoe = $customer->customer_amphoe;
                    $customer_province = $customer->customer_province;
                    $customer_zipcode = $customer->customer_zipcode;
                }
                $order_price = $product_price_checked;
                $dataorder = array(
                    'shop_id_pri' => $shop_id_pri,
                    'user_id' => $user_id,
                    'online_id' => $online->online_id,
                    'customer_id_pri' => $customer->customer_id_pri,
                    'customer_name' => $customer_name,
                    'customer_tel' => $customer_tel,
                    'customer_email' => $customer_email,
                    'customer_address' => $customer_address,
                    'customer_district' => $customer_district,
                    'customer_amphoe' => $customer_amphoe,
                    'customer_province' => $customer_province,
                    'customer_zipcode' => $customer_zipcode,
                    'order_pay_id' => 1,
                    'order_status_id' => 1,
                    'order_price' => $order_price,
                    'order_save_id' => 0,
                    'order_save_amount' => 0,
                    'order_save' => 0,
                    'order_befor_tax' => $order_price,
                    'order_tax_id' => 1,
                    'order_tax' => 0,
                    'order_total' => $order_price,
                    'order_totalpay' => $order_price,
                    'order_deposit_id' => 0,
                    'order_refund_id' => 1,
                    'order_clinicpro_id' => 1,
                    'order_shipping_id' => $shipping_type_id == 1 ? 1 : 0,
                    'charge_id' => !empty($charge_id) ? $charge_id : null,
                    'order_create' => $this->misc->getdate(),
                    'order_update' => $this->misc->getdate()
                );
                //echo '<pre>';
                //print_r($dataorder);
                //echo '</pre>';
                $order_id_pri = $this->order_model->insert_order($dataorder);
                if ($order_id_pri > 0) {
                    $shop = $this->order_model->getDocSetting($shop_id_pri);
                    $this->order_model->update_order($order_id_pri, array('order_id' => $shop->receipt_id_default . sprintf('%0' . $shop->receipt_number_digit . 'd', $shop->receipt_number_default)));
                    $order_id = $shop->receipt_id_default . sprintf('%0' . $shop->receipt_number_digit . 'd', $shop->receipt_number_default);
                    $this->order_model->updateDocSetting(array('receipt_number_default' => $shop->receipt_number_default += 1), $shop_id_pri);
                }
                // log order
                $action_text = 'เพิ่ม เลขที่ใบเสร็จ ' . $order_id;
                $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                $orderdetail_temps = $this->order_model->get_orderdetail_temp();
                if ($orderdetail_temps->num_rows() > 0) {
                    foreach ($orderdetail_temps->result() as $orderdetail_temp) {
                        // เพิ่มรายการ
                        $dataorderdetail = array(
                            'order_id_pri' => $order_id_pri,
                            'course_id_pri' => $orderdetail_temp->course_id_pri,
                            'drugorder_id_pri' => $orderdetail_temp->drugorder_id_pri,
                            'product_id' => $orderdetail_temp->product_id,
                            'orderdetail_type_id' => $orderdetail_temp->orderdetail_temp_type_id,
                            'orderdetail_id' => $orderdetail_temp->orderdetail_temp_id,
                            'orderdetail_name' => $orderdetail_temp->orderdetail_temp_name,
                            'orderdetail_amount' => $orderdetail_temp->orderdetail_temp_amount,
                            'orderdetail_unit' => $orderdetail_temp->orderdetail_temp_unit,
                            'orderdetail_cost' => $orderdetail_temp->orderdetail_temp_cost,
                            'orderdetail_price' => $orderdetail_temp->orderdetail_temp_price,
                            'orderdetail_discount' => $orderdetail_temp->orderdetail_temp_discount,
                            'orderdetail_total' => $orderdetail_temp->orderdetail_temp_total,
                            'orderdetail_direction' => $orderdetail_temp->orderdetail_temp_direction,
                            'orderdetail_point' => $orderdetail_temp->orderdetail_temp_point,
                            'orderdetail_modify' => $this->misc->getdate()
                        );
                        //echo '<pre>';
                        //print_r($dataorderdetail);
                        //echo '</pre>';
                        $orderdetail_id_pri = $this->order_model->insert_orderdetail($dataorderdetail);
                        // เพิ่มฉลากยา
                        if ($orderdetail_temp->orderdetail_temp_type_id == 2) {
                            $drugorders = $this->order_model->getdrug_drugorder($orderdetail_temp->drugorder_id_pri);
                            if ($drugorders->num_rows() > 0) {
                                $datadrugsticker = array(
                                    'drug_id_pri' => $drugorders->row()->drug_id_pri,
                                    'customer_id_pri' => $customer->customer_id_pri,
                                    'drugsticker_direction' => $orderdetail_temp->orderdetail_temp_direction,
                                    'drugsticker_amount' => $orderdetail_temp->orderdetail_temp_amount,
                                    'drugsticker_unit' => $orderdetail_temp->orderdetail_temp_unit,
                                    'drugsticker_price' => $orderdetail_temp->orderdetail_temp_total,
                                    'drugsticker_expdate' => $drugorders->row()->drugorder_expdate,
                                    'drugsticker_active_id' => 1,
                                    'drugsticker_modify' => $this->misc->getdate(),
                                );
                                //echo '<pre>';
                                //print_r($datadrugsticker);
                                //echo '</pre>';
                                $this->order_model->insert_drugsticker($datadrugsticker);
                            }
                        }
                        if ($orderdetail_temp->drugorder_id_pri != null || $orderdetail_temp->drugorder_id_pri != '') {
                            // อัพเดพยา
                            $orderdrug = $this->order_model->getorderdrug($orderdetail_temp->drugorder_id_pri)->row();
                            $datadrugorder = array(
                                'drugorder_sold' => $orderdrug->drugorder_sold + $orderdetail_temp->orderdetail_temp_amount,
                                'drugordert_total' => $orderdrug->drugordert_total - $orderdetail_temp->orderdetail_temp_amount,
                            );
                            //echo '<pre>';
                            //print_r($datadrugorder);
                            //echo '</pre>';
                            $this->order_model->update_drugorder($orderdrug->drugorder_id_pri, $datadrugorder);
                            //history
                            $history = array(
                                'shop_id_pri' => $shop_id_pri,
                                'drugorder_id_pri' => $orderdrug->drugorder_id_pri,
                                'drughistory_out' => $orderdetail_temp->orderdetail_temp_amount,
                                'orderdetail_id_pri' => $orderdetail_id_pri,
                                'drughistory_status_id' => 2,
                                'drughistory_out_id' => 2,
                                'drughistory_date' => $this->misc->getdate(),
                                'drughistory_modify' => $this->misc->getdate(),
                            );
                            //echo '<pre>';
                            //print_r($history);
                            //echo '</pre>';
                            $this->order_model->insertdrughistory($history);
                        }
                    }
                }
                $this->order_model->delete_orderdetail_temp_alltype($shop_id_pri);
                // ซื้อแล้ว (orderlist)
                $order_pay_id = 2;
                $order_point_id = !empty($this->input->post('use_point')) ? 2 : 1;
                $order_pointsave = $use_point = !empty($this->input->post('use_point')) ? intval($this->input->post('use_point')) : null;
                $shop_bank_id = $this->order_model->get_shop_bank($shop_id_pri);
                $teams_id = null;
                $order = $this->order_model->get_order($order_id_pri)->row();
                $order_totalpay = $order->order_totalpay;
                $customer = $this->order_model->get_customer($order->customer_id_pri);
                if ($order_point_id == 2) {
                    $order_totalpay = $order->order_totalpay - $order_pointsave;
                    $dataorder = array(
                        'order_point_id' => 2,
                        'order_befor_point' => $order->order_totalpay,
                        'order_pointsave' => $order_pointsave,
                        'order_totalpay' => $order_totalpay,
                        'order_pay_id' => $order_pay_id,
                        'teams_id' => $teams_id,
                        'order_pay_date' => $this->misc->getdate(),
                        'order_update' => $this->misc->getdate()
                    );
                    $this->order_model->update_order($order_id_pri, $dataorder);
                    // log
                    $action_text = 'ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                    $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                    // ตัด point
                    $dataonline = array(
                        'online_point' => $online->online_point - $order_pointsave,
                        'online_update' => $this->misc->getdate()
                    );
                    $this->order_model->update_online($online->online_id, $dataonline);
                    // log point
                    $order_point_text = '-' . $order_pointsave;
                    $online_point_text = $online->online_point - $order_pointsave;
                    $action_text = 'แลกใช้แต้ม (' . $order->order_id . ')';
                    $this->systemlog->log_pointonline($action_text, $shop_id_pri, $online->online_id, 1, $online->online_point, $order_point_text, $online_point_text);
                } else {
                    $order_point = $product_point;
                    if ($order_point > 0) {
                        $dataorder = array(
                            'order_point' => $order_point,
                            'order_point_id' => 1,
                            'order_totalpay' => $order_totalpay,
                            'order_pay_id' => $order_pay_id,
                            'teams_id' => ($teams_id != 0) ? $teams_id : null,
                            'order_pay_date' => $this->misc->getdate(),
                            'order_update' => $this->misc->getdate()
                        );
                        $this->order_model->update_order($order_id_pri, $dataorder);
                        // log
                        $action_text = 'ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                        $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                        // ตัด point
                        $dataonline = array(
                            'online_point' => $online->online_point + $order_point,
                            'online_update' => $this->misc->getdate()
                        );
                        $this->order_model->update_online($online->online_id, $dataonline);
                        // log point
                        $order_point_text = $order_point;
                        $online_point_text = $online->online_point + $order_point;
                        $action_text = 'สั่งซื้อได้รับแต้ม (' . $order->order_id . ')';
                        $this->systemlog->log_pointonline($action_text, $shop_id_pri, $online->online_id, 1, $online->online_point, $order_point_text, $online_point_text);
                    }
                }
                // จ่ายเงิน
                $dataorderpay = array(
                    'order_id_pri' => $order_id_pri,
                    'user_id' => $user_id,
                    'orderpay_period' => 0,
                    'orderpay_current' => $order_totalpay,
                    'orderpay_balance' => 0,
                    'orderpay_all' => $order_totalpay,
                    'orderpay_status_id' => 1,
                    'orderpay_active_id' => 1,
                    'shop_bank_id' => $shop_bank_id,
                    //'charge_id'          => $charge_id,
                    'orderpay_modify' => $this->misc->getdate()
                );
                $datashopbank = array(
                    'shop_bank_wallet' => $this->order_model->getshopbank($shop_bank_id)->row()->shop_bank_wallet + $order_totalpay,
                    'shop_bank_modify' => $this->misc->getdate()
                );
                $this->order_model->update_shopbank($shop_bank_id, $datashopbank);
                // log bank
                $action_text = number_format($order_totalpay, 2) . ' บาท  ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                $this->systemlog->log_bank($action_text, $shop_id_pri, $user_id, $shop_bank_id);
                // log orderpay
                $action_text = 'ชำระเต็ม ' . number_format($order_totalpay, 2) . ' บาท เลขที่ใบเสร็จ ' . $order->order_id;
                $this->systemlog->log_orderpay($action_text, $shop_id_pri, $user_id);
                $this->order_model->insert_orderpay($dataorderpay);
                // คอร์ส
                $orderdetails = $this->order_model->get_orderdetail($order_id_pri);
                if ($orderdetails->num_rows() > 0) {
                    foreach ($orderdetails->result() as $orderdetail) {
                        if ($orderdetail->course_id_pri != null || $orderdetail->course_id_pri != '') {
                            $course = $this->order_model->getcourse($orderdetail->course_id_pri)->row();
                            if ($course->course_type == 1) {
                                for ($i = 0; $i < $course->course_amount; $i++) {
                                    $datacourse = array(
                                        'shop_id_pri' => $shop_id_pri,
                                        'order_id_pri' => $order_id_pri,
                                        'course_id_pri' => $course->course_id_pri,
                                        'serving_name' => $course->course_name,
                                        'serving_cost' => $course->course_costdoctor,
                                        'serving_costuser' => $course->course_costuser,
                                        'customer_id_pri' => $customer->row()->customer_id_pri,
                                        'serving_status_id' => 1,
                                        'serving_type' => 1,
                                        'serving_modify' => $this->misc->getdate(),
                                    );
                                    $this->order_model->insert_serving($datacourse);
                                }
                                // log คอร์ส
                                $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . $course->course_amount . ' ครั้ง/คอร์ส เลขที่ใบเสร็จ ' . $order->order_id;
                                $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                            } else if ($course->course_type == 2) {
                                $datacourse = array(
                                    'shop_id_pri' => $shop_id_pri,
                                    'order_id_pri' => $order_id_pri,
                                    'course_id_pri' => $course->course_id_pri,
                                    'serving_name' => $course->course_name,
                                    'serving_cost' => $course->course_costdoctor,
                                    'serving_costuser' => $course->course_costuser,
                                    'customer_id_pri' => $customer->row()->customer_id_pri,
                                    'serving_status_id' => 1,
                                    'serving_type' => 2,
                                    'serving_expday' => $course->course_expday,
                                    'serving_start' => $this->misc->getdate(),
                                    'serving_end' => date('Y-m-d', strtotime(date('Y-m-d') . "+ $course->course_expday day")),
                                    'serving_modify' => $this->misc->getdate(),
                                );
                                $this->order_model->insert_serving($datacourse);
                                // log คอร์ส
                                $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . $course->serving_expday . ' วัน เลขที่ใบเสร็จ ' . $order->order_id;
                                $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                            } else if ($course->course_type == 3) { // type 3
                                $datacourse = array(
                                    'shop_id_pri' => $shop_id_pri,
                                    'order_id_pri' => $order_id_pri,
                                    'course_id_pri' => $course->course_id_pri,
                                    'serving_name' => $course->course_name,
                                    'serving_cost' => $course->course_costdoctor,
                                    'serving_costuser' => $course->course_costuser,
                                    'customer_id_pri' => $customer->row()->customer_id_pri,
                                    'serving_status_id' => 1,
                                    'serving_type' => 3,
                                    'serving_modify' => $this->misc->getdate(),
                                );
                                $serving_id = $this->order_model->insert_serving($datacourse);
                                $courset3s = $this->order_model->get_courset3($course->course_id_pri);
                                if ($courset3s->num_rows() > 0) {
                                    foreach ($courset3s->result() as $courset3) {
                                        $databook = array(
                                            'serving_id' => $serving_id,
                                            'shop_id_pri' => $shop_id_pri,
                                            'customer_id_pri' => $customer->row()->customer_id_pri,
                                            'course_id_pri' => $course->course_id_pri,
                                            'drug_id_pri' => $courset3->drug_id_pri,
                                            'servingdetail_book_amount' => $courset3->coursedrug_amount,
                                            'servingdetail_book_modify' => $this->misc->getdate(),
                                        );
                                        $this->order_model->insert_servingdetail_book($databook);
                                    }
                                }
                                // log คอร์ส
                                $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . 1 . ' ชุด เลขที่ใบเสร็จ ' . $order->order_id;
                                $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                            }
                        }
                    }
                }
                // เช็คแนะนำเพื่อน
                if ($online->guide_id != null) {
                    if ($online->online_order_id == 0) {
                        $guides = $this->order_model->get_guide($online->guide_id);
                        if ($guides->num_rows() == 1) {
                            $guide = $guides->row();
                            $dataguide = array(
                                'online_point' => $guide->online_point + $this->config->item('point_guide'),
                                'online_update' => $this->misc->getdate()
                            );
                            $this->order_model->update_online($guide->guide_id, $dataguide);
                            //log point
                            $order_point_text = $this->config->item('point_guide');
                            $online_point_text = $guide->online_point + $this->config->item('point_guide');
                            $action_text = 'แนะนำเพื่อน';
                            $this->systemlog->log_pointonline($action_text, $shop_id_pri, $guide->online_id, 1, $guide->online_point, $order_point_text, $online_point_text);
                            $dataonline = array(
                                'online_order_id' => 1,
                                'online_update' => $this->misc->getdate()
                            );
                            $this->order_model->update_online($online->online_id, $dataonline);
                        }
                    }
                }
                $response = array(
                    'status' => 'success',
                    'message' => 'ทำรายการสั่งซื้อเรียบร้อยแล้ว',
                    'order_id_pri' => $order_id_pri,
                );
            }
            // nut code upper //
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบเพื่อทำรายการ',
                'order_id_pri' => null
            );
        }
        echo json_encode($response);
    }

//    public function modalreview() {
//        $data = array(
//            'images'         => $this->opdcard_model->getOpdUpload($this->input->post('opd_id'), $this->input->post('opdupload_type')),
//            'opdupload_type' => $this->input->post('opdupload_type'),
//        );
//        $this->load->view('modal/order_review_modal', $data);
//    }
//
//    public function reviewModal() {
//        $data = array(
//            'order_product_list_id' => $this->input->post('order_product_list_id'),
//            'product_id'            => $this->input->post('product_id'),
//            'data'                  => $this->orders_model->getProductReviewByOrderProductList($this->input->post('order_product_list_id'), $this->input->post('product_id'))
//        );
//        $this->load->view('modal/order_review_modal', $data);
//    }
//
//    public function processReview() {
//        $get_p_r = $this->orders_model->getProductReviewByOrderProductList($this->input->post('order_product_list_id'), $this->input->post('product_id'));
//        if ($get_p_r->num_rows() == 1) {
//            $row_p_r = $get_p_r->row();
//            $data = array(
//                'product_review_rating'  => $this->input->post('product_review_rating'),
//                'product_review_content' => $this->input->post('product_review_content'),
//                'product_review_update'  => date('Y-m-d H:i:s')
//            );
//            $this->orders_model->updateProductReview($row_p_r->product_review_id, $data);
//            // rating
//            $count_all_rating = $this->orders_model->countProductReviewRating($this->input->post('product_id'));
//            $sum_all_rating = $this->orders_model->sumProductReviewRating($this->input->post('product_id'));
//            $product_rating = $sum_all_rating / $count_all_rating;
//            $data_product = array(
//                'product_rating' => $product_rating
//            );
//            $this->orders_model->updateProduct($this->input->post('product_id'), $data_product);
//            $json = array(
//                'status'  => 'success',
//                'title'   => 'สำเร็จ',
//                'message' => 'ดำเนินการเรียบร้อยเเล้ว'
//            );
//        } else {
//            $data = array(
//                'product_id'             => $this->input->post('product_id'),
//                'customer_id'            => $this->session->userdata('customer_id'),
//                'order_product_list_id'  => $this->input->post('order_product_list_id'),
//                'product_review_rating'  => $this->input->post('product_review_rating'),
//                'product_review_content' => $this->input->post('product_review_content'),
//                'product_review_create'  => date('Y-m-d H:i:s')
//            );
//            $this->orders_model->insertProductReview($data);
//            // rating
//            $count_all_rating = $this->orders_model->countProductReviewRating($this->input->post('product_id'));
//            $sum_all_rating = $this->orders_model->sumProductReviewRating($this->input->post('product_id'));
//            $product_rating = $sum_all_rating / $count_all_rating;
//            $data_product = array(
//                'product_rating' => $product_rating
//            );
//            $this->orders_model->updateProduct($this->input->post('product_id'), $data_product);
//            $json = array(
//                'status'  => 'success',
//                'title'   => 'สำเร็จ',
//                'message' => 'ดำเนินการเรียบร้อยเเล้ว'
//            );
//        }
//
//        echo json_encode($json);
//    }

    public function cardPayment() {
        if (!empty($this->session->userdata('online_id'))) {
            $get_cart = $this->order_model->getCartCheck();
            if ($get_cart->num_rows() > 0) {
                // check drug and promotion
                $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                $month_current = date('m');
                $is_drug_error = 0;
                $is_promotion_error = 0;
                $product_price_checked = 0;
                $drug_cart_qty = array();
                foreach ($get_cart->result() as $cart) {
                    $product_price_checked += $cart->orderdetail_temp_total;
                    if (!empty($cart->drugorder_id_pri)) {
                        $drug_stock_qty = 0;
                        $get_order_drug_check = $this->order_model->getOrderDrugCheck($cart->drugorder_id_pri);
                        if ($get_order_drug_check->num_rows() == 1) {
                            $drug_stock_qty = $get_order_drug_check->row()->drugordert_total;
                        }
                        if (empty($drug_cart_qty[$cart->drugorder_id_pri])) {
                            $drug_cart_qty[$cart->drugorder_id_pri] = 0;
                        }
                        $drug_cart_qty[$cart->drugorder_id_pri] += $cart->orderdetail_temp_amount;
                        $check_drug_stock_qty = $drug_stock_qty - $drug_cart_qty[$cart->drugorder_id_pri];
                        if ($check_drug_stock_qty < 0) {
                            $is_drug_error = 1;
                        }
                    }
                    // check promotion birthdate
                    if ($cart->product_group_id == 2) {
                        if ($month_birthdate != $month_current) {
                            $is_promotion_error = 1;
                        }
                    }
                }
                // post data
                $product_price = $this->input->post('product_price');
                $use_point = !empty($this->input->post('use_point')) ? intval($this->input->post('use_point')) : 0;
                $omise_token = $this->input->post('omise_token');
                // check point
                $is_point_error = 0;
                if ($use_point > 0) {
                    $online = $this->order_model->getOnline()->row();
                    if ($online->online_point >= $use_point) {
                        $is_point_error = 0;
                        // add used point
                    } else {
                        $is_point_error = 1;
                    }
                }
                // omise charge
                $amount = ($product_price_checked - $use_point) * 100;
                if ($is_drug_error == 0 && $is_promotion_error == 0 && $is_point_error == 0 && $product_price == $product_price_checked && $amount >= 5000 && !empty($omise_token)) {
                    //charge_id
                    $charge_data = array(
                        'online_id' => $this->session->userdata('online_id'),
                        'charge_create' => date('Y-m-d H:i:s')
                    );
                    $charge_id = $this->order_model->insertCharge($charge_data);

                    require_once APPPATH . 'third_party/omise-php/lib/Omise.php';
                    define('OMISE_API_VERSION', $this->config->item('OMISE_API_VERSION'));
                    define('OMISE_PUBLIC_KEY', $this->config->item('OMISE_PUBLIC_KEY'));
                    define('OMISE_SECRET_KEY', $this->config->item('OMISE_SECRET_KEY'));
                    // charge
                    $charge = OmiseCharge::create(
                                    array(
                                        'amount' => $amount,
                                        'currency' => 'THB',
                                        'card' => $omise_token,
                                        'return_uri' => base_url() . 'order/charge/' . $this->session->userdata('online_id') . '/' . $charge_id
                                    )
                    );
                    if ($charge['status'] == 'pending' && $charge['authorize_uri'] != null) {
                        $charge_data = array(
                            'charge_chrg_id' => $charge['id'],
                            'charge_chrg_amount' => $charge['amount'],
                            'charge_chrg_fee' => $charge['fee'],
                            'charge_chrg_fee_vat' => $charge['fee_vat'],
                            'charge_chrg_net' => $charge['net'],
                            'charge_card_name' => $charge['card']['name'],
                            'charge_card_last_digit' => $charge['card']['last_digits'],
                            'charge_card_bank' => $charge['card']['bank'],
                            'charge_card_brand' => $charge['card']['brand'],
                            'charge_status' => $charge['status'],
                            'shipping_type_id' => $this->input->post('shipping_type_id'),
                            'prefix' => $this->input->post('prefix'),
                            'fname' => $this->input->post('fname'),
                            'lname' => $this->input->post('lname'),
                            'phone' => $this->input->post('phone'),
                            'address' => $this->input->post('address'),
                            'sub_district' => $this->input->post('sub_district'),
                            'district' => $this->input->post('district'),
                            'province' => $this->input->post('province'),
                            'zipcode' => $this->input->post('zipcode'),
                            'product_price' => $this->input->post('product_price'),
                            'use_point' => $this->input->post('use_point'),
                        );
                        $this->order_model->updateCharge($charge_id, $charge_data);
                        $response = array(
                            'status' => $charge['status'],
                            'message' => $charge['authorize_uri'],
                            'charge_id' => $charge_data//$charge_id
                        );
                    } else {
                        $charge_data = array(
                            'charge_status' => $charge['status'],
                        );
                        $this->order_model->updateCharge($charge_id, $charge_data);
                        $response = array(
                            'status' => 'error',
                            'message' => 'ชำระเงินไม่สำเร็จ',
                            'charge_id' => null
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'สินค้าหรือแต้มมีจำนวนไม่เพียงพอ',
                        'charge_id' => null
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'ไม่มีรายการสินค้าในตะกร้า',
                    'charge_id' => null
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'กรุณาเข้าสู่ระบบเพื่อทำรายการ',
                'charge_id' => null
            );
        }
        echo json_encode($response);
    }

    public function charge($online_id, $charge_id) {
        if (!empty($this->session->userdata('online_id'))) {
            $charges = $this->order_model->getOnlineCharge($online_id, $charge_id);
            if ($charges->num_rows() == 1) {
                $charge = $charges->row();
                require_once APPPATH . 'third_party/omise-php/lib/Omise.php';
                define('OMISE_API_VERSION', $this->config->item('OMISE_API_VERSION'));
                define('OMISE_PUBLIC_KEY', $this->config->item('OMISE_PUBLIC_KEY'));
                define('OMISE_SECRET_KEY', $this->config->item('OMISE_SECRET_KEY'));
                // charge
                $checkcharge = OmiseCharge::retrieve($charge->charge_chrg_id);
//                echo '<pre>';
//                print_r($checkcharge);               
                $charge_data = array(
                    'charge_status' => $checkcharge['status'],
                    'charge_failure_code' => !empty($checkcharge['failure_code']) ? $checkcharge['failure_code'] : null,
                    'charge_failure_message' => !empty($checkcharge['failure_message']) ? $checkcharge['failure_message'] : null,
                );
                $this->order_model->updateCharge($charge->charge_id, $charge_data);

                if ($checkcharge['status'] == 'successful') {
                    // post address data
                    $shipping_type_id = $charge->shipping_type_id;
                    $prefix = $charge->prefix;
                    $fname = $charge->fname;
                    $lname = $charge->lname;
                    $phone = $charge->phone;
                    $address = $charge->address;
                    $sub_district = $charge->sub_district;
                    $district = $charge->district;
                    $province = $charge->province;
                    $zipcode = $charge->zipcode;
                    // post order data
                    $product_price = $charge->product_price;
                    $use_point = $charge->use_point;
                    $charge_id = $charge->charge_id;
                    // get cart
                    $product_point = 0;
                    $get_cart = $this->order_model->getCartCheck();
                    if ($get_cart->num_rows() > 0) {
                        // check drug and promotion
                        $month_birthdate = date('m', strtotime($this->session->userdata('online_birthdate')));
                        $month_current = date('m');
                        $is_promotion_error = 0;
                        $is_drug_error = 0;
                        $product_price_checked = 0;
                        $drug_cart_qty = array();
                        foreach ($get_cart->result() as $cart) {
                            $product_price_checked += $cart->orderdetail_temp_total;
                            $product_point += $cart->orderdetail_temp_point;
                            if (!empty($cart->drugorder_id_pri)) {
                                $drug_stock_qty = 0;
                                $get_order_drug_check = $this->order_model->getOrderDrugCheck($cart->drugorder_id_pri);
                                if ($get_order_drug_check->num_rows() == 1) {
                                    $drug_stock_qty = $get_order_drug_check->row()->drugordert_total;
                                }
                                if (empty($drug_cart_qty[$cart->drugorder_id_pri])) {
                                    $drug_cart_qty[$cart->drugorder_id_pri] = 0;
                                }
                                $drug_cart_qty[$cart->drugorder_id_pri] += $cart->orderdetail_temp_amount;
                                $check_drug_stock_qty = $drug_stock_qty - $drug_cart_qty[$cart->drugorder_id_pri];
                                if ($check_drug_stock_qty < 0) {
                                    $is_drug_error = 1;
                                }
                            }
                            // check promotion birthdate
                            if ($cart->product_group_id == 2) {
                                if ($month_birthdate != $month_current) {
                                    $is_promotion_error = 1;
                                }
                            }
                        }
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => 'ไม่มีรายการสินค้าในตะกร้า',
                            'charge_id' => null
                        );
                    }
                    // check card or point payment
                    $is_payment_error = 0;
                    if (!empty($charge_id)) {
                        // card payment ( ignore is_drug_error )
                        $get_charge = $this->order_model->getCharge($charge_id);
                        if ($get_charge->num_rows() == 1) {
                            $charge = $get_charge->row();
                            $amount = ($product_price_checked - $use_point) * 100;
                            if ($charge->charge_chrg_amount >= $amount) {
                                $is_payment_error = 0;
                                // do something
                            } else {
                                $is_payment_error = 1;
                                $response = array(
                                    'status' => 'error',
                                    'message' => 'ยอดชำระเงินไม่ถูกต้อง',
                                    'charge_id' => null
                                );
                            }
                        } else {
                            $is_payment_error = 1;
                            $response = array(
                                'status' => 'error',
                                'message' => 'รายการชำระเงินไม่ถูกต้อง',
                                'charge_id' => null
                            );
                        }
                    } else {
                        // point payment
                        $online = $this->order_model->getOnline()->row();
                        if ($online->online_point >= $use_point && $use_point >= $product_price_checked) {
                            $is_payment_error = 0;
                            // add used point
                        } else {
                            $is_payment_error = 1;
                        }
                    }

                    // nut code below //
                    if ($is_payment_error == 1) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'ชำระเงินไม่สำเร็จ',
                            'order_id_pri' => null,
                        );
                    } else if ($is_drug_error == 1) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'ยาในรอบสต๊อกที่เลือกไม่พอจ่าย',
                            'order_id_pri' => null,
                        );
                    } else if ($is_promotion_error == 1) {
                        $response = array(
                            'status' => 'error',
                            'message' => 'เงื่อนไขโปรโมชั่นไม่ถูกต้อง',
                            'order_id_pri' => null,
                        );
                    } else {
                        // เช็ค customer
                        $online = $this->order_model->get_online()->row();
                        $shop_id_pri = $this->order_model->get_orderdetail_temp()->row(0)->shop_id_pri;
                        $user_id = $this->order_model->get_user($shop_id_pri);
                        $customer_onlines = $this->order_model->get_customer_online($shop_id_pri);
                        // เป็นลูกค้าแล้ว(ซิงข้อมูลแล้ว)
                        if ($customer_onlines->num_rows() == 1) {
                            $customer = $customer_onlines->row();
                        } else {
                            $customer_onlines = $this->order_model->get_customer_tel($online->online_tel, $shop_id_pri);
                            // เป็นลูกค้าแล้ว(ยังไม่ซิงข้อมูล)
                            if ($customer_onlines->num_rows() == 1) {
                                $customer = $customer_onlines->row();
                                $datacustomer = array(
                                    'online_id' => $online->online_id,
                                    'customer_update' => $this->misc->getdate()
                                );
                                $this->order_model->update_customer($customer->customer_id_pri, $datacustomer);
                                //echo 'update';
                            } else {
                                $datacustomer = array(
                                    'online_id' => $this->session->userdata('online_id'),
                                    'customer_id' => '',
                                    'shop_id_pri' => $shop_id_pri,
                                    'user_id' => $user_id,
                                    'customer_group_id' => $this->order_model->get_customer_group($shop_id_pri),
                                    'customer_idcard' => $online->online_idcard,
                                    'customer_prefix' => $online->online_prefix,
                                    'customer_fname' => $online->online_fname,
                                    'customer_lname' => $online->online_lname,
                                    'customer_gender' => $online->online_gender,
                                    'customer_blood' => $online->online_blood,
                                    'customer_email' => $online->online_email,
                                    'customer_tel' => $online->online_tel,
                                    'customer_birthdate' => $online->online_birthdate,
                                    'customer_address' => $online->online_address,
                                    'customer_district' => $online->online_district,
                                    'customer_amphoe' => $online->online_amphoe,
                                    'customer_province' => $online->online_province,
                                    'customer_zipcode' => $online->online_zipcode,
                                    'customer_comment' => $online->online_comment,
                                    'customer_allergic' => $online->online_allergic,
                                    'customer_disease' => $online->online_disease,
                                    'customer_image' => 'none.png',
                                    'customer_point' => 0,
                                    'customer_status_id' => 1,
                                    'customer_tags' => '#ClinicPRO',
                                    'customer_create' => $this->misc->getdate(),
                                    'customer_update' => $this->misc->getdate()
                                );
                                $customer_id_pri = $this->order_model->insert_customer($datacustomer);
                                $datacustomertags = array(
                                    'customer_id_pri' => $customer_id_pri,
                                    'customer_tag_id' => 1,
                                );
                                $this->order_model->insert_customer_tag_map($datacustomertags);
                                if ($customer_id_pri > 0) {
                                    $shop = $this->order_model->getDocSetting($shop_id_pri);
                                    $customer_id = $shop->customer_id_default . sprintf('%0' . $shop->customer_number_digit . 'd', $shop->customer_number_default);
                                    $this->order_model->update_customer($customer_id_pri, array('customer_id' => $customer_id));
                                    $this->order_model->updateDocSetting(array('customer_number_default' => $shop->customer_number_default += 1), $shop_id_pri);
                                }
                                $customer = $this->order_model->get_customer_online($shop_id_pri)->row();
                                $logdata = array(
                                    'log_status_id' => 1,
                                    'customer_id_pri' => $customer_id_pri,
                                    'shop_id_pri' => $shop_id_pri,
                                    'user_id' => $user_id,
                                    'customer_id' => $customer_id,
                                    'customer_group_id' => $this->order_model->get_customer_group($shop_id_pri),
                                    'customer_idcard' => $online->online_idcard,
                                    'customer_prefix' => $online->online_prefix,
                                    'customer_fname' => $online->online_fname,
                                    'customer_lname' => $online->online_lname,
                                    'customer_gender' => $online->online_gender,
                                    'customer_blood' => $online->online_blood,
                                    'customer_email' => $online->online_email,
                                    'customer_tel' => $online->online_tel,
                                    'customer_birthdate' => $online->online_birthdate,
                                    'customer_address' => $online->online_address,
                                    'customer_district' => $online->online_district,
                                    'customer_amphoe' => $online->online_amphoe,
                                    'customer_province' => $online->online_province,
                                    'customer_zipcode' => $online->online_zipcode,
                                    'customer_comment' => $online->online_comment,
                                    'customer_allergic' => $online->online_allergic,
                                    'customer_disease' => $online->online_disease,
                                    'customer_status_id' => 1,
                                    'log_user_id' => $user_id,
                                    'log_ip_address' => $this->input->ip_address(),
                                    'log_browser' => $this->systemlog->getAgent(),
                                    'log_time' => $this->misc->getdate()
                                );
                                $this->order_model->insert_logcustomer($logdata);
                                //echo 'add';
                            }
                        }
                        //echo '<pre>';
                        //print_r($customer);
                        //echo '</pre>';
                        // เพิ่ม Order
                        if ($shipping_type_id == 1) {
                            $customer_name = $prefix . ' ' . $fname . '  ' . $lname;
                            $customer_tel = $phone;
                            $customer_email = $customer->customer_email;
                            $customer_address = $address;
                            $customer_district = $sub_district;
                            $customer_amphoe = $district;
                            $customer_province = $province;
                            $customer_zipcode = $zipcode;
                        } else {
                            $customer_name = $customer->customer_prefix . ' ' . $customer->customer_fname . '  ' . $customer->customer_lname;
                            $customer_tel = $customer->customer_tel;
                            $customer_email = $customer->customer_email;
                            $customer_address = $customer->customer_address;
                            $customer_district = $customer->customer_district;
                            $customer_amphoe = $customer->customer_amphoe;
                            $customer_province = $customer->customer_province;
                            $customer_zipcode = $customer->customer_zipcode;
                        }
                        $order_price = $product_price_checked;
                        $dataorder = array(
                            'shop_id_pri' => $shop_id_pri,
                            'user_id' => $user_id,
                            'online_id' => $online->online_id,
                            'customer_id_pri' => $customer->customer_id_pri,
                            'customer_name' => $customer_name,
                            'customer_tel' => $customer_tel,
                            'customer_email' => $customer_email,
                            'customer_address' => $customer_address,
                            'customer_district' => $customer_district,
                            'customer_amphoe' => $customer_amphoe,
                            'customer_province' => $customer_province,
                            'customer_zipcode' => $customer_zipcode,
                            'order_pay_id' => 1,
                            'order_status_id' => 1,
                            'order_price' => $order_price,
                            'order_save_id' => 0,
                            'order_save_amount' => 0,
                            'order_save' => 0,
                            'order_befor_tax' => $order_price,
                            'order_tax_id' => 1,
                            'order_tax' => 0,
                            'order_total' => $order_price,
                            'order_totalpay' => $order_price,
                            'order_deposit_id' => 0,
                            'order_refund_id' => 1,
                            'order_clinicpro_id' => 1,
                            'order_shipping_id' => $shipping_type_id == 1 ? 1 : 0,
                            'charge_id' => !empty($charge_id) ? $charge_id : null,
                            'order_create' => $this->misc->getdate(),
                            'order_update' => $this->misc->getdate()
                        );
                        //echo '<pre>';
                        //print_r($dataorder);
                        //echo '</pre>';
                        $order_id_pri = $this->order_model->insert_order($dataorder);
                        if ($order_id_pri > 0) {
                            $shop = $this->order_model->getDocSetting($shop_id_pri);
                            $this->order_model->update_order($order_id_pri, array('order_id' => $shop->receipt_id_default . sprintf('%0' . $shop->receipt_number_digit . 'd', $shop->receipt_number_default)));
                            $order_id = $shop->receipt_id_default . sprintf('%0' . $shop->receipt_number_digit . 'd', $shop->receipt_number_default);
                            $this->order_model->updateDocSetting(array('receipt_number_default' => $shop->receipt_number_default += 1), $shop_id_pri);
                        }
                        // log order
                        $action_text = 'เพิ่ม เลขที่ใบเสร็จ ' . $order_id;
                        $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                        $orderdetail_temps = $this->order_model->get_orderdetail_temp();
                        if ($orderdetail_temps->num_rows() > 0) {
                            foreach ($orderdetail_temps->result() as $orderdetail_temp) {
                                // เพิ่มรายการ
                                $dataorderdetail = array(
                                    'order_id_pri' => $order_id_pri,
                                    'course_id_pri' => $orderdetail_temp->course_id_pri,
                                    'drugorder_id_pri' => $orderdetail_temp->drugorder_id_pri,
                                    'product_id' => $orderdetail_temp->product_id,
                                    'orderdetail_type_id' => $orderdetail_temp->orderdetail_temp_type_id,
                                    'orderdetail_id' => $orderdetail_temp->orderdetail_temp_id,
                                    'orderdetail_name' => $orderdetail_temp->orderdetail_temp_name,
                                    'orderdetail_amount' => $orderdetail_temp->orderdetail_temp_amount,
                                    'orderdetail_unit' => $orderdetail_temp->orderdetail_temp_unit,
                                    'orderdetail_cost' => $orderdetail_temp->orderdetail_temp_cost,
                                    'orderdetail_price' => $orderdetail_temp->orderdetail_temp_price,
                                    'orderdetail_discount' => $orderdetail_temp->orderdetail_temp_discount,
                                    'orderdetail_total' => $orderdetail_temp->orderdetail_temp_total,
                                    'orderdetail_direction' => $orderdetail_temp->orderdetail_temp_direction,
                                    'orderdetail_point' => $orderdetail_temp->orderdetail_temp_point,
                                    'orderdetail_modify' => $this->misc->getdate()
                                );
                                //echo '<pre>';
                                //print_r($dataorderdetail);
                                //echo '</pre>';
                                $orderdetail_id_pri = $this->order_model->insert_orderdetail($dataorderdetail);
                                // เพิ่มฉลากยา
                                if ($orderdetail_temp->orderdetail_temp_type_id == 2) {
                                    $drugorders = $this->order_model->getdrug_drugorder($orderdetail_temp->drugorder_id_pri);
                                    if ($drugorders->num_rows() > 0) {
                                        $datadrugsticker = array(
                                            'drug_id_pri' => $drugorders->row()->drug_id_pri,
                                            'customer_id_pri' => $customer->customer_id_pri,
                                            'drugsticker_direction' => $orderdetail_temp->orderdetail_temp_direction,
                                            'drugsticker_amount' => $orderdetail_temp->orderdetail_temp_amount,
                                            'drugsticker_unit' => $orderdetail_temp->orderdetail_temp_unit,
                                            'drugsticker_price' => $orderdetail_temp->orderdetail_temp_total,
                                            'drugsticker_expdate' => $drugorders->row()->drugorder_expdate,
                                            'drugsticker_active_id' => 1,
                                            'drugsticker_modify' => $this->misc->getdate(),
                                        );
                                        //echo '<pre>';
                                        //print_r($datadrugsticker);
                                        //echo '</pre>';
                                        $this->order_model->insert_drugsticker($datadrugsticker);
                                    }
                                }
                                if ($orderdetail_temp->drugorder_id_pri != null || $orderdetail_temp->drugorder_id_pri != '') {
                                    // อัพเดพยา
                                    $orderdrug = $this->order_model->getorderdrug($orderdetail_temp->drugorder_id_pri)->row();
                                    $datadrugorder = array(
                                        'drugorder_sold' => $orderdrug->drugorder_sold + $orderdetail_temp->orderdetail_temp_amount,
                                        'drugordert_total' => $orderdrug->drugordert_total - $orderdetail_temp->orderdetail_temp_amount,
                                    );
                                    //echo '<pre>';
                                    //print_r($datadrugorder);
                                    //echo '</pre>';
                                    $this->order_model->update_drugorder($orderdrug->drugorder_id_pri, $datadrugorder);
                                    //history
                                    $history = array(
                                        'shop_id_pri' => $shop_id_pri,
                                        'drugorder_id_pri' => $orderdrug->drugorder_id_pri,
                                        'drughistory_out' => $orderdetail_temp->orderdetail_temp_amount,
                                        'orderdetail_id_pri' => $orderdetail_id_pri,
                                        'drughistory_status_id' => 2,
                                        'drughistory_out_id' => 2,
                                        'drughistory_date' => $this->misc->getdate(),
                                        'drughistory_modify' => $this->misc->getdate(),
                                    );
                                    //echo '<pre>';
                                    //print_r($history);
                                    //echo '</pre>';
                                    $this->order_model->insertdrughistory($history);
                                }
                            }
                        }
                        $this->order_model->delete_orderdetail_temp_alltype($shop_id_pri);
                        // ซื้อแล้ว (orderlist)
                        $order_pay_id = 2;
                        $order_point_id = $use_point > 0 ? 2 : 1;
                        $order_pointsave = $use_point > 0 ? $use_point : null;
                        $shop_bank_id = $this->order_model->get_shop_bank($shop_id_pri);
                        $teams_id = null;
                        $order = $this->order_model->get_order($order_id_pri)->row();
                        $order_totalpay = $order->order_totalpay;
                        $customer = $this->order_model->get_customer($order->customer_id_pri);
                        if ($order_point_id == 2) {
                            $order_totalpay = $order->order_totalpay - $order_pointsave;
                            $dataorder = array(
                                'order_point_id' => 2,
                                'order_befor_point' => $order->order_totalpay,
                                'order_pointsave' => $order_pointsave,
                                'order_totalpay' => $order_totalpay,
                                'order_pay_id' => $order_pay_id,
                                'teams_id' => $teams_id,
                                'order_pay_date' => $this->misc->getdate(),
                                'order_update' => $this->misc->getdate()
                            );
                            $this->order_model->update_order($order_id_pri, $dataorder);
                            // log
                            $action_text = 'ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                            $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                            // ตัด point
                            $dataonline = array(
                                'online_point' => $online->online_point - $order_pointsave,
                                'online_update' => $this->misc->getdate()
                            );
                            $this->order_model->update_online($online->online_id, $dataonline);
                            // log point
                            $order_point_text = '-' . $order_pointsave;
                            $online_point_text = $online->online_point - $order_pointsave;
                            $action_text = 'แลกใช้แต้ม (' . $order->order_id . ')';
                            $this->systemlog->log_pointonline($action_text, $shop_id_pri, $online->online_id, 1, $online->online_point, $order_point_text, $online_point_text);
                        } else {
                            $order_point = $product_point;
                            if ($order_point > 0) {
                                $dataorder = array(
                                    'order_point' => $order_point,
                                    'order_point_id' => 1,
                                    'order_totalpay' => $order_totalpay,
                                    'order_pay_id' => $order_pay_id,
                                    'teams_id' => ($teams_id != 0) ? $teams_id : null,
                                    'order_pay_date' => $this->misc->getdate(),
                                    'order_update' => $this->misc->getdate()
                                );
                                $this->order_model->update_order($order_id_pri, $dataorder);
                                // log
                                $action_text = 'ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                                $this->systemlog->log_order($action_text, $shop_id_pri, $user_id);
                                // ตัด point
                                $dataonline = array(
                                    'online_point' => $online->online_point + $order_point,
                                    'online_update' => $this->misc->getdate()
                                );
                                $this->order_model->update_online($online->online_id, $dataonline);
                                // log point
                                $order_point_text = $order_point;
                                $online_point_text = $online->online_point + $order_point;
                                $action_text = 'สั่งซื้อได้รับแต้ม (' . $order->order_id . ')';
                                $this->systemlog->log_pointonline($action_text, $shop_id_pri, $online->online_id, 1, $online->online_point, $order_point_text, $online_point_text);
                            }
                        }
                        // จ่ายเงิน
                        $dataorderpay = array(
                            'order_id_pri' => $order_id_pri,
                            'user_id' => $user_id,
                            'orderpay_period' => 0,
                            'orderpay_current' => $order_totalpay,
                            'orderpay_balance' => 0,
                            'orderpay_all' => $order_totalpay,
                            'orderpay_status_id' => 1,
                            'orderpay_active_id' => 1,
                            'shop_bank_id' => $shop_bank_id,
                            //'charge_id'          => $charge_id,
                            'orderpay_modify' => $this->misc->getdate()
                        );
                        $datashopbank = array(
                            'shop_bank_wallet' => $this->order_model->getshopbank($shop_bank_id)->row()->shop_bank_wallet + $order_totalpay,
                            'shop_bank_modify' => $this->misc->getdate()
                        );
                        $this->order_model->update_shopbank($shop_bank_id, $datashopbank);
                        // log bank
                        $action_text = number_format($order_totalpay, 2) . ' บาท  ชำระ เลขที่ใบเสร็จ ' . $order->order_id;
                        $this->systemlog->log_bank($action_text, $shop_id_pri, $user_id, $shop_bank_id);
                        // log orderpay
                        $action_text = 'ชำระเต็ม ' . number_format($order_totalpay, 2) . ' บาท เลขที่ใบเสร็จ ' . $order->order_id;
                        $this->systemlog->log_orderpay($action_text, $shop_id_pri, $user_id);
                        $this->order_model->insert_orderpay($dataorderpay);
                        // คอร์ส
                        $orderdetails = $this->order_model->get_orderdetail($order_id_pri);
                        if ($orderdetails->num_rows() > 0) {
                            foreach ($orderdetails->result() as $orderdetail) {
                                if ($orderdetail->course_id_pri != null || $orderdetail->course_id_pri != '') {
                                    $course = $this->order_model->getcourse($orderdetail->course_id_pri)->row();
                                    if ($course->course_type == 1) {
                                        for ($i = 0; $i < $course->course_amount; $i++) {
                                            $datacourse = array(
                                                'shop_id_pri' => $shop_id_pri,
                                                'order_id_pri' => $order_id_pri,
                                                'course_id_pri' => $course->course_id_pri,
                                                'serving_name' => $course->course_name,
                                                'serving_cost' => $course->course_costdoctor,
                                                'serving_costuser' => $course->course_costuser,
                                                'customer_id_pri' => $customer->row()->customer_id_pri,
                                                'serving_status_id' => 1,
                                                'serving_type' => 1,
                                                'serving_modify' => $this->misc->getdate(),
                                            );
                                            $this->order_model->insert_serving($datacourse);
                                        }
                                        // log คอร์ส
                                        $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . $course->course_amount . ' ครั้ง/คอร์ส เลขที่ใบเสร็จ ' . $order->order_id;
                                        $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                                    } else if ($course->course_type == 2) {
                                        $datacourse = array(
                                            'shop_id_pri' => $shop_id_pri,
                                            'order_id_pri' => $order_id_pri,
                                            'course_id_pri' => $course->course_id_pri,
                                            'serving_name' => $course->course_name,
                                            'serving_cost' => $course->course_costdoctor,
                                            'serving_costuser' => $course->course_costuser,
                                            'customer_id_pri' => $customer->row()->customer_id_pri,
                                            'serving_status_id' => 1,
                                            'serving_type' => 2,
                                            'serving_expday' => $course->course_expday,
                                            'serving_start' => $this->misc->getdate(),
                                            'serving_end' => date('Y-m-d', strtotime(date('Y-m-d') . "+ $course->course_expday day")),
                                            'serving_modify' => $this->misc->getdate(),
                                        );
                                        $this->order_model->insert_serving($datacourse);
                                        // log คอร์ส
                                        $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . $course->serving_expday . ' วัน เลขที่ใบเสร็จ ' . $order->order_id;
                                        $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                                    } else if ($course->course_type == 3) { // type 3
                                        $datacourse = array(
                                            'shop_id_pri' => $shop_id_pri,
                                            'order_id_pri' => $order_id_pri,
                                            'course_id_pri' => $course->course_id_pri,
                                            'serving_name' => $course->course_name,
                                            'serving_cost' => $course->course_costdoctor,
                                            'serving_costuser' => $course->course_costuser,
                                            'customer_id_pri' => $customer->row()->customer_id_pri,
                                            'serving_status_id' => 1,
                                            'serving_type' => 3,
                                            'serving_modify' => $this->misc->getdate(),
                                        );
                                        $serving_id = $this->order_model->insert_serving($datacourse);
                                        $courset3s = $this->order_model->get_courset3($course->course_id_pri);
                                        if ($courset3s->num_rows() > 0) {
                                            foreach ($courset3s->result() as $courset3) {
                                                $databook = array(
                                                    'serving_id' => $serving_id,
                                                    'shop_id_pri' => $shop_id_pri,
                                                    'customer_id_pri' => $customer->row()->customer_id_pri,
                                                    'course_id_pri' => $course->course_id_pri,
                                                    'drug_id_pri' => $courset3->drug_id_pri,
                                                    'servingdetail_book_amount' => $courset3->coursedrug_amount,
                                                    'servingdetail_book_modify' => $this->misc->getdate(),
                                                );
                                                $this->order_model->insert_servingdetail_book($databook);
                                            }
                                        }
                                        // log คอร์ส
                                        $action_text = 'สร้าง คอร์ส ' . $course->course_name . ' (' . $course->course_id . ') ' . 1 . ' ชุด เลขที่ใบเสร็จ ' . $order->order_id;
                                        $this->systemlog->log_serving($action_text, $shop_id_pri, $user_id);
                                    }
                                }
                            }
                        }
                        // เช็คแนะนำเพื่อน
                        if ($online->guide_id != null) {
                            if ($online->online_order_id == 0) {
                                $guides = $this->order_model->get_guide($online->guide_id);
                                if ($guides->num_rows() == 1) {
                                    $guide = $guides->row();
                                    $dataguide = array(
                                        'online_point' => $guide->online_point + $this->config->item('point_guide'),
                                        'online_update' => $this->misc->getdate()
                                    );
                                    $this->order_model->update_online($guide->guide_id, $dataguide);
                                    //log point
                                    $order_point_text = $this->config->item('point_guide');
                                    $online_point_text = $guide->online_point + $this->config->item('point_guide');
                                    $action_text = 'แนะนำเพื่อน';
                                    $this->systemlog->log_pointonline($action_text, $shop_id_pri, $guide->online_id, 1, $guide->online_point, $order_point_text, $online_point_text);
                                    $dataonline = array(
                                        'online_order_id' => 1,
                                        'online_update' => $this->misc->getdate()
                                    );
                                    $this->order_model->update_online($online->online_id, $dataonline);
                                }
                            }
                        }
                        $this->session->set_flashdata('flash_message', 'success,การชำระเงินสำเร็จ,' . 'ทำรายการสั่งซื้อของคุณเรียบร้อยแล้ว');
                        redirect(base_url('order'));
                    }
                } else {
                    $this->session->set_flashdata('flash_message', 'error,เกิดข้อผิดพลาด,' . 'ทำรายการชำระเงินไม่สำเร็จ');
                    redirect(base_url('cart'));
                }
            } else {
                $this->session->set_flashdata('flash_message', 'error,เกิดข้อผิดพลาด,' . 'ทำรายการชำระเงินไม่สำเร็จ');
                redirect(base_url('cart'));
            }
        } else {
            redirect(base_url());
        }
    }

}
