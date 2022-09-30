<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;

$route['promotions'] = 'products';
$route['shops'] = 'search';
$route['promotionbirthdate'] = 'productbirthdate';
$route['promotion/(:any)'] = 'productdetail/show/$1';
$route['shop/(:any)'] = 'shopdetail/show/$1';
$route['doctor/(:any)'] = 'shopdetail/doctor/$1';
$route['appointdoctor/(:any)'] = 'shopdetail/appointdoctor/$1';


$route['sitemap.xml'] = 'sitemap/sitemapxml';
$route['promotions.xml'] = 'sitemap/productxml';
$route['blog.xml'] = 'sitemap/blogxml';
$route['shops.xml'] = 'sitemap/shopxml';
