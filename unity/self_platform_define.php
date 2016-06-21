<?php
   
	//用户来源
    class PLATFORM
    {
        const DEFAULT_PLATFORM = 0;//默认
        const HONGXINGLAJIAO = 1;//红星辣椒
        const VIETNAM = 2;//越南渠道ingame
        const APPTO = 3;//越南appto ios越狱
        const EWAY = 4;//越南eway渠道
       // const BAI_DU = 3;//百度91
    }
    
    //订单来源
    class ORDER_SOURCE_PLAT_FORM
    {
    	const DEFAULT_PLATFORM = 0;//默认
    	const HONGXINGLAJIAO = 1;//红星辣椒
        const GOOGLE_PLAY = 2;//google play 
        const APP_STORE = 3;//ios app store
        const VIETNAM_CARD = 4;//越南市场交易类型
        const VIETNAM_BANK = 5;//越南市场交易类型、
        const SMS = 6;//越南appto ios越狱交易类型
        const PAYPAL = 7;//越南appto ios越狱交易类型
        const EWAY = 8;//eway来源
    }
?>