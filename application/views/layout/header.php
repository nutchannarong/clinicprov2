<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <!-- Favicon and Touch Icons -->
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

  <!-- Viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  echo "\n\t";
  if (isset($meta)) {
    foreach ($meta as $meta_key => $meta_value) {
      echo "\t" . $this->assets->meta($meta_key, $meta_value);
    }
  }
  echo "\r";
  echo "\t" . $this->assets->css_full('plugin/select2/css/select2.min.css');
  echo "\t" . $this->assets->css_full('plugin/fontawesome/css/all.min.css');
  echo "\t" . $this->assets->css_full('plugin/toast-master/css/jquery.toast.css');
  echo "\t" . $this->assets->css_full('plugin/sweetalert/sweetalert.css');
  echo "\t" . $this->assets->css('parsley.min.css');
  echo "\t" . $this->libs->css_full('plugin/fancybox/dist/jquery.fancybox.css');
  echo "\n\t"; ?>
  <meta name="msapplication-TileColor" content="#080032">
  <meta name="msapplication-config" content="<?php echo base_url() . 'assets/favicon/browserconfig.xml'; ?>">
  <meta name="theme-color" content="#ffffff">

  <!-- Vendor Styles -->
  <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'assets/vendor/boxicons/css/boxicons.min.css'; ?>" />

  <!-- Main Theme Styles + Bootstrap -->
  <link rel="stylesheet" media="screen" href="<?php echo base_url() . 'assets/css/theme.css'; ?>">

  <!-- Page loading styles -->
  <style>
    .page-loading {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      -webkit-transition: all .4s .2s ease-in-out;
      transition: all .4s .2s ease-in-out;
      background-color: #fff;
      opacity: 0;
      visibility: hidden;
      z-index: 9999;
    }

    .dark-mode .page-loading {
      background-color: #0b0f19;
    }

    .page-loading.active {
      opacity: 1;
      visibility: visible;
    }

    .page-loading-inner {
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      text-align: center;
      -webkit-transform: translateY(-50%);
      transform: translateY(-50%);
      -webkit-transition: opacity .2s ease-in-out;
      transition: opacity .2s ease-in-out;
      opacity: 0;
    }

    .page-loading.active>.page-loading-inner {
      opacity: 1;
    }

    .page-loading-inner>span {
      display: block;
      font-size: 1rem;
      font-weight: normal;
      color: #9397ad;
    }

    .dark-mode .page-loading-inner>span {
      color: #fff;
      opacity: .6;
    }

    .page-spinner {
      display: inline-block;
      width: 2.75rem;
      height: 2.75rem;
      margin-bottom: .75rem;
      vertical-align: text-bottom;
      border: .15em solid #b4b7c9;
      border-right-color: transparent;
      border-radius: 50%;
      -webkit-animation: spinner .75s linear infinite;
      animation: spinner .75s linear infinite;
    }

    .dark-mode .page-spinner {
      border-color: rgba(255, 255, 255, .4);
      border-right-color: transparent;
    }

    @-webkit-keyframes spinner {
      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    @keyframes spinner {
      100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }

    h1,
    h2,
    h3,
    h4 {
      font-family: "Prompt" !important;
    }

    p,
    div,
    li,
    a {
      font-family: "Sarabun" !important;
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <?php
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
  echo "\t" . $this->assets->js_full('plugin/select2/js/select2.min.js');
  echo "\t" . $this->assets->js_full('plugin/toast-master/js/jquery.toast.js');
  echo "\t" . $this->assets->js('parsley.min.js');
  echo "\t" . $this->libs->js_full('plugin/fancybox/dist/jquery.fancybox.js');
  echo "\t" . $this->assets->js_full('plugin/sweetalert/sweetalert.min.js');
  echo "\t" . $this->assets->js_full('plugin/sweetalert/jquery.sweet-alert.custom.js');
  echo "\n\t";
  ?>

  <!-- Theme mode -->
  <script>
    let mode = window.localStorage.getItem('mode'),
      root = document.getElementsByTagName('html')[0];
    if (mode !== null && mode === 'dark') {
      root.classList.add('dark-mode');
    } else {
      root.classList.remove('dark-mode');
    }
  </script>

  <!-- Page loading scripts -->
  <script>
    (function() {
      window.onload = function() {
        const preloader = document.querySelector('.page-loading');
        preloader.classList.remove('active');
        setTimeout(function() {
          preloader.remove();
        }, 1000);
      };
    })();
  </script>
</head>

<!-- Body -->

<body>
  <input type="hidden" id="service_base_url" value="<?php echo base_url(); ?>" />
  <input type="hidden" id="service_admin_url" value="<?php echo admin_url(); ?>" />
  <script>
    const service_base_url = document.getElementById('service_base_url').value;
    const service_admin_url = document.getElementById('service_admin_url').value;
    const pb_key = '<?php echo $this->config->item('OMISE_PUBLIC_KEY'); ?>'
  </script>
  <!-- Page loading spinner -->
  <div class="page-loading active">
    <div class="page-loading-inner">
      <div class="page-spinner"></div><span>Loading...</span>
    </div>
  </div>