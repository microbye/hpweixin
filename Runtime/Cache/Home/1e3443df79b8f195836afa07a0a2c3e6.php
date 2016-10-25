<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title><?php echo empty($page_title) ? C('WEB_SITE_TITLE') : $page_title; ?></title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/mobile_module.css?v=<?php echo SITE_VERSION;?>" media="all">
    <script type="text/javascript">
		//静态变量
		var SITE_URL = "<?php echo SITE_URL;?>";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "<?php echo ($jsapiParams["appId"]); ?>";
		var	WXJS_TIMESTAMP='<?php echo ($jsapiParams["timestamp"]); ?>'; 
		var NONCESTR= '<?php echo ($jsapiParams["nonceStr"]); ?>'; 
		var SIGNATURE= '<?php echo ($jsapiParams["signature"]); ?>';
	</script>
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="minify.php?f=/Public/Home/js/prefixfree.min.js,/Public/Home/js/m/dialog.js,/Public/Home/js/m/flipsnap.min.js,/Public/Home/js/m/mobile_module.js&v=<?php echo SITE_VERSION;?>"></script>
</head>
<!-- saved from url=(0148)http://hpweixin.microbye.com/index.php?s=/addon/UserCenter/Wap/userCenter/token/gh_b5826b7a409f&&code=011t0PSh0ccrEB1plQTh0TNLSh0t0PSX&state=weiphp# -->
<html class=" -webkit-"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>慧享书香</title>
    
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" type="text/css"  href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrowRecord/myStyle.css">
    <script type="text/javascript">
		//静态变量
		var SITE_URL = "http://hpweixin.microbye.com";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "wxcc4fa59b8b59436d";
		var	WXJS_TIMESTAMP='1476668102'; 
		var NONCESTR= 'GBuNFQ6q4H3Vg7ex'; 
		var SIGNATURE= '6d33b15df1a4c4e81a1a6b987df8edd8e4752bab';
	</script>
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/jquery-2.0.3.min.js.download"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/jweixin-1.0.0.js.download"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/minify.php"></script>
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/userCenter.css" rel="stylesheet" type="text/css"></head>


<body>
<div class="container">
  <div class="userHead">
    <div class="userInfo">
      <div class="head"><img src="<?php echo ($info["headimgurl"]); ?>"></div>
      <div class="info">
        <p class="name"><strong><?php echo ($info["nickname"]); ?></strong></p>
        <p class="attr"><span>积分:</span><?php echo (intval($info["score"])); ?></p>
        <p class="attr"><span>经历值:</span> <?php echo (intval($info["experience"])); ?></p>
      </div>
    </div>
</div>
  
      <h3>&nbsp;借书记录</h3>
	<div class="fx_cont">
   
     <ul>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li>
	   <div class="user_box"> 
	   <div class="fx_bookName">
	   <span><?php echo ($data["book_name"]); ?></span>
	   <div class="fx_time">
	
	   <img src="慧享书香_files/time.png" height="16" width="16"/>
	   <span><?php echo ($data["create_time"]); ?></span>
	   </div>
	   </div>
	   <div class="fx_author"><span>作者：<?php echo ($data["writer"]); ?></span></div>
	   <div class="fx_ownner"><span>所属： <?php echo ($data["ownner"]); ?></span></div>
	   <div class="fx_backMessage"><span>返回消息：<?php if($data["reply_info"] == null): ?>没有回复<?php else: echo ($data["reply_info"]); endif; ?></span></div>
	   </div>
	   </li><?php endforeach; endif; else: echo "" ;endif; ?>
	 </ul>
    
	</div>
<!-- Wap页面脚部 -->
<div style="height:0; visibility:hidden; overflow:hidden;">
<script>$.post("http://hpweixin.microbye.com/log.php?_addons=UserCenter&_controller=Wap&_action=userCenter&m=Home&token=gh_b5826b7a409f&code=011t0PSh0ccrEB1plQTh0TNLSh0t0PSX&state=weiphp&publicid=1&c=Addons&a=execute&uid=0");</script></div>

</div></body></html>