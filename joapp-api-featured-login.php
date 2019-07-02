<?php

/*
  Plugin Name: لاگین برای محصولات ویژه JoApp API
  Plugin URI: http://api.joapp.ir/
  Description: با فعال کردن این افزونه محصولات پیشنهاد ویژه در اپلیکیشن تنها برای کاربران عضو شده نمایش داده میشود
  Version: 1.0
  Author: SEPAHAN DATA TOOLS Co.
  Author URI: http://bejo.ir/
  Copyright: 2018 joapp.ir & bejo.ir
 * 
 * مشاهده تمام مستندات پلاگین نویسی در JoApp API در لینک http://api.joapp.ir
 * 
 */
if (!defined('ABSPATH')) {
    exit;
}

add_action("joapp_api_action_get_woo_one_product", "joapp_api_get_woo_one_product_featured_login");

function joapp_api_get_woo_one_product_featured_login() {
    global $joapp_result;

    $product = $joapp_result['product'];

    if (!$product->featured) {
        return;
    }

    $is_login = false;
    $user = $_REQUEST['user'];
    $pass = $_REQUEST['pass'];

    if ($user) {
        if (!wp_login($user, $pass)) {
            $is_login = false;
        } else {

            $u = get_user_by('login', "$user");

            if (is_null($u->ID)) {
                $u = get_user_by('email', "$user");
            }

            if (is_null($u->ID)) {
                $is_login = false;
            } else {
                $is_login = TRUE;
            }
        }
    } else {
        $is_login = false;
    }

    if (!$is_login) {
        unset($joapp_result['product']);
        $joapp_result['status'] = "login";
        $joapp_result['error'] = "محصولات پیشنهاد ویژه برای کاربران عضو میباشد. لطفا برای استفاده از امکانات این بخش ابتدا وارد حساب کاربری خود شوید.";
    }
}

?>
