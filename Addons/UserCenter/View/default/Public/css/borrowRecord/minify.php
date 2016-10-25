
(function(){function t(e,t){return[].slice.call((t||document).querySelectorAll(e))}if(!window.addEventListener)return;var e=window.StyleFix={link:function(t){try{if(t.rel!=="stylesheet"||t.hasAttribute("data-noprefix"))return}catch(n){return}var r=t.href||t.getAttribute("data-href"),i=r.replace(/[^\/]+$/,""),s=(/^[a-z]{3,10}:/.exec(i)||[""])[0],o=(/^[a-z]{3,10}:\/\/[^\/]+/.exec(i)||[""])[0],u=/^([^?]*)\??/.exec(r)[1],a=t.parentNode,f=new XMLHttpRequest,l;f.onreadystatechange=function(){f.readyState===4&&l()},l=function(){var n=f.responseText;if(n&&t.parentNode&&(!f.status||f.status<400||f.status>600)){n=e.fix(n,!0,t);if(i){n=n.replace(/url\(\s*?((?:"|')?)(.+?)\1\s*?\)/gi,function(e,t,n){return/^([a-z]{3,10}:|#)/i.test(n)?e:/^\/\//.test(n)?'url("'+s+n+'")':/^\//.test(n)?'url("'+o+n+'")':/^\?/.test(n)?'url("'+u+n+'")':'url("'+i+n+'")'});var r=i.replace(/([\\\^\$*+[\]?{}.=!:(|)])/g,"\\$1");n=n.replace(RegExp("\\b(behavior:\\s*?url\\('?\"?)"+r,"gi"),"$1")}var l=document.createElement("style");l.textContent=n,l.media=t.media,l.disabled=t.disabled,l.setAttribute("data-href",t.getAttribute("href")),a.insertBefore(l,t),a.removeChild(t),l.media=t.media}};try{f.open("GET",r),f.send(null)}catch(n){typeof XDomainRequest!="undefined"&&(f=new XDomainRequest,f.onerror=f.onprogress=function(){},f.onload=l,f.open("GET",r),f.send(null))}t.setAttribute("data-inprogress","")},styleElement:function(t){if(t.hasAttribute("data-noprefix"))return;var n=t.disabled;t.textContent=e.fix(t.textContent,!0,t),t.disabled=n},styleAttribute:function(t){var n=t.getAttribute("style");n=e.fix(n,!1,t),t.setAttribute("style",n)},process:function(){t("style").forEach(StyleFix.styleElement),t("[style]").forEach(StyleFix.styleAttribute)},register:function(t,n){(e.fixers=e.fixers||[]).splice(n===undefined?e.fixers.length:n,0,t)},fix:function(t,n,r){for(var i=0;i<e.fixers.length;i++)t=e.fixers[i](t,n,r)||t;return t},camelCase:function(e){return e.replace(/-([a-z])/g,function(e,t){return t.toUpperCase()}).replace("-","")},deCamelCase:function(e){return e.replace(/[A-Z]/g,function(e){return"-"+e.toLowerCase()})}};(function(){setTimeout(function(){},10),document.addEventListener("DOMContentLoaded",StyleFix.process,!1)})()})(),function(e){function t(e,t,r,i,s){e=n[e];if(e.length){var o=RegExp(t+"("+e.join("|")+")"+r,"gi");s=s.replace(o,i)}return s}if(!window.StyleFix||!window.getComputedStyle)return;var n=window.PrefixFree={prefixCSS:function(e,r,i){var s=n.prefix;n.functions.indexOf("linear-gradient")>-1&&(e=e.replace(/(\s|:|,)(repeating-)?linear-gradient\(\s*(-?\d*\.?\d*)deg/ig,function(e,t,n,r){return t+(n||"")+"linear-gradient("+(90-r)+"deg"})),e=t("functions","(\\s|:|,)","\\s*\\(","$1"+s+"$2(",e),e=t("keywords","(\\s|:)","(\\s|;|\\}|$)","$1"+s+"$2$3",e),e=t("properties","(^|\\{|\\s|;)","\\s*:","$1"+s+"$2:",e);if(n.properties.length){var o=RegExp("\\b("+n.properties.join("|")+")(?!:)","gi");e=t("valueProperties","\\b",":(.+?);",function(e){return e.replace(o,s+"$1")},e)}return r&&(e=t("selectors","","\\b",n.prefixSelector,e),e=t("atrules","@","\\b","@"+s+"$1",e)),e=e.replace(RegExp("-"+s,"g"),"-"),e=e.replace(/-\*-(?=[a-z]+)/gi,n.prefix),e},property:function(e){return(n.properties.indexOf(e)?n.prefix:"")+e},value:function(e,r){return e=t("functions","(^|\\s|,)","\\s*\\(","$1"+n.prefix+"$2(",e),e=t("keywords","(^|\\s)","(\\s|$)","$1"+n.prefix+"$2$3",e),e},prefixSelector:function(e){return e.replace(/^:{1,2}/,function(e){return e+n.prefix})},prefixProperty:function(e,t){var r=n.prefix+e;return t?StyleFix.camelCase(r):r}};(function(){var e={},t=[],r={},i=getComputedStyle(document.documentElement,null),s=document.createElement("div").style,o=function(n){if(n.charAt(0)==="-"){t.push(n);var r=n.split("-"),i=r[1];e[i]=++e[i]||1;while(r.length>3){r.pop();var s=r.join("-");u(s)&&t.indexOf(s)===-1&&t.push(s)}}},u=function(e){return StyleFix.camelCase(e)in s};if(i.length>0)for(var a=0;a<i.length;a++)o(i[a]);else for(var f in i)o(StyleFix.deCamelCase(f));var l={uses:0};for(var c in e){var h=e[c];l.uses<h&&(l={prefix:c,uses:h})}n.prefix="-"+l.prefix+"-",n.Prefix=StyleFix.camelCase(n.prefix),n.properties=[];for(var a=0;a<t.length;a++){var f=t[a];if(f.indexOf(n.prefix)===0){var p=f.slice(n.prefix.length);u(p)||n.properties.push(p)}}n.Prefix=="Ms"&&!("transform"in s)&&!("MsTransform"in s)&&"msTransform"in s&&n.properties.push("transform","transform-origin"),n.properties.sort()})(),function(){function i(e,t){return r[t]="",r[t]=e,!!r[t]}var e={"linear-gradient":{property:"backgroundImage",params:"red, teal"},calc:{property:"width",params:"1px + 5%"},element:{property:"backgroundImage",params:"#foo"},"cross-fade":{property:"backgroundImage",params:"url(a.png), url(b.png), 50%"}};e["repeating-linear-gradient"]=e["repeating-radial-gradient"]=e["radial-gradient"]=e["linear-gradient"];var t={initial:"color","zoom-in":"cursor","zoom-out":"cursor",box:"display",flexbox:"display","inline-flexbox":"display",flex:"display","inline-flex":"display",grid:"display","inline-grid":"display","min-content":"width"};n.functions=[],n.keywords=[];var r=document.createElement("div").style;for(var s in e){var o=e[s],u=o.property,a=s+"("+o.params+")";!i(a,u)&&i(n.prefix+a,u)&&n.functions.push(s)}for(var f in t){var u=t[f];!i(f,u)&&i(n.prefix+f,u)&&n.keywords.push(f)}}(),function(){function s(e){return i.textContent=e+"{}",!!i.sheet.cssRules.length}var t={":read-only":null,":read-write":null,":any-link":null,"::selection":null},r={keyframes:"name",viewport:null,document:'regexp(".")'};n.selectors=[],n.atrules=[];var i=e.appendChild(document.createElement("style"));for(var o in t){var u=o+(t[o]?"("+t[o]+")":"");!s(u)&&s(n.prefixSelector(u))&&n.selectors.push(o)}for(var a in r){var u=a+" "+(r[a]||"");!s("@"+u)&&s("@"+n.prefix+u)&&n.atrules.push(a)}e.removeChild(i)}(),n.valueProperties=["transition","transition-property"],e.className+=" "+n.prefix,StyleFix.register(n.prefixCSS)}(document.documentElement);// JavaScript Document dialog

(function(){
	var elemDialog, elemOverlay, elemContent, elemTitle,
		inited = false,
		body = document.compatMode && document.compatMode !== 'BackCompat' ?
					document.documentElement : document.body,
		cssFixed;
	
	function init(){
		if (!inited){
			createOverlay();
			createDialog();
			inited = true;
		}
	}
	
	function createOverlay(){
		if (!elemOverlay){
			elemOverlay = $('<div class="box_overlay"></div>');
			$('body').append(elemOverlay);
		}
	}
	function createDialog(){
		if (!elemDialog){
			
					elemDialog = $('<div class="dialog">'+
						'<div class="dialog_content"></div>'+
						'</div>');
					
					elemContent = $('.dialog_content', elemDialog);
					$('body').append(elemDialog);
					elemDialog.show();
					
				
		}
	}
	function open(){
		elemDialog.show();
		elemOverlay.show();
		//$('select').hide();
	}
	function close(){
		elemDialog.hide();
		if(elemOverlay)elemOverlay.hide();
		elemContent.empty();
		//$('select').show();
	}
	
	function setHtml(html){
		elemContent.html(html);
	}	
	var Dialog = {
		loading:function(){
			this.open("<p class='dialog_loading'></p>");
			},
		success:function(){
			var successTips = "操作成功!";
			if(arguments[0]!=null)successTips = arguments[0];
			this.open("<p class='dialog_success'>"+successTips+"</p>");
			setTimeout(function(){
				$.Dialog.close();
				},2000)
			},
		fail:function(){
			var failTips = "操作失败!";
			if(arguments[0]!=null)failTips = arguments[0];
			this.open("<p class='dialog_fail'>"+failTips+"</p>");
			setTimeout(function(){
				$.Dialog.close();
				},2000)
			},
		confirm:function(title,msg,callback,jump_url){
				var _title = title;
				var _msg = msg;
				var tempHtml =$("<div class='dialog_confirm'><p class='title'>"+title+"</p><p class='msg'></p><p class='btnWrap'><a href='javascript:;' class='confirmBtn'>确定</a></p></div>");
				$('.msg',tempHtml).append(msg);
				this.open(tempHtml);
				$('.confirmBtn',tempHtml).click(function(){
					if(callback){
						callback();
					}else if(jump_url){
					     window.location.href=jump_url;
					}else{
						$.Dialog.close();	
					}
				});
			},	
		confirmBox:function(title,msg,opts){
				var _title = title;
				var _msg = msg;
				var leftText = "否";
				var rightText = "是"
				if(opts){
					leftText = opts.leftBtnText || "否";
					rightText = opts.rightBtnText || "是"
				}
				var tempHtml =$("<div class='dialog_confirm'><p class='title'>"+title+"</p><p class='msg'>"+_msg+"</p><p class='btnWrap'><a href='javascript:;' class='leftBtn'>"+leftText+"</a><a href='javascript:;' class='rightBtn'>"+rightText+"</a></p></div>");
				this.open(tempHtml);
				$('.rightBtn',tempHtml).click(function(){
					if(opts && opts.rightCallback){
						opts.rightCallback();
					}else{
						$.Dialog.close();	
					}
				});
				$('.leftBtn',tempHtml).click(function(){
					if(opts && opts.leftCallback){
						opts.leftCallback();
					}else{
						$.Dialog.close();	
					}
				});
			},	
		open: function(html){
			init();
			setHtml(html);
			open();
		},
		close: close
	};
	
	$.extend($,{Dialog: Dialog});
	
})();
(function(e,t,n){function h(e,t){return this instanceof h?this.init(e,t):new h(e,t)}function p(e,t){return e.changedTouches?e.changedTouches[0][t]:e[t]}function d(e){return y(e,function(e){return r.style[e]!==n})}function v(e,t,r){var o=s[t];o?e[o]=r:e[t]!==n?(s[t]=t,e[t]=r):y(i,function(i){var o=g(i)+g(t);if(e[o]!==n)return s[t]=o,e[o]=r,!0})}function m(e){if(r.style[e]!==n)return e;var t;return y(i,function(i){var s=g(i)+g(e);if(r.style[s]!==n)return t="-"+i+"-"+e,!0}),t}function g(e){return e.charAt(0).toUpperCase()+e.substr(1)}function y(e,t){for(var n=0,r=e.length;n<r;n++)if(t(e[n],n))return!0;return!1}function b(e,t,n,r){var i=Math.abs(e-n),s=Math.abs(t-r),o=Math.sqrt(Math.pow(i,2)+Math.pow(s,2));return{x:i,y:s,z:o}}function w(e){var t=e.y/e.z,n=Math.acos(t);return 180/(Math.PI/n)}var r=t.createElement("div"),i=["webkit","moz","o","ms"],s={},o=h.support={},u=!1,a=5,f=55;o.transform3d=d(["perspectiveProperty","WebkitPerspective","MozPerspective","OPerspective","msPerspective"]),o.transform=d(["transformProperty","WebkitTransform","MozTransform","OTransform","msTransform"]),o.transition=d(["transitionProperty","WebkitTransitionProperty","MozTransitionProperty","OTransitionProperty","msTransitionProperty"]),o.addEventListener="addEventListener"in e,o.mspointer=e.navigator.msPointerEnabled,o.cssAnimation=(o.transform3d||o.transform)&&o.transition;var l=["touch","mouse"],c={start:{touch:"touchstart",mouse:"mousedown"},move:{touch:"touchmove",mouse:"mousemove"},end:{touch:"touchend",mouse:"mouseup"}};o.addEventListener&&(t.addEventListener("gesturestart",function(){u=!0}),t.addEventListener("gestureend",function(){u=!1})),h.prototype.init=function(e,r){var i=this;i.element=e,typeof e=="string"&&(i.element=t.querySelector(e));if(!i.element)throw new Error("element not found");return o.mspointer&&(i.element.style.msTouchAction="pan-y"),r=r||{},i.distance=r.distance,i.maxPoint=r.maxPoint,i.disableTouch=r.disableTouch===n?!1:r.disableTouch,i.disable3d=r.disable3d===n?!1:r.disable3d,i.transitionDuration=r.transitionDuration===n?"350ms":r.transitionDuration+"ms",i.currentPoint=0,i.currentX=0,i.animation=!1,i.use3d=o.transform3d,i.disable3d===!0&&(i.use3d=!1),o.cssAnimation?i._setStyle({transitionProperty:m("transform"),transitionTimingFunction:"cubic-bezier(0,0,0.25,1)",transitionDuration:"0ms",transform:i._getTranslate(0)}):i._setStyle({position:"relative",left:"0px"}),i.refresh(),l.forEach(function(e){i.element.addEventListener(c.start[e],i,!1)}),i},h.prototype.handleEvent=function(e){var t=this;switch(e.type){case c.start.touch:t._touchStart(e,"touch");break;case c.start.mouse:t._touchStart(e,"mouse");break;case c.move.touch:t._touchMove(e,"touch");break;case c.move.mouse:t._touchMove(e,"mouse");break;case c.end.touch:t._touchEnd(e,"touch");break;case c.end.mouse:t._touchEnd(e,"mouse");break;case"click":t._click(e)}},h.prototype.refresh=function(){var e=this;e._maxPoint=e.maxPoint===n?function(){var t=e.element.childNodes,n=-1,r=0,i=t.length,s;for(;r<i;r++)s=t[r],s.nodeType===1&&n++;return n}():e.maxPoint,e.distance===n?e._maxPoint<0?e._distance=0:e._distance=e.element.scrollWidth/(e._maxPoint+1):e._distance=e.distance,e._maxX=-e._distance*e._maxPoint,e.moveToPoint()},h.prototype.hasNext=function(){var e=this;return e.currentPoint<e._maxPoint},h.prototype.hasPrev=function(){var e=this;return e.currentPoint>0},h.prototype.toNext=function(e){var t=this;if(!t.hasNext())return;t.moveToPoint(t.currentPoint+1,e)},h.prototype.toPrev=function(e){var t=this;if(!t.hasPrev())return;t.moveToPoint(t.currentPoint-1,e)},h.prototype.moveToPoint=function(e,t){var r=this;t=t===n?r.transitionDuration:t+"ms";var i=r.currentPoint;e===n&&(e=r.currentPoint),e<0?r.currentPoint=0:e>r._maxPoint?r.currentPoint=r._maxPoint:r.currentPoint=parseInt(e,10),o.cssAnimation?r._setStyle({transitionDuration:t}):r.animation=!0,r._setX(-r.currentPoint*r._distance,t),i!==r.currentPoint&&(r._triggerEvent("fsmoveend",!0,!1),r._triggerEvent("fspointmove",!0,!1))},h.prototype._setX=function(e,t){var n=this;n.currentX=e,o.cssAnimation?n.element.style[s.transform]=n._getTranslate(e):n.animation?n._animate(e,t||n.transitionDuration):n.element.style.left=e+"px"},h.prototype._touchStart=function(e,n){var r=this;if(r.disableTouch||r.scrolling||u)return;r.element.addEventListener(c.move[n],r,!1),t.addEventListener(c.end[n],r,!1);var i=e.target.tagName;n==="mouse"&&i!=="SELECT"&&i!=="INPUT"&&i!=="TEXTAREA"&&i!=="BUTTON"&&e.preventDefault(),o.cssAnimation?r._setStyle({transitionDuration:"0ms"}):r.animation=!1,r.scrolling=!0,r.moveReady=!1,r.startPageX=p(e,"pageX"),r.startPageY=p(e,"pageY"),r.basePageX=r.startPageX,r.directionX=0,r.startTime=e.timeStamp,r._triggerEvent("fstouchstart",!0,!1)},h.prototype._touchMove=function(e,t){var n=this;if(!n.scrolling||u)return;var r=p(e,"pageX"),i=p(e,"pageY"),s,o;if(n.moveReady){e.preventDefault(),s=r-n.basePageX,o=n.currentX+s;if(o>=0||o<n._maxX)o=Math.round(n.currentX+s/3);n.directionX=s===0?n.directionX:s>0?-1:1;var l=!n._triggerEvent("fstouchmove",!0,!0,{delta:s,direction:n.directionX});l?n._touchAfter({moved:!1,originalPoint:n.currentPoint,newPoint:n.currentPoint,cancelled:!0}):n._setX(o)}else{var c=b(n.startPageX,n.startPageY,r,i);c.z>a&&(w(c)>f?(e.preventDefault(),n.moveReady=!0,n.element.addEventListener("click",n,!0)):n.scrolling=!1)}n.basePageX=r},h.prototype._touchEnd=function(e,n){var r=this;r.element.removeEventListener(c.move[n],r,!1),t.removeEventListener(c.end[n],r,!1);if(!r.scrolling)return;var i=-r.currentX/r._distance;i=r.directionX>0?Math.ceil(i):r.directionX<0?Math.floor(i):Math.round(i),i<0?i=0:i>r._maxPoint&&(i=r._maxPoint),r._touchAfter({moved:i!==r.currentPoint,originalPoint:r.currentPoint,newPoint:i,cancelled:!1}),r.moveToPoint(i)},h.prototype._click=function(e){var t=this;e.stopPropagation(),e.preventDefault()},h.prototype._touchAfter=function(e){var t=this;t.scrolling=!1,t.moveReady=!1,setTimeout(function(){t.element.removeEventListener("click",t,!0)},200),t._triggerEvent("fstouchend",!0,!1,e)},h.prototype._setStyle=function(e){var t=this,n=t.element.style;for(var r in e)v(n,r,e[r])},h.prototype._animate=function(e,t){var n=this,r=n.element,i=+(new Date),s=parseInt(r.style.left,10),o=e,u=parseInt(t,10),a=function(e,t){return-(e/=t)*(e-2)},f=setInterval(function(){var e=new Date-i,t,n;e>u?(clearInterval(f),n=o):(t=a(e,u),n=t*(o-s)+s),r.style.left=n+"px"},10)},h.prototype.destroy=function(){var e=this;l.forEach(function(t){e.element.removeEventListener(c.start[t],e,!1)})},h.prototype._getTranslate=function(e){var t=this;return t.use3d?"translate3d("+e+"px, 0, 0)":"translate("+e+"px, 0)"},h.prototype._triggerEvent=function(e,n,r,i){var s=this,o=t.createEvent("Event");o.initEvent(e,n,r);if(i)for(var u in i)i.hasOwnProperty(u)&&(o[u]=i[u]);return s.element.dispatchEvent(o)},typeof exports=="object"?module.exports=h:typeof define=="function"&&define.amd?define(function(){return h}):e.Flipsnap=h})(window,window.document);// JavaScript Document by jacy

var RESULT_SUCCESS = 'success';
var RESULT_FAIL = 'fail';
var WeiPHP_RAND_COLOR = ["#ff6600","#ff9900","#99cc00","#33cc00","#0099cc","#3399ff","#9933ff","#cc3366","#333333","#339999","#ff6600","#ff9900","#99cc00","#33cc00","#0099cc","#3399ff","#9933ff","#cc3366","#333333","#339999","#ff6600","#ff9900","#99cc00","#33cc00","#0099cc","#3399ff","#9933ff","#cc3366","#333333","#339999"];


(function(){
	//异步请求提交表单
	//提交后返回格式json json格式 {'result':'success|fail',data:{....}}
	function doAjaxSubmit(form,callback){
		$.Dialog.loading();
		$.ajax({
			data:form.serializeArray(),
			type:'post',
			dataType:'json',
			url:form.attr('action'),
			success:function(data){
				$.Dialog.close();
				callback(data);
				}
			})
	}
	
	function initFixedLayout(){
		var navHeight = $('#fixedNav').height();
		$('#fixedContainer').height($(window).height()-navHeight);	
	}
	//通用banner
	function banner(id,isAuto,delayTime,wh){
		if($(id).find('ul').html()==undefined)return;
		if(!wh)wh = 2;
		var screenWidth = $(id).width();
		var count = $(id).find('li') .size();
		$(id).find('ul').width(screenWidth*count);
		$(id).find('li').height(screenWidth/wh);
		$(id).height(screenWidth/wh);
		$(id).find('li').width(screenWidth).height(screenWidth/wh);
		$(id).find('li img').width(screenWidth).height(screenWidth/wh);
		$(id).find('li .title').css({'width':'98%','padding-left':'2%'})
		// With options
		$(id).find('li .title').each(function(index, element) {
            $(this).text($(this).text().length>15?$(this).text().substring(0,15)+" ...":$(this).text());
        });
		var flipsnap = Flipsnap(id+' ul');
		flipsnap.element.addEventListener('fstouchend', function(ev) {
			$(id).find('.identify em').eq(ev.newPoint).addClass('cur').siblings().removeClass('cur');
		}, false);
		$(id).find('.identify em').eq(0).addClass('cur')
		if(isAuto){
			var point = 1;
			setInterval(function(){
				//console.log(point);
				flipsnap.moveToPoint(point);
				$(id).find('.identify em').eq(point).addClass('cur').siblings().removeClass('cur');
				if(point+1==$(id).find('li').size()){
					point=0;
				}else{
					point++;
					}
				
				},delayTime)
		}
	}
	//多图banner num=列数
	function mutipicBanner(id,isAuto,delayTime,num){
		if($(id).find('ul').html()==undefined)return;  
		var screenWidth = $(id).width();
		var count = $(id).find('li') .size();
		var aNew=Math.ceil(count/num-1)  ;
		$(id).find('ul').width(screenWidth*count/num);
		$(id).find('li').width(screenWidth/num*0.9375)
		$(id).find('li').css('marginLeft',screenWidth/num*0.03125+'px') //li的margin
		$(id).find('li').css('marginRight',screenWidth/num*0.03125+'px')
		$(id).find('li').css('marginTop',screenWidth/num*0.03125+'px')
		$(id).find('li .title').css({'width':'98%','padding-left':'2%'})
		// With options
		$(id).find('li .title').each(function(index, element) {
            $(this).text($(this).text().length>15?$(this).text().substring(0,15)+" ...":$(this).text());
        });  
    	var points='';
		for (var i = 0; i <= aNew; i++) {			
			
			points += '<em></em>';
		};	
		$(id).find('.pointer').html(points);
		var flipsnap = Flipsnap(id+' ul',{
			distance:screenWidth ,
			maxPoint: Math.ceil(count/num-1) 
		});
		flipsnap.element.addEventListener('fstouchend', function(ev) {
			$(id).find('.mutipic_banner_identify em').eq(ev.newPoint).addClass('cur').siblings().removeClass('cur');
		}, false);
		$(id).find('.mutipic_banner_identify em').eq(0).addClass('cur')
		if(isAuto){
			var point = 1;
			setInterval(function(){
				//console.log(point);
				flipsnap.moveToPoint(point);
				$(id).find('.mutipic_banner_identify em').eq(point).addClass('cur').siblings().removeClass('cur');
				if(point+1==$(id).find('li').size()){
					point=0;
				}else{
					point++;
					}
				
				},delayTime)
		}
		
	}
	//相册效果
	function gallery(container,slideContainer){
		var screenWidth = $('.container').width();
		var count = $(container).find('li').size();
		$(container).find('ul').width(screenWidth*count);		
		$(container).find('ul').height(screenWidth);
		$(container).height(screenWidth);
		$(container).find('li').css({width:screenWidth,height:screenWidth});
		$(container).find('li img').width("100%").height("100%");
		if ($('.identify em').size()==1) {$('.identify em').hide()}
		var flipsnap = Flipsnap(slideContainer,{
			distance: screenWidth
		});
		flipsnap.element.addEventListener('fstouchend', function(ev) {
			$(container).find('.identify em').eq(ev.newPoint).addClass('cur').siblings().removeClass('cur');
		}, false);
		$(container).find('.identify em').eq(0).addClass('cur')
		
	}
	//正方形图片预览
	function squarePicSlide(isAuto,delayTime,width,height,prevBtn,nextBtn){
		var count = $('.banner li').size();
		$('.banner ul').width(width*count);
		$('.banner ul').height(height);
		$('.banner').height(height);
		$('.banner li').width(width).height(height);
		$('.banner li img').width(width).css('min-height',height);
		$('.banner li .title').css({'width':'98%','padding-left':'2%'})
		// With options
		$('.banner li .title').each(function(index, element) {
            $(this).text($(this).text().length>15?$(this).text().substring(0,15)+" ...":$(this).text());
        });
		var flipsnap = Flipsnap('.banner ul');
		flipsnap.element.addEventListener('fstouchend', function(ev) {
			$('.identify em').eq(ev.newPoint).addClass('cur').siblings().removeClass('cur');
		}, false);
		$('.identify em').eq(0).addClass('cur');
		var point = 0;
		if(isAuto){
			
			setInterval(function(){
				//console.log(point);
				flipsnap.moveToPoint(point);
				},delayTime)
		}
		flipsnap.element.addEventListener('fstouchend', function(ev) {
			point = ev.newPoint;
			$('.identify em').eq(point).addClass('cur').siblings().removeClass('cur');
		}, false);
		$(prevBtn).click(function(){
			 if(flipsnap.hasPrev()){
				flipsnap.toPrev();
				point = point-1;
			 }else{
				flipsnap.moveToPoint(count-1);
				point = count-1;
				}
			$('.identify em').eq(point).addClass('cur').siblings().removeClass('cur');
			});
		$(nextBtn).click(function(){
			 if(flipsnap.hasNext()){
				flipsnap.toNext();
				point = point+1;
			 }else{
				flipsnap.moveToPoint(0);
				point = 0;
				}
			$('.identify em').eq(point).addClass('cur').siblings().removeClass('cur');
			
			});
	}
	//随机颜色
	function setRandomColor(selector){
		$(selector).each(function(index, element) {
			$(this).css('background-color',WeiPHP_RAND_COLOR[index]);
		});;
	}
	//显示分享提示
	function showShareTips(callback){
		var tempHtml = $('<div class="shareTips"><div class="tipsPic"></div><a class="close" href="javascript:;"></a></div>');
		$('body').append(tempHtml);
		$('.shareTips').click(function(){
			closeShareTips(callback);	
		})
	}
	function showShareFriend(callback){
		var tempHtml = $('<div class="shareTips"><div class="tips_friend"></div><a class="close" href="javascript:;"></a></div>');
		$('body').append(tempHtml);
		$('.shareTips').click(function(){
			closeShareTips(callback);	
		})
	}
	function showSubscribeTips(opts){
		if(opts.qrcode.length>5){
			var tempHtml = $('<div class="shareTips"><div class="tips_concern"></div><div class="qrcode"><img src="'+opts.qrcode+'"/><p>长按二维码关注公众号</p></div><a class="close" href="javascript:;"></a></div>');
		}else{
			var tempHtml = $('<div class="shareTips"><div class="tips_concern"></div><a class="close" href="javascript:;"></a></div>');
		}
		$('body').append(tempHtml);
		$('.shareTips').click(function(){
			$('.shareTips').remove();
			if(opts.caalback)closeShareTips(opts.callback);	
		})
	}
	function closeShareTips(callback){
		$('.shareTips').remove();
		if(callback){
			callback();	
		}
	}
	//初始化分享数据
	
	function initWxShare(shareData){
		wx.ready(function(res){
			//alert('res:'+res);
			//分享
			wx.onMenuShareTimeline({
				title: shareData.desc, // 分享标题
				link: shareData.link, // 分享链接
				imgUrl: shareData.imgUrl, // 分享图标
				success: function () { 
					// 用户确认分享后执行的回调函数
				},
				cancel: function () { 
					// 用户取消分享后执行的回调函数
				}
			});
			wx.onMenuShareAppMessage({
				title: shareData.title, // 分享标题
				desc: shareData.desc, // 分享描述
				link: shareData.link, // 分享链接
				imgUrl: shareData.imgUrl, // 分享图标
				type: shareData.type, // 分享类型,music、video或link，不填默认为link
				dataUrl: shareData.dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
				success: function () { 
					// 用户确认分享后执行的回调函数
				},
				cancel: function () { 
					// 用户取消分享后执行的回调函数
				}
			});
			wx.onMenuShareQQ({
				title: shareData.title, // 分享标题
				desc: shareData.desc, // 分享描述
				link: shareData.link, // 分享链接
				imgUrl: shareData.imgurl, // 分享图标
				success: function () { 
				   // 用户确认分享后执行的回调函数
				},
				cancel: function () { 
				   // 用户取消分享后执行的回调函数
				}
			});
		})
	}
	function back(){
		var hisLen = window.history.length;
		if(hisLen == 1){
			wx.closeWindow();
		}else{
			window.history.back();
		}
	}
	function showQrcode(title,url){
		var qrHtml = $('<div class="qrcode_dialog"><a href="javascript:;" class="close"></a><div class="content"><img src=""/><p></p></div></div>');
		$('img',qrHtml).attr('src','http://qr.liantu.com/api.php?text='+url);
		$('p',qrHtml).html(title);
		$('body').append(qrHtml);
		$('.close',qrHtml).click(function(){
			qrHtml.remove();
		})
	}
	//利用微信接口上传图片
	function wxChooseImg(_this,num,name,callback){
		wx.chooseImage({
			count: num, // 默认9
			sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function (res0) {
				var localIds = res0.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				if(callback){
					callback(localIds);
				}else{
					wxUploadImg(localIds,name,_this);
				}
			}
		});
		
    }
	//利用微信接口上传图片到微信服务器
	function wxUploadImg(localIds,name,target){
		var localId = localIds.pop();
		$.Dialog.loading();
		wx.uploadImage({
			localId: localId, // 需要上传的图片的本地ID，由chooseImage接口获得
			isShowProgressTips: 0, // 默认为1，显示进度提示
			success: function (res) {
				$('textarea').val();
				$.get(SITE_URL+"/index.php?s=/Home/Weixin/downloadPic/media_id/"+res.serverId+".html",function(data){
					$.Dialog.close();
					if(data.result=="success"){
						var addImg = $('<div class="img_item"><em>X</em><input type="hidden" name="'+name+'" value="'+data.id+'"/><img src="'+data.picUrl+'"/></div>');
						addImg.insertBefore($(target));
						var uploadImgWidth = $('.muti_picture_row .img_item').width()-10;
						$('.muti_picture_row .img_item').height(uploadImgWidth).width(uploadImgWidth);
						$('em',addImg).click(function(){
							$(this).parent().remove();
						})
						
						if(localIds.length>0){
							wxUploadImg(localIds,name,target);
						}
					}else{
						alert('上传图片失败，请通知管理员处理');
					}
				})
			}
		});
	}
	//下拉刷新只需要在页面上配置
	//内容列表配置 id="pullContainer"
	//页码使用WeiPHP服务器返回的页码  在page中打开 
	//如：<div class="page" data-pullload="true"> {$_page|default=''} </div>
	function initLoadMorePage(){
		if($('.page').data('pullload')==true){
			$('.page').hide();
			var isLoading = false;
			var $loading = $('<div class="moreLoading"><em></em><br/>正在加载...</div>').hide();
			$loading.insertAfter('#pullContainer');
			$(window).scroll(function(){
				//console.log($('body').height());
				//console.log($(window).scrollTop());	
				var next = $('.page').find('.current').last().next('a.num');
				var nextUrl = next.attr('href');
				if(nextUrl && isLoading==false && $('body').height()<$(window).scrollTop()+$(window).height()+30){
					isLoading = true;
					$loading.show();
					$.get(nextUrl,function(data){
						var dataDom = $(data);
						var listDom = dataDom.find('#pullContainer');
						$('#pullContainer').append(listDom.html());
						isLoading = false;
						$loading.hide();
						$('.page').find('.current').next('a').addClass('current');
					});
				}else if(isLoading == false && isLoading==false && $('body').height()<$(window).scrollTop()+$(window).height()+30){
					$loading.html('没有更多了').show();
				}
				
			});
		}
	}
	//下拉刷新
	//每页拉去数
	var pageCount = 10;
	//是否正在加载
	var isLoading = false;
	//拉取时间戳参数 页码或lastId
	//var ids;
	var lastId = 0;
	var minId =0;
	var maxId = 0;
	var pageIds ='';
	//类型 0按页码 1按lastId
	var loadType = 0;
	//请求地址
	var loadUrl;
	//是否还有更多
	var hasMore = true;
	//dom class
	var domClass;
	//容器
	var domContainer;
	//加载数据
	function loadMoreContent(){
		$('.contentItem').each(function(){
			pageIds+= $(this).data('goodsids')+',';
		});
		isLoading = true;
		$('.moreLoading').show();
		$('.noMore').hide();
		$.get(loadUrl,{"count":pageCount,"lastId":lastId,'minId':minId,'maxId':maxId,'pageIds':pageIds},function(data){
				
			if($.trim(data)==""||data.indexOf('default_png')>0){
				hasMore = false;
				$('.noMore').show();
				$('.moreLoading').hide();
			}else{
				$('#'+domContainer).append(data);
				hasMore = true;
				$('.moreLoading').hide();
			}
			isLoading = false;
		});
	}
	//初始化微信api
	function initWxApi(){
		wx.config({
			debug: false,
			appId: WX_APPID, // 必填，公众号的唯一标识
			timestamp: WXJS_TIMESTAMP, // 必填，生成签名的时间戳
			nonceStr: NONCESTR, // 必填，生成签名的随机串
			signature: SIGNATURE,// 必填，签名，见附录1
			jsApiList: [
				'checkJsApi',
				'onMenuShareTimeline',
				'onMenuShareAppMessage',
				'onMenuShareQQ',
				'onMenuShareWeibo',
				'hideMenuItems',
				'showMenuItems',
				'hideAllNonBaseMenuItem',
				'showAllNonBaseMenuItem',
				'translateVoice',
				'startRecord',
				'stopRecord',
				'onRecordEnd',
				'playVoice',
				'pauseVoice',
				'stopVoice',
				'uploadVoice',
				'downloadVoice',
				'chooseImage',
				'previewImage',
				'uploadImage',
				'downloadImage',
				'getNetworkType',
				'openLocation',
				'getLocation',
				'hideOptionMenu',
				'showOptionMenu',
				'closeWindow',
				'scanQRCode',
				'chooseWXPay',
				'openProductSpecificView',
				'addCard',
				'chooseCard',
				'openCard'
				]
			});
		wx.error(function(res){
			//alert('js授权出错,请检查域名授权设置和参数是否正确');
		})
	}
	function moneyFormat(value){
		var float = parseFloat(value);
		float = Math.ceil(float*100);
		float = float/100;
		if(Number(float) === float && float % 1 === 0){
			float = float+".00";
		}
		return float;
	}
	function getListMaxId(className){
		var maxId = 0;
		$('.'+className).each(function(index, element) {
            if(parseInt($(this).data('lastid'))>maxId){
				maxId = $(this).data('lastid');
			}
        });
		return maxId;
	}
	function getListMinId(className){
		var minId = parseInt($('.'+className).eq(0).data('lastid'));
		$('.'+className).each(function(index, element) {
            if(parseInt($(this).data('lastid'))<minId){
				minId = $(this).data('lastid');
			}
        });
		return minId;
	}
	var WeiPHP = {
		doAjaxSubmit:doAjaxSubmit,
		setRandomColor:setRandomColor,
		initBanner:banner,
		initMutipicBanner:mutipicBanner,
		gallery:gallery,
		squarePicSlide:squarePicSlide,
		initFixedLayout:initFixedLayout,
		showShareTips:showShareTips,//弹出提示分享指引
		showShareFriend:showShareFriend,//分享给朋友
		showSubscribeTips:showSubscribeTips,//提示关注公众号
		initLoadMore:function(opts){
			pageCount = opts.pageCount || 10;
			lastId = opts.lastId || 0;
			minId = opts.minId || 0;
			maxId = opts.maxId || 0;
			loadType = opts.loadType || 0;
			loadUrl = opts.loadUrl;
			pageIds = opts.pageids;
			domClass = opts.domClass || "contentItem";
			domContainer = opts.domContainer || "container";
			$(window).scroll( function() {
				if(!isLoading && hasMore){
					if(loadType==0){
						lastId++; 
					}else{
						minId = getListMinId(domClass);
						maxId = getListMaxId(domClass);
						
						
						
						if(!lastId){
							lastId = $('.'+domClass).last().data('lastid');
						}
					}
					totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());  
					if ($(document).height() <= totalheight+50){
						loadMoreContent();
					} 
				}else if(hasMore == false){
					$('.noMmore').show();
					$('.moreLoading').hide();
				} 
			})
		},
		initWxShare:initWxShare,
		initWxApi:initWxApi,
		back:back,
		showQrcode:showQrcode,
		wxChooseImg:wxChooseImg,
		wxUploadImg:wxUploadImg,
		initLoadMorePage:initLoadMorePage,
		moneyFormat:moneyFormat,
		getListMinId:getListMinId,
		getListMaxId:getListMaxId
		
		
	};
	$.extend($,{
		WeiPHP: WeiPHP
	});
})();


$(function(){
	//初始化微信js api
	$.WeiPHP.initWxApi();
	//页面总是撑满屏幕
	$('.body').css('min-height',$(window).height());
	//
	$('.toggle_list .title').click(function(){
		$(this).parents('li').toggleClass("toggle_list_open");
		})
	$('.top_nav_a').click(function(){
		if(!$(this).hasClass('active')){
				$(this).next().show();
				$(this).addClass('active')
			}else{
				$(this).next().hide();
				$(this).removeClass('active')
				}
		});
	
	//打开成员详情
	$('.user_item').click(function(){
		var detail = $(this).find('.detail').html();
		var dialogHtml = $('<div class="user_dialog"><span class="close"></span><div>'+detail+'</div></div>');
		var closeHtml = $('.close',dialogHtml);
		closeHtml.click(function(){
			$.Dialog.close();
			});
		$.Dialog.open(dialogHtml);
		})
	//考试选择效果
	$(".testing li input[type='radio']").change(function(){
		var $icon = $(this).parent("label").find(".icon");
		if(!$icon.hasClass("selected"))$icon.addClass('selected');
		$(this).parents("li").siblings().find(".icon").removeClass("selected");
		
	});
	$(".testing li input[type='checkbox']").change(function(){
		var $icon = $(this).parent("label").find(".icon");
		console.log($(this).is(":checked"));
		if($(this).is(":checked")){
			$icon.addClass('selected');
			}else{
				$icon.removeClass('selected');
				}
		
		
		
	});
	$('.class_item .more').click(function(){
			$(this).parent().find('.summary').toggle();
			$(this).parent().find('.desc_all').toggle();
			$(this).html()=="查看更多"?$(this).html("收起"):$(this).html("查看更多");
		});
	//返回
	$(".top_back_btn").click(function(){
		var href = $(this).attr('href');
		if(href=='javascript:void(0);'||href==''||href=='###'||href=='#')	history.back(-1);
	});	
	
	var uploadImgWidth = $('.muti_picture_row .img_item').width()-10;
	$('.muti_picture_row .img_item').height(uploadImgWidth).width(uploadImgWidth);
	$('.muti_picture_row .img_item em').click(function(){
		$(this).parent().remove();
	})
	
	if($('.container').data('mh')){
		var mh = parseFloat($('.container').data('mh'))*$(window).height();
		$('.container').css({'min-height':mh})
	}
	//初始化为正方式
	$('.init_square').each(function(index, element) {
	   var img =  $(this).attr('src');
	   var image = new Image();
	   image.onload =function(){
		   $(element).height($(element).width()); 
	   }
       image.src = img;
    });
	//运行倒计时
	function countDownTimer(time){
			var ts = time; 
			var timer = setInterval(function(){
				var dd = parseInt(ts / 60 / 60 / 24, 10);//计算剩余的天数  
				var hh = parseInt(ts / 60 / 60 % 24, 10);//计算剩余的小时数  
				var mm = parseInt(ts / 60 % 60, 10);//计算剩余的分钟数  
				var ss = parseInt(ts % 60, 10);//计算剩余的秒数  
				dd = checkTime(dd);  
				hh = checkTime(hh);  
				mm = checkTime(mm);  
				ss = checkTime(ss);  
				ts--;
				$('#runCountDown .day').text(dd);
				$('#runCountDown .hour').text(hh);
				$('#runCountDown .min').text(mm);
				$('#runCountDown .sec').text(ss);
				if(dd==0 && hh==0 && mm==0 && ss==0){
					clearInterval(timer);
					window.location.reload();
				}
			},1000);		
	}
	function checkTime(i){    
	   if (i < 10) {    
		   i = "0" + i;    
		}    
	   return i;    
	}    
	if($('#runCountDown').data('time')){
		var time = parseInt($('#runCountDown').data('time'));
		if(time>0){
			countDownTimer(time)
		}
	}

})