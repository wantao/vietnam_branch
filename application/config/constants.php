<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');



define('LANGUAGE_EN',							1);
//define('LANGUAGE_CH',							1);
if ( defined('LANGUAGE_EN')) {
	define('LG_GM',					'GM Manage');
	define('LG_SEND_AWARD',			'Send Award');
	define('LG_AWARD_DESCRIBE',		'Award detail');
	define('LG_SEARCH_BY_ACCOUNT',	'Search By Player Account');
	define('LG_PLAYER_BASE',		'Player Base');
	define('LG_PET_INFO',			'Pet Information');
	define('LG_ONLINE_NUMBER',		'Online Number');
	define('LG_LEVEL_SPREAD',		'Level Spread');
	define('LG_SYSTEM_GLOBAL',		'System Global');
	define('LG_GEM_GET_AND_USE',	'Gem Get And Use');
	define('LG_RECHARGE_LOG',		'Recharge Log');
	define('LG_EVERY_AREA_GATHER',	'Every Area Gather');
	define('LG_EVERY_AREA_DETAIL',	'Every Area Detail');
	define('LG_EVERY_AREA_LOG',		'Every Area Log');
	define('LG_SERVICES_STATE',		'Services State');
	define('LG_RETENTION_RATE',		'Retention Rate');
	define('LG_BUY_RANK',			'Buy Rank');
	define('LG_RECHARGE_RANK',		'Recharge Rank');
	define('LG_SEARCH_BY_ID',		'Search By Player ID');
	define('LG_STOP_FOR_REPAIR',	'Stop service maintenance');
	define('LG_CDKEY_ACTIVE',		'Cdkey active');
	define('LG_SYSTEM_NOTICE',		'System Notice');
	define('LG_SYSTEM_ACTIVITY',	'System Activity');
	define('LG_GUILD_LEVEL_SPREAD',	'Guild level spread');
	define('LG_VIP_LEVEL_SPREAD',	'Vip level spread');
	define('LG_PVP_SCORE_RANGE_SPREAD',	'Pvp score range spread');
	
	//views main
	define('LG_SELECT_SERVER',		'Select Server');
	define('LG_SELECT',				'Select');
	define('LG_CURRENCT_SELECTED',	'Current Selected');
	define('LG_SELECT_CMD',			'Selected Cmd');
	define('LG_CMD_DESCRIPTION',	'Cmd Description');
	define('LG_INPUT_CMD_PARAMS',	'Input Cmd Params');
	define('LG_GM_ACCOUNT',			'Gm Account');
	define('LG_GM_PASSWORD',		'Gm Password(Optional)');
	define('LG_EXECUTE',			'Execute');
	define('LG_REQUESTING',			'Requesting');
	
	//views award describe
	define('LG_AWARD_TYPE',			'Award Type');
	define('LG_PET_ID',			    'Pet ID');
	define('LG_NUMBER',			    'Number');
	define('LG_PARAM4',  			'Level');
	define('LG_RESET',  			'Reset');
	define('LG_OUTPUT',  			'Output');
	define('LG_PET_NAME_SELECT',	'Select Pet ID By Name');
	define('LG_GOODS_NAME_SELECT',  'Select Goods ID By Name');
	define('LG_OTHER_AWARD_TYPE_ID','Ohter Award Type ID');
	define('LG_AWARD_EXP',          'Exp');
	define('LG_AWARD_GOLD',         'Gold');
	define('LG_AWARD_YUANBAO',      'YuanBao');
	define('LG_AWARD_PET',          'Pet');
	define('LG_AWARD_ACTION_COUNT', 'Action Count');
	define('LG_AWARD_FRIEND_SHIP',  'Friendship');
	define('LG_AWARD_EQUIP',        'Equip');
	define('LG_AWARD_RANDOM_PET',   'Random Pet');
	define('LG_AWARD_RANDOM_EQUIP', 'Random Equp');
	define('LG_AWARD_GOODS',        'Goods');
	define('LG_AWARD_OTHER_WORLD_INTRUSION_CURRENCY', 'Other Word Intrusion Currency');
	define('LG_AWARD_OTHER_WORLD_EXPEDITION_CURRENCY','Other Word Expedtion Currency');
	define('LG_AWARD_GUILD_CURRENCY',                 'Guild Currency');
	define('LG_AWARD_EQUIP_RAFFLE_TICKETS',           'Equip Raffle Tickets');
	define('LG_AWARD_PET_RAFFLE_TICKETS',             'Pet Raffle Tickets');
	define('LG_AWARD_FIRST_QUEUE_PET_EXP',            'First Queue Pet Exp');
	define('LG_AWARD_BY_SEND_EMAIL',                  'EMail Award');
	define('LG_AWARD_PVP_CURRENCY',                   'Pvp Currency');
	define('LG_WHITE_EQUIP',          'White Equip');
	define('LG_GREEN_EQUIP',          'Green Equip');
	define('LG_BLUE_EQUIP',          'Blue Equip');
	define('LG_PRUPLE_EQUIP',          'Purple');
	define('LG_ORANGE_EQUIP',          'Orange Equip');
	define('LG_WHITE_BLUE_ITEM',          'White~Blue Item');
	define('LG_GREEN_PURPLE_ITEM',          'Green~Purple Item');
	define('LG_BLUE_PURPLE_ITEM',          'Blue~Purple Item');
	define('LG_BLUE_ORANGE_ITEM',          'Blue~Orange Item');
	define('LG_PURPLE_ORANGE_ITEM',          'Purple~Orange Item');
	define('LG_1_STAR_PET',          '1 star pet');
	define('LG_2_STAR_PET',          '2 star pet');
	define('LG_3_STAR_PET',          '3 star pet');
	define('LG_4_STAR_PET',          '4 star pet');
	define('LG_5_STAR_PET',          '5 star pet');
	define('LG_6_STAR_PET',          '6 star pet');
	define('LG_1_3_CALL',          '☆1~☆3 star item');
	define('LG_1_4_CALL',          '☆1~☆4 star item');
	define('LG_3_4_CALL',          '☆3~☆4 star item');
	define('LG_3_5_CALL',          '☆3~☆5 star item');
	define('LG_4_5_CALL',          '☆4~☆5 star item');
	define('LG_NOTHING',          'Nothing');
	
	//views account
	define('LG_ACCOUNT',			'Account');
	define('LG_NAME',				'Player Name');
	define('LG_SERVER',				'Server');
	define('LG_LOGIN_PLATFORM',		'Login Platform');
	define('LG_CREATE_TIME',		'Create Time');
	define('LG_QUERY_PROMPT',		'Querying,Please wait');
	
	//views player_id_search			
	define('LG_PLAYER_ID',			'Digital Id');
	
	//views player			
	define('LG_SEX',				'Sex');
	define('LG_LEVEL',				'Level');
	define('LG_EXP',				'Exp');
	define('LG_GOLD',				'Gold');	
	define('LG_ACTION_COUNT',		'Action Count');
	define('LG_HEAD_PIC_ID',		'Head Pic Id');
	define('LG_GUIDE_STEP',			'Guide Step');
	define('LG_FLAG_FIRST_ENTER_GAME','First Enter Game Flag');
	define('LG_CUR_QUEUE_ID',		'Current Queue Id');
	define('LG_PET_MAX_NUMBER',		'Pet Max Number');
	define('LG_FRIEND_SHIP',		'Friendship');
	define('LG_ADD_FRIEND_BY_OTHER','Add Friend By Other');
	define('LG_NEXT_SUMMON_FREE_TIME','Next Summon Free Time');
	define('LG_TODAY_FIGHT_COUNTS',	'Today Fight Counts');
	define('LG_TODAY_ARCHEMY_COUNTS','Today Achemy Counts');
	define('LG_LEIJICHONGZHI',       'Sum Chongzhi');
	
	//views pet
	define('LG_PET_NAME',			'Pet Name');
	define('LG_PET_DIGITAL_ID',		'Pet Digital Id');
	define('LG_PET_CLASS_ID',		'Pet Class Id');
	define('LG_IS_PROTECTED',		'Is Protected');
	define('LG_SKILL_LEVEL',		'Skill Level');	
	define('LG_EQUIP_ID_1',			'Equip Id_1');
	define('LG_EQUIP_ID_2',			'Equip Id_2');
	define('LG_EQUIP_ID_3',			'Equip Id_3');
	define('LG_NEW_STATE',			'New State');
	
	//views online
	define('LG_TIME_RANGE',			'Time Range');
	define('LG_TIME_FROM',			'From');
	define('LG_TIME_TO',			'To');
	define('LG_ACTIVE_NUMBER',		'Active Number');
	define('LG_TIME',				'Time');
	define('LG_LAST_PAGE',			'Last Page');
	define('LG_Next_PAGE',			'Next Page');
	
	//views level
	define('LG_PLAYER_NUMBER',		'Player Number');

	// views guide step
	define('LG_PLAYER_GUIDE_STEP',	'New Guide Step');
	
	//views gem
	define('LG_OPTIONAL',			'Optional');
	define('LG_DESCRIPTION',		'Description');
	define('LG_TYPE',				'Type');
	define('LG_TOTAL',				'Total');
	define('LG_CONSUME',			'Consume');
	define('LG_NEGATIVE_NUMBER',	'Negative Number');
	define('LG_POSITIVE_NUMBER',	'Positive Number');
	define('LG_PUCHASE_TIME',		'Puchase Time');
	define('LG_GET',				'Get');
	
	//views charge
	define('LG_CURRENT_PAGE',		'Current Page');
	define('LG_PLAYER_TOTAL_AMOUNT_OF_RECHARGE','Total Amount Of Recharge');
	define('LG_PLAYER_TOTAL_NUMBER_OF_RECHARGE','Total Number Of Recharge');
	define('LG_MONEY',				'Money');
	define('LG_GEMSTONE',			'Gemstone');
	define('LG_RECHARGE_TIME',		'Recharge Time');
	define('LG_ADD_TO_GAME_TIME',	'Add To Game Time');
	define('LG_STATUS',				'Status');
	define('LG_TRANSACTION_ID',		'Transaction Id');
	define('LG_AREA_NUMBER',		'Area Number');
	
	//views total
	define('LG_TOTAL_NUMBER_OF_PLAYER','Total Number Of Player');
	define('LG_MAX_NUMBER_ONLINE',	'Max Number Online');
	define('LG_THE_NUMBER_OF_RECHARGE',	'The Number Of Recharge');
	define('LG_RECHARGE_TIMES',		'Recharge Times');
	define('LG_TOTAL_AMOUNT_OF_RECHARGE','Total Amount Of Recharge');
	define('LG_AVERAGE_DAILY_AMOUNT_OF_RECHARGE','Average Daily Amount Of Recharge');
	define('LG_AVERAGE_DAILY_ARPRU','Average Daily ARPRU');
	define('LG_AVERAGE_DAILY_ARPPU','Average Daily ARPPU');
	define('LG_AVERAGE_DAILY_PR','Average Daily PR');
	
	//views detail
	define('LG_DATETIME','Datetime');
	define('LG_NEWER_NO_OPERATION_RATE','Newer No Operation Rate');
	
	//views server_state
	define('LG_LOGIN_SERVER','Login Server');
	define('LG_GAME_SERVER','Game Server');
	define('LG_OPEN','Open');
	define('LG_CLOSE','Close');
	
	//views remain
	define('LG_SELECT_DATE_TIME','Select Date Time');
	define('LG_DNU','DNU');
	define('LG_DRU_1','DRU_1');
	define('LG_DRU_3','DRU_3');
	define('LG_DRU_7','DRU_7');
	define('LG_DRU_15','DRU_15');
	define('LG_DRU_30','DRU_30');
	
	//views props_purchase_list
	define('LG_GOODS_ID','Goods Id');
	define('LG_GOODS_NAME','Goods Name');
	define('LG_NUMBER_OF_PURCHASE','Number Of Purchase');
	define('LG_DESCRIPTION_OF_PURCHASE','Description Of Purchase');
	
	//views chongzhi_list
	define('LG_ITEM_ID','Item Id');
	define('LG_COUNT','Count');
	define('LG_SUM','Sum');
	
	//views close_server_and_maintain
	define('LG_NORMAL','Normal');
	define('LG_MAINTAIN','Maintain');
	define('LG_NEW_AREA','New Area');
	define('LG_HOT','Hot');
	define('LG_MINUTES_LATER','Minutes(1-60) Later');
	define('LG_CLOSE_SERVER','Close Server');
	define('LG_SET_RUN_STATUS','Set Run Status');
	define('LG_SET_Fluency_STATUS','Set Fluency Status');
	
	define('LG_LOGOUT','Logout');
	define('LG_BACKSTAGE_MANAGEMENT_SYSTEM','Backstage Management System');
	define('LG_LOGIN_ACCOUNT','Login Account');
	define('LG_LOGIN_PASSWORD','Login Password');
	define('LG_VERIFICATION_CODE','Verification Code');
	define('LG_ERROR_VERIFICATION_CODE','Error Verification Code');
	define('LG_ERROR_ACCOUNT_OR_PASSWORD','Error Account Or Password');
	define('LG_INVALID_GM_ACCOUNT','Invalid Gm Account');
	
	//views cdkey
	define('LG_TITLE','Title');
	define('LG_ACTIVITY_ID','Activity Id');
	define('LG_PICTURE_URL','Picture Url');
	define('LG_BEGIN_TIME','Begin Time');
	define('LG_END_TIME','End Time');
	define('LG_GET_AEARD_TIME','Get Award Time');
	define('LG_MIN_LEVEL','Min Level');
	define('LG_AWARD','Award');
	define('LG_CANCEL','Cancel');
	define('LG_MODIFY','Modify');
	define('LG_DELETE','Delete');
	define('LG_ADD','Add');
	
	define('LG_CHANNEL','channel');
	define('LG_CHANNEL_DETAIL','channel_detail');
	
	define('LG_GUILD_LEVEL','guild level');
	define('LG_GUILD_NUMBER','guild number');
	
	define('LG_VIP_LEVEL','vip level');
	define('LG_PVP_SCORE_RANGE','pvp score range');	
	
	define('LG_SUMMONER_TRAINEE','Summoner trainee');
	define('LG_TRAINEE_SUMMONER','Trainee Summoner'); 
	define('LG_JUNIOR_SUMMONER','Junior Summoner');
	define('LG_MIDDLE_SUMMONER','Middle Summoner');
	define('LG_SENIOR_SUMMONER','Senior Summoner');
	define('LG_MASTER_SUMMONER','Master Summoner');
	define('LG_GREY_ROBE_SUMMONER','Grey Robe Summoner');
	define('LG_GREEN_ROBE_SUMMONER','Green robe Summoner');
	define('LG_WHITE_ROBE_SUMMONER','White robe Summoner');
	define('LG_ROYAL_SUMMONER','Royal Summoner');
	define('LG_MIRACLE_SUMMONER','Miracle Summoner');
	define('LG_LEGEND_SUMMONER','Legend Summoner');
	
	
	//award_show
	define('LG_SEND_TO_A_SINGLE_PLAYER','Send to a single player');
	define('LG_SEND_TO_MULTIPLE_PLAYERS','Send to multiple players');
	define('LG_SEND_TO_ABOVE_THE_LEVEL_INCLUDE','Send to (including) above the level of the player');
	define('LG_PLAYER_LEVEL','Player level');
	define('LG_EMAIL_TYPE','Email type');
	define('LG_NON_REWARD_EMAIL','Non reward email');
	define('LG_CAN_AWARD_EMAIL','Can award email');
	define('LG_EMAIL_TITLE','Email title');
	define('LG_EMAIL_CONTENT','Email content');
	define('LG_AWARD_DESCRIPTION','Award description');
	define('LG_FORMATE','Formate');
	
	//add/delete test authority
	define('LG_ADD_DEL_TEST_AUTHORITY','Add/Delete test server test authority');
	define('LG_ADD_TEST_AUTHORITY','Add test authority');
	define('LG_DEL_TEST_AUTHORITY','Delete test authority');
	define('LG_DEL_ALL_TEST_AUTHORITY','Delete all test authority');
	
	//views system_notice
	define('LG_NOTICE_IDX','Notice Idx');
	define('LG_FREQUENCY','Frequency');
	define('LG_DELAY_BEGIN','Delay Begin');
	define('LG_CONTENT','Content');
	
	//send email_award
	define('LG_EMAIL_AWARD_SEND_QUERY','Email award send query');
	define('LG_EMAIL_AWARDS','Awards');
	define('LG_EMAIL_AWARD_SEND_TIME','Send time');
	
	//views system_active
	define('LG_ACTIVE_ID','Active Id');
	define('LG_ACTIVE_NAME','Active Name');
	define('LG_ACTIVE_DESC','Active Desc');
	define('LG_ACTIVE_AWARD','Active Award');
	define('LG_ACTIVE_VALUE','Active Value');
	define('LG_ACTIVE_EVERY_DAY','Every Day Active');
	define('LG_ACTIVE_LOGIN','Login Active');
	define('LG_ACTIVE_COST','Cost Active');
	define('LG_ACTIVE_UPGRADE','Upgrade Active');
	define('LG_ACTIVE_ZHAO_HUAN','ZhaoHuan Active');
	define('LG_ACTIVE_CHONG_ZHI','Recharge Active');
	define('LG_ACTIVE_PVP_RANK','Pvp Rank Active');
	define('LG_ACTIVE_INVEST_MENT','Investment Active');
	define('LG_ACTIVE_ONLINE_CHECK','Online Check Active');
	define('LG_ACTIVE_LUCK_STAR','Lucky Star Active');
	define('LG_TIME_LIMIT_BUYING','Time Limit Buying');
	define('LG_ACTIVE_EXCHANGE','Exchange Active');
	define('LG_ACTIVE_SIGNLE_CHONGZHI','Single Charge Active');
	define('LG_ACTIVE_Online','Online Active');
	define('LG_GET_AWARD_TIME','Get Award Time');
	define('LG_ACTIVE_INPUT_SQL_FIL','Input File');
	define('LG_ACTIVE_OUTPUT_SQL_FIL','Output File');
	define('LG_ACTIVE_INPUT_CHOOSE_FIL','Select_File');
	//recent email_award 
	define('LG_RECENT_SEND_RECORD','Recent send record');
	define('LG_EXECUTE_ACCOUNT','Execute account');
	define('LG_EXECUTE_IP','Execute ip');
	define('LG_RECIEVE_TYPE','Recieve type');
	define('LG_RECIEVERS','Recievers');
	
	define('LG_SERVER_NAME','Server name');
	
	//order_lose_query_resend
	define('LG_ORDER_LOSE_QUERY',	'Order lose query');
	define('LG_PLAT_FORM_TRANS_ID',	'Plat form transaction id');
	define('LG_ORDER_SOURCE', 'Order source');
	
	//order_lose_resend
	define('LG_ORDER_LOSE_RESEND',	'Order lose resend');
	define('LG_PRODUCT_NAME',	'Product name');
	define('LG_ORDER_LOSE_RESEND_TYPE',	'Order lose resend type');
	define('LG_GOOGLE_PLAY_ORDER_LOSE_RESEND',	'Google_play');
	define('LG_APPSTORE_ORDER_LOSE_RESEND',	'Appstore');
	
	//yuanbao_trace
	define('LG_YUANBAO_TRACE',	'Gemstone trace');
	define('LG_YUANBAO_CHANGE',	'Gemstone change');
	define('LG_BEFORE_CHANGE',	'Before change');
	define('LG_AFTER_CHANGE',	'After change');
	define('LG_CHANGE_REASON',	'Reason changed');
	define('LG_CHANGE_TIME',	'Time changed');
	
	//equipment info
	define('LG_PLAYER_EQUIPMENT',	'Player Equipment');
	define('LG_UNIQUE_ID',	'Unique id');
	define('LG_EQUIPMENT_ID',	'Equipment ID');
	define('LG_HOLE1',	'Hole1');
	define('LG_HOLE2',	'Hole2');
	define('LG_HOLE3',	'Hole3');
	define('LG_BELONG_TO_PET_ID',	'Belong to pet id');
	
	//goods info
	define('LG_PLAYER_GOODS',	'Player goods');
	define('LG_RESOURCE_NAME',	'Name');
	
	//time limited buying 
	define('LG_INVENTORY',	'inventory');
	define('LG_TODAY_LIMIT_BUY_COUNT',	'today limit buy count');
	define('LG_TODAY_BOUGHT_COUNT',	'today bought count');
	
	//payment behavior
	define('LG_PAYMENT_BEHAVIOR',	'payment behavior');
	define('LG_BEHAVIOR_DESC',	'behavior desc');
	define('LG_BEHAVIOR_COUNT',	'behavior count');
	define('LG_TOTAL_PAYMENT',	'total payment');
	
	//checkpoint_process
	define('LG_CHECKPOINT_PROCESS',	'checkpoint process');
	define('LG_CHECKPOINT_TYPE',	'checkpoint type');
	define('LG_PUTONG_CHAPTER',	'putong chapter');
	define('LG_JINGYING_CHAPTER',	'jingying chapter');
	define('LG_ACTIVE_CHAPTER',	'active chapter');
	define('LG_OTHER_WORLD_INTRUSION_CHAPTER',	'other world intrusion chapter');
	define('LG_GUILD_CHAPTER',	'guild chapter');
	define('LG_OTHER_WORLD_EXPEDITION_CHAPTER',	'other world expediton chapter');
	define('LG_CHAPTER_ID',	'chapter id');
	define('LG_CHECKPOINT_ID',	'checkpoint id');
	define('LG_PEOPLE_TOTAL_NUMBER',	'people total number');
	
	//guild_info
	define('LG_GUILD_INFO',	'guild info');
	define('LG_LIANMENG_ID',	'guild id');
	define('LG_LIANMENG_NAME',	'guild name');
	define('LG_LIANMENG_LEVEL',	'guild level');
	define('LG_LIANMENG_MEMBER',	'guild member');
	
	define('LG_PLYAER_LOGIN_IP',	'login ip');
}
 
