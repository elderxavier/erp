<?php

class ReportsController extends Controller
{
    public function GetSubMenu()
    {
        $arr = array(
            'all reports' => array('action' => 'list','visible' => $this->rights['categories_see'] ? 1 : 0 , 'class' => 'list-products'),
        );

        return $arr;
    }

    public function actionIndex()
    {
        $this->actionList();
    }

    public function actionList()
    {
        $this->renderText('reports');
    }
}