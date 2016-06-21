<?php
	/*
	 错误码
	 */
	class ErrorCode
	{
	    const SUCCESS = 0;//成功
	    const NOT_FIND_ORDER = -1;//找不到该订单
	    const DB_OPERATION_FAILURE = -2;//数据库处理错误
	    const PROCESSED_ORDER = -3;//订单已被处理过
	    const LOGIN_PARAMS_ERROR = -4;//登陆参数错误
	    const ORDER_QUERY_PARAMS_ERROR = -5;//订单查询参数错误
	    const ORDER_PAY_FAILURE = -6;//订单支付失败
	    const ORDER_IS_PROCESSING = -7;//订单正在处理中
	    const ORDER_IS_NOT_PROCESSED = -8;//订单未处理
		const AUTHENTICATE_FAILURE = -9;//认证服务区失败
		const URL_HAS_NO_SERVER_CODE = -10;//url中没有设置选择的区号
		const URL_HAS_NO_APP_KEY = -11;//url中没有设置app_key
		const ERROR_APP_KEY = -12;//错误的app_key;
		const ERROR_HONGXINGLAJIAO_LOGIN_AUTH_ERROR = -13;//红星辣椒登陆验证失败
		const ERROR_NOT_SET_LOGIN_AUTH_PARAMS = -14;//没有设置登陆验证参数
		const ERROR_NOT_SET_PLATE_KEY = -15;//没有设置平台给的key
		const ERROR_NOT_SET_UID = -16;//没有设置UID
		const ERROR_NOT_SET_CHARGE_NOTIFY_PARAMS = -17;//没有设置支付通知参数
		const ERROR_CHARGE_NOTIFY_PARAMS_ERROR = -18;//支付通知参数错误
		const ERROR_NOT_SET_CASH = -19;//没有设置金额
		const ERROR_NOT_SET_PLATE_TRANSFER_CODE = -20;//没有设置平台交易号
		const ERROR_NOT_SET_GOOGLE_PLAY_ORDER_DATA = -21;//未设置google play订单数据
		const ERROR_NOT_SET_GOOGLE_PLAY_ORDER_DATA_SIGNATURE = -22;//未设置google play订单数据签名
		const ERROR_NOT_SET_PING_TAI_ID = -23;//未设置平台id
		const ERROR_VERIFY_FAILURE = -24;//数据验证失败
		const ERROR_NOT_FIND_THE_PRODUCT_INFO = -25;//未找到该产品信息
		const ERROR_ORDER_DATA_STRUTURE_CHANGED = -26;//订单数据结构已发生改变，需要重新同步google play 的订单数据结构
		const ERROR_NOT_FIND_THE_UID = -27;//未找到该uid
		const ERROR_DB_CONNECT_FAILURE = -28;//db 连接失败
		const ERROR_NOT_SET_RECEIPT = -29;//未设置订单凭证
		const ERROR_NOT_SET_PARAMS = -30;//未设置相关参数
		const ERROR_NOT_SET_ACCOUNT = -31;//未填写账号
		const ERROR_NOT_SET_PASSWORD = -32;//未设置密码
		const ERROR_ACCOUNT_HAS_BEEN_USED = -33;//账号已被占用
		const ERROR_ACCOUNT_IS_TOO_LONG = -34;//填写的账号太长
		const ERROR_PASSWORD_IS_TOO_LONG = -35;//填写的密码太长
		const ERROR_ACCOUNT_IS_WRONG = -36;//账号错误
		const ERROR_PASSWORD_IS_WRONG = -37;//密码错误 
		const ERROR_TOKEN_ERROR = -38;//错误token
		const ERROR_NOT_FIND_THE_SERVER_CODE = -39;//未找到该区号
		const ERROR_NOT_SET_INVITATION_CODE = -40;//没有设置邀请码
		const ERROR_INVITATION_CODE_ERROR = -41;//邀请码错误
		const ERROR_INVITATION_CODE_HAS_BEEN_USED = -42;//邀请码已被使用
		const ERROR_TUIJIAN_PRODUCT_ONLY_BUY_ONCE = -43;//推荐商品只允许购买一次
		const ERROR_YUEKA_IS_NOT_IN_DEAD_TIME = -44;//还未到月卡截止时间
		const ERROR_NOT_ACCEPT_LICENSE = -45;//没有同意游戏条款
		const ERROR_SERVER_IS_MAINTAINING = -46;//服务器维护中
		const ERROR_PROCESS_ORDER_FAILURE = -47;//处理订单失败
		
	    const UNKOWN_ERROR = -10000;//未知错误
	}
	function get_err_desc($err_code) {
		if (ErrorCode::SUCCESS == $err_code) {
			return "success";//成功	
		}	
		if (ErrorCode::NOT_FIND_ORDER == $err_code) {
			return "not_find_order";//找不到该订单	
		}
		if (ErrorCode::DB_OPERATION_FAILURE == $err_code) {
			return "db_operation_failure";//数据库处理错误	
		}
		if (ErrorCode::PROCESSED_ORDER == $err_code) {
			return "processed_order";//订单已被处理过
		}
		if (ErrorCode::LOGIN_PARAMS_ERROR == $err_code) {
			return "login_params_error";//登陆参数错误
		}
		if (ErrorCode::ORDER_QUERY_PARAMS_ERROR == $err_code) {
			return "order_query_params_error";//订单查询参数错误
		}
		if (ErrorCode::ORDER_PAY_FAILURE == $err_code) {
			return "order_pay_failure";//订单支付失败
		}
		if (ErrorCode::ORDER_IS_PROCESSING == $err_code) {
			return "order_is_processing";//订单正在处理中
		}
		if (ErrorCode::ORDER_IS_NOT_PROCESSED == $err_code) {
			return "order_is_not_processed";//订单未处理
		}
		if (ErrorCode::AUTHENTICATE_FAILURE == $err_code) {
			return "authecticate_failure";//认证服务区失败
		}
		if (ErrorCode::URL_HAS_NO_SERVER_CODE == $err_code) {
			return "url_has_no_server_code";//url中没有设置选择的区号
		}
		if (ErrorCode::URL_HAS_NO_APP_KEY == $err_code) {
			return "url_has_no_app_key";//url中没有设置app_key
		}
		if (ErrorCode::ERROR_APP_KEY == $err_code) {
			return "error_app_key";//错误的app_key	
		}
		if (ErrorCode::ERROR_HONGXINGLAJIAO_LOGIN_AUTH_ERROR == $err_code) {
			return "error_hongxinglajiao_login_auth_error";//红星辣椒登陆验证失败
		}
		if (ErrorCode::ERROR_NOT_SET_LOGIN_AUTH_PARAMS == $err_code) {
			return "NOT_SET_LOGIN_AUTH_PARAMS";//未设置登陆验证参数
		}
		if (ErrorCode::ERROR_NOT_SET_PLATE_KEY == $err_code) {
			return "NOT_SET_PLATE_KEY";//没有设置平台给的key
		}
		if (ErrorCode::ERROR_NOT_SET_UID == $err_code) {
			return "NOT_SET_UID";//没有设置UID	
		}
		if (ErrorCode::ERROR_NOT_SET_CHARGE_NOTIFY_PARAMS == $err_code) {
			return "NOT_SET_CHARGE_NOTIFY_PARAMS";//没有设置支付通知参数
		}
		if (ErrorCode::ERROR_CHARGE_NOTIFY_PARAMS_ERROR == $err_code) {
			return "CHARGE_NOTIFY_PARAMS_ERROR";//支付通知参数错误	
		}
		if (ErrorCode::ERROR_NOT_SET_CASH == $err_code) {
			return "NOT_SET_CASH";//没有设置金额	
		}
		if (ErrorCode::ERROR_NOT_SET_PLATE_TRANSFER_CODE == $err_code) {
			return "NOT_SET_PLATE_TRANSFER_CODE";//没有设置平台交易号
		}
		if (ErrorCode::ERROR_NOT_SET_GOOGLE_PLAY_ORDER_DATA == $err_code) {
			return "NOT_SET_GOOGLE_PLAY_ORDER_DATA";//未设置google play订单数据
		}
		if (ErrorCode::ERROR_NOT_SET_GOOGLE_PLAY_ORDER_DATA_SIGNATURE == $err_code) {
			return "NOT_SET_GOOGLE_PLAY_ORDER_DATA_SIGNATURE";//未设置google play订单数据签名
		}
		if (ErrorCode::ERROR_NOT_SET_PING_TAI_ID == $err_code) {
			return "NOT_SET_PING_TAI_ID";//未设置平台id	
		}
		if (ErrorCode::ERROR_VERIFY_FAILURE == $err_code) {
			return "VERIFY_FAILURE";//数据验证失败;	
		}
		if (ErrorCode::ERROR_NOT_FIND_THE_PRODUCT_INFO == $err_code) {
			return "NOT_FIND_THE_PRODUCT_INFO";//未找到该产品信息	
		}
		if (ErrorCode::ERROR_ORDER_DATA_STRUTURE_CHANGED == $err_code) {
			return "ORDER_DATA_STRUTURE_CHANGED";//订单数据结构已发生改变，需要重新同步google play 的订单数据结构
		}
		if (ErrorCode::ERROR_NOT_FIND_THE_UID == $err_code) {
			return "NOT_FIND_THE_UID";//未找到该uid	
		}
		if (ErrorCode::ERROR_DB_CONNECT_FAILURE == $err_code) {
			return "DB_CONNECT_FAILURE";//db 连接失败	
		}
		if (ErrorCode::ERROR_NOT_SET_RECEIPT == $err_code) {
			return "NOT_SET_RECEIPT";//未设置订单凭证	
		}
		if (ErrorCode::ERROR_NOT_SET_PARAMS == $err_code) {
			return "NOT_SET_PARAMS";//未设置相关参数
		}
		if (ErrorCode::ERROR_NOT_SET_ACCOUNT == $err_code) {
			return "NOT_SET_ACCOUNT";//未填写账号
		}
		if (ErrorCode::ERROR_NOT_SET_PASSWORD == $err_code) {
			return "NOT_SET_PASSWORD";//未设置密码
		}
		if (ErrorCode::ERROR_ACCOUNT_HAS_BEEN_USED == $err_code) {
			return "ACCOUNT_HAS_BEEN_USED";//账号已被占用
		}
		if (ErrorCode::ERROR_ACCOUNT_IS_TOO_LONG == $err_code) {
			return "ACCOUNT_IS_TOO_LONG";//填写的账号太长
		}
		if (ErrorCode::ERROR_PASSWORD_IS_TOO_LONG == $err_code) {
			return "PASSWORD_IS_TOO_LONG";//填写的密码太长
		}
		if (ErrorCode::ERROR_ACCOUNT_IS_WRONG == $err_code) {
			return "CCOUNT_IS_WRONG";//账号错误
		}
		if (ErrorCode::ERROR_PASSWORD_IS_WRONG == $err_code) {
			return "PASSWORD_IS_WRONG";//密码错误 
		}
		if (ErrorCode::ERROR_TOKEN_ERROR == $err_code) {
			return "TOKEN_ERROR";//token error 
		}
		if (ErrorCode::ERROR_NOT_FIND_THE_SERVER_CODE == $err_code) {
			return "NOT_FIND_THE_SERVER_CODE";//未找到该区号 
		}
		if (ErrorCode::ERROR_NOT_SET_INVITATION_CODE == $err_code) {
			return "NOT_SET_INVITATION_CODE";//没有设置邀请码 
		}
		if (ErrorCode::ERROR_INVITATION_CODE_ERROR == $err_code) {
			return "INVITATION_CODE_ERROR";//邀请码错误
		}
		if (ErrorCode::ERROR_INVITATION_CODE_HAS_BEEN_USED == $err_code) {
			return "INVITATION_CODE_HAS_BEEN_USED";//邀请码已被使用
		}
		if (ErrorCode::ERROR_TUIJIAN_PRODUCT_ONLY_BUY_ONCE == $err_code) {
			return "TUIJIAN_PRODUCT_ONLY_BUY_ONCE";///推荐商品只允许购买一次
		}
		if (ErrorCode::ERROR_YUEKA_IS_NOT_IN_DEAD_TIME == $err_code) {
			return "YUEKA_IS_NOT_IN_DEAD_TIME";//还未到月卡截止时间
		}
		if (ErrorCode::ERROR_NOT_ACCEPT_LICENSE == $err_code) {
			return "NOT_ACCEPT_LICENSE";//没有同意游戏条款
		}
		if (ErrorCode::ERROR_SERVER_IS_MAINTAINING == $err_code) {
			return "SERVER_IS_MAINTAINING";//服务器维护中
		}
		if (ErrorCode::ERROR_PROCESS_ORDER_FAILURE == $err_code) {
			return "PROCESS_ORDER_FAILURE";//处理订单失败
		}
		
		return "unkonw_err_desc";//未知错误描述
	}
	function make_return_err_code_and_des($err_code,$err_desc) {
		$result_ret = array();
		$result_ret["error_code"]=$err_code;
		$result_ret["error_desc"]=$err_desc;
		$Res = json_encode($result_ret);
		print_r(urldecode($Res));	
	}
	
?>