else if ( defined('LANGUAGE_CH')){
	define('LG_GM',					'GM管理');
	define('LG_SEND_AWARD',			'发送奖励');
	define('LG_AWARD_DESCRIBE',		'奖励描述');
	define('LG_SEARCH_BY_ACCOUNT',	'账号查询');
	define('LG_PLAYER_BASE',		'玩家基本信息');
	define('LG_PET_INFO',			'宠物信息');
	define('LG_ONLINE_NUMBER',		'实时在线');
	define('LG_LEVEL_SPREAD',		'等级分布');
	define('LG_SYSTEM_GLOBAL',		'系统全局');
	define('LG_GEM_GET_AND_USE',	'宝石获得与消耗');
	define('LG_RECHARGE_LOG',		'充值记录');
	define('LG_EVERY_AREA_GATHER',	'各服汇总');
	define('LG_EVERY_AREA_DETAIL',	'各服明细');
	define('LG_EVERY_AREA_LOG',		'各服日志');
	define('LG_SERVICES_STATE',		'服务器状态');
	define('LG_RETENTION_RATE',		'留存率');
	define('LG_BUY_RANK',			'单区道具购买榜');
	define('LG_RECHARGE_RANK',		'单区充值榜');
	define('LG_SEARCH_BY_ID',		'玩家id查询');
	define('LG_GUILD_LEVEL_SPREAD',	'公会等级分布');
	define('LG_VIP_LEVEL_SPREAD',	'Vip等级分布');
	define('LG_PVP_SCORE_RANGE_SPREAD',	'竞技场-段位分布');
	//views main
	define('LG_STOP_FOR_REPAIR',	'停服维护');
	define('LG_CDKEY_ACTIVE',		'cdkey活动');
	define('LG_SYSTEM_NOTICE',		'系统定时公告');
	define('LG_SYSTEM_ACTIVITY',	'活动配置');
	define('LG_SELECT_SERVER',		'选择区');
	define('LG_SELECT',				'添加');
	define('LG_CURRENCT_SELECTED',	'当前选择区');
	define('LG_SELECT_CMD',			'选择命令');
	define('LG_CMD_DESCRIPTION',	'命令描述');
	define('LG_INPUT_CMD_PARAMS',	'输入命令参数');
	define('LG_GM_ACCOUNT',			'gm账号');
	define('LG_GM_PASSWORD',		'Gm密码(可选)');
	define('LG_EXECUTE',			'提交执行');
	define('LG_REQUESTING',			'正在请求');
	
	//views award describe
	define('LG_AWARD_TYPE',			'奖励类型');
	define('LG_PET_ID',			    '宠物id');
	define('LG_NUMBER',			    '数量');
	define('LG_PARAM4',  			'等级');
	define('LG_RESET',  			'重置');
	define('LG_OUTPUT',  			'输出');
	define('LG_PET_NAME_SELECT',	'宠物名字查找id');
	define('LG_GOODS_NAME_SELECT',  '物品名字查找id');
	define('LG_OTHER_AWARD_TYPE_ID','其他类型id');
	define('LG_AWARD_EXP',          '经验');
	define('LG_AWARD_GOLD',         '金币');
	define('LG_AWARD_YUANBAO',      '元宝');
	define('LG_AWARD_PET',          '宠物');
	define('LG_AWARD_ACTION_COUNT', '行动力');
	define('LG_AWARD_FRIEND_SHIP',  '友情点');
	define('LG_AWARD_EQUIP',        '装备');
	define('LG_AWARD_RANDOM_PET',   '随机宠物卡');
	define('LG_AWARD_RANDOM_EQUIP', '随机装备');
	define('LG_AWARD_GOODS',        '物品');
	define('LG_AWARD_OTHER_WORLD_INTRUSION_CURRENCY', '异界入侵货币');
	define('LG_AWARD_OTHER_WORLD_EXPEDITION_CURRENCY','异界远征货币');
	define('LG_AWARD_GUILD_CURRENCY',                 '公会币');
	define('LG_AWARD_EQUIP_RAFFLE_TICKETS',           '装备抽奖券');
	define('LG_AWARD_PET_RAFFLE_TICKETS',             '宠物抽奖券');
	define('LG_AWARD_FIRST_QUEUE_PET_EXP',            '当前冒险编队的宠物加经验');
	define('LG_AWARD_BY_SEND_EMAIL',                  '邮件发奖');
	define('LG_AWARD_PVP_CURRENCY',                   '竞技币');
	define('LG_WHITE_EQUIP',          '白色装备');
	define('LG_GREEN_EQUIP',          '绿色装备');
	define('LG_BLUE_EQUIP',          '蓝色装备');
	define('LG_PRUPLE_EQUIP',          '紫色装备');
	define('LG_ORANGE_EQUIP',          '橙色装备');
	define('LG_WHITE_BLUE_ITEM',          '白装~蓝装召唤券');
	define('LG_GREEN_PURPLE_ITEM',          '绿装~紫装召唤券');
	define('LG_BLUE_PURPLE_ITEM',          '蓝装~紫装召唤券');
	define('LG_BLUE_ORANGE_ITEM',          '蓝装~橙装召唤券');
	define('LG_PURPLE_ORANGE_ITEM',          '紫装~橙装召唤券');
	define('LG_1_STAR_PET',          '1星宠物');
	define('LG_2_STAR_PET',          '2星宠物');
	define('LG_3_STAR_PET',          '3星宠物');
	define('LG_4_STAR_PET',          '4星宠物');
	define('LG_5_STAR_PET',          '5星宠物');
	define('LG_6_STAR_PET',          '6星宠物');
	define('LG_1_3_CALL',          '☆1~☆3召唤券');
	define('LG_1_4_CALL',          '☆1~☆4召唤券券');
	define('LG_3_4_CALL',          '☆3~☆4召唤券券');
	define('LG_3_5_CALL',          '☆3~☆5召唤券');
	define('LG_4_5_CALL',          '☆4~☆5召唤券');
	define('LG_NOTHING',          '无');

	
	//views account
	define('LG_ACCOUNT',			'账号');
	define('LG_NAME',				'名称');
	define('LG_SERVER',				'所在区');
	define('LG_LOGIN_PLATFORM',		'平台');
	define('LG_CREATE_TIME',		'创建时间');
	define('LG_QUERY_PROMPT',		'正在查询，请稍候');
	
	//views player_id			
	define('LG_PLAYER_ID',			'玩家的唯一id');
	
	//views player			
	define('LG_SEX',				'性别');
	define('LG_LEVEL',				'等级');
	define('LG_EXP',				'经验');
	define('LG_GOLD',				'金');	
	define('LG_ACTION_COUNT',		'攻略关卡消耗行动点');
	define('LG_HEAD_PIC_ID',		'系统头像id');
	define('LG_GUIDE_STEP',			'新手引导当前步骤');
	define('LG_FLAG_FIRST_ENTER_GAME','是否第一次进入游戏');
	define('LG_CUR_QUEUE_ID',		'当前编队号');
	define('LG_PET_MAX_NUMBER',		'宠物上限值');
	define('LG_FRIEND_SHIP',		'友情点');
	define('LG_ADD_FRIEND_BY_OTHER','是否能被别人申请好友');
	define('LG_NEXT_SUMMON_FREE_TIME','下次免费召唤时间');
	define('LG_TODAY_FIGHT_COUNTS',	'今日切磋次数');
	define('LG_TODAY_ARCHEMY_COUNTS','今日炼金次数');
	define('LG_LEIJICHONGZHI','累计充值 ');

	//views pet
	define('LG_PET_NAME',			'Pet Name');
	define('LG_PET_DIGITAL_ID',		'宠物64id');
	define('LG_PET_CLASS_ID',		'宠物类id');
	define('LG_IS_PROTECTED',		'是否保护');
	define('LG_SKILL_LEVEL',		'技能等级');	
	define('LG_EQUIP_ID_1',			'装备ID1');
	define('LG_EQUIP_ID_2',			'装备ID2');
	define('LG_EQUIP_ID_3',			'装备ID3');
	define('LG_NEW_STATE',			'新的状态');
	
	//views online
	define('LG_TIME_RANGE',			'时间范围');
	define('LG_TIME_FROM',			'从');
	define('LG_TIME_TO',			'到');
	define('LG_ACTIVE_NUMBER',		'活跃人数');
	define('LG_TIME',				'时间');
	define('LG_LAST_PAGE',			'上一页');
	define('LG_Next_PAGE',			'下一页');
	
	//views level
	define('LG_PLAYER_NUMBER',		'人数');
	// views guide step
	define('LG_PLAYER_GUIDE_STEP',	'新手引导');
	
	//views gem
	define('LG_OPTIONAL',			'可选');
	define('LG_DESCRIPTION',		'描述');
	define('LG_TYPE',				'类型');
	define('LG_TOTAL',				'总额');
	define('LG_CONSUME',			'消费');
	define('LG_NEGATIVE_NUMBER',	'负数');
	define('LG_POSITIVE_NUMBER',	'正数');
	define('LG_PUCHASE_TIME',		'购买时间');
	define('LG_GET',				'获得');
	
	//views charge
	define('LG_CURRENT_PAGE',		'当前页码');
	define('LG_PLAYER_TOTAL_AMOUNT_OF_RECHARGE','被查询玩家充值总金额');
	define('LG_PLAYER_TOTAL_NUMBER_OF_RECHARGE','被查询玩家总充值总次数 ');
	define('LG_MONEY',				'金额');
	define('LG_GEMSTONE',			'游戏币');
	define('LG_RECHARGE_TIME',		'充值时间');
	define('LG_ADD_TO_GAME_TIME',	'到账时间');
	define('LG_STATUS',				'状态');
	define('LG_TRANSACTION_ID',		'订单号');
	define('LG_AREA_NUMBER',		'区');
	
	//views total
	define('LG_TOTAL_NUMBER_OF_PLAYER','角色总数');
	define('LG_MAX_NUMBER_ONLINE',	'最高同时在线');
	define('LG_THE_NUMBER_OF_RECHARGE',	'充值人数');
	define('LG_RECHARGE_TIMES',		'充值次数');
	define('LG_TOTAL_AMOUNT_OF_RECHARGE','充值总额');
	define('LG_AVERAGE_DAILY_AMOUNT_OF_RECHARGE','平均日充值金额');
	define('LG_AVERAGE_DAILY_ARPRU','平均日ARPRU');
	define('LG_AVERAGE_DAILY_ARPPU','平均日ARPPU');
	define('LG_AVERAGE_DAILY_PR','平均日PR');
	
	//views detail
	define('LG_DATETIME','日期');
	define('LG_NEWER_NO_OPERATION_RATE','新手无操作率');
	
	//views server_state
	define('LG_LOGIN_SERVER','登入服务器');
	define('LG_GAME_SERVER','游戏服务器');
	define('LG_OPEN','开放');
	define('LG_CLOSE','关闭');
	
	//views remain
	define('LG_SELECT_DATE_TIME','选择日期');
	define('LG_DNU','(当天新增角色)DNU');
	define('LG_DRU_1','次日留存率');
	define('LG_DRU_3','三天留存率');
	define('LG_DRU_7','七天留存率');
	define('LG_DRU_15','十五天留存率');
	define('LG_DRU_30','三十天留存率');
	
	//views props_purchase_list
	define('LG_GOODS_ID','物品id');
	define('LG_GOODS_NAME','物品名称');
	define('LG_NUMBER_OF_PURCHASE','购买次数');
	define('LG_DESCRIPTION_OF_PURCHASE','购买方式(desc)');
	
	//views chongzhi_list
	define('LG_ITEM_ID','充值产品id');
	define('LG_COUNT','次数');
	define('LG_SUM','总额');
	
	//views close_server_and_maintain
	define('LG_NORMAL','正常');
	define('LG_MAINTAIN','维护');
	define('LG_NEW_AREA','新区');
	define('LG_HOT','火爆');
	define('LG_MINUTES_LATER','分钟(最小1分钟，最大60分钟)后');
	define('LG_CLOSE_SERVER','停服维护');
	define('LG_SET_RUN_STATUS','设置运行状态');
	define('LG_SET_Fluency_STATUS','设置流畅度');
	
	define('LG_LOGOUT','退出');
	define('LG_BACKSTAGE_MANAGEMENT_SYSTEM','后台管理系统');
	define('LG_LOGIN_ACCOUNT','账号');
	define('LG_LOGIN_PASSWORD','密码');
	define('LG_VERIFICATION_CODE','验证码');
	define('LG_ERROR_VERIFICATION_CODE','验证码错误');
	define('LG_ERROR_ACCOUNT_OR_PASSWORD','用户名/密码错误');
	define('LG_INVALID_GM_ACCOUNT','无效gm用户');
	
	define('LG_TITLE','标题');
	define('LG_ACTIVITY_ID','活动id');
	define('LG_PICTURE_URL','图片地址');
	define('LG_BEGIN_TIME','开始时间');
	define('LG_END_TIME','结束时间');
	define('LG_GET_AEARD_TIME','领奖时间');
	define('LG_MIN_LEVEL','要求等级');
	define('LG_AWARD','奖励');
	define('LG_CANCEL','取消');
	define('LG_MODIFY','修改');
	define('LG_DELETE','删除');
	define('LG_ADD','增加');
	
	define('LG_CHANNEL','渠道');
	define('LG_CHANNEL_DETAIL','渠道明细');
	
	
	define('LG_GUILD_LEVEL','公会等级');
	define('LG_GUILD_NUMBER','公会数量');
	
	define('LG_VIP_LEVEL','vip等级');
	define('LG_PVP_SCORE_RANGE','pvp分数区间');
	
	define('LG_SUMMONER_TRAINEE','召唤师学徒');
	define('LG_TRAINEE_SUMMONER','见习召唤师'); 
	define('LG_JUNIOR_SUMMONER','初级召唤师');
	define('LG_MIDDLE_SUMMONER','中级召唤师');
	define('LG_SENIOR_SUMMONER','高级召唤师');
	define('LG_MASTER_SUMMONER','召唤大师');
	define('LG_GREY_ROBE_SUMMONER','灰袍召唤师');
	define('LG_GREEN_ROBE_SUMMONER','绿袍召唤师');
	define('LG_WHITE_ROBE_SUMMONER','白袍召唤师');
	define('LG_ROYAL_SUMMONER','皇家召唤师');
	define('LG_MIRACLE_SUMMONER','奇迹召唤师');
	define('LG_LEGEND_SUMMONER','传奇召唤师');
	
	//award_show
	define('LG_SEND_TO_A_SINGLE_PLAYER','发送给单个玩家');
	define('LG_SEND_TO_MULTIPLE_PLAYERS','发送给多个玩家');
	define('LG_SEND_TO_ABOVE_THE_LEVEL_INCLUDE','发送给该等级(包括)以上的玩家 ');
	define('LG_PLAYER_LEVEL','玩家等级');
	define('LG_EMAIL_TYPE','邮件类型');
	define('LG_NON_REWARD_EMAIL','非奖励邮件');
	define('LG_CAN_AWARD_EMAIL','可奖励邮件');
	define('LG_EMAIL_TITLE','邮件标题');
	define('LG_EMAIL_CONTENT','邮件内容');
	define('LG_AWARD_DESCRIPTION','奖励描述');
	define('LG_FORMATE','格式');
	
	//add/delete test authority
	define('LG_ADD_DEL_TEST_AUTHORITY','添加/删除测试区测试权限');
	define('LG_ADD_TEST_AUTHORITY','添加测试权限');
	define('LG_DEL_TEST_AUTHORITY','删除测试权限');
	define('LG_DEL_ALL_TEST_AUTHORITY','删除所有测试权限');
	
	define('LG_NOTICE_IDX','公告编号');
	define('LG_FREQUENCY','广播频率');
	define('LG_DELAY_BEGIN','几秒后开始');
	define('LG_CONTENT','公告内容');
	
	//send email_award
	define('LG_EMAIL_AWARD_SEND_QUERY','邮件奖励发送查询');
	define('LG_EMAIL_AWARDS','奖励内容');
	define('LG_EMAIL_AWARD_SEND_TIME','奖励发送时间');
	
	//views system_active
	define('LG_ACTIVE_ID','活动ID');
	define('LG_ACTIVE_NAME','活动名称');
	define('LG_ACTIVE_DESC','活动描述');
	define('LG_ACTIVE_AWARD','活动奖励');
	define('LG_ACTIVE_VALUE','活动参数');
	define('LG_ACTIVE_EVERY_DAY','每日活动');
	define('LG_ACTIVE_LOGIN','登录活动');
	define('LG_ACTIVE_COST','消耗活动');
	define('LG_ACTIVE_UPGRADE','升级活动');
	define('LG_ACTIVE_ZHAO_HUAN','召唤活动');
	define('LG_ACTIVE_CHONG_ZHI','储值活动');
	define('LG_ACTIVE_PVP_RANK','竞技排名活动');
	define('LG_ACTIVE_INVEST_MENT','投资理财活动');
	define('LG_ACTIVE_ONLINE_CHECK','上线触发活动');
	define('LG_TIME_LIMIT_BUYING','限时抢购');
	define('LG_ACTIVE_EXCHANGE','兑换活动');
	define('LG_ACTIVE_SIGNLE_CHONGZHI','单笔充值活动');
	define('LG_ACTIVE_Online','在线活动');
	define('LG_ACTIVE_LUCK_STAR','幸运星活动');
	define('LG_GET_AWARD_TIME','领奖时间');
	define('LG_ACTIVE_INPUT_SQL_FIL','导入');
	define('LG_ACTIVE_OUTPUT_SQL_FIL','导出');
	define('LG_ACTIVE_INPUT_CHOOSE_FIL','选择文件');
	//recent email_award 
	define('LG_RECENT_SEND_RECORD','最近发送记录');
	define('LG_EXECUTE_ACCOUNT','执行人的账号');
	define('LG_EXECUTE_IP','执行人的ip');
	define('LG_RECIEVE_TYPE','接收者的类型');
	define('LG_RECIEVERS','接收者');
	
	define('LG_SERVER_NAME','区名称');
	
	//order_lose_query_resend
	define('LG_ORDER_LOSE_QUERY',	'丢单查询');
	define('LG_PLAT_FORM_TRANS_ID',	'订单号');
	define('LG_ORDER_SOURCE', '订单号来源');
	
	//order_lose_resend
	define('LG_ORDER_LOSE_RESEND',	'丢单补发');
	define('LG_PRODUCT_NAME',	'产品名称');
	define('LG_ORDER_LOSE_RESEND_TYPE',	'丢单补发类型');
	define('LG_GOOGLE_PLAY_ORDER_LOSE_RESEND',	'Google_play');
	define('LG_APPSTORE_ORDER_LOSE_RESEND',	'Appstore');
	
	//yuanbao_trace
	define('LG_YUANBAO_TRACE',	'元宝追踪');
	define('LG_YUANBAO_CHANGE',	'元宝改变值');
	define('LG_BEFORE_CHANGE',	'改变前');
	define('LG_AFTER_CHANGE',	'改变后');
	define('LG_CHANGE_REASON',	'改变原因');
	define('LG_CHANGE_TIME',	'改变时间');
	
	//equipment info
	define('LG_PLAYER_EQUIPMENT',	'玩家装备');
	define('LG_UNIQUE_ID',	'唯一ID');
	define('LG_EQUIPMENT_ID',	'装备ID');
	define('LG_HOLE1',	'孔洞1');
	define('LG_HOLE2',	'孔洞2');
	define('LG_HOLE3',	'孔洞3');
	define('LG_BELONG_TO_PET_ID',	'所属宠物ID');
	
	//goods info
	define('LG_PLAYER_GOODS',	'玩家物品');
	define('LG_RESOURCE_NAME',	'名称');
	
	//time limited buying 
	define('LG_INVENTORY',	'库存');
	define('LG_TODAY_LIMIT_BUY_COUNT',	'今日限购次数');
	define('LG_TODAY_BOUGHT_COUNT',	'今日已购次数');
	
	//payment behavior
	define('LG_PAYMENT_BEHAVIOR',	'付费行为');
	define('LG_BEHAVIOR_DESC',	'行为描述');
	define('LG_BEHAVIOR_COUNT',	'行为数量');
	define('LG_TOTAL_PAYMENT',	'总付费');
	
	//checkpoint_process
	define('LG_CHECKPOINT_PROCESS',	'关卡进程');
	define('LG_CHECKPOINT_TYPE',	'关卡类型');
	define('LG_PUTONG_CHAPTER',	'普通关卡');
	define('LG_JINGYING_CHAPTER',	'精英关卡');
	define('LG_ACTIVE_CHAPTER',	'活动关卡');
	define('LG_OTHER_WORLD_INTRUSION_CHAPTER',	'异界入侵关卡');
	define('LG_GUILD_CHAPTER',	'公会boss战关卡');
	define('LG_OTHER_WORLD_EXPEDITION_CHAPTER',	'异界远征关卡');
	define('LG_CHAPTER_ID',	'章id');
	define('LG_CHECKPOINT_ID',	'关卡id');
	define('LG_PEOPLE_TOTAL_NUMBER',	'人数');
	
	//guild_info
	define('LG_GUILD_INFO',	'公会信息');
	define('LG_LIANMENG_ID',	'公会ID');
	define('LG_LIANMENG_NAME',	'公会名称');
	define('LG_LIANMENG_LEVEL',	'公会等级');
	define('LG_LIANMENG_MEMBER',	'公会成员');
	
	define('LG_PLYAER_LOGIN_IP',	'登录IP');
}

