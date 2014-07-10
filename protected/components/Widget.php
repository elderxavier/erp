<?php

class Widget extends CWidget
{
    public $labels = array();

    //override constructor
    public function __construct($owner=null)
    {
        //get all labels from db
        $this->labels = Labels::model()->getLabels();

        //call parent constructor
        parent::__construct($owner);
    }
}