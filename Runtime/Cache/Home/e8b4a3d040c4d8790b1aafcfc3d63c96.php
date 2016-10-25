<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0076)http://hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/info/id/3419 -->
<html class=" -webkit- -webkit- -webkit- -webkit-"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>慧享书香</title>
    
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
	<link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/css/info/mobile_module.css" media="all">
    <link href="<?php echo ADDON_PUBLIC_PATH;?>/css/info/css.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/info/myStyle.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/info/datetimepicker.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/info/dropdown.css" rel="stylesheet" type="text/css">
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
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/jquery-2.0.3.min.js.download"></script>
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/booklist/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/form/minify.php"></script>
	
	

<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script> 
<script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script>
 

	<script type="text/javascript">
	function ask(ownner,name,book_id,userid){
	var mark = confirm("请注意每天可发起三次借阅，确定借阅？");
	if(mark==true){
	$.Dialog.loading();
	//alert(ownner);
    $.ajax({
	   url:"index.php?s=/addon/WeiSite/SendMessage/ask/token/gh_b5826b7a409f",
	   type:'post',
	   data:{
		ownner:ownner,
		name:name,
		book_id:book_id,
		userid:userid		
		},
	   dataType:'json',
	   success:function(json){
		  
			if(json.status==1){
			   	//	alert(json.info);
			   		$.Dialog.success(json.info);
					
			   }else{
				   	$.Dialog.fail(json.info);
					//alert('3');
			}
   		},
		error:function(){
				$.Dialog.close();
			 //$.Dialog.fail();
			}
	   });
	   }
	}
