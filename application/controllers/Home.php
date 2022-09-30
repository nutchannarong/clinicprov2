<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
            'meta' => $meta,
            'css' => array('ribbon.css'),
            'js' => array(),
        );
        $this->renderView('home_view', $data);
    }

}
