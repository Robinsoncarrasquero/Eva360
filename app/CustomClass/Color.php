<?php
namespace App\CustomClass;

class Color
{


    public function __construct()
    {

    }

    public function getBGColor()
    {
        $color=['maroon','red','yellow','blue','green','black','gray','purple','pink','green','orange','maroon','cyan','magenta'];
        $r=$color[rand(0,count($color)-1)];

        return $r;
    }

    public function getColor()
    {
        $color=['white','black','gray'];
        $r=$color[rand(0,0)];

        return   $r;
    }

}



?>
