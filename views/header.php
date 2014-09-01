<!DOCTYPE html>
<html>
 <head>
    <title>FX-trend pamm analyzer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/public/css/general.css" type="text/css">
    <link href="/public/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/amcharts.js"></script>
 </head>
 <body style="padding-top: 100px;">

  <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="/" class="navbar-brand">Главная</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="/pamm/" >ПАММ Счета</a>
            </li>
            <li>
              <a href="/blog/">Blog</a>
            </li> 
            <li>
              <a href="/help/">Help</a>
            </li>
  
          </ul>
        </div>
      </div>
    </div>
<div class="container">
  <?if($this->flash_messages){ ?> 
    <? foreach ($this->flash_messages as $mess) { ?>
      <?=$mess;?>
    <?}?>     
<?}?>