function get_channel($app_id) {
	if ('4150ee1fedfb016340a5d7f0a5bbf082' == $app_id) {
		return 'GOOGLE PLAY';
	} else if ('3c8953f6568c92a46ecace70bf673c52' == $app_id) {
		return 'APPSTOREVN_ANDROID';
	} else if ('50d239ea8326a712c6abb7c242cffa32' == $app_id) {
		return 'ITUNE';
	} else if ('f5f4e46f022771c650e17b17a20c453a' == $app_id) {
		return 'APPSTOREVN_IOS';
	} else if ('e659f8af4336490427be06d2b239c91a' == $app_id) {
		return 'OPPO';
	} else if ('K-A170639-U00000-R80WZJ-B5B6EE8A5200FE2C' == $app_id) {
		return 'APPOTA_IOS_JAILBREAK';
	} else if ('SK-A170639-U00000-YGP0NL-DCC55F1D37D9AFA5' == $app_id) {
		return 'APPOTA_IOS_JAILBREAK_SANDBOX';
	} else if ('trieu-hoi-3d') {
		return 'eway';
	}
	return '';
}




define('ERROR_LOG_FILE_NAME', 'error_log');
define('SUCCESS_LOG_FILE_NAME', 'success_log');



/* End of file constants.php */
/* Location: ./application/config/constants.php */