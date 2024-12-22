<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Collection routes
$route['collections'] = 'collections/index';
$route['collections/view/(:num)'] = 'collections/view/$1';
$route['collections/search'] = 'collections/search';

// Trade routes
$route['trades'] = 'trades/index';
$route['trades/request/(:num)'] = 'trades/request/$1';
$route['trades/submit_request'] = 'trades/submit_request';
$route['trades/view/(:num)'] = 'trades/view/$1';
$route['trades/accept/(:num)'] = 'trades/accept/$1';
$route['trades/reject/(:num)'] = 'trades/reject/$1';
$route['trades/get_tradeable_stickers'] = 'trades/get_tradeable_stickers';

// Trade chat routes
$route['trades/send_message']['post'] = 'trades/send_message';
$route['trades/get_new_messages']['get'] = 'trades/get_new_messages';

// Chat routes
$route['chat'] = 'chat/index';
$route['chat/trade/(:num)'] = 'chat/trade/$1';
$route['chat/send'] = 'chat/send';
$route['chat/get_new_messages'] = 'chat/get_new_messages';

// Admin routes
$route['admin'] = 'admin/index';
$route['admin/collections'] = 'admin/collections';
$route['admin/stickers/(:num)'] = 'admin/stickers/$1';
$route['admin/users'] = 'admin/users';
$route['admin/trades'] = 'admin/trades';
$route['admin/add_sticker/(:num)'] = 'admin/add_sticker/$1';
$route['admin/add_category'] = 'admin/add_category';

// Admin category routes
$route['admin/categories'] = 'admin/categories/index';
$route['admin/categories/add'] = 'admin/categories/add';
$route['admin/categories/edit/(:num)'] = 'admin/categories/edit/$1';
$route['admin/categories/delete/(:num)'] = 'admin/categories/delete/$1';

// Notification routes
$route['notifications'] = 'notifications/index';
$route['notifications/mark_read/(:num)'] = 'notifications/mark_read/$1';
$route['notifications/mark_all_read'] = 'notifications/mark_all_read';

// Admin collection routes
$route['admin/add_collection'] = 'admin/add_collection';
$route['admin/edit_collection/(:num)'] = 'admin/edit_collection/$1';

// Admin sticker routes
$route['admin/add_sticker/(:num)'] = 'admin/add_sticker/$1';
$route['admin/get_sticker/(:num)'] = 'admin/get_sticker/$1';
$route['admin/edit_sticker'] = 'admin/edit_sticker';
$route['admin/delete_sticker/(:num)'] = 'admin/delete_sticker/$1';

// Help routes
$route['help'] = 'help/index';
$route['help/contact'] = 'help/contact';
$route['help/report-bug'] = 'help/report_bug';
$route['guide/(:any)'] = 'help/guide/$1';

// Legal routes
$route['terms'] = 'legal/terms';
$route['privacy'] = 'legal/privacy';
$route['cookies'] = 'legal/cookies';
$route['license'] = 'legal/license';
