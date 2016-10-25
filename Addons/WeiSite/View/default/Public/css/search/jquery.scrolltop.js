/*
* 作者:张方雪
* 功能: 创建一个可以让页面滚动到顶部的按钮, 常见于各种社交网站的微博列表.
* 修改时间: 2014-2-26
* 备注: DOM被设置成了浮动的, 用户可以自己设定位置, 传入right, bottom参数即可
      还可以配置滚到条到多高的时候会显示插件图标.
*/
(function ($) {
    $.fn.scrolltop = function (options) {
        var opts = $.extend({}, $.fn.scrolltop.defaults, options);

        var run2top = function () {
            var scrollDist = $(window).scrollTop();
            if (scrollDist > 0) {
                scrollDist -= opts.topSpeed;
                scrollDist = Math.max(scrollDist, 0);
                $(window).scrollTop(scrollDist);
                setTimeout(run2top, 1);
            }
        };

        return this.each(function () {
            var $this = $(this);
			$this.css("display", "none");
            $this.css("opacity", "0.3");
            $this.css("background", "url('" + opts.bgImg + "') no-repeat");
			$this.css("z-index","9999");
            $this.css("width", opts.width);
            $this.css("height", opts.height);
            $this.css("position", "fixed");
            $this.css("right", opts.right);
            $this.css("bottom", opts.bottom);
            $this.hover(
                function () {
                    $(this).css('opacity', '1.0');
                },
                function () {
                    $(this).css('opacity', '0.5');
                }
            );
            $this.click(function () {
                //$(window).scrollTop(0);
                run2top();
            });
            $(window).scroll(function () {
                var scrollDist = $(window).scrollTop();
                if (scrollDist >= opts.heightThreshhold) { //当滚动条离顶部超过阈值的时候, 就显示
                    $this.css("display", "block");
                } else {
                    $this.css("display", "none");
                }
            });
        });
    };
    $.fn.scrolltop.defaults = {
        heightThreshhold: 500,
        width: "50px",
        height: "50px",
        right: "8%",
        bottom: "30px",
        topSpeed: 150, 
		bgImg: "http://hpweixin.microbye.com/Addons/WeiSite/View/default/Public/css/booklist/top.png"
    };
})(jQuery);