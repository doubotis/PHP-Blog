<?php

require_once '../src/constants.php';

if(isset($_FILES['upload'])){
  // ------ Process your file upload code -------
        $filen = $_FILES['upload']['tmp_name'];
        
        $pathInfo = pathinfo($_FILES['upload']['name']);
        $ext = $pathInfo["extension"];
        $finalName = md5($_FILES['upload']['name']) . '.' . $ext;
        $con_images = "upload/" . $finalName;
        move_uploaded_file($filen, $con_images );
        $url = DOMAIN_NAME . WEBAPP_WEBSITE_URL . $con_images;

   $funcNum = $_GET['CKEditorFuncNum'] ;
   // Optional: instance name (might be used to load a specific configuration file or anything else).
   $CKEditor = $_GET['CKEditor'] ;
   // Optional: might be used to provide localized messages.
   $langCode = $_GET['langCode'] ;
    
   // Usually you will only assign something here if the file could not be uploaded.
   $message = '';
   echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}

?>