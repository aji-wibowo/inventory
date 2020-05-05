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
$route['admin/barang/ajax/get/id'] = 'AdminController/ajax_get_barang_by_id';
$route['admin/barang/ajax/save'] = 'AdminController/ajax_save_barang';
$route['admin/barang/ajax/update/(:any)'] = 'AdminController/ajax_update_barang/$1';
$route['admin/barang/ajax/delete/(:any)'] = 'AdminController/ajax_delete_barang/$1';

$route['admin/supplier'] = 'AdminController/supplier';
$route['admin/supplier/ajax/get/all'] = 'AdminController/ajax_get_all_supplier';
$route['admin/supplier/ajax/get/id'] = 'AdminController/ajax_get_supplier_by_id';
$route['admin/supplier/ajax/save'] = 'AdminController/ajax_save_supplier';
$route['admin/supplier/ajax/update/(:any)'] = 'AdminController/ajax_update_supplier/$1';
$route['admin/supplier/ajax/delete/(:any)'] = 'AdminController/ajax_delete_supplier/$1';

$route['admin/transaksi/list/masuk'] = 'AdminController/list_transaksi_barang_masuk';
$route['admin/transaksi/ajax/masuk/detail/(:any)'] = 'AdminController/ajax_detail_transaksi_barang_masuk/$1';
$route['admin/transaksi/list/keluar'] = 'AdminController/list_transaksi_barang_keluar';
$route['admin/transaksi/ajax/keluar/detail/(:any)'] = 'AdminController/ajax_detail_transaksi_barang_keluar/$1';

//staff
$route['staff'] = 'StaffController/index';
$route['staff/transaksi/masuk'] = 'StaffController/transaksi_barang_masuk';
$route['staff/transaksi/keluar'] = 'StaffController/transaksi_barang_keluar';
$route['staff/transaksi/masuk/insert'] = 'StaffController/ajax_transaksi_barang_masuk_insert';
$route['staff/transaksi/keluar/insert'] = 'StaffController/ajax_transaksi_barang_keluar_insert';
$route['staff/transaksi/insert/temporary'] = 'StaffController/ajax_transaksi_insert_temporary';
$route['staff/transaksi/get/temporary'] = 'StaffController/ajax_transaksi_get_temporary';
$route['staff/transaksi/delete/temporary'] = 'StaffController/ajax_transaksi_delete_temporary';

$route['staff/transaksi/list/masuk'] = 'StaffController/list_transaksi_barang_masuk';
$route['staff/transaksi/ajax/masuk/detail/(:any)'] = 'StaffController/ajax_detail_transaksi_barang_masuk/$1';
$route['staff/transaksi/list/keluar'] = 'StaffController/list_transaksi_barang_keluar';
$route['staff/transaksi/ajax/keluar/detail/(:any)'] = 'StaffController/ajax_detail_transaksi_barang_keluar/$1';

$route['staff/satuan'] = 'StaffController/satuan_barang';
$route['staff/satuan/ajax/get/all'] = 'StaffController/ajax_get_all_satuan';
$route['staff/satuan/ajax/get/id'] = 'StaffController/ajax_get_by_id';
$route['staff/satuan/ajax/save'] = 'StaffController/ajax_save_satuan';
$route['staff/satuan/ajax/update/(:num)'] = 'StaffController/ajax_update_satuan/$1';
$route['staff/satuan/ajax/delete/(:num)'] = 'StaffController/ajax_delete_satuan/$1';

$route['staff/barang'] = 'StaffController/barang';
$route['staff/barang/ajax/get/all'] = 'StaffController/ajax_get_all_barang';
$route['staff/barang/ajax/get/id'] = 'StaffController/ajax_get_barang_by_id';
$route['staff/barang/ajax/save'] = 'StaffController/ajax_save_barang';
$route['staff/barang/ajax/update/(:any)'] = 'StaffController/ajax_update_barang/$1';
$route['staff/barang/ajax/delete/(:any)'] = 'StaffController/ajax_delete_barang/$1';

$route['staff/supplier'] = 'StaffController/supplier';
$route['staff/supplier/ajax/get/all'] = 'StaffController/ajax_get_all_supplier';
$route['staff/supplier/ajax/get/id'] = 'StaffController/ajax_get_supplier_by_id';
$route['staff/supplier/ajax/save'] = 'StaffController/ajax_save_supplier';
$route['staff/supplier/ajax/update/(:any)'] = 'StaffController/ajax_update_supplier/$1';
$route['staff/supplier/ajax/delete/(:any)'] = 'StaffController/ajax_delete_supplier/$1';

// Manager
$route['manager'] = 'ManagerController/index';
$route['manager/pengguna'] = 'ManagerController/pengguna';
$route['manager/pengguna/ajax/get/all'] = 'ManagerController/ajax_get_all_pengguna';
$route['manager/pengguna/ajax/save'] = 'ManagerController/ajax_save_pengguna';
$route['manager/pengguna/ajax/update/(:num)'] = 'ManagerController/ajax_update_pengguna/$1';
$route['manager/pengguna/ajax/get/id'] = 'ManagerController/ajax_get_pengguna_by_id';
$route['manager/pengguna/ajax/delete/(:num)'] = 'ManagerController/ajax_delete_pengguna_by_id/$1';

$route['manager/transaksi/list/masuk'] = 'ManagerController/list_transaksi_barang_masuk';
$route['manager/transaksi/ajax/masuk/detail/(:any)'] = 'ManagerController/ajax_detail_transaksi_barang_masuk/$1';
$route['manager/transaksi/list/keluar'] = 'ManagerController/list_transaksi_barang_keluar';
$route['manager/transaksi/ajax/keluar/detail/(:any)'] = 'ManagerController/ajax_detail_transaksi_barang_keluar/$1';

$route['default_controller'] = 'MappingController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;






















