<?php 
	class ErrorCode {
		const err_success = 0;//成功
		const err_not_set_player_id = -1;//没有设置玩家id
		const err_not_set_msg_award_type = -2;//没有设置邮件奖励类型
		const err_not_set_msg_award_title = -3;//没有设置邮件奖励主题
		const err_not_set_msg_award_content = -4;//没有设置邮件奖励消息内容
		const err_not_set_msg_award = -5;//没有设置邮件奖励
		const err_not_set_sign = -6;//没有设置签名
		const err_sign_false = -7;//签名不对
		const err_award_formate_is_error = -8;//奖励格式错误
		const err_not_find_player_id = -9;//未找到该玩家id
		const err_not_set_app_account = -10;//没有设置app_account
		const err_not_find_app_acount = -11;//未找到该app_account
		const err_db_operate_failure = -12;//db操作失败
		const err_msg_award_type_not_exist = -13;//邮件奖励类型不存在
		const err_award_kind_not_exist = -14;//奖励类型不存在
		const err_equip_raffle_tickets_kind_not_exist = -15;//装备抽奖券的小类型不存在
		const err_pet_raffle_tickets_kind_not_exist = -16;//宠物抽奖券的小类型不存在
	}
?>