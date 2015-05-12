<?php 

  require(dirname(__FILE__) .'/vendor/ircmaxell/password-compat/lib/password.php');
  require(dirname(__FILE__). '/mandrill.conf.php');
  require(dirname(__FILE__). '/firebase.conf.php');
  require(dirname(__FILE__). '/functions.php');
  
?>
<!DOCTYPE html>
  <head>  
    <title>Please Register for ROI-DNA</title>
    <link rel="stylesheet" href="/bower_components/foundation/css/foundation.min.css">
    <link rel="stylesheet" href="/bower_components/foundation/css/normalize.min.css">
    <link rel="stylesheet" href="/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="/css/custom.css">
  </head>
  <body>
    <header>
      <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
          <li class="name">
            <h1><a href="#">Register for ROI-DNA</a></h1>
          </li>
        </ul>
      </nav>
    </header>
    <div class="row">
      <section class="main small-6 small-centered columns">
        <img class="animated fadeInDown logo" src="http://www.roidna.com/wordpress/wp-content/themes/roidna/imgs/logo-white.svg">
