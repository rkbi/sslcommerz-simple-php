<?php

#######################################
### PLEASE DO NOT MODIFY THIS FILE ####
#######################################


require_once('config.php');
if(IS_SANDBOX) {
    define('API_URL', "https://sandbox.sslcommerz.com");
} else {
    define('API_URL', "https://securepay.sslcommerz.com");
}
