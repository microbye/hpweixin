<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0072)http://hpweixin.microbye.com/index.php?s=/addon/WeiSite/WeiSite/booklist -->
<html class=" -webkit-"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
    <title>慧享书香</title>
    
	<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" type="text/css" href="<?php echo ADDON_PUBLIC_PATH;?>/css/search/mobile_module.css" media="all">
    <link rel="stylesheet"  href="<?php echo ADDON_PUBLIC_PATH;?>/css/search/style.css"></link>
	<script type="text/javascript">
		//静态变量
		var SITE_URL = "http://hpweixin.microbye.com";
		var IMG_PATH = "/Public/Home/images";
		var STATIC_PATH = "/Public/static";
		var WX_APPID = "wxcc4fa59b8b59436d";
		var	WXJS_TIMESTAMP='1474612715'; 
		var NONCESTR= 'a9Jr1ybp98HDDS7h'; 
		var SIGNATURE= '5c25d13537e623b960fb60a6e58e3d1b0fa4d268';
	</script>
    <script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/minify.php"></script>
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/comment.js"></script>
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/search/detail.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/search/booklist.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADDON_PUBLIC_PATH;?>/css/search/myStyle.css" rel="stylesheet" type="text/css">
	
	
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
	<script type="text/javascript" src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/jquery.scrolltop.js"></script>
	<title>首页推荐</title>
	<script>
