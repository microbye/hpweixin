<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class=" -webkit- -webkit-"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>慧享书香</title>
    
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"> 
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/mobile_module.css" media="all">
    <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/css.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/myStyle.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/datetimepicker.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/form/dropdown.css" rel="stylesheet" type="text/css">
	<script type = "text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/jquery.validate.js}"></script>
	<!--<script type="text/javascript">
		//静态变量
		var SITE_URL = "http://hpweixin.microbye.com";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "wxcc4fa59b8b59436d";
		var	WXJS_TIMESTAMP='1474527452'; 
		var NONCESTR= 'I7wgsOQmj03DxrFO'; 
		var SIGNATURE= 'bc5192305ade6fa4a903b58e06ce09c45caf44d1';
	</script>-->
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/jquery-2.0.3.min.js"></script>

	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/minify.php"></script>
	
	</head>

<body>
    <div id="container" class="container body" style="min-height: 748px;">
		<div class="top_relative">
		<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/advise_title.jpg">            
		<p style="word-wrap:break-word;">请求图书馆增加想看的书籍！</p>
		</div>
                 	
       <!-- 
        <div class="block_content_bg p_10 m_10 " style="background-size:20px 20px; background-repeat:no-repeat; background-position:right center; ">word-wrap:break-word;
           
           	分享你认为有意义的好书！    
	    </div>   -->     
		
        <div class="block_content_bg m_10"> 
		
			
			<!-- 表单 -->
			<form id="form" action="http://hpweixin.microbye.com/index.php?s=/addon/Forms/Wap/index.html" method="post" class="form-horizontal p_10">
			
					<div class="form-item cf">
					     

						 <div class="controls">	 
						 
						     <img src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/1_05.gif">
							 <input  type="text" class="text input-large" name="book" placeholder="书名" value=""> 	
												  
						 </div>
						 
						 
					</div>  
			          
					<div class="form-item cf">
					     
						 <div class="controls">  
						    
						     <img src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/1_08.gif">
							 <input type="text" class="text input-large" name="writer" placeholder="作者" value="">
						              
						 </div>
					</div>                
					  
					<div class="form-item cf">
								
						 <div class="controls">
						      <img src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/1_10.gif">
							 <select name = "kind">
							  <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$kind): $mod = ($i % 2 );++$i;?><option ><?php echo ($kind["kind"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							 </select>
						 </div>
					</div>                
			
					<div class="form-item cf">
						
						 <div class="controls">
						   <img src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/1_12.gif">
							<textarea name="description" placeholder = "如果你希望图书馆增加此书，请详细描述此书"></textarea>
						 </div>
					</div>
				
					<div class="form-item cf">
						<input type="hidden" name="id" value="">
						
						<button class="home_btn submit-btn mb_10 mt_10" id="submit" type="button" target-form="form-horizontal">提交</button>
					
					</div>
		
		  </form>

       </div>
	   
       <p class="copyright">慧享书香</p>
  </div>
  
  
  <!-- Wap页面脚部 -->
<!--<div style="height:0; visibility:hidden; overflow:hidden;">-->
</div>

<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">

  <link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script> 
  <script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script>

  
 <script type="text/javascript">
$('#submit').click(function(){
   var mark = confirm("确认推荐？");
  /* x=$('#form').serializeArray();
	$.each(x, function(i, field){
		
		alert(field.name + ":" + field.value + " ");
	});
   alert(document.getElementById("microbye_available").defaultValue);
  */
  if(mark==true){
   $.Dialog.loading();
   $.ajax({
	   url:"index.php?s=/addon/WeiSite/BookInfo/addbookDeal/token/gh_b5826b7a409f",
	   type:'post',
	   data:$('#form').serializeArray(),
	   dataType:'json',
	   success:function(json){
		    //$.Dialog.close();
			if(json.status==1){
			   		//alert('2');
			   		$.Dialog.success(json.info);
					setTimeout(function(){
						//window.close();
						window.location.href="index.php?s=/addon/WeiSite/BookInfo/booklist/source/-1/kinds/0/token/gh_b5826b7a409f";
					},3000);
			   }
					
			   else{
				   	$.Dialog.fail(json.info);
					//alert(json.info+"状态"+json.status);
					setTimeout(function(){
						//window.close();
						//window.location.href="index.php?s=/addon/WeiSite/WeiSite/booklist/token/gh_b5826b7a409f";
					},4000);
					//alert('3');
			}
		   /*if(json.url!=""){
			   setTimeout(function(){
				   window.location.href="www.microbye.com";
				   },2000);
			   }*/
   		},
		error:function(){
				$.Dialog.close();
			}
	   });}
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

</body>
</html>