<?php 
	class AWARD_KIND {
		const AWARD_EXP=1;//# 声望奖励标识 EXP
		const AWARD_GOLD=2;//# 金币奖励表示
		const AWARD_YUAN_BAO =3; //奖励元宝
		const AWARD_PET=4; //奖励宠物
		const AWARD_ACTION_COUNT=5; //奖励行动力
        const AWARD_FRIENDSHIP=6; //友情点
        const AWARD_EQUIP=7; //装备
        const AWARD_RANDOM_PET=8; //随机宠物卡
        const AWARD_RANDOM_EQUIP=9; //随机装备
        const AWARD_GOODS=10; //给物品
        const AWARD_OTHER_WORLD_INTRUSION_CURRENCY=11;//异界入侵商店使用的货币
        const AWARD_OTHER_WORLD_EXPEDITION_CURRENCY=12;//异界远征商店使用的货币
        const AWARD_GUILD_CURRENCY=13;//奖励公会币
        const AWARD_EQUIP_RAFFLE_TICKETS=14;//奖励装备抽奖券
        const AWARD_PET_RAFFLE_TICKETS=15;//奖励宠物抽奖券
        const AWARD_FIRST_QUEUE_PET_EXP=16; // 给当前冒险编队的宠物加经验 [16:0:exp:0;]
        const AWARD_BY_SEND_EMAIL=17; //邮件奖励
        const AWARD_COMPETITIVE_CURRENCY=18;//奖励竞技币
	}
	
	//奖励种类集合
	$award_kind_arry = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18);
	//装备抽奖券中的类型集合
	$equip_raffle_tickets_kind_arry = array(1,2,3,4,5,6,7,8);
	//宠物抽奖券中的类型集合
	$pet_raffle_tickets_kind_arry = array(1,2,3,4,5);
	
?>