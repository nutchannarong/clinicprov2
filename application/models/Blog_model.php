<?php

/**
 * Created by PhpStorm.
 * User: AODCAt
 * Date: 7/2/2020
 * Time: 9:45
 */

class Blog_model extends CI_Model {
    public function countPagination($filter) {
        $now = date("Y-m-d H:i:s");
        $this->db->select('article.article_id');
        $this->db->from('article');
        $this->db->where("(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= '$now' AND ('$now' <= article.article_end OR article.article_end IS NULL)))");
        //$this->db->where('(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= now() AND now() <= article.article_end))');
        //        $this->db->where('article.article_type_id', 1);
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                article.article_title LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_title_en LIKE '%" . $filter['searchtext'] . "%' OR
                article.article_excerpt LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_excerpt_en LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_text LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_text_en LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }
        return $this->db->get()->num_rows();
    }

    public function getPagination($filter, $params = array()) {
        $now = date("Y-m-d H:i:s");
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where("(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= '$now' AND ('$now' <= article.article_end OR article.article_end IS NULL)))");
        //$this->db->where('(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= now() AND now() <= article.article_end))');
        //        $this->db->where('article.article_type_id', 1);
        if ($filter['searchtext'] != '') {
            $this->db->where(" (
                article.article_title LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_title_en LIKE '%" . $filter['searchtext'] . "%' OR
                article.article_excerpt LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_excerpt_en LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_text LIKE '%" . $filter['searchtext'] . "%' OR 
                article.article_text_en LIKE '%" . $filter['searchtext'] . "%'
            ) ");
        }

        if (array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists('start', $params) && array_key_exists('limit', $params)) {
            $this->db->limit($params['limit']);
        }
        $this->db->order_by('article.article_create', 'desc');
        $this->db->order_by('article.article_start', 'desc');
        return $this->db->get();
    }

    public function getBlogArticleByID($article_slug) {
        $now = date("Y-m-d H:i:s");
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where("(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= '$now' AND ('$now' <= article.article_end OR article.article_end IS NULL)))");
        //$this->db->where('(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= now() AND now() <= article.article_end))');
        //        $this->db->where('article.article_type_id', 1);
        $this->db->where('article.article_slug', $article_slug);
        return $this->db->get();
    }
}
