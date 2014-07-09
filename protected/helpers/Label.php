<?php

class Label
{
    public static function Get($label)
    {
        /* @var $labelObj Labels */

        //value is label by default
        $value = $label;

        //try find label in db
        $labelObj = Labels::model()->findByAttributes(array('label' => $label));

        //if found something
        if(!empty($labelObj))
        {
            //get value from object
            $value = $labelObj->value;
        }

        //return value
        return $value;
    }
}