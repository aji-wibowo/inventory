<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'LoginController/login';
$route['login/proses'] = 'LoginController/login_proses';
$route['logout'] = 'LoginController/logout';

//admin
$route['admin'] = 'AdminController/index';
$route['admin/pengguna'] = 'AdminController/pengguna';
$route['admin/pengguna/ajax/get/all'] = 'AdminController/ajax_get_all_pengguna';
$route['admin/pengguna/ajax/save'] = 'AdminController/ajax_save_pengguna';

$route['admin/satuan'] = 'AdminController/satuan_barang';
$route['admin/satuan/ajax/get/all'] = 'AdminController/ajax_get_all_satuan';
$route['admin/satuan/ajax/get/id'] = 'AdminController/ajax_get_by_id';
$route['admin/satuan/ajax/save'] = 'AdminController/ajax_save_satuan';
$route['admin/satuan/ajax/update/(:num)'] = 'AdminController/ajax_update_satuan/$1';
$route['admin/satuan/ajax/delete/(:num)'] = 'AdminController/ajax_delete_satuan/$1';

$route['admin/barang'] = 'AdminController/barang';
$route['admin/barang/ajax/get/all'] = 'AdminController/ajax_get_all_barang';
$route['admin/barang/ajax/get/id'] = 'AdminController/ajax_get_by_id';
$route['admin/barang/ajax/save'] = 'AdminController/ajax_save_barang';
$route['admin/barang/ajax/update/(:num)'] = 'AdminController/ajax_update_barang/$1';
$route['admin/barang/ajax/delete/(:num)'] = 'AdminController/ajax_delete_barang/$1';

$route['default_controller'] = 'MappingController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;






















