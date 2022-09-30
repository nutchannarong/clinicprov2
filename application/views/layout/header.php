<!DOCTYPE html>
<html lang="th" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo isset($title) ? $title . ' | ' . $this->config->item('app_title') : $this->config->item('app_title'); ?></title>
        <meta name="description" content="<?php echo isset($description) ? $description . ' ' . $this->config->item('app_description') : $this->config->item('app_description'); ?>" />
        <meta name="keywords" content="<?php echo isset($keyword) ? $keyword . ',' . $this->config->item('app_keyword') : $this->config->item('app_keyword'); ?>" />
        <meta name="author" content="<?php echo $this->config->item('app_author'); ?>" />
        <link rel="shortcut icon" href="<?php echo base_url() . 'assets/img/' . $this->config->item('app_favicon'); ?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() . 'assets/img/' . $this->config->item('app_favicon'); ?>">
        <link rel="alternate" hreflang="th" href="<?php echo current_url(); ?>" />
        <?php
        echo "\n\t";
        if (isset($meta)) {
            foreach ($meta as $meta_key => $meta_value) {
                echo "\t" . $this->assets->meta($meta_key, $meta_value);
            }
        }
        echo "\r";
        echo "\n\t";
        echo "\t" . $this->assets->css('fonts.css');
        echo "\t" . $this->assets->css_full('plugin/bootstrap/css/bootstrap.css');
        echo "\t" . $this->assets->css_full('plugin/owl-carousel/assets/owl.carousel.min.css');
        echo "\t" . $this->assets->css_full('plugin/photoswipe/photoswipe.css');
        echo "\t" . $this->assets->css_full('plugin/photoswipe/default-skin/default-skin.css');
        echo "\t" . $this->assets->css_full('plugin/select2/css/select2.min.css');
        echo "\t" . $this->assets->css('style.css');
        echo "\t" . $this->assets->css('style.header-classic-variant-one.css');
        echo "\t" . $this->assets->css('style.mobile-header-variant-one.css');
        echo "\t" . $this->assets->css_full('plugin/fontawesome/css/all.min.css');
        echo "\t" . $this->assets->css_full('plugin/toast-master/css/jquery.toast.css');
        echo "\t" . $this->assets->css_full('plugin/sweetalert/sweetalert.css');
        echo "\t" . $this->assets->css('parsley.min.css');
        echo "\t" . $this->libs->css_full('plugin/fancybox/dist/jquery.fancybox.css');
        echo "\n\t";
        if (isset($css_full)) {
            foreach ($css_full as $row) {
                echo "\t" . $this->assets->css_full($row);
            }
        }
        if (isset($css)) {
            foreach ($css as $row) {
                echo "\t" . $this->assets->css($row);
            }
        }
        echo "\n\t";
        echo "\t" . $this->assets->js_full('plugin/jquery/jquery.min.js');
        echo "\t" . $this->assets->js_full('plugin/bootstrap/js/bootstrap.bundle.min.js');
        echo "\t" . $this->assets->js_full('plugin/owl-carousel/owl.carousel.min.js');
        echo "\t" . $this->assets->js_full('plugin/nouislider/nouislider.min.js');
        echo "\t" . $this->assets->js_full('plugin/photoswipe/photoswipe.min.js');
        echo "\t" . $this->assets->js_full('plugin/photoswipe/photoswipe-ui-default.min.js');
        echo "\t" . $this->assets->js_full('plugin/select2/js/select2.min.js');
        echo "\t" . $this->assets->js_full('plugin/toast-master/js/jquery.toast.js');
        echo "\t" . $this->assets->js('parsley.min.js');
        echo "\t" . $this->assets->js('number.js');
        echo "\t" . $this->assets->js('main.js');
        echo "\t" . $this->libs->js_full('plugin/fancybox/dist/jquery.fancybox.js');
        echo "\t" . $this->assets->js_full('plugin/sweetalert/sweetalert.min.js');
        echo "\t" . $this->assets->js_full('plugin/sweetalert/jquery.sweet-alert.custom.js');
        echo "\n\t";
        if (isset($js_full)) {
            foreach ($js_full as $row) {
                echo "\t" . $this->assets->js_full($row);
            }
        }
        if (isset($js)) {
            foreach ($js as $row) {
                echo "\t" . $this->assets->js($row);
            }
        }
        if (isset($js_import)) {
            foreach ($js_import as $link_js_import) {
                echo '<script src="' . $link_js_import . '" type="text/javascript"></script>';
            }
        }
        echo "\n\t";
        $this->load->view('layout/tag');
        ?>
		<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5W6JJH8');</script>
<!-- End Google Tag Manager -->
    </head>
    <body>
        <input type="hidden" id="service_base_url" value="<?php echo base_url(); ?>" />
        <input type="hidden" id="service_admin_url" value="<?php echo admin_url(); ?>" />
        <script>
            const service_base_url = $('#service_base_url').val();
            const service_admin_url = $('#service_admin_url').val();
            const pb_key = '<?php echo $this->config->item('OMISE_PUBLIC_KEY'); ?>'
        </script>
        <div class="site">