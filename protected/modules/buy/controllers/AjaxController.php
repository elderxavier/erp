<?php

class AjaxController extends Controller
{
    public function actionIndex()
    {
        $this->renderText('this is ajax');
    }

    public function actionMega()
    {
        $this->renderText('mega!');
    }
}