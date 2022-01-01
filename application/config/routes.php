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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'UserController/index';
$route['404_override'] = 'UserController/page404';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'UserController/login';
$route['forget-password'] = 'UserController/forget_password';
$route['forget-password-process'] = 'UserController/forget_password_process';
$route['sign-up'] = 'UserController/sign_up';
$route['sign-up-process'] = 'UserController/sign_up_process';
$route['change-password'] = 'UserController/change_password';
$route['home'] = 'UserController/home';
$route['ledger'] = 'UserController/ledger';
$route['show-ledger'] = 'UserController/show_ledger';
$route['ledger-entry'] = 'UserController/ledger_entry';
$route['ledger-save'] = 'UserController/ledger_save';
$route['ledger-edit'] = 'UserController/ledger_edit';
$route['ledger-update'] = 'UserController/ledger_update';
$route['ledger-delete'] = 'UserController/ledger_delete';
$route['journal'] = 'UserController/journal';
$route['journal-entry'] = 'UserController/journal_entry';
$route['journal-save'] = 'UserController/journal_save';
$route['journal-delete'] = 'UserController/journal_delete';
$route['trial-balance'] = 'UserController/trial_balance';
$route['trading-account'] = 'UserController/trading_account';
$route['profit-loss-account'] = 'UserController/profit_loss_account';
$route['balance-sheet'] = 'UserController/balance_sheet';
$route['logoff'] = 'UserController/logoff';
$route['user/(:any)'] = 'UserController/user/$1';