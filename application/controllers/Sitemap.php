<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sitemap_model');
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
            'title' => 'ผังเว็บไซต์',
            'description' => 'ผังเว็บไซต์',
            'keyword' => 'ผังเว็บไซต์',
            'meta' => $meta,
            'css' => array(),
            'js' => array(),
        );
        $this->renderView('sitemap_view', $data);
    }

    public function sitemapxml() {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('sitemap_xml_view');
    }

    public function productxml() {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('product_xml_view');
    }

    public function blogxml() {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('blog_xml_view');
    }

    public function shopxml() {
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view('shop_xml_view');
    }

}
