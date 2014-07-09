<?php

class Label
{
    public static function Get($language=null)
    {
        

        $labels = array();    
        
       
        $connection = Yii::app()->labels;
        $sql="SELECT label, value FROM labels";
        $dataReader=$connection->createCommand($sql)->query();
        $dataReader->bindColumn(1,$label);
        // привязываем второе поле (email) к переменной $email
        $dataReader->bindColumn(2,$value);
        
        while($dataReader->read()!==false)
        {
            $labels[$label] = $value;   
        }
        
        return $labels;
    }
}