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

<!DOCTYPE html>
<html lang="ch"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!--
	<link rel="apple-touch-icon" sizes="57x57" href="./userfiles/qrcode/136/341/logo/57_57/52ac4d82a4fa7.1.jpg">
	<link rel="apple-touch-icon" sizes="72x72" href="./userfiles/qrcode/136/341/logo/72_72/52ac4d82a4fa7.1.jpg">
	<link data-logo="" rel="apple-touch-icon" sizes="114x114" href="./userfiles/qrcode/136/341/logo/114_114/52ac4d82a4fa7.1.jpg">  
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="-1">
	-->
	<title><?=$c['urltitle']?></title>
	<link rel="stylesheet" type="text/css" href="./userfiles/main.css">
	<!--浏览器兼容HTML5标签-->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="/js/admin/common/html5.js"></script>
	<![endif]-->
	<!--移动端版本兼容 -->
	<script type="text/javascript">
		var phoneWidth =  parseInt(window.screen.width);
		var phoneScale = phoneWidth/640;
		var ua = navigator.userAgent;
		if (/Android (\d+\.\d+)/.test(ua)){
			var version = parseFloat(RegExp.$1);
			if(version>2.3){
				document.write('<meta name="viewport" content="width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
			}else{
				document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
			}
		} else {
			document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
		}
	</script><meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
	<!--移动端版本兼容 end -->
	<script>SYS_SITE_ID = 136</script>
</head>
<body>
<input type="hidden" value="341" id="activeId">
<section class="p-index" >
	<!--fn-声音提示 -->
	<div class="audio_txt close">
		<p class="txt">点击开启/关闭音效</p>
		<p></p>
	</div>
	<!--fn-声音提示 end-->
	<!--fn-声音显示 -->
	<section class="fn-audio">
	<div class="btn">
		<p class="btn_audio"><span class="css_sprite01 audio_open"></span><span class="css_sprite01 audio_close"></span></p>
		<audio id="car_audio" controls="" preload="preload">
			<source src="./userfiles/bg.mp3" type="audio/mpeg" />
			您的浏览器不支持HTML5音频格式
		</audio>
	</div>
	</section>
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
         $index=0;
    ?>

    <? foreach($config as $file){$index++;?>
        <?if($file[1]){?>
        <section data-page="<?=$index?>" class="m-page m-page<?=$index?>" data-type="info_nomore">
            <div class="m-img m-img0<?$index?>" data-bk="" style="background:url(../files/<?=$dir?>/<?=$file[0]?>) center no-repeat; background-size:cover;">
                <a class="register" style="position:absolute;margin-left:24%;top:61%;" href="http://mp.weixin.qq.com/s?__biz=MzA5NTM1NTUyNw==&mid=200175183&idx=1&sn=bd3c0b798a219cad509862c285418ce2#rd">
                    <img width="340px" height="80px" src="./userfiles/regbtn.png">
                </a>
            </div>
        </section>
        <?}else{?>
        <section data-page="<?=$index?>" class="m-page m-page<?=$index?>" data-type="info-nomore">
            <div class="m-img m-img0<?$index?>" data-bk="" style="background:url(../files/<?=$dir?>/<?=$file[0]?>) center no-repeat; background-size:cover;">
            </div>
        </section>
        <?}?>
    <?}?>
	<section class="pageLoading">
		<img src="./userfiles/load.gif" alt="loading">
	</section>
	<!--脚本加载-->
	<script type="text/javascript" src="./userfiles/html5.js"></script>
	<script type="text/javascript" src="./userfiles/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="./userfiles/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="./userfiles/yl3d.js"></script>
	<script type="text/javascript" src="./userfiles/main.js"></script>
	<!--脚本加载 end-->
</section>
</body>
<script>
var dataForWeixin={
    appId:"",
	MsgImg:"http://demo.timepearls.com/logo/<?=$dir?>/<?=$c['logo']?>",
	TLImg:"http://demo.timepearls.com/logo/<?=$dir?>/<?=$c['logo']?>",
    	url:"<?=$full_url?>",
	title:"<?=$c['title']?>",
	desc:"<?=$c['text']?>",
	fakeid:"",
	callback:function(){}
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
</html>
