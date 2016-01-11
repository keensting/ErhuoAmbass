<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/26
 * Time: 11:40
 */

interface product
{
    public function color();
    public function talk();
}
//abstract class test implements product{
//    public function color()
//    {
//        // TODO: Implement color() method.
//    }
//}
class black implements product{
    public function color()
    {
        echo 'black';
    }
    public function talk()
    {
        echo 'not know!';
    }
}


class yellow implements product{
    public function color()
    {
        echo 'yellow';
    }
    public function talk()
    {
        echo 'chinese!';
    }
}

class white implements product{
    public function color()
    {
        echo 'white';
    }
    public function talk()
    {
        echo 'english!';
    }
}

