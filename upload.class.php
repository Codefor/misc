<?php
session_start();
/*
 * jQuery File Upload Plugin PHP Class 5.11.2
 */
class SaeStorage{
    public function getUrl($domain,$filename){
        return sprintf("http://demo.timepearls.com/files/%s/%s",$_SESSION['dir'],$filename);
    }

    public function write($domain,$file,$uploaded_file){
        $d = sprintf("./files/%s",$_SESSION['dir']);
        if(!is_dir($d)){
            mkdir($d,0777);
        }

        move_uploaded_file($uploaded_file,$d.'/'.$file->delete_hash);
        //resize
        //$this->resize($file,$uploaded_file);

        return sprintf("http://demo.timepearls.com/files/%s/%s",$_SESSION['dir'],$file->delete_hash);
    }

    public function resize($file,$uploaded_file){
        if(!file_exists($uploaded_file)){
            return;
        }

        list($width, $height) = getimagesize($uploaded_file);
        $newwidth = 640;
        $newheight = 1016;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $methodin = sprintf("imagecreatefrom%s",$file->ext);
        $img = $methodin($uploaded_file);
        if($img){
            // Resize
            if(imagecopyresized($thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height)){
                $methodout = sprintf("image%s",$file->ext);
                ob_start();
                $methodout($thumb);
                $data = ob_get_contents();
                ob_end_clean();

                imagedestroy($img);
                imagedestroy($thumb);

                $target_path = "./files/".$file->delete_hash;
                file_put_contents($target_path,$data);
            }
        }
    }
}

class UploadHandler
{
    protected $options;
    protected $storage;
    protected $index;

