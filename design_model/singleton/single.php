<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/11/25
 * Time: 23:13
 */
//error_reporting(3);
class Single{
    protected static $_single;

    protected function __construct()
    {
        echo '该对象禁止外部实例化！';
    }

    public function __clone()
    {
        trigger_error('该对象拒绝被克隆！',E_USER_NOTICE);
    }

    public static function getInstance()
    {
        if(!(self::$_single instanceof self))
        {
            echo 'ok';
            self::$_single=new self;
        }
        return self::$_single;

    }

    public function run()
    {
        echo '不服来打我啊！';
    }



}
//class Danli {
//
////保存类实例的静态成员变量
//    private static $_instance;
//
////private标记的构造方法
//    private function __construct(){
//        echo 'This is a Constructed method;';
//    }
//
////创建__clone方法防止对象被复制克隆
//    public function __clone(){
//        trigger_error('Clone is not allow!',E_USER_ERROR);
//    }
//
////单例方法,用于访问实例的公共的静态方法
//    public static function getInstance(){
//        if(!(self::$_instance instanceof self)){
//            self::$_instance = new self;
//        }
//        return self::$_instance;
//    }
//
//    public function test(){
//        echo '调用方法成功';
//    }
//
//}
