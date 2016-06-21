<?php
require_once '../../unity/self_log.php';
require_once 'common.php';

$status = $_GET['status'];
$app_id = $_GET['app_id'];
$app_secret = get_app_scret($app_id);
$transaction_id = $_GET['transaction_id'];
$transaction_type = $_GET['transaction_type'];
$amount = $_GET['amount'];
$currency = $_GET['currency'];
$game_order = $_GET['game_order'];
$country_code = $_GET['country_code'];
$response_time = $_GET['response_time'];
$user_id = $_GET['user_id'];
$username = $_GET['username'];
$sign = $_GET['sign'];
$sandbox = 0;
$verify_url = '';
if (isset($_GET['sandbox'])) {
	$sandbox = $_GET['sandbox'];
}
if (0 == $sandbox) {
	$verify_url = 'https://api.ingamemobi.com/sdk/confirm';	
} else {
	$verify_url = 'https://api.ingamemobi.com:8443/sdk/confirm';	
}


$hash = $status . $app_id . $transaction_id . $transaction_type . $amount . $currency . $game_order . $country_code . $response_time . $user_id . $username;

if($status == 1) {
	if($transaction_type == 'CARD'){
		$card_code = $_GET['card_code'];
		$card_serial = $_GET['card_serial'];
		$card_vendor = $_GET['card_vendor'];
		$hash .= $card_code . $card_serial . $card_vendor . $app_secret;
		$hash = md5($hash);
		if($sign == $hash){
			if ( !proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$verify_url,$transaction_type,$currency,$amount)) {
				echo "{\"status\": \"0\"}";
				exit;
			}
			echo "{\"status\": \"1\"}";
			exit;
		}
	}
	else if($transaction_type == 'BANK'){
		$bank_id = $_GET['bank_id'];
		$hash .= $bank_id . $app_secret;
		$hash = md5($hash);
		if($sign == $hash){
			if ( !proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$verify_url,$transaction_type,$currency,$amount)) {
				echo "{\"status\": \"0\"}";
				exit;
			}
			echo "{\"status\": \"1\"}";
			exit;
		}
	}
	else if($transaction_type == 'GOOGLE'){
		$google_id = $_GET['google_id'];
		$hash .= $google_id . $app_secret;
		$hash = md5($hash);
		if($sign == $hash){
			if ( !proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$verify_url,$transaction_type,$currency,$amount)) {
				echo "{\"status\": \"0\"}";
				exit;
			}
			echo "{\"status\": \"1\"}";
			exit;
		}
	}
	else if($transaction_type == 'APPLE'){
		$apple_id = $_GET['apple_id'];
		$hash .= $apple_id . $app_secret;
		$hash = md5($hash);
		if($sign == $hash){
			if ( !proccess_recieved_order_notify($game_order,$transaction_id,$app_id,$verify_url,$transaction_type,$currency,$amount)) {
				echo "{\"status\": \"0\"}";
				exit;
			}
			echo "{\"status\": \"1\"}";
			exit;
		}
	}
}
echo "{\"status\": \"0\"}";
exit;
?>