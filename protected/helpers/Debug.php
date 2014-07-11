<?php

/*
 * Just used to debug some info. There is also option display debugged info only for specific IPs
 */

class Debug
{
    //who can see debugged info
    private static $arrIps = array(
        '127.0.0.1',
        '::1',
    );

    //debugs variable

    /**
     * @param $var
     * @param string $title
     */
    public static function out($var, $title = '')
    {
        //if current ip exist in available ips array
        if(in_array($_SERVER["REMOTE_ADDR"],self::$arrIps))
        {
            //debug
            ob_start();
            if( $title )
                echo "$title\n";
            print_r($var);
            $out = ob_get_clean();
            echo "<pre>";
            echo htmlentities($out);
            echo "</pre>";
        }

    }
    
    
    /**
     * Функция отладки
     * 
     * @param $value параметр что отлаживаем
     */
    public static function d($value = null,$die = 1){
        echo 'Debug: <br/><pre>';
        print_r($value);
        echo '</pre>';
        
        if($die)
            die;
    } 

}

?>