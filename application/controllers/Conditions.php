<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Conditions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
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
            'title' => 'ข้อตกลงและเงื่อนไข',
            'description' => 'ข้อตกลงและเงื่อนไข',
            'keyword' => 'ข้อตกลงและเงื่อนไข',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
        );
        $this->renderView('conditions_view', $data);
    }
}