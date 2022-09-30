<?php

class Global_model extends CI_Model {

    public function getBlog($limit = null, $not = null) {
        $this->db->select('*');
        $this->db->from('article');
        $this->db->where('(article.content_status_id = 1 OR (article.content_status_id = 3 AND article.article_start <= now() AND now() <= article.article_end))');
//        $this->db->where('article.article_type_id', 1);
        if ($not != null) {
            $this->db->where('article.article_id !=', $not);
        }
        if ($limit != null) {
            $this->db->limit($limit);
        }
        $this->db->order_by('article.article_create', 'desc');
        $this->db->order_by('article.article_start', 'desc');
        return $this->db->get();
    }

    public function getShopNature() {
        $this->db->select('*');
        $this->db->from('shop_nature');
        $this->db->where('shop_nature.shop_nature_status_id', 1);
        return $this->db->get();
    }

    public function getProduct($limit, $type = null, $online_point = 0) {
        $this->db->select('product.*,shop_nature.shop_nature_name');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
            if ($type == 1) {
                $this->db->order_by('product.product_group_id', 'DESC');
            }
        } else {
            $this->db->where('product.product_group_id', 1);
            $this->db->order_by('product.product_group_id', 'DESC');
        }
        $this->db->order_by('product.product_total', '<= ' . $online_point . ' DESC');
        $this->db->limit($limit);
        //$this->db->order_by('product.product_active_date', 'DESC');
        return $this->db->get();
    }

    public function getProductSale() {
        $this->db->select('product.*,shop_nature.shop_nature_name');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');
        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $this->db->where("product.product_percent >", 0);

        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate == $month_current) {
            $this->db->where_in('product.product_group_id', array(1, 2));
        } else {
            $this->db->where('product.product_group_id', 1);
        }

        $this->db->limit(4);
        $this->db->order_by('RAND()');
        return $this->db->get();
    }

    public function getShop() {
        $this->db->select('
                           IFNULL(AVG(productreview.productreview_rating),0) AS rating,
                           IFNULL(COUNT(productreview.productreview_rating),0) AS count_rating,
                           IFNULL(COUNT(product.product_id),0) AS count_product,
                           shop.*,
                           shop_nature.shop_nature_name');
        $this->db->from('shop');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('product', 'product.shop_id_pri = shop.shop_id_pri', 'left');
        $this->db->join('productreview', 'productreview.product_id = product.product_id', 'left');
        $this->db->where('shop.shop_latlong !=', '');
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('(shop.shop_active_id = 1 OR shop.shop_proactive_id = 1)');
        $this->db->where('(productreview.productreview_status_id = 1 OR productreview.productreview_status_id IS NULL)');
        $this->db->group_by('shop.shop_id_pri');
        $this->db->limit(8);
        $this->db->order_by('shop.shop_proactive_id', 'DESC');
        $this->db->order_by('count_product', 'DESC');
        return $this->db->get();
    }

    public function getSlide($limit = NULL, $page_id = NULL) {
        $this->db->select('slideshow.slideshow_name,slideshow.slideshow_image,slideshow.slideshow_image_half,slideshow.slideshow_link,slideshow.slideshow_open_link');
        $this->db->from('slideshow');
        $this->db->where('(slideshow.slideshow_status_id = 1 OR (slideshow.slideshow_status_id = 3 AND slideshow.slideshow_start <= now() AND now() <= slideshow.slideshow_end))');
        if ($limit != NULL) {
            $this->db->where('slideshow.slideshow_page_id', $page_id);
        }
        if ($limit != NULL) {
            $this->db->limit($limit);
        }
        $this->db->order_by('slideshow.slideshow_sort', 'asc');
        return $this->db->get();
    }

    public function getProductReview($product_id) {
        $this->db->select('productreview.product_id');
        $this->db->from('productreview');
        $this->db->where('productreview.product_id', $product_id);
        $this->db->where('productreview.productreview_status_id', 1);
        return $this->db->get()->num_rows();
    }

    public function getOnlineByID($online_id) {
        $this->db->select('*');
        $this->db->from('online');
        $this->db->where('online.online_id', $online_id);
        return $this->db->get();
    }

    public function getShopReviewByID($shop_id_pri) {
        $this->db->select('IFNULL(AVG(productreview.productreview_rating),0) AS rating, IFNULL(COUNT(productreview.productreview_rating),0) AS count_rating');
        $this->db->from('shop');
        $this->db->join('product', 'product.shop_id_pri = shop.shop_id_pri', 'left');
        $this->db->join('productreview', 'productreview.product_id = product.product_id', 'left');
        $this->db->where('shop.shop_id_pri', $shop_id_pri);
        $this->db->where('(productreview.productreview_status_id = 1 OR productreview.productreview_status_id IS NULL)');
        $this->db->group_by('shop.shop_id_pri');
        return $this->db->get();
    }

    // count nav bar
    public function countAppoint() {
        $this->db->select('appoint.appoint_id_pri');
        $this->db->from('appoint');
        $this->db->join('customer', 'appoint.customer_id_pri = customer.customer_id_pri');
        //$this->db->join('online', 'customer.online_id = online.online_id');
        $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
        $this->db->join('user', 'appoint.user_id = user.user_id');
        //$this->db->where('online.online_id', $online_id);
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('customer.customer_status_id', 1);
        $this->db->where('appoint.appoint_status_id', 1);

        return $this->db->get()->num_rows();
    }

    public function countProductBirthDate($online_point = 0) {
        $this->db->select('product.product_id');
        $this->db->from('product');
        $this->db->join('shop', 'shop.shop_id_pri = product.shop_id_pri');
        $this->db->join('shop_nature', 'shop_nature.shop_nature_id = shop.shop_nature_id');
        $this->db->join('course', 'product.course_id_pri = course.course_id_pri', 'LEFT');
        $this->db->join('drugorder', 'product.drugorder_id_pri = drugorder.drugorder_id_pri', 'LEFT');
        $this->db->join('drug', 'drugorder.drug_id_pri = drug.drug_id_pri', 'LEFT');

        $this->db->where("product.product_active_id", 1);
        $this->db->where("product.product_status_id", 1);
        $this->db->where('shop.shop_status_id', 1);
        $this->db->where('shop.shop_proactive_id', 1);
        $this->db->where("product.product_end >", date('Y-m-d'));
        $month_birthdate = date("m", strtotime($this->session->userdata('online_birthdate')));
        $month_current = date('m');
        if ($month_birthdate != $month_current) {
            $this->db->where('product.product_group_id', 1);
            $this->db->where('product.product_total <=', $online_point);
        } else {
            $this->db->where('(product.product_group_id = 2 OR product.product_total <= ' . $online_point . ')');
        }
        $this->db->group_by('product.product_id');
        return $this->db->get()->num_rows();
    }

    public function countCart() {
        $this->db->select('orderdetail_temp.orderdetail_temp_id_pri');
        $this->db->from('orderdetail_temp');
        $this->db->join('shop', 'shop.shop_id_pri = orderdetail_temp.shop_id_pri');
        $this->db->join('product', 'product.product_id = orderdetail_temp.product_id');
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->order_by('product.product_id', 'ASC');
        return $this->db->get()->num_rows();
        ;
    }

    public function countService() {
        $this->db->select('customer.customer_id_pri');
        $this->db->from('customer');
        $this->db->join('online', 'customer.online_id = online.online_id');
        $this->db->join('shop', 'customer.shop_id_pri = shop.shop_id_pri');
        $this->db->join('order', 'order.customer_id_pri = customer.customer_id_pri');
        $this->db->join('serving', 'serving.order_id_pri = order.order_id_pri');
        $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
        $this->db->where_in("serving.serving_status_id", array(1, 2));
        $this->db->where('order.order_status_id', 1);
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        $this->db->where('customer.customer_status_id', 1);

        $this->db->group_by('course.course_id_pri');
        return $this->db->get()->num_rows();
    }

    public function sum_servingdetail_book_customer() {
        $this->db->select('sum(servingdetail_book.servingdetail_book_amount) AS servingdetail_book_amount');
        $this->db->from('servingdetail_book');
        $this->db->join('customer', 'customer.customer_id_pri = servingdetail_book.customer_id_pri');
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        $this->db->group_by('servingdetail_book.serving_id,servingdetail_book.course_id_pri');
        $this->db->having('sum(servingdetail_book.servingdetail_book_amount) = 0');
        return $this->db->get();
    }

    public function get_serving($serving_status_id = null) {
        $this->db->select('*');
        $this->db->from('serving');
        $this->db->join('course', 'serving.course_id_pri = course.course_id_pri');
        $this->db->join('order', 'serving.order_id_pri = order.order_id_pri');
        $this->db->join('customer', 'customer.customer_id_pri = serving.customer_id_pri');
        $this->db->where('order.order_status_id', 1);
        //$shop_id_pri = $this->session->userdata('shop_id_pri');
        //$this->db->where("(serving.shop_id_pri = $shop_id_pri OR serving.shop_id_customer = $shop_id_pri)");
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        if ($serving_status_id != NULL) {
            if ($serving_status_id == 1) {
                $this->db->where('serving.serving_status_id', 1);
                $this->db->where('(serving.serving_end IS NULL OR serving.serving_end > now())');
            } elseif ($serving_status_id == 3) {
                $this->db->where('serving.serving_status_id', 3);
            }
        }
        $this->db->where('serving.serving_status_id !=', 0);
        $this->db->order_by('serving.serving_modify');
        return $this->db->get();
    }

    // cart check
    public function getCartNavbar() {
        $this->db->select('
            orderdetail_temp.orderdetail_temp_id_pri,
            product.product_group_id
        ');
        $this->db->from('orderdetail_temp');
        $this->db->join('product', 'product.product_id = orderdetail_temp.product_id');
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        return $this->db->get();
    }

    public function clearCartByIds($ids) {
        $this->db->where_in('orderdetail_temp.orderdetail_temp_id_pri', $ids);
        $this->db->where('orderdetail_temp.online_id', $this->session->userdata('online_id'));
        $this->db->delete('orderdetail_temp');
    }

    public function countUnReview() {
        $this->db->select('servingreview.servingreview_id');
        $this->db->from('servingreview');
        $this->db->join('serving', 'serving.serving_id = servingreview.serving_id');
        $this->db->join('customer', 'customer.customer_id_pri = serving.customer_id_pri');
        $this->db->where('serving.shop_id_pri', $this->config->item('shop_id_pri'));
        $this->db->where('customer.customer_tel', $this->session->userdata('online_tel'));
        $this->db->where('servingreview.servingreview_status_id', 0);
        return $this->db->get()->num_rows();
    }

}
