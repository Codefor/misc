<?php
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'])){
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sec_file = sprintf("./logo/%s.txt",md5($username));
if(file_exists($sec_file)){
    $dir = file_get_contents($sec_file);
}else{
    $dir = uniqid("c_",True); 
    file_put_contents($sec_file,$dir);
}
$_SESSION['dir'] = $dir;


if(isset($_POST['wxsubmit'])){
    $urltitle = $_POST['exampleUrlTitle'];
    $title = $_POST['exampleTitle'];
    $text = $_POST['exampleText'];

    if(isset($_FILES['exampleLogo'])){
        $logo = "";
        $f = $_FILES['exampleLogo'];
        if(is_uploaded_file($f['tmp_name'])){
            $md5sum = md5($f['tmp_name']);
            list(,$ext)  = explode(".",$f['name']);
            $logo = sprintf("%s.%s",$md5sum,$ext); 
            mkdir("./logo/$dir",0777);
            move_uploaded_file($f['tmp_name'],"./logo/$dir/$logo");
            file_put_contents("./logo/$dir/logo.txt",$logo);
        }
    }
    
    file_put_contents("./logo/$dir/urltitle.txt",$urltitle);
    file_put_contents("./logo/$dir/title.txt",$title);
    file_put_contents("./logo/$dir/text.txt",$text);
}

$old_url_title = file_get_contents("./logo/$dir/urltitle.txt");
$old_title = file_get_contents("./logo/$dir/title.txt");
$old_text = file_get_contents("./logo/$dir/text.txt");
$old_logo = file_get_contents("./logo/$dir/logo.txt");

if($old_logo != False){
    $old_logo_url = sprintf("logo/%s/%s",$dir, $old_logo);
}

?><!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin  6.9.1
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<meta charset="utf-8">
<title >STC 宣传页 在线模板生成</title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bar and preview images for jQuery. Supports cross-domain, chunked and resumable file uploads. Works with any server-side platform (Google App Engine, PHP, Python, Ruby on Rails, Java, etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width">
<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>

<div class="container">
    <div class="page-header">
        <a href="http://nowstc.com/">BACK TO STC</a> | 
        欢迎你，<?=$username?>! | <a href="logout.php">登出</a>
        <h1>在线宣传页生成工具</h1>
    </div>
    <blockquote>
        <p>在线宣传页生成工具<br>
		1、选择微信转发文案及转发logo<br>
		2、选择你要添加的图片，建议3~5张<br>
		点击上传即可</p>
    </blockquote>
    <br>
    <form role="form" class="span7" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="exampleUrlTitle">网页title</label>
        <input type="text" class="form-control input-lg" id="exampleUrlTitle" name="exampleUrlTitle" value="<?=$old_url_title?>">
      </div>

      <div class="form-group">
        <label for="exampleTitle">微信转发title</label>
        <input type="text" class="form-control input-lg" id="exampleTitle" name="exampleTitle" value="<?=$old_title?>">
      </div>
      <div class="form-group">
        <label for="exampleText">微信转发简介文案</label>
        <textarea class="form-control" rows="3" id="exampleText" name="exampleText" ><?=$old_text?></textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputFile">微信"转发"logo</label>
        <input type="file" id="exampleLogo" name="exampleLogo">
        <?php
        if(isset($old_logo_url)){
            echo sprintf('<img src="%s"></img>',$old_logo_url);
        }
        ?>
        <p class="help-block">用于微信转发按钮</p>
      </div>
      <button type="submit" name="wxsubmit" class="btn btn-primary">提交微信配置</button>
    <br>
    </form>
    <!-- The file upload form used as target for the file upload widget -->
  <form id="fileupload" action="upload.php" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                
            </div>
            <div class="span7">
            <br>
            <br>
            <p class="help-block">下面为页面图片上传</p>
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>增加文件</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>开始上传</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>取消上传</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>删除文件</span>
                </button>
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <br>
        <a target='blank' href='template1?d=<?=$dir?>'>template1</a> | <a target='blank' href='template2?d=<?=$dir?>'>template2</a>
        <br>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped">
            <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
        </table>   
</div>
<div>

</div>
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="index"><span class="fade">{%=i%}</span></td>
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
<script src="js/jquery/1.7.2/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="js/locale.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
</body> 
</html>

