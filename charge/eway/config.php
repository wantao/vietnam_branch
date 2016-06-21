<?php

	$eway_shop_goods_config = array(
		'VND' => array(
			 //普通充值(shop_type=0)
			'10000' => array('product_id_str'=>'','cash'=>10000,'yuanbao'=>30,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6101),
			'20000' => array('product_id_str'=>'','cash'=>20000,'yuanbao'=>60,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6102),
			'50000' => array('product_id_str'=>'','cash'=>50000,'yuanbao'=>150,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6103),
			'100000' => array('product_id_str'=>'','cash'=>100000,'yuanbao'=>300,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6104),
			'200000' => array('product_id_str'=>'','cash'=>200000,'yuanbao'=>600,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6105),
			'300000' => array('product_id_str'=>'','cash'=>300000,'yuanbao'=>900,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6106),
			'500000' => array('product_id_str'=>'','cash'=>500000,'yuanbao'=>1500,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6107),
			'1000000' => array('product_id_str'=>'','cash'=>1000000,'yuanbao'=>3000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6108),
			'2000000' => array('product_id_str'=>'','cash'=>2000000,'yuanbao'=>6000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6109),
			'5000000' => array('product_id_str'=>'','cash'=>5000000,'yuanbao'=>15000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6110),
			'5000' => array('product_id_str'=>'','cash'=>5000,'yuanbao'=>15,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6118),
			'30000' => array('product_id_str'=>'','cash'=>30000,'yuanbao'=>90,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6119),
		),
		'C' => array(
			 //普通充值(shop_type=0)
			'10000' => array('product_id_str'=>'','cash'=>10000,'yuanbao'=>30,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6101),
			'20000' => array('product_id_str'=>'','cash'=>20000,'yuanbao'=>60,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6102),
			'50000' => array('product_id_str'=>'','cash'=>50000,'yuanbao'=>150,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6103),
			'100000' => array('product_id_str'=>'','cash'=>100000,'yuanbao'=>300,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6104),
			'200000' => array('product_id_str'=>'','cash'=>200000,'yuanbao'=>600,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6105),
			'300000' => array('product_id_str'=>'','cash'=>300000,'yuanbao'=>900,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6106),
			'500000' => array('product_id_str'=>'','cash'=>500000,'yuanbao'=>1500,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6107),
			'1000000' => array('product_id_str'=>'','cash'=>1000000,'yuanbao'=>3000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6108),
			'2000000' => array('product_id_str'=>'','cash'=>2000000,'yuanbao'=>6000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6109),
			'5000000' => array('product_id_str'=>'','cash'=>5000000,'yuanbao'=>15000,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6110),
			'5000' => array('product_id_str'=>'','cash'=>5000,'yuanbao'=>15,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6118),
			'30000' => array('product_id_str'=>'','cash'=>30000,'yuanbao'=>90,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6119),
		),
		'USD' => array(
			 //普通充值(shop_type=0)
			'0.99' => array('product_id_str'=>'','cash'=>20790,'yuanbao'=>70,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6111),
			'4.99' => array('product_id_str'=>'','cash'=>104790,'yuanbao'=>350,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6112),
			'9.99' => array('product_id_str'=>'','cash'=>209790,'yuanbao'=>700,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6113),
			'19.99' => array('product_id_str'=>'','cash'=>419790,'yuanbao'=>1400,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6114),
			'29.99' => array('product_id_str'=>'','cash'=>629790,'yuanbao'=>2100,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6115),
			'49.99' => array('product_id_str'=>'','cash'=>1049790,'yuanbao'=>3500,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6116),
			'99.99' => array('product_id_str'=>'','cash'=>2099790,'yuanbao'=>7150,'extra_yuanbao'=>0,'shop_type'=>0,'item_id'=>6117),
		),
	);
	
	//月卡商品配置
	$eway_shop_yueka_goods_config = array(
		'VND' => array(
			'100000' => array('product_id_str'=>'','cash'=>100000,'yuanbao'=>0,'extra_yuanbao'=>0,'shop_type'=>1,'item_id'=>6201),	
		),
		'C' => array(
			'100000' => array('product_id_str'=>'','cash'=>100000,'yuanbao'=>0,'extra_yuanbao'=>0,'shop_type'=>1,'item_id'=>6201),	
		),
		'USD' => array(
			'4.99' => array('product_id_str'=>'','cash'=>104790,'yuanbao'=>0,'extra_yuanbao'=>0,'shop_type'=>1,'item_id'=>6201),	
		),
	);
	
	require_once '../../unity/self_log.php';
	
	function get_product_info($currency,$cash) {
		global $eway_shop_goods_config;
		if (!isset($eway_shop_goods_config[$currency])) {
			writeLog(__FUNCTION__." not find currency:".$currency,LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;			
		}
		$currency_config = $eway_shop_goods_config[$currency];
		if (!isset($currency_config[$cash])) {
			writeLog(__FUNCTION__." not find cash:".$cash." it's currency is:".$currency,LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;			
		}
		return $currency_config[$cash];
	}
	function get_yueka_product_info($currency,$cash) {
		global $eway_shop_yueka_goods_config;
		if (!isset($eway_shop_yueka_goods_config[$currency])) {
			writeLog(__FUNCTION__." not find currency:".$currency,LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;			
		}
		$currency_config = $eway_shop_yueka_goods_config[$currency];
		if (!isset($currency_config[$cash])) {
			writeLog(__FUNCTION__." not find cash:".$cash." it's currency is:".$currency,LOG_NAME::ERROR_LOG_FILE_NAME);
			return false;			
		}
		return $currency_config[$cash];
	}
?>