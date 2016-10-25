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
<style type="text/css">
.banner{ width:100%; overflow:hidden; position:relative;}
.banner ul{ position:absolute; left:0; top:0; z-index:10; -webkit-animation:}
.banner ul li{ float:left; display:table-cell; position:relative}
.banner li a{ width:100%; height:100%; display:block;}
.banner li .title{background-color:RGBA(0,0,0,.5); height:30px; color:#fff; line-height:30px; padding-left:10px; position:absolute; left:0; bottom:0; width:100%; z-index:1000;}
.identify{text-align:right; position:absolute; bottom:0; right:0; z-index:100; height:30px;}
.identify em{ display:inline-block; margin:10px 5px;-webkit-border-radius: 6px;-moz-border-radius: 6px;
border-radius: 6px;margin-left: 5px;width: 12px;height: 12px;background: #fff;}
.identify em.cur{ background-color:#090}
.big_pic_list{}
.big_pic_list li{ padding:10px; margin-bottom:15px; background-color:#fff;}
.big_pic_list img{ width:100%;}
.big_pic_list a{ display:block; color:#666}
</style>
<body id="weisite">
<div class="container">
    <section class="banner">
<!--     	<ul> -->
<!--         <?php foreach($list_data as $k=>$vo){ if($k>2) continue; ?> -->
<!--         	<li> -->
<!--             	<a href="<?php echo U('detail', 'id='.$vo[id]);?>"><img src="<?php echo (get_cover_url($vo["cover"])); ?>"/></a> -->
<!--             	<span class="title"><?php echo ($vo["title"]); ?></span> -->
<!--             </li> -->
<!--          <?php $img_count += 1 ;unset($list_data[$k]); } ?> -->
<!--         </ul> -->
<!--         <div class="identify"> -->
<!--         	<?php for($i=0; $i<$img_count; $i++){ ?> -->
<!--                 <em></em> -->
<!--              <?php } ?> -->
<!--         </div> -->
<ul>
        <?php if(is_array($slide_data)): $i = 0; $__LIST__ = $slide_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            	<a href="<?php echo ($vo["url"]); ?>"><img src="<?php echo (get_cover_url($vo["cover"])); ?>"/></a>
            	<span class="title"><?php echo ($vo["title"]); ?></span>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <span class="identify">
            <span class="pointer">
            <?php if(is_array($slide_data)): $i = 0; $__LIST__ = $slide_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><em></em><?php endforeach; endif; else: echo "" ;endif; ?> 
             </span>       
        </span>
    </section>
    <ul class="big_pic_list">
    <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
        	<a href="<?php echo ($vo["url"]); ?>">
            	<?php if(!empty($vo["cover"])): ?><img src="<?php echo (get_cover_url($vo["cover"])); ?>"/><?php endif; ?>
                <h6><?php echo ($vo["title"]); ?></h6>
                <span class="colorless"><?php echo (time_format($vo["cTime"])); ?></span>
            </a>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <!-- 分页 -->
    <div class="page"> <?php echo ((isset($_page) && ($_page !== ""))?($_page):''); ?> </div>
</div>
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
<script type="text/javascript">
$(function(){
	$.WeiPHP.initBanner(true,5000);
})

</script>
</html>