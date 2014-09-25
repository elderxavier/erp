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
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
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

                <?php $this->widget('application.widgets.PersonalSettings');?>

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

                <?php $this->widget('application.widgets.ActiveTasks');?>
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

<div class="dialog"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/task_checker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.flot.js"></script>

<script type="text/javascript">
    $(function() {
        var d2 = rndGen(20,5,15);
        var d3 = rndGen(40,-5,10);
        var d4 = rndGen(25,10,20);
        var d5 = rndGen(25,20,30);
        $.plot(".graph_1",[d2],{grid: {backgroundColor: { colors: [ "#77CAF0", "#eee" ] }}});
        $.plot(".graph_2",[d3],{grid: {backgroundColor: { colors: [ "#BDE9FF", "#eee" ] }}});
        $.plot(".graph_3",[d4],{grid: {backgroundColor: { colors: [ "#FFC6A5", "#eee" ] }}});
        $.plot(".graph_4",[d5,d4],{grid: {backgroundColor: { colors: [ "#FB8F73", "#eee" ] }}});
    });

    var rndGen = function(point_count,min,max)
    {
        var points = [];
        var x = 0;
        for(i=0;i < point_count; i++)
        {
            x += 10;
            y = Math.random() * (max - min) + min;
            points[i] = [x,y];
        }

        return points;
    };
</script>

</body>
</html>