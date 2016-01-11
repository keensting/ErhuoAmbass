<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/26
 * Time: 11:19
 */
require(dirname(__FILE__).'/product.php');
abstract class abs_factory{

    public abstract function create_human($type);

}



class human_factory extends abs_factory{
    public function create_human($type)
    {
        switch($type)
        {
            case 'yellow':
                return new yellow();
            case 'white':
                return new white();
            case 'black':
                return new black();
            default:
                return false;
        }
    }

}