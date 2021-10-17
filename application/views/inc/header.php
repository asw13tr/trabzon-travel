<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php if(isset($pageTitle)){ echo $pageTitle; }else{ echo defined("PAGE_TITLE")? PAGE_TITLE : '•'; } ?></title>
  <meta name="description" content="<?php if(isset($pageDescription)){ echo $pageDescription; }else{ echo defined("PAGE_DESCRIPTION")? PAGE_DESCRIPTION : '•'; } ?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/foundation.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.fancybox.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dropzone/dropzone.min.css'); ?>">
  <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,300i,400,400i,600,700&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
<div id="maincontent">
