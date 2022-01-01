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
$route['about-us'] = 'UserController/about';
$route['contact-us'] = 'UserController/contact';
$route['contact-form-process'] = 'UserController/contact_form_process';
$route['site-map'] = 'UserController/site_map';
$route['delivery-information'] = 'UserController/delivery_information';
$route['returns'] = 'UserController/returns';
$route['returns-process'] = 'UserController/returns_process';
$route['terms-conditions'] = 'UserController/terms_conditions';
$route['privacy-policy'] = 'UserController/privacy_policy';
$route['return-policy'] = 'UserController/return_policy';
$route['register'] = 'UserController/register';
$route['login'] = 'UserController/login';
$route['login-process'] = 'UserController/login_process';
$route['forget-password'] = 'UserController/forget_password';
$route['forget-password-process'] = 'UserController/forget_password_process';
$route['category/(:any)'] = 'UserController/category/$1';
$route['product/(:any)'] = 'UserController/product/$1';
$route['write-review'] = 'UserController/write_review';
$route['cart'] = 'UserController/cart';
$route['checkout'] = 'UserController/checkout';
$route['order'] = 'UserController/order';
$route['order-cancel'] = 'UserController/order_cancel';
$route['order-cancel-process'] = 'UserController/order_cancel_process';
$route['wishlist'] = 'UserController/wishlist';
$route['order-detail'] = 'UserController/order_detail';
$route['order-track'] = 'UserController/order_track';
$route['order-cancel'] = 'UserController/order_cancel';
$route['order-cancel-process'] = 'UserController/order_cancel_process';
$route['user/(:any)'] = 'UserController/user/$1';

$route['search'] = 'UserController/search';
$route['shop'] = 'UserController/shop';
$route['shop-loader'] = 'UserController/shop_loader';
$route['add-cart'] = 'UserController/add_to_cart';
$route['delete-from-cart'] = 'UserController/delete_from_cart';
$route['update-to-cart'] = 'UserController/update_to_cart';
$route['set-shipping'] = 'UserController/set_shipping';
$route['product-compare'] = 'UserController/product_compare';
$route['product-compare-add'] = 'UserController/product_compare_add';
$route['product-compare-delete'] = 'UserController/product_compare_delete';
$route['register-process'] = 'UserController/register_process';
$route['logoff'] = 'UserController/logoff';

$route['profile'] = 'UserController/profile';
$route['profile-update-process'] = 'UserController/profile_update_process';
$route['profile-email-code'] = 'UserController/profile_email_code';
$route['change-password'] = 'UserController/change_password';
$route['change-password-process'] = 'UserController/change_password_process';
$route['manage-address'] = 'UserController/manage_address';
$route['manage-address-edit'] = 'UserController/manage_address_edit';
$route['manage-address-edit-process'] = 'UserController/manage_address_edit_process';
$route['manage-address-delete'] = 'UserController/manage_address_delete';


$route['wishlist-add'] = 'UserController/wishlist_add';
$route['wishlist-delete'] = 'UserController/wishlist_delete';

$route['checkout-select-address'] = 'UserController/checkout_select_address';
$route['checkout-new-address'] = 'UserController/checkout_new_address';
$route['payment-process-cod'] = 'UserController/payment_process_cod';
$route['payment-process-paypal'] = 'UserController/payment_process_paypal';
$route['payment-process-paypal-success'] = 'UserController/payment_process_paypal_success';
$route['payment-process-paypal-cancel'] = 'UserController/payment_process_paypal_cancel';
$route['payment-process-paypal-ipn'] = 'UserController/payment_process_paypal_ipn';

$route['newsletter-subscribe'] = 'UserController/newsletter_subscribe';

$route['apply-coupon-code'] = 'UserController/apply_coupon_code';
$route['cancel-coupon-code'] = 'UserController/cancel_coupon_code';

$route['blog'] = 'UserController/blog';
$route['blog-page'] = 'UserController/blog_page';
$route['blog/(:any)'] = 'UserController/blog_info/$1';

$route['visitor-tracker'] = 'UserController/visitor_tracker';

$route['test'] = 'UserController/test';

