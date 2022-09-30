<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacypolicy extends CI_Controller
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
            'title' => 'นโยบายความเป็นส่วนตัว',
            'description' => 'นโยบายความเป็นส่วนตัว',
            'keyword' => 'นโยบายความเป็นส่วนตัว',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
        );
        $this->renderView('privacypolicy_view', $data);
    }
}