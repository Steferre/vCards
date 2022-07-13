<?php
namespace App\Helpers;

class AppHelper
{
    public function suspended($stile)
    {    
        return $stile = "background-color: red;";
    }


    public static function instance()
    {
        return new AppHelper();
    }
}