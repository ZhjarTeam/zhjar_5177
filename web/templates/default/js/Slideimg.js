// JavaScript Document

(function($){
	$.fn.slideimg = function(speed){
	//默认配置
		if(speed == undefined){ 
			var speed = 5000;
		}

		var obj = $(this),
		    picnum = 0,
			$picli = obj.find(".pic").find("li"),
			imglen = $picli.length,
			$next = obj.find(".next"),
			$prev = obj.find(".prev"),
			pichei = $(window).width()/1920*460;

		$(".home-focus").height(pichei);

		//$("#home-focus .pic ul li img").css("margin-left",""+($(window).width()-1920)/2+"px");
		for (var i = imglen - 1; i >= 0; i--) { //浮标个数添加
			obj.find(".num").find("ul").append("<li></li>");
		};

		var $numli = obj.find(".num").find("li");
		$numli.first().addClass("cur");//第一个浮标显示

		if(imglen > 1){
		
			play(0);//初始化

			var turnimg = setInterval(tz,speed);//循环播放

			$numli.click(function(){//浮标点击切换
				var numindex = $(this).index(),
					$curnum = obj.find(".cur").index();
				//console.log($curnum);
				picnum = numindex;
				$picli.eq($curnum).css("z-index","0");
				$picli.eq(picnum).css("z-index","1").animate({ 
					opacity:'1'
				},function(){
					$picli.eq($curnum).animate({ 
						opacity:'0'
					});
				});
				$(this).siblings().removeClass("cur");
				$(this).addClass("cur");
			});	
			$next.click(function(){ 
				if(picnum < imglen-1){
					picnum = picnum + 1;
				}else{ 
					picnum = 0;
				}
				var $curnum = obj.find(".cur").index();
				$picli.eq($curnum).css("z-index","0");
				$picli.eq(picnum).css("z-index","1").animate({ 
					opacity:'1'
				},function(){
					$picli.eq($curnum).animate({ 
						opacity:'0'
					});
				});
				$numli.removeClass("cur");
				$numli.eq(picnum).addClass("cur");
			});
			$prev.click(function(){ 
				if(picnum == 0){
					picnum = imglen-1;
				}else{ 
					picnum = picnum - 1;	
				}
				var $curnum = obj.find(".cur").index();
				$picli.eq($curnum).css("z-index","0");
				$picli.eq(picnum).css("z-index","1").animate({ 
					opacity:'1'
				},function(){
					$picli.eq($curnum).animate({ 
						opacity:'0'
					});
				});
				$numli.removeClass("cur");
				$numli.eq(picnum).addClass("cur");
				
			});

			obj.hover(function(){//清除计时器
				$next.show();
				$prev.show();
				clearInterval(turnimg);
			},function(){ 
				$next.hide();
				$prev.hide();
				turnimg = setInterval(tz,speed);
			});
		}else{ 
			$picli.css("opacity","1");
		}
		function tz(){
				picnum++;
				if(picnum >= imglen) picnum=0;
				play(picnum);
		}
		function play(picnum){//图片切换事件
			$numli.removeClass("cur");
			$numli.eq(picnum).addClass("cur");
			var $curnum = obj.find(".cur").index();
			if($curnum != 0){
				if(picnum == 1){
					$picli.eq(0).css("z-index","0");
					$picli.eq(0).animate({
						opacity:'0'
					});
				}else{ 
					$picli.eq($curnum-1).css("z-index","0");
					$picli.eq($curnum-1).animate({
						opacity:'0'
					});
				}
				$picli.eq(picnum).css("z-index","1").animate({ 
					opacity:'1'
				});
			}else{
				$picli.eq($picli.length-1).css("z-index","0");
				$picli.eq($picli.length-1).animate({ 
					opacity:'0'
				});
				$picli.eq(picnum).css("z-index","1").animate({ 
					opacity:'1'
				});
			}
			

		}

	}
})(jQuery);