</script>
<script>
function changeImage(){
  //用户点击时判断该用户是否已经点过赞，判断标志位，为0的话，变为点赞的状态，然后想后台发送点赞消息
  
  var state = document.getElementById("microbye_zan_state").defaultValue;
  var book_id=<?php echo ($book["id"]); ?>;//获取属性
  var uid = <?php echo ($zan["uid"]); ?>;
  var vl = $("#microbye_zan").text();
 // alert(uid);
 // alert();
  //state为0表示没有点赞
  if(state == 0){
	state =1;
	//alert("uid:news_id:state:"+uid+news_id+state);
	document.getElementById("fx_x1").src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/fx_d1.png";
	//文章赞数+1，赞加用户已经为该文章点赞的记录，点赞状态编程1	
	vl=parseInt(vl)+1;
	$.post("index.php?s=/addon/WeiSite/BookInfo/zan",{
	vl:vl,
	uid:uid,
	book_id:book_id,
	state:state
	},function(data){
            if(data.status==1){ 
				$("#microbye_zan").html(vl);
				
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
	document.getElementById("fx_x1").src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/fx_d2.png";
	vl=parseInt(vl)-1;
	$.post("index.php?s=/addon/WeiSite/BookInfo/zan",{
	vl:vl,
	uid:uid,
	book_id:book_id,
	state:state
		},function(data){
            if(data.status==1){ 
				$("#microbye_zan").html(vl);
				document.getElementById("microbye_zan_state").value= 0;	
            }
			else{
                alert('您已经点过赞了,不要重复哦！');
            }
        });
	}
}
</script>
</head>
	
	
<body>
    <div id="container" class="container body" style="min-height: 760px;">
<!--书籍信息开始 -->  
			<div class="fx_bookTopMes">
			   <div class="fx_topPic">
			   <img src = "<?php echo ADDON_PUBLIC_PATH;?>/css/info/coverxq.jpg"/>
			   </div>
				   <div class="fx_bookMesBox1">
						 <div class="fx_bookMesBox2">
								<div class="fx_bookMesBox3">
								  <table>
									 <tbody><tr>
									  <td><span>《<?php echo ($book["name"]); ?>》</span></td>
									 </tr>
									 <tr>
									   <td></td>
									 </tr>
									 <tr>
									   <td><font>&nbsp;作者：<?php echo ($book["writer"]); ?></font> </td>
									 </tr>
									 <tr>
									   <td><font>&nbsp;分类：<?php echo ($book["kind"]); ?></font> </td>
									 </tr>
									 <tr>
									   <td><font>&nbsp;来源：<?php echo ($book["nickname"]); ?></font> </td>
									   </tr>
									 <tr>
									   <td>
									   <?php if(($book["nickname"] != '三楼阅览室') and $book["available"] == 1): ?><font>&nbsp;<a onclick=ask("<?php echo ($book["ownner"]); ?>","<?php echo ($book["name"]); ?>","<?php echo ($book["id"]); ?>","<?php echo ($userid); ?>")>向他借阅？</a></font>
									   <?php elseif($book["nickname"] == '三楼阅览室'): ?><font><p>不支持在线借阅</p></font>
									   <?php else: ?><font><p>暂时不可借阅 &nbsp;&nbsp;<a href ='index.php?s=/addon/WeiSite/BookInfo/addBook/token/gh_b5826b7a409f'>请求增加该书籍？</a></p></font><?php endif; ?>
									   </td>
									 </tr>
								  </tbody></table>
								
								</div> 																						 
						 </div>
				   </div>	
			</div>
 <!--书籍信息结束 -->    
 
 <!--推荐理由开始 -->     
            <div class="fx_coments1">
				<div class="fx_bookMesBox4">
								<p><b><span>推荐理由：</span></b><?php echo ($book["description"]); ?></p>								
				<div class="fx_dz1">
			     <ul>
				  <li><span>阅读量：<?php echo ($book["view_count"]); ?></span></li>
				   <li>&nbsp;</li>
				   <input type="hidden" id="microbye_zan_state" value=<?php echo ($zan["state"]); ?>>
				   <li>
				   <?php if($zan["state"] == '0'): ?><img src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/fx_d2.png"  id="fx_x1" width="26" height="23" onClick="changeImage()">
					<?php else: ?>
					<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/fx_d1.png"  id="fx_x1" width="26" height="23" onClick="changeImage()"><?php endif; ?>
				   </li>
				   <li><span id = "microbye_zan"><?php echo ($book["zan"]); ?></span></li>
				   <li>&nbsp;</li>
				   <li><a href="index.php?s=/addon/WeiSite/BookInfo/message/userid/<?php echo ($userid); ?>/bookid/<?php echo ($book["id"]); ?>"><img id="fx_x1" src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/fx_p1.png" width="26" height="23"></a></li>
				   <li><?php echo ($message_count); ?></li>
				 </ul>
				</div>
				</div>
				
			</div>	
<!--推荐理由结束 -->  

<!--留言板开始 -->				
							
			 
<!--留言板结束 -->		
  
<!--留言内容开始 -->  
            <div class="fx_coments2">
              	   
			   <ul class = "message">
				 <input type="hidden" id="microbye_page" value=1>
				 <input type="hidden" id="microbye_mark" value="<?php echo ($mark); ?>">
				 <?php if(is_array($message_list)): $i = 0; $__LIST__ = $message_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li>
				    <div class="fx_headPortrait">
					   <table>
					   <tbody><tr>
					        <td><img src="<?php echo ($list["headimgurl"]); ?>" width="60" height="60">
					        <div class="fx_uname"><span><?php echo ($list["nickname"]); ?></span></div>
							<div class="fx_time"><span><?php echo ($list["create_time"]); ?></span></div>
							</td>
					   </tr>
					   <tr>
					        <td><div class="fx_reply"><p><?php echo ($list["content"]); ?>。</p></div></td>
					   </tr>
					   
					   </tbody></table>
					</div>					
				 </li><?php endforeach; endif; else: echo "" ;endif; ?>
			   </ul>
			</div>
<!--留言内容结束 --> 			
					
		<div class="fx_promptMes">
		
		</div>
	<?php if($mark == 1): ?><p class="copyright">慧享书香</p>
	  <?php else: ?>
	<p class="copyright">加载更多</p><?php endif; ?>
  </div>
  
<script src="<?php echo ADDON_PUBLIC_PATH;?>/css/info/dist/dropload.min.js"></script>
<script>
   $(function(){
		var winH = $(window).height(); //页面可视区域高度
		//alert("屏幕高度为："+winH);
		
		//获取当前的页数和书本的id,是否还可以继续加载
		
		//alert(page);
		$(window).scroll(function () {
			var page = document.getElementById("microbye_page").value; //设置当前页数
			//alert("当前页数"+page);
			var bookid = <?php echo ($book["id"]); ?>;
			var mark = document.getElementById("microbye_mark").value;
			var pageH = $(document.body).height();//整个网页的高度
			//alert("屏幕高度为："+winH);
			//alert("整个网页高度为："+pageH);
			var scrollT = $(window).scrollTop(); //滚动条t的高度
			//alert("滚动条高度为："+scrollT);
			var aa = (pageH-winH-scrollT)/winH;
			//当抵达底部的时候选择添加新的评论，如果评论已经加载完毕，则不再增加，通过一个标志位判断是否已经完全加载。
			var i =0;
			if(mark != 1){				
				if(aa<0.2){
				 //每次执行到这里的时候必须要记录当前已经加载的页码，下一次可以从这里开始加载。页码最开始为1.
				 //document.getElementById("microbye_page").value="2"; 
				 
					$.post("index.php?s=/addon/WeiSite/BookInfo/getMessage/token/gh_b5826b7a409f",{
						page:page,
						bookid:bookid
					},function(data){
						if(data.status==1){ 
							var result;
							data = JSON.stringify(data);
							
							var jsonObj = eval('(' + data + ')');
							var jslength=0;
							for(var js2 in jsonObj){
								jslength++;
							}
							//alert(jslength);
							for(i=0;i<jslength-4;i++){
								result = '<li><div class=fx_headPortrait><table><tbody><tr><td><img src='+jsonObj[i].headimgurl+' width=60 height=60><div class=fx_uname><span>'+jsonObj[i].nickname+'</span></div>'+
							'<div class=fx_time><span>'+jsonObj[i].create_time+'</span></div></td></tr><tr><td><div class=fx_reply><p>'+jsonObj[i].content+'</p></div></td></tr></tbody></table></div></li>';
								
								$('.message').append(result);
							
							}
							document.getElementById("microbye_page").value = jsonObj.page;
							//alert(document.getElementById("microbye_page").value);
							document.getElementById("microbye_mark").value = jsonObj.mark;
							if(jsonObj.mark == 1){
								$(".copyright").html("慧享书香");
							}
						}
						else{
							alert('您已经点过赞了,不要重复哦！');
						}
					});
				}
			}
		});
	});
</script>
  <!-- Wap页面脚部 -->

</body></html>