<?php
use Updater\Config\Constant;
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=6.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
      <?php
        if ( !empty($page_title) && !is_null($page_title)) {
          echo $page_title;
        } else {
          echo 'MSN Toolkit';
        }
      ?>
    </title>
    <link rel="preload" as="style" href="<?php echo Constant::PUBLIC_CSS_URL?>bootstrap-reboot-rtl.css"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?php echo Constant::PUBLIC_CSS_URL?>bootstrap-reboot-rtl.css">
    </noscript>
    <link rel="preload" as="style" href="<?php echo Constant::PUBLIC_CSS_URL?>bootstrap-rtl.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?php echo Constant::PUBLIC_CSS_URL?>bootstrap-rtl.css">
    </noscript>
    <link rel="preload" as="style" href="<?php echo Constant::PUBLIC_CSS_URL?>custom.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?php echo Constant::PUBLIC_CSS_URL?>custom.css">
    </noscript>
    <link rel="icon" href="<?php echo Constant::PUBLIC_IMAGES_URL?>favicon.ico" type="image/x-icon"/>
    <link rel="preload" href="<?php echo Constant::FONTS_URL ?>Vazir.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" as="script" href="https://code.jquery.com/jquery-3.5.1.slim.min.js">
    <link rel="preload" as="script" href="<?php echo Constant::PUBLIC_JS_URL?>bootstrap.bundle.js">
    <link rel="preload" as="script" href="<?php echo Constant::PUBLIC_JS_URL?>custom.js">
    <link rel="preload" as="script" href="https://kit.fontawesome.com/f0c97a4a4d.js">

</head>
<body>
