<?php

class Widget extends CWidget
{
    public $labels = array();
    public $rights = array();

    //override constructor
    public function __construct($owner=null)
    {
        //get all labels from db
        $this->labels = Labels::model()->getLabels();

        //rights
        $this->rights = Yii::app()->user->GetState('rights');

        //call parent constructor
        parent::__construct($owner);
    }
}