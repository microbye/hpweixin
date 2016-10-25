<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0068)http://hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/form -->
<html class=" -webkit- -webkit-"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>大侠同意借书</title>
    
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/mobile_module.css" media="all">
    <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/css.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
		//静态变量
		var SITE_URL = "http://hpweixin.microbye.com";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "wxcc4fa59b8b59436d";
		var	WXJS_TIMESTAMP='1474527452'; 
		var NONCESTR= 'I7wgsOQmj03DxrFO'; 
		var SIGNATURE= 'bc5192305ade6fa4a903b58e06ce09c45caf44d1';
	</script>
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/minify.php"></script>
<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/css(1).css" rel="stylesheet" type="text/css"></head>
<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/myStyle.css" rel="stylesheet" type="text/css">


    <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/css.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/myStyle.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/datetimepicker.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/dropdown.css" rel="stylesheet" type="text/css">
	
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/jquery-2.0.3.min.js"></script>

	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/minify.php"></script></head>
	<title>首页推荐</title>
	 
<body>
    <div id="container" class="container body" style="min-height: 760px;">
		<div class="top_relative">
		<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/1200809.png">            
		<p style="word-wrap:break-word;">大侠果然好心肠！</p>
		</div>
                 	
       <!-- 
        <div class="block_content_bg p_10 m_10 " style="background-size:20px 20px; background-repeat:no-repeat; background-position:right center; ">word-wrap:break-word;
           
           	分享你认为有意义的好书！    
	    </div>   -->     
		<div class="block_content_bg m_10"><p>大侠你好，<?php echo ($user["nickname"]); ?>向你借《<?php echo ($data["book"]); ?>》,如果你愿意借给他，请在下方输入联系方式以便他能够飞鸽传书给你！</p></div>
        <div class="block_content_bg m_10"> 
		   
			
			<!-- 表单 -->
			<form id="form" action="http://hpweixin.microbye.com/index.php?s=/addon/Forms/Wap/index.html" method="post" class="form-horizontal p_10">
			
					
			                    
					  
					         
			
					<div class="form-item cf">
						
						 <div class="controls">
						   <img src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/1_12.gif">
							<input type="text" name="mes" id="fx_mes" placeholder="邮箱/手机号" pattern="^1[3-9]\d{9}$" required/>
						 </div>
					</div>
					
		
					<input type="hidden" class="text input-large" name="forms_id" value="3">                
					 
					 
					<div id="top-alert" class="fixed alert alert-error" style="display: none;">
						 <button class="close fixed" style="margin-top: 4px;">×</button>
						 <div class="alert-content"></div>
					</div>
				
					<div class="form-item cf">
						<input type="hidden" name="name" value="<?php echo ($data["book"]); ?>">
						<input type="hidden" name="userid" value="<?php echo ($data["userid"]); ?>">
						<input type="hidden" name="ownner" value="<?php echo ($data["ownner"]); ?>">
						<input type="hidden" name="bookid" value="<?php echo ($data["bookid"]); ?>">
						<button class="home_btn submit-btn mb_10 mt_10" id="fx_submit" type="button" target-form="form-horizontal">仗义相借</button>			
					</div>
		
		  </form>

       </div>
	   
       <p class="copyright">慧享书香</p>
  </div>
  
  
  <!-- Wap页面脚部 -->
<script>$.post("http://hpweixin.microbye.com/log.php?_addons=Forms&_controller=Wap&_action=index&m=Home&forms_id=3&publicid=1&c=Addons&a=execute&uid=1");</script></div>
<script type="text/javascript">
	$.WeiPHP.initWxShare({
		title:"我要荐书",
		imgUrl:"http://hpweixin.microbye.com/Public/static/icon/education/1200809.png",
		desc:"分享你认为有意义的好书！",
		link:window.location.href
	})
</script>
 
 <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/datetimepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/dropdown.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/bootstrap-datetimepicker.min.js"></script> 
  <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/borrow/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
$('#fx_submit').click(function(){
   // $('#form').submit();
   $.Dialog.loading();
   $.ajax({
		url:"index.php?s=/addon/WeiSite/SendMessage/reply/token/gh_b5826b7a409f",
	   type:'post',
	   data:$('#form').serializeArray(),
	   dataType:'json',
	   success:function(json){
		    //$.Dialog.close();
			if(json.status==1){
			   		// alert("1");
			   		$.Dialog.success(json.info);
					//alert('2');
			   }else{
				   	$.Dialog.fail(json.info);
					//alert('3');
			}
		   /*if(json.url!=""){
			   setTimeout(function(){
				   window.location.href=json.url;
				   },2000);
			   }*/
   		},
		error:function(){
				$.Dialog.close();
			 //$.Dialog.fail();
			}
	   });
});

$(function(){
       $('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:0,
        autoclose:true
    });

});
</script> 

</body></html>