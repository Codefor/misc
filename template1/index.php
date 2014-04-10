<?php

$dir = "-1";
if(isset($_GET['d'])){
    $dir = empty($_GET['d'])? $dir:$_GET['d'];
}

if(!is_dir("../logo/$dir")){
    $dir = 'default';
    $c = array(
        "urltitle"=>"STC",
        "title"=>"Social Talent Circle",
        "text"=>"May the social power be with you!",
        "logo"=>"suoluetu.png"
    );
}else{
    $c = array(
        "urltitle"=>file_get_contents("../logo/$dir/urltitle.txt"),
        "title"=>file_get_contents("../logo/$dir/title.txt"),
        "text"=>file_get_contents("../logo/$dir/text.txt"),
        "logo"=>file_get_contents("../logo/$dir/logo.txt"),
    );
}
$full_url =  sprintf("http://%s%s",$_SERVER['HTTP_HOST'],$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?=$c['urltitle']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<script type="text/javascript">
	var phoneWidth =  parseInt(window.screen.width);
	var phoneScale = phoneWidth/640;
	var ua = navigator.userAgent;
	if (/Android (\d+\.\d+)/.test(ua)){
		var version = parseFloat(RegExp.$1);
		if(version>2.3){
			document.write('<meta name="viewport" content="width=320, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
		}else{
			document.write('<meta name="viewport" content="width=320, target-densitydpi=device-dpi">');
		}
	} else {
		document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
	}
</script>
<!--移动端版本兼容 end -->
<script>SYS_SITE_ID = 136</script>
<style type="text/css">
html { width: 100%; height: 100%; }
body { overflow:hidden;margin:0 auto; width:100%; background:#fff; font-family:"微软雅黑";z-index:1;position:relative;}
*{ padding:0; margin:0;}
a{ text-decoration:none;}
.win{ 
	width:100%;
	position:relative; cursor:pointer;
	-webkit-perspective: 2000px;
	-moz-perspective: 2000px;
	-o-perspective: 2000px;
	-ms-perspective: 2000px;
	perspective: 2000px;
	-webkit-transform-style: preserve-3d;
	-moz-transform-style: preserve-3d;
	transform-style: preserve-3d;
	-webkit-transform:rotateX(0deg);
	-moz-transform:rotateX(0deg);
	-o-transform:rotateX(0deg);
	-ms-transform:rotateX(0deg);
}
.pscroll{
	width:100%;
	height:100%;
	position:absolute;
	left:0;
	top:0%;
	-webkit-transform-style: preserve-3d;
	-moz-transform-style: preserve-3d;
	-o-transform-style: preserve-3d;
	-ms-transform-style: preserve-3d;
	transform-style: preserve-3d;
	-webkit-transition: all 1s;
	-moz-transition: all 1s;
	-o-transition: all 1s;
	-ms-transition: all 1s;
	transition: all 1s;
	text-align:center;
	color:#396;
}
section{display:block;}
/* 声音提示 */
.audio_txt { position:fixed; top:59px; right:90px; height:60px; overflow:hidden; opacity:1;z-index:3000; 
	-webkit-transition: opacity 1s;
	-moz-transition: opacity 1s;
	-ms-transition: opacity 1s;
	-0-transition: opacity 1s;
	transition: opacity 1s;
}

/* 统一功能模块样式 fn- */
.fn-audio { position:fixed; top:45px; right:35px; z-index:3000;
	-webkit-transform:translateZ(3000px);
	-moz-transform:translateZ(3000px);
	-o-transform:translateZ(3000px);
	-ms-transform:translateZ(3000px);
	width:60px; height:61px; line-height:120px; text-align:center; }
.fn-audio .btn p { width:60px; height:61px; }
.fn-audio .btn p span { display:none; width: 60px; height: 61px; }
.fn-audio .btn p span:first-child { display:inline-block; }
.fn-audio .btn audio { height:0; width:0; opacity:0; }

/* 声音提示 */
.audio_txt { position:fixed; top:59px; right:90px; height:60px; overflow:hidden; opacity:1; z-index:3000; 
	-webkit-transition: opacity 1s;
	-moz-transition: opacity 1s;
	-ms-transition: opacity 1s;
	-0-transition: opacity 1s;
	transition: opacity 1s;
}
.audio_txt p { float:left; background:rgba(93,143,176,0.5); font-size:16px; color:#fff; font-weight:bold; }
.audio_txt p:first-child { padding:0 10px; height:40px; line-height:40px; border-bottom-left-radius:10px; border-top-left-radius:10px; }
.audio_txt p:last-child { 
	border-style: solid;
	border-width: 20px;
	border-color: transparent transparent transparent rgba(93,143,176,0.5);
	background:none;	
}
.audio_txt.close { opacity:0; }

.audio_open { background-position:-60px 0px; }
.btn_audio .audio_open{background-position-x:-60px;background-position-y:0px;}
.audio_close { background-position: 0 0; }

.css_sprite01 { background:url(sprite01.png) no-repeat; background-repeat: no-repeat; }

</style>
<script src="jquery-1.8.2.min.js"></script>
</head>
<body>
	<section class="win" id="win">
    <?php
         $files = scandir("../files/$dir");
         $config = array();
         for($i=0;$i<count($files);$i++){
            if($files[$i] === '.' || $files[$i] == '..'){
                continue;
            }
            $config[] = array($files[$i],False);
         }

         usort($config,function($a,$b){return (int)$a[0] > (int)$b[0] ? 1:-1;});
         $config[count($config)-1][1] = True;
    ?>
    <? foreach($config as $file){?>
        <?if($file[1]){?>
            <section class="pscroll" style="background:url(../files/<?=$dir?>/<?=$file[0]?>) center no-repeat;">
                <img id="register" style="position:absolute;left:40%;top:54%;" width="112px" height="31px" src="regbtn.png">
            </section>
        <?}else{?>
		    <section class="pscroll" style="background:url(../files/<?=$dir?>/<?=$file[0]?>) center no-repeat;"></section>
        <?}?>
    <?}?>
	</section>
	<div class="audio_txt close">
		<p class="txt">点击开启/关闭音效</p>
		<p></p>
	</div>
	<section id="fn_audio" class="fn-audio">
	<div class="btn">
		<p class="btn_audio"><span class="css_sprite01 audio_open"></span><span class="css_sprite01 audio_close"></span></p>
		<audio id="car_audio" controls="" preload="preload">
			<source src="bg.mp3" type="audio/mpeg" />
			您的浏览器不支持HTML5音频格式
		</audio>
	</div>
	</section>
</body>
</html>
<script>
	function E(f, e, o) {
		if (!e) e = 'load';
		if (!o) o = window;
		if (o.attachEvent) {
			o.attachEvent('on' + e, f)
		} else {
			o.addEventListener(e, f, false)
		}
	}
	function isMobile() {
		var isMobile = navigator.userAgent.match(/Android/i) 
			|| navigator.userAgent.match(/webOS/i) 
			|| navigator.userAgent.match(/iPhone/i) 
			|| navigator.userAgent.match(/iPad/i) 
			|| navigator.userAgent.match(/iPod/i) 
			|| navigator.userAgent.match(/BlackBerry/i) 
			|| navigator.userAgent.match(/Windows Phone/i);
		return isMobile ? true: false;
	}
	function getBroseType(){
		var dummyStyle = document.body.style;
		var vendors = 't,webkitT,MozT,msT,OT'.split(','),
		t,
		i = 0,
		l = vendors.length;
		var value = "";
		for ( ; i < l; i++ ) {
			t = vendors[i] + 'ransform';
			if ( t in dummyStyle ) {
				var kernel = vendors[i].substr(0, vendors[i].length - 1);
				if(kernel) value = kernel;
			}
		}
		return value.toLowerCase();
	}
	var isM = isMobile();
	var START = isM ? "touchstart": "mousedown";
	var MOVE = isM ? "touchmove": "mousemove";
	var END = isM ? "touchend": "mouseup";
	var pageW = 0;

	function init_pageH(){
		var fn_h = function() {
			if(document.compatMode == "BackCompat")
				var Node = document.body;
			else
				var Node = document.documentElement;
			 return Math.max(Node.scrollHeight,Node.clientHeight);
		}
		var fn_w = function() {
			if(document.compatMode == "BackCompat")
				var Node = document.body;
			else
				var Node = document.documentElement;
			 return Math.max(Node.scrollWidth,Node.clientWidth);
		}
		var page_h = fn_h();
		var page_w = fn_w();
		var m_h = $(".m-page").height();
		page_h >= m_h ? v_h = page_h : v_h = m_h ;

		pageW = page_w;

		//设置各种模块页面的高度，扩展到整个屏幕高度
		$(".win,.pscroll").css({"height":v_h});
	};
	init_pageH();
	var registerUrl = "http://115.29.144.55/index.php?g=Wap&m=Selfform&a=index&token=rkzvor1394369693&wecha_id=&id=25";

$(document).ready(function(){
	$("#car_audio")[0].play();
	audio_loop = true;
	var startX = 0, startY = 0;
	var win = $("#win")[0]; 
	if(!win) return;
	_w=window.screen.width;
	_popw=0;
	_left=0;
	_top=0;
	setTimeout(function() {
		window.scrollTo(0, 1)  
	}, 0);
	var len=$(".pscroll").length;
	var degree = 360/len;
	var halfdeg=degree/2;
	var tValue = 420;
	if(_w===480){
		tValue = 275;
		$("#register").css("left","36.6%")
	}
	if(_w>640){
		$("#register").css("left","46.6%")
	}
	zdegree=tValue/(Math.tan(2*Math.PI/360*halfdeg));
	$(".pscroll").each(function(i){
		$(this).css("-webkit-transform","rotateY("+(degree*i)+"deg) translateZ("+zdegree+"px)");
		$(this).css("-moz-transform","rotateY("+(degree*i)+"deg) translateZ("+zdegree+"px)");
		$(this).css("-o-transform","rotateY("+(degree*i)+"deg) translateZ("+zdegree+"px)");
		$(this).css("-ms-transform","rotateY("+(degree*i)+"deg) translateZ("+zdegree+"px)");
	});
	var n=0,to=1;
	function moveimg(to){
		n=to=='left'?n+degree:n-degree;
		$(".win section.pscroll").each(function(i){
			$(this).css("-webkit-transform","rotateY("+(degree*i+n)+"deg) translateZ("+zdegree+"px)");
			$(this).css("-moz-transform","rotateY("+(degree*i+n)+"deg) translateZ("+zdegree+"px)");
			$(this).css("-o-transform","rotateY("+(degree*i+n)+"deg) translateZ("+zdegree+"px)");
			$(this).css("-ms-transform","rotateY("+(degree*i+n)+"deg) translateZ("+zdegree+"px)");
		});
		/*
		var cValue = 0;
		var oldDegree = $(".win").attr("style");
		var degf = oldDegree.indexOf("rotateY(");
		var dege = oldDegree.indexOf("deg");
		if(degf!=-1 && dege!=-1){
			cValue = oldDegree.substring(degf+8,dege);
		}
		$(".win").css(kernel+"transform","rotateY("+(Number(cValue) + degree)+"deg)");
		*/
	}
	function touchSatrtFunc(evt) {
		window.start=true;
		var ex = evt || window.event;
		var target = ex.target || ex.srcElement;
		if(target.id==="register"){
			window.location.href = registerUrl;
		}
		else if($(target)===$("#fn_audio") || $(target).closest("#fn_audio").length){
			$(".fn-audio").find(".btn").trigger("click");
		}
		stopDefault(ex);
		try{
			var x = getXY(ex).x;
			startX = x;
		}catch (e) {}
	}
	function touchMoveFunc(evt) {
		if(!window.start) return;
		var ex = evt || window.event;
		stopDefault(ex);
		try{
			var x = getXY(ex).x;
			if(Math.abs(x-startX)>20){//防止误操作，参数100可调
				 if(x-startX>0){
				  	to=1;
				  }else{
				  	to=0;
				  }
				window.start=false;
			}
		}catch (e) {}
	}
	function getXY(e) {
		var x=0,y=0;
		if (isM) {
			var touch = e.touches[0];
			x = touch.clientX;
			y = touch.clientY;
		}
		else {
			x = e.pageX;
			y = e.pageY;
		}
		return {"x":x,"y":y};
	}
	function touchEndFunc(evt) {
		if(window.start) return;
		var ex = evt || window.event;
		stopDefault(ex);
		try {
			to?moveimg('left'):moveimg('right');
			$("#car_audio")[0].play();
		}catch (e) {}
		window.start=true;	
	}
	function stopDefault(e){
		e.preventDefault();
		e.stopPropagation();
	}
	var addevent=function(){
		E(touchSatrtFunc,START,win);
		E(touchMoveFunc,MOVE,win);
		E(touchEndFunc,END,win);
	}
	E(stopDefault,START);
	E(stopDefault,MOVE);
	E(stopDefault,END);
	addevent();
});

	var audio_switch_btn= true;			//声音开关控制值
	/*
	** 声音功能的控制
	*/
	var audio_switch_btn= true,			//声音开关控制值
	audio_btn		= true,			//声音播放完毕
	audio_loop		= false,		//声音循环
	audioTime		= null,         //声音播放延时
	audioTimeT		= null,			//记录上次播放时间
	audio_interval	= null,			//声音循环控制器
	audio_start		= null,			//声音加载完毕
	audio_stop		= null,			//声音是否在停止
	mousedown		= null;			//PC鼠标控制鼠标按下获取值

	function audio_close(){
		if(audio_btn&&audio_loop){
			audio_btn =false;
			audioTime = Number($("#car_audio")[0].duration-$("#car_audio")[0].currentTime)*1000;	
			if(audioTime<0){ audioTime=0; }
			if(audio_start){
				if(isNaN(audioTime)){
					audioTime = audioTimeT;
				}else{
					audioTime > audioTimeT ? audioTime = audioTime: audioTime = audioTimeT;
				}
			};
			if(!isNaN(audioTime)&&audioTime!=0){
				audio_btn =false;		
				setTimeout(
					function(){	
						$("#car_audio")[0].pause();
						$("#car_audio")[0].currentTime = 0;
						audio_btn = true;
						audio_start = true;	
						if(!isNaN(audioTime)&&audioTime>audioTimeT) audioTimeT = audioTime;
					},audioTime);
			}else{
				audio_interval = setInterval(function(){
					if(!isNaN($("#car_audio")[0].duration)){
						if($("#car_audio")[0].currentTime !=0 && $("#car_audio")[0].duration!=0 && $("#car_audio")[0].duration==$("#car_audio")[0].currentTime){
							$("#car_audio")[0].currentTime = 0;	
							$("#car_audio")[0].pause();
							clearInterval(audio_interval);
							audio_btn = true;
							audio_start = true;
							if(!isNaN(audioTime)&&audioTime>audioTimeT) audioTimeT = audioTime;
						}
					}
				},20)	
			}
		}
	}


	$(function(){
		//获取声音元件
		var btn_au = $(".fn-audio").find(".btn");

		//绑定点击事件
		btn_au.on('click',audio_switch);
		function audio_switch(){
			if($("#car_audio")==undefined){
				return;
			}
			if(audio_switch_btn){
				//关闭声音
				$("#car_audio")[0].pause();
				audio_switch_btn = false;
				//$("#car_audio")[0].currentTime = 0;
				btn_au.find("span").eq(0).css("display","none");
				btn_au.find("span").eq(1).css("display","inline-block");
			}
			//开启声音
			else{
				audio_switch_btn = true;
				btn_au.find("span").eq(1).css("display","none");
				btn_au.find("span").eq(0).css("display","inline-block");
			}
		}
	});

</script>

<script>
var dataForWeixin={
    appId:"",
	MsgImg:"http://demo.timepearls.com/logo/<?=$dir?>/<?=$c['logo']?>",
	TLImg:"http://demo.timepearls.com/logo/<?=$dir?>/<?=$c['logo']?>",
    	url:"<?=$full_url?>",
	title:"<?=$c['title']?>",
	desc:"<?=$c['text']?>",
	fakeid:"",
	callback:function(){
        //WeixinJSBridge.call("hideOptionMenu")
        //alert(dataForWeixin.url);
        //alert(dataForWeixin.MsgImg);
        //WeixinJSBridge.call("closeWindow")
    }
};
(function(){
	var onBridgeReady=function(){
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            WeixinJSBridge.invoke('sendAppMessage',{
                "appid":dataForWeixin.appId,
                    "img_url":dataForWeixin.MsgImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
            }, function(res){(dataForWeixin.callback)();});
        });
        WeixinJSBridge.on('menu:share:timeline', function(argv){
            (dataForWeixin.callback)();
            WeixinJSBridge.invoke('shareTimeline',{
                "img_url":dataForWeixin.TLImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
            }, function(res){});
        });
        WeixinJSBridge.on('menu:share:weibo', function(argv){
            WeixinJSBridge.invoke('shareWeibo',{
                "content":dataForWeixin.title,
                    "url":dataForWeixin.url
            }, function(res){(dataForWeixin.callback)();});
        });
        WeixinJSBridge.on('menu:shareacebook', function(argv){
            (dataForWeixin.callback)();
            WeixinJSBridge.invoke('shareFB',{
                "img_url":dataForWeixin.TLImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
            }, function(res){});
        });
    };
    if(document.addEventListener){
        document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
    }else if(document.attachEvent){
        document.attachEvent('WeixinJSBridgeReady'   , onBridgeReady);
        document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
    }
})();
</script>

