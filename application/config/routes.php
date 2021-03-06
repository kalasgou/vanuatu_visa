<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'welcome';
$route['cn'] = 'welcome/index/cn';
$route['en'] = 'welcome/index/en';
$route['login'] = 'welcome/login';
$route['register'] = 'welcome/register';
$route['partner'] = 'welcome/partner';
//$route['admin_login'] = 'welcome/admin_login';
//$route['admin_register'] = 'welcome/admin_register';
$route['logout'] = 'user/logout';
//$route['activation_confirm/(:any)'] = 'welcome/activation_confirm/$1';
$route['account'] = 'welcome/account';
$route['password'] = 'welcome/password';
$route['refresh_captcha'] = 'welcome/refresh_captcha';
$route['visa_verify/(:any)'] = 'welcome/visa_verify/$1';
//$route['space/(:num)/(:any)'] = 'space/$2/$1';
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */