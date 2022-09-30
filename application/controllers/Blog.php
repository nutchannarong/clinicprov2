<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public $per_page = 10;

    public function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->library('ajax_pagination');
    }

    public function index() {
        $meta = array(
            'og:site_name' => $this->config->item('app_title'),
            'og:url' => base_url() . 'blog',
            'og:title' => 'บทความ ' . $this->config->item('app_title'),
            'og:locale' => 'th_th',
            'og:description' => 'บทความ' . $this->config->item('app_description'),
            'og:image' => base_url() . 'assets/img/thumbnail.jpg',
            'og:image:width' => '560',
            'og:image:height' => '420',
            'og:type' => 'article',
        );
        $data = array(
            'title' => 'บทความ',
            'description' => 'บทความ',
            'keyword' => 'บทความ',
            'meta' => $meta,
            'css' => array('ribbon.css'),
            'js' => array(),
        );
        $this->renderView('blog_view', $data);
    }

    public function ajax_pagination() {
        $filter = array(
            'searchtext' => $this->input->post('searchtext')
        );
        $count = $this->blog_model->countPagination($filter);
        $config['div'] = 'result-pagination';
        $config['base_url'] = base_url('blog/ajax_pagination');
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
            'data' => $this->blog_model->getPagination($filter, array('start' => $segment, 'limit' => $this->per_page)),
            'count' => $count,
            'segment' => $segment,
            'links' => $this->ajax_pagination->create_links()
        );
        $this->load->view('ajax/blog_pagination', $data);
    }

    public function detail($article_slug = null) {
        $get_article = $this->blog_model->getBlogArticleByID($article_slug);
        if ($article_slug != null && $get_article->num_rows() == 1) {
            $row_article = $get_article->row();
            $meta = array(
                'og:site_name' => $this->config->item('app_title'),
                'og:url' => base_url() . "blog/detail/" . $row_article->article_slug,
                'og:title' => $row_article->article_title . ' ' . $this->config->item('app_title'),
                'og:locale' => 'th_th',
                'og:description' => $row_article->article_title . ' ' . $this->config->item('app_description'),
                'og:image' => app_admin_url() . "assets/upload/article/" . ($row_article->article_thumbnail != "" ? $row_article->article_thumbnail : "none.png"),
                'og:image:width' => '560',
                'og:image:height' => '420',
                'og:type' => 'article',
            );
            $data = array(
                'title' => $row_article->article_title,
                'description' => $row_article->article_description,
                'keyword' => $row_article->article_keyword,
                'meta' => $meta,
                'data' => $row_article,
                'css' => array('ribbon.css')
            );
            $this->renderView('blog_detail_view', $data);
        } else {
            redirect(base_url() . 'blog');
        }
    }

}