    function __construct($options=null) {
        $this->index = 0;
        $this->storage = new SaeStorage();
        $this->storage_domain = "danglab";
        $this->options = array(
            'script_url' => $this->getFullUrl().'/',
            'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/'.$_SESSION['dir'].'/',
            'upload_url' => $this->getFullUrl().'/files/'.$_SESSION['dir'].'/',
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            // The maximum number of files for the upload directory:
            'max_number_of_files' => null,
            // Image resolution restrictions:
            'max_width' => null,
            'max_height' => null,
            'min_width' => 1,
            'min_height' => 1,
            // Set the following option to false to enable resumable uploads:
            'discard_aborted_uploads' => false,
            // Set to true to rotate images based on EXIF meta data, if available:
            'orient_image' => false,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                'large' => array(
                    'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/files/',
                    'upload_url' => $this->getFullUrl().'/files/',
                    'max_width' => 1920,
                    'max_height' => 1200,
                    'jpeg_quality' => 95
                ),
                 */
                'thumbnail' => array(
                    'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/thumbnails/',
                    'upload_url' => $this->getFullUrl().'/thumbnails/',
                    'max_width' => 80,
                    'max_height' => 80
                )
            )
        );
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }

    protected function getFullUrl() {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
            ($https && $_SERVER['SERVER_PORT'] === 443 ||
            $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }

    protected function set_file_delete_url($file) {
        $file->delete_url = $this->options['script_url']
            .'/upload.php?file='.rawurlencode($file->delete_hash);
        $file->delete_type = $this->options['delete_type'];
        if ($file->delete_type !== 'DELETE') {
            $file->delete_url .= '&_method=DELETE';
        }
    }

    protected function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'].$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'].rawurlencode($file->name);
            foreach($this->options['image_versions'] as $version => $options) {
                if (is_file($options['upload_dir'].$file_name)) {
                    $file->{$version.'_url'} = $options['upload_url']
                        .rawurlencode($file->name);
                }
            }
            //$this->set_file_delete_url($file);
            $file->delete_url = $this->options['script_url']
            .'/upload.php?file='.rawurlencode($file->name);
            return $file;
        }
        return null;
    }

    protected function get_file_objects() {
        return array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            scandir($this->options['upload_dir'])
        )));
    }

    protected function create_scaled_image($file_name, $options) {
        $file_path = $this->storage->getUrl($this->storage_domain,$file_name);
        //$file_path = $this->options['upload_dir'].$file_name;
        $new_file_path = $options['upload_dir'].$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
        case 'jpg':
        case 'jpeg':
            $src_img = @imagecreatefromjpeg($file_path);
            $write_image = 'imagejpeg';
            $image_quality = isset($options['jpeg_quality']) ?
                $options['jpeg_quality'] : 75;
            break;
        case 'gif':
            @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
            $src_img = @imagecreatefromgif($file_path);
            $write_image = 'imagegif';
            $image_quality = null;
            break;
        case 'png':
            @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
            @imagealphablending($new_img, false);
            @imagesavealpha($new_img, true);
            $src_img = @imagecreatefrompng($file_path);
            $write_image = 'imagepng';
            $image_quality = isset($options['png_quality']) ?
                $options['png_quality'] : 9;
            break;
        default:
            $src_img = null;
        }
        $success = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }

    protected function validate($uploaded_file, $file, $error, $index) {
        if ($error) {
            $file->error = $error;
            return false;
        }
        if (!$file->name) {
            $file->error = 'missingFileName';
            return false;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            $file->error = 'acceptFileTypes';
            return false;
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
            $file_size > $this->options['max_file_size'] ||
            $file->size > $this->options['max_file_size'])
        ) {
            $file->error = 'maxFileSize';
            return false;
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
                $file->error = 'minFileSize';
                return false;
            }
        if (is_int($this->options['max_number_of_files']) && (
            count($this->get_file_objects()) >= $this->options['max_number_of_files'])
        ) {
            $file->error = 'maxNumberOfFiles';
            return false;
        }
        list($img_width, $img_height) = @getimagesize($uploaded_file);
        if (is_int($img_width)) {
            if ($this->options['max_width'] && $img_width > $this->options['max_width'] ||
                $this->options['max_height'] && $img_height > $this->options['max_height']) {
                    $file->error = 'maxResolution';
                    return false;
                }
            if ($this->options['min_width'] && $img_width < $this->options['min_width'] ||
                $this->options['min_height'] && $img_height < $this->options['min_height']) {
                    $file->error = 'minResolution';
                    return false;
                }
        }
        return true;
    }

    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }

    protected function upcount_name($name) {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcount_name_callback'),
            $name,
            1
        );
    }

    protected function trim_file_name($name, $type, $index) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
                $file_name .= '.'.$matches[1];
            }
        if ($this->options['discard_aborted_uploads']) {
            while(is_file($this->options['upload_dir'].$file_name)) {
                $file_name = $this->upcount_name($file_name);
            }
        }
        return $file_name;
    }

    protected function handle_form_data($file, $index) {
        // Handle form data, e.g. $_REQUEST['description'][$index]
    }

    protected function orient_image($file_path) {
        $exif = @exif_read_data($file_path);
        if ($exif === false) {
            return false;
        }
        $orientation = intval(@$exif['Orientation']);
        if (!in_array($orientation, array(3, 6, 8))) {
            return false;
        }
        $image = @imagecreatefromjpeg($file_path);
        switch ($orientation) {
        case 3:
            $image = @imagerotate($image, 180, 0);
            break;
        case 6:
            $image = @imagerotate($image, 270, 0);
            break;
        case 8:
            $image = @imagerotate($image, 90, 0);
            break;
        default:
            return false;
        }
        $success = imagejpeg($image, $file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($image);
        return $success;
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type, $index);
        list(,$file->ext)  = explode(".",$file->name);
        $file->size = intval($size);
        $file->type = $type;
        if ($this->validate($uploaded_file, $file, $error, $index)) {
            $this->handle_form_data($file, $index);
            $file_path = $this->options['upload_dir'].$file->name;
            $append_file = !$this->options['discard_aborted_uploads'] &&
                is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    $file->ext = $file->ext == "jpg" ? "jpeg":$file->ext;
                    if(in_array($file->ext,array("jpeg","png","gif"))){
                        $file->delete_hash = sprintf("%s_%s.%s",$_SESSION['index'],md5(date("Ymd").$file->name),$file->ext);
                        $file->url = $this->storage->write($this->storage_domain, $file, $uploaded_file);
                    }
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen('php://input', 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_path = $uploaded_file;
            $file_size = filesize($file_path);
            if ($file_size === $file->size) {
                if ($this->options['orient_image']) {
                    $this->orient_image($file_path);
                }
                //$file->url = $this->options['upload_url'].rawurlencode($file->name);
                /**foreach($this->options['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $options)) {
                        if ($this->options['upload_dir'] !== $options['upload_dir']) {
                            $file->{$version.'_url'} = $options['upload_url']
                                .rawurlencode($file->name);
                        } else {
                            clearstatcache();
                            $file_size = filesize($file_path);
                        }
                    }
                }*/
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
            $this->set_file_delete_url($file);
        }
        return $file;
    }

    public function get() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        usort($info,function($a,$b){return (int)$a->name > (int)$b->name ? 1:-1;});
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function post() {

        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete();
        }
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : null;
        $info = array();
        if ($upload && is_array($upload['tmp_name'])) {
            // param_name is an array identifier like "files[]",
            // $_FILES is a multi-dimensional array:
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index],
                    $index
                );
            }
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            // param_name is a single object identifier like "file",
            // $_FILES is a one-dimensional array:
            $info[] = $this->handle_file_upload(
                isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                $upload['name'] : null),
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                $upload['size'] : null),
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                $upload['type'] : null),
                isset($upload['error']) ? $upload['error'] : null
            );
        }
        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
            stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: '.sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
                header('Content-type: application/json');
            } else {
                header('Content-type: text/plain');
            }
        echo $json;

    }

    public function delete() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        //$success = $this->storage->delete($this->storage_domain,$file_name);
        $file_path = $this->options['upload_dir'].$file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'].$file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }

}

