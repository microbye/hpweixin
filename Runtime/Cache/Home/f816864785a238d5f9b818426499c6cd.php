<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
<link href="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/detail.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/iconfont/iconfont.css" type="text/css" />
<script type="text/javascript" src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/jquery-3.1.0.js" ></script>
<script type="text/javascript" src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/comment.js" ></script>
<script>
function changeImage(){
  //用户点击时判断该用户是否已经点过赞，判断标志位，为0的话，变为点赞的状态，然后想后台发送点赞消息
  var state = document.getElementById("microbye_zan_state").defaultValue;
  var news_id=<?php echo ($info["id"]); ?>;//获取属性
  var uid = <?php echo ($zan["uid"]); ?>;
  var vl = $("#microbye_zan").text();
  //state为0表示没有点赞
  if(state == 0){
	state =1;
	//alert("uid:news_id:state:"+uid+news_id+state);
	document.getElementById("fx_d2").src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/fx_d1.png";
	//文章赞数+1，赞加用户已经为该文章点赞的记录，点赞状态编程1	
	vl=parseInt(vl)+1;
	$.post("index.php?s=/addon/WeiSite/WeiSite/zan",{
	vl:vl,
	uid:uid,
	news_id:news_id,
	state:state
	},function(data){
            if(data.status==1){ 
				$("#microbye_zan").html(vl);
				//alert("uid:news_id:state:"+data.uid+data.news_id+data.state);
				document.getElementById("microbye_zan_state").value= 1;	
            }
			else{
                alert('您已经点过赞了,不要重复哦！');
            }
      });
  }
  else{
	state = 0
	//alert("uid:news_id:state:"+uid+news_id+state);
	document.getElementById("fx_d2").src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/fx_d2.png";
	vl=parseInt(vl)-1;
	$.post("index.php?s=/addon/WeiSite/WeiSite/zan",{
	vl:vl,
	uid:uid,
	news_id:news_id,
	state:state
		},function(data){
            if(data.status==1){ 
				$("#microbye_zan").html(vl);
				//alert("uid:news_id:state:"+data.uid+data.news_id+data.state);
				document.getElementById("microbye_zan_state").value= 0;	
            }
			else{
                alert('您已经点过赞了,不要重复哦！');
            }
        });
	}
	
}
</script>
<!--必要样式-->
<body id="weisite">
	<div class="container">
		<div class="detail">
			<h6 class="title"><?php echo ($info["title"]); ?></h6>
			<input type="hidden" id="a" value=<?php echo ($info["id"]); ?>>
			<p class="info"><span class="colorless"><?php echo (time_format($info["cTime"])); ?></span></p>
			<section class="content">
                <?php if(!empty($info["cover"])): ?><p><img src="<?php echo (get_cover_url($info["cover"])); ?>"/></p><?php endif; ?>
                <?php echo (htmlspecialchars_decode($info["content"])); ?>
			</section>
						
			<div class="opera">
			    <div class="fx_span">
				 <span>阅读</span>&nbsp;<span><?php echo ($info["view_count"]); ?></span>			
			    </div>
				<input type="hidden" id="microbye_zan_state" value=<?php echo ($zan["state"]); ?>>
				<div class="fx_dz">
				<?php if($zan["state"] == '0'): ?><img src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/fx_d2.png"  width="24" height="24"  id="fx_d2" onclick="changeImage()">&nbsp;
				<?php else: ?>
					<img src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/fx_d1.png"  width="24" height="24"  id="fx_d2" onclick="changeImage()">&nbsp;<?php endif; ?>
				</div>
				<div id="microbye_zan"> <?php echo ($info["zan"]); ?></div>
			</div>	
						
		</div>
	</div>	

<p class="copyright">慧享书香</p>
<script src="<?php echo CUSTOM_TEMPLATE_PATH;?>Detail/V2/js/jquery.min.js" type="text/javascript">
</script>
<!-- 底部导航 -->
<?php echo ($footer_html); ?>
<!-- 统计代码 -->
<?php if(!empty($config["code"])): ?><p class="hide bdtongji">
<?php echo ($config["code"]); ?>
</p>
<?php else: ?>
<p class="hide bdtongji">
<?php echo ($tongji_code); ?>
</p><?php endif; ?>
</body>
</html>