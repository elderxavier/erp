<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/index.css');
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.flot.js',CClientScript::POS_END);
$cs->registerScript('script_graph','    $(function() {
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
    };',CClientScript::POS_END);
?>



<div class="container-fluid main-content-holder">
    <div class="row wiidgets-holder">
        <div class="col-lg-6 col-md-6 wdgts wdg1"><div class="graph_1"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg2"><div class="graph_2"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg3"><div class="graph_3"></div></div>
        <div class="col-lg-6 col-md-6 wdgts wdg4"><div class="graph_4"></div></div>
    </div><!--/ row -->
</div><!--/container -->