function changeImage(state,book_id,zan){
  //用户点击时判断该用户是否已经点过赞，判断标志位，为0的话，变为点赞的状态，然后想后台发送点赞消息
  
  state = document.getElementById("microbye_"+book_id).defaultValue;
 // alert(state);
  uid = <?php echo ($userid); ?>;
 // uid = <?php echo ($userid); ?>;
  //state为0表示没有点赞
  if(state == 0){
	vl =parseInt(zan)+1;
	state =1;
	//alert("uid:news_id:state:"+uid+news_id+state);
	document.getElementById("fx_d"+book_id).src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d1.png";
	//文章赞数+1，赞加用户已经为该文章点赞的记录，点赞状态编程1	
	$.post("index.php?s=/addon/WeiSite/BookInfo/zan",{
	vl:vl,
	uid:uid,
	book_id:book_id,
	state:state
	},function(data){
            if(data.status==1){ 
				document.getElementById("microbye_"+book_id).value= 1;	
            }
			else{
            }
      });
  }
  else{
  vl = zan;
	state = 0;
	document.getElementById("fx_d"+book_id).src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d2.png";
	vl = parseInt(zan);
	$.post("index.php?s=/addon/WeiSite/BookInfo/zan",{
	vl:vl,
	uid:uid,
	book_id:book_id,
	state:state
		},function(data){
            if(data.status==1){ 
				document.getElementById("microbye_"+book_id).value= 0;	
            }
			else{
                alert('您已经点过赞了,不要重复哦！');
            }
        });
	}
}
</script>
<script type="text/javascript">
function ask(ownner,name,book_id,userid){
	var mark = confirm("请注意每天可发起三次借阅，确定借阅？");
	if(mark==true){
	$.Dialog.loading();
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

function setPage(){
	document.getElementById("microbye_page").value =1;
	//alert(<?php echo ($page); ?>);
}
</script>
</head>
	


<!--必要样式-->
<body id="weisite">	
	<div id="scrollTop"> </div>
	<div class="container" id="fx-container">
	<div class="detail">
	<div class="top">
		<form id="microbye_form1" action="index.php?s=/addon/WeiSite/BookInfo/search" method="post">
	
		    <div class="search">
				<div class="search_box"><input type="text" id="searchkeyword" name = "key" placeholder="书名/作者" value="<?php echo ($key); ?>">
				<a onClick = "document.getElementById('microbye_form1').submit();" id="btnsearch" ><span class="fx_searchspan"  >搜索</span></a>
				</div>
				<div class="search_list" benlai-id="searchList" style="display:none;"></div>
            </div>
		</form>
		<!--热度+分类+来源 开始 -->
		<div class="fx_rfl">
		   <ul>
			<input type = hidden id = "microbye_key" name = "key" value = "<?php echo ($key); ?>">
			<li><span id="fx_sort" onClick="chooseSort()" value="0">搜索结果如下：</span></li>
			
		   </ul>
		</div>
		<!--热度+分类+来源 结束 -->
	    
	</div>

	<div class="fx_havingline"></div>
		<div id="fx_pane1" class="fx_panel1">
			<input type = "hidden" id = "microbye_page" name = "page" value = "1">
		</div>	
		<div id="fx_pane3" class="fx_panel3">
		</div>	
		<div id="fx_pane2" class="fx_panel2"></div>	
	<div class="mid">	   
		<ul class = "booklist">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><li>	
			  <div class="fx_heart">
			  <input type = hidden id = "microbye_<?php echo ($book["id"]); ?>" value ="<?php echo ($book["state"]); ?>">
				<?php if($book["state"] == '0'): ?><img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d2.png"  name="fx_d2" id="fx_d<?php echo ($book["id"]); ?>" width = "24"  height="21" onClick=changeImage("<?php echo ($book["state"]); ?>","<?php echo ($book["id"]); ?>","<?php echo ($book["zan"]); ?>")>
				<?php else: ?>
					<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d1.png"  name="fx_d2" id="fx_d<?php echo ($book["id"]); ?>" width = "24"  height="21" onClick=changeImage("<?php echo ($book["state"]); ?>","<?php echo ($book["id"]); ?>","<?php echo ($book["zan"]); ?>")><?php endif; ?>
			   <!--<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d2.png" name="fx_d2" id="fx_d2" onClick="changeImage(this)">-->
			  </div>
			  <?php if(($book["nickname"] != '三楼阅览室')AND ($book["available"] == 1)): ?><div class="fx_borrow">
			    <span><a onclick=ask("<?php echo ($book["ownner"]); ?>","<?php echo ($book["name"]); ?>","<?php echo ($book["id"]); ?>","<?php echo ($userid); ?>")>借阅？</a></span>
			  </div><?php endif; ?>
			  <div class="bookMessage"> 	    					
			    <table>						   
						   <tbody><tr>						
							<td>
							<span ><a href="index.php?s=/addon/WeiSite/BookInfo/info/id/<?php echo ($book["id"]); ?>/token/gh_b5826b7a409f" onClick = setPage()><b><?php echo ($book["name"]); ?></b></a></span>
							</td>
							
							 </tr>
							<tr>						
								 <td>作者：<?php echo ($book["writer"]); ?></td>
							 </tr>
							 <tr>	     
								 <td>来源：<?php echo ($book["nickname"]); ?></td>
							 </tr>
							 <tr>						    
								 <td>分类：<?php echo ($book["kind"]); ?>&nbsp;&nbsp;
							 <!--<a onclick="ask(&quot;00000000021&quot;,&quot;一本书&quot;,&quot;3420&quot;,&quot;&quot;)">向他借阅？</a> --></td>
							 </tr>
							 
							
							
				</tbody></table>
				</div>
		   </li>
		   <div class="fx_hr"></div><?php endforeach; endif; else: echo "" ;endif; ?>	  		  
		</ul>		
	</div>
	<div>
	
</div>	
	<?php if($mark == 1): ?><p class="copyright">慧享书香</p>
	 <?php else: ?>
	<p class="copyright">加载更多</p><?php endif; ?>
<block name= "script">
<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/datetimepicker_blue.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<link href="<?php echo SITE_URL;?>/Public/static/datetimepicker/css/dropdown.css?v=<?php echo SITE_VERSION;?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script> 
<script type="text/javascript" src="<?php echo SITE_URL;?>/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js?v=<?php echo SITE_VERSION;?>" charset="UTF-8"></script>

  
</block>
<!-- 底部导航 -->
<!-- 统计代码 -->
<p class="hide bdtongji">
<script>$.post("http://hpweixin.microbye.com/log.php?_addons=WeiSite&_controller=WeiSite&_action=booklist&m=Home&publicid=1&c=Addons&a=execute&uid=1");</script></p>
<script>
//处理滑动到底部的事件
   $(function(){
		var winH = $(window).height(); //页面可视区域高度
		//alert("屏幕高度为："+winH);
		
		//获取当前的页数和书本的id,是否还可以继续加载	
		//alert(page);
		$(window).scroll(function () {
			//获取基本的书单信息
			var page = document.getElementById("microbye_page").value; //设置当前页数
			var key = document.getElementById("microbye_key").value;
			//alert(key);
			//alert(key);
			//alert(page);
			//var page = document.getElementById("microbye_page").value; //设置当前页数
			//alert("当前页数"+page);
			//var bookid = <?php echo ($book["id"]); ?>;
			//var mark = document.getElementById("microbye_mark").value;
			var pageH = $(document.body).height();//整个网页的高度
			//alert("屏幕高度为："+winH);
			//alert("整个网页高度为："+pageH);
			var scrollT = $(window).scrollTop(); //滚动条t的高度
			//alert("滚动条高度为："+scrollT);
			var aa = (pageH-winH-scrollT)/winH;
			//alert("整个网页的高度："+pageH+"屏幕高度为："+winH+"滚动条高度"+scrollT+"比值"+aa);
			//当抵达底部的时候选择添加新的评论，如果评论已经加载完毕，则不再增加，通过一个标志位判断是否已经完全加载。
			var i =0;
			//if(mark != 1){				
				if(aa == 0){
				 //每次执行到这里的时候必须要记录当前已经加载的页码，下一次可以从这里开始加载。页码最开始为1.
				 //document.getElementById("microbye_page").value="2"; 
				// alert("滑到底部了");
					//alert(key);
					$.post("index.php?s=/addon/WeiSite/BookInfo/getMoreSearchList/token/gh_b5826b7a409f",{
						page:page,
						key:key
					},function(list){
						if(list.status==1){ 
							var result;
							list = JSON.stringify(list);
							//alert(list);
							var jsonObj = eval('(' + list + ')');
							var jslength=0;
							for(var js2 in jsonObj){
								jslength++;
							}
							for(i=0;i<jslength-5;i++){
								if(jsonObj[i].nickname == "三楼阅览室"){
									if(jsonObj[i].state == 0){
										result = '<li><div class=fx_heart><input type = hidden id = "microbye_'+jsonObj[i].id+'" value ="'+jsonObj[i].state+'">'+
									'<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d2.png"  name="fx_d2" id="fx_d'+jsonObj[i].id+'" width = "24"  height="21" onClick=changeImage("'+jsonObj[i].state+'","'+jsonObj[i].id+'","'+jsonObj[i].zan+'")></div>'+
						
			 '<div class="bookMessage">'+					
			    '<table>'+						   
						  ' <tbody><tr>'+						
							'<td>'+
							'<span ><a href="index.php?s=/addon/WeiSite/BookInfo/info/id/'+jsonObj[i].id+'/token/gh_b5826b7a409f" onClick = setPage()><b>'+jsonObj[i].name+'</b></a></span>'+
							'</td>'+
							' </tr>'+
							'<tr>	'+					
								' <td>作者：'+jsonObj[i].writer+'</td>'+
							 '</tr>'+
							 '<tr>	'+     
							'	 <td>来源：'+jsonObj[i].nickname+'</td>'+
							 '</tr>'+
							 '<tr>	'+					    
								' <td>分类：'+jsonObj[i].kind+'&nbsp;&nbsp;'+
							' </td>'+
							 '</tr>'+
							 
							
							
				'</tbody></table>'+
				'</div>'+
		  ' </li>';
		  }						
									else{
										result = '<li><div class=fx_heart><input type = hidden id = "microbye_'+jsonObj[i].id+'" value ="'+jsonObj[i].state+'">'+
									'<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d1.png"  name="fx_d2" id="fx_d'+jsonObj[i].id+'" width = "24"  height="21" onClick=changeImage("'+jsonObj[i].state+'","'+jsonObj[i].id+'","'+jsonObj[i].zan+'")></div>'+
						
			 '<div class="bookMessage">'+					
			    '<table>'+						   
						  ' <tbody><tr>'+						
							'<td>'+
							'<span ><a href="index.php?s=/addon/WeiSite/BookInfo/info/id/'+jsonObj[i].id+'/token/gh_b5826b7a409f" onClick = setPage()><b>'+jsonObj[i].name+'</b></a></span>'+
							'</td>'+
							' </tr>'+
							'<tr>	'+					
								' <td>作者：'+jsonObj[i].writer+'</td>'+
							 '</tr>'+
							 '<tr>	'+     
							'	 <td>来源：'+jsonObj[i].nickname+'</td>'+
							 '</tr>'+
							 '<tr>	'+					    
								' <td>分类：'+jsonObj[i].kind+'&nbsp;&nbsp;'+
							' </td>'+
							 '</tr>'+
							 
							
							
				'</tbody></table>'+
				'</div>'+
		  ' </li>';					}
								}
		  
								else{
									if(jsonObj[i].state == 0){
										result = '<li><div class=fx_heart><input type = hidden id = "microbye_'+jsonObj[i].id+'" value ="'+jsonObj[i].state+'">'+
									'<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d2.png"  name="fx_d2" id="fx_d'+jsonObj[i].id+'" width = "24"  height="21" onClick=changeImage("'+jsonObj[i].state+'","'+jsonObj[i].id+'","'+jsonObj[i].zan+'")></div>'+
			  '<if condition = "'+jsonObj[i].available+ ' eq 1"><div class=fx_borrow><span><a onclick=ask("'+jsonObj[i].ownner+'","'+jsonObj[i].name+'","'+jsonObj[i].id+'","<?php echo ($userid); ?>")>借阅？</a></span></div><div class="bookMessage">'+					
			    '<table>'+						   
						  ' <tbody><tr>'+						
							'<td>'+
							'<span ><a href="index.php?s=/addon/WeiSite/BookInfo/info/id/'+jsonObj[i].id+'/token/gh_b5826b7a409f" onClick = setPage()><b>'+jsonObj[i].name+'</b></a></span>'+
							'</td>'+
							' </tr>'+
							'<tr>	'+					
								' <td>作者：'+jsonObj[i].writer+'</td>'+
							 '</tr>'+
							 '<tr>	'+     
							'	 <td>来源：'+jsonObj[i].nickname+'</td>'+
							 '</tr>'+
							 '<tr>	'+					    
								' <td>分类：'+jsonObj[i].kind+'&nbsp;&nbsp;'+
							' </td>'+
							 '</tr>'+
							 
							
							
				'</tbody></table>'+
				'</div>'+
		  ' </li>';
									}
									else{
										result = '<li><div class=fx_heart><input type = hidden id = "microbye_'+jsonObj[i].id+'" value ="'+jsonObj[i].state+'">'+
									'<img src="<?php echo ADDON_PUBLIC_PATH;?>/css/search/img/fx_d1.png"  name="fx_d2" id="fx_d'+jsonObj[i].id+'" width = "24"  height="21" onClick=changeImage("'+jsonObj[i].state+'","'+jsonObj[i].id+'","'+jsonObj[i].zan+'")></div>'+
			  '<if condition = "'+jsonObj[i].available+ ' eq 1"><div class=fx_borrow><span><a onclick=ask("'+jsonObj[i].ownner+'","'+jsonObj[i].name+'","'+jsonObj[i].id+'","<?php echo ($userid); ?>")>借阅？</a></span></div><div class="bookMessage">'+					
			    '<table>'+						   
						  ' <tbody><tr>'+						
							'<td>'+
							'<span ><a href="index.php?s=/addon/WeiSite/BookInfo/info/id/'+jsonObj[i].id+'/token/gh_b5826b7a409f" onClick = setPage()><b>'+jsonObj[i].name+'</b></a></span>'+
							'</td>'+
							' </tr>'+
							'<tr>	'+					
								' <td>作者：'+jsonObj[i].writer+'</td>'+
							 '</tr>'+
							 '<tr>	'+     
							'	 <td>来源：'+jsonObj[i].nickname+'</td>'+
							 '</tr>'+
							 '<tr>	'+					    
								' <td>分类：'+jsonObj[i].kind+'&nbsp;&nbsp;'+
							' </td>'+
							 '</tr>'+
							 
							
							
				'</tbody></table>'+
				'</div>'+
		  ' </li>';
									}
								}
							
								//alert(result);
								$('.booklist').append(result);
							}
							document.getElementById("microbye_page").value = jsonObj.page;
							
							if(jsonObj.mark == 1){
								$(".copyright").html("慧享书香");
							}

						}
						else{
							
							alert('您已经点过赞了,不要重复哦！');
						}
					});
				}
		});
	});
</script>
<script type="text/javascript">
			$(function(){
				$("#scrollTop").scrolltop({
					right: "7%",
					bottom: "30px",
					heightThreshold: 600,
					topSpeed: 300,
					bkImg: "<?php echo ADDON_PUBLIC_PATH;?>/css/search/top.png"
				});
			});
</script>
</body></html>