<?php


class Error_404 extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array(
            'title'       => 'Page Not Found ',
            'description' => 'Page Not Found ',
            'keyword'     => 'Page Not Found ',
            'meta'        => array(),
            'css'         => array(),
            'js'          => array(),
        );
        $this->renderView('error_404_view', $data);
    }
}