<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/index.css');
?>

<div class="container-fluid main-content-holder">
    <div class="row wiidgets-holder">
        <div class="col-lg-6 col-md-6 wdgts wdg1"><div class="graph_1"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg2"><div class="graph_2"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg3"><div class="graph_3"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg4"><div class="graph_4"></div></div>
    </div><!--/ row -->
</div><!--/container -->