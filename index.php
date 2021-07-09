<?php
include_once 'config.php';

$post_data = array();
$post_data['store_id'] = STORE_ID;
$post_data['store_passwd'] = STORE_PASSWD;
$session_api_url = API_URL . "/gwprocess/v4/api.php";

$post_data['total_amount'] = "10.00";
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_".uniqid();
$post_data['success_url'] = PROJECT_URL . "/success.php";
$post_data['fail_url'] = PROJECT_URL . "/fail.php";
$post_data['cancel_url'] = PROJECT_URL . "/cancel.php";
$post_data['ipn_url'] = PROJECT_URL . "/ipn.php";

# CUSTOMER INFORMATION
$post_data['cus_name'] = "Name";
$post_data['cus_email'] = "email@example.com";
$post_data['cus_phone'] = "01234567890";
$post_data['cus_add1'] = "Dhaka";
$post_data['cus_add2'] = "Dhaka";
$post_data['cus_city'] = "Dhaka";
$post_data['cus_state'] = "Dhaka";
$post_data['cus_phone'] = "01234567890";
$post_data['cus_country'] = "Bangladesh";

# SHIPMENT INFORMATION
$post_data['shipping_method'] = "NO";
$post_data['ship_name'] = "Store Test";

# PRODUCT PARAMETERS
$post_data['product_name'] = "Example";
$post_data['product_category'] = "General";
$post_data['product_profile'] = "general";


# REQUEST SEND TO SSLCOMMERZ

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $session_api_url );
curl_setopt($handle, CURLOPT_TIMEOUT, 30);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($handle, CURLOPT_POST, 1 );
curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC

$content = curl_exec($handle );

$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if($code == 200 && !( curl_errno($handle))) {
	curl_close( $handle);
	$sslcommerzResponse = $content;
} else {
	curl_close( $handle);
	echo "FAILED TO CONNECT WITH SSLCOMMERZ API - $code";

    if(DEBUG) {
        echo '<pre>';
        print_r($content);
    }

	exit;
}


# PARSE THE JSON RESPONSE
$sslcz = json_decode($sslcommerzResponse, true );

if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="") {

      	// echo "<meta http-equiv='refresh' content='0;url=".($sslcz['GatewayPageURL'])."'>";
      	header("Location: ". $sslcz['GatewayPageURL']);
      	exit;
} else {
	var_dump($content);
}



