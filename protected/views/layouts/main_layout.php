<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet" type="text/css">
    <title><?php echo $this->site_title." - ".$this->page_title ?></title>
</head>

<body>
<div class="head_navs">
    <div class="container-fluid">
        <div class="row head_navs-holder">
            <div class="logo col-xs-4  col-sm-3 col-md-2">
                <a href="/"><img class="pull-left" src="/images/logo.png" width="25" height="25"><span>Olivia<span>version: 0000</small></span></a>
            </div><!--/LOGO -->
            <div class="actions col-xs-8 col-sm-8 col-md-7 pull-right">
                <div class="login pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span>Dmitrij Hitrov</span> <img src="/images/user_thumb.jpg" width="40" height="40">
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a class="logout" href="#"><span class="login-actions pull-left">Atsijungti</span><span class="icon pull-right"></span></a></li>
                            <li><a class="user-edit" href="#"><span class="login-actions pull-left">duomenys</span><span class="icon pull-right"></span></a></li>
                            <li><a class="user-options" href="#"><span class="login-actions pull-left">Parinktys</span><span class=" icon pull-right"></span></a></li>
                        </ul>
                    </div><!--/btn-group -->
                </div><!--/login -->

                <div class="lang_selector pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            LT
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">RU</a></li>
                            <li><a href="#">LT</a></li>
                        </ul>
                    </div><!--/btn-group -->

                </div><!--/lang_selector -->

                <div class="active_task pull-right">
                    <a href="#"><span class="badge pull-right">88</span><span class="hidden-xs">Aktyvios užduotys</span></a>
                </div><!--/active -->
            </div><!--/actions -->
        </div><!-- /row -->
    </div><!--/contaier -->
</div><!-- head_navs -->

<div class="after_head_navs clearfix">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid main-nav-holder">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!--/navbar-header -->

            <?php $this->widget('application.widgets.MainMenu');?>

        </div><!--/container -->
    </nav>
</div><!-- afetr_head_navs -->

<div class="main_container">
    <?php echo $content; ?>
</div><!--/ main-container -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
</body>
</html>