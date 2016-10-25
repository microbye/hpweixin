<?php
        	
namespace Addons\BookManage\Model;
use Home\Model\WeixinModel;
        	
/**
 * BookManage的微信模型
 */
class WeixinAddonModel extends WeixinModel{
	function reply($dataArr, $keywordArr = array()) {
		$config = getAddonConfig ( 'BookManage' ); // 获取后台插件的配置参数	
		//dump($config);
	}
}
        	