<?php
/**
 * Created by PhpStorm.
 * User: KeenSting
 * Date: 2015/10/20
 * Time: 10:00
 */

class csv_analysis{
    protected $file_name;//csv文件名

    /**文件相对路径名，如./assert/test.csv
     * @param $file
     */
    function __construct($file)
    {
        $this->file_name=$file;
    }

    /**
     *启动函数，开始运行
     */
    function run(){
        return $this->handle_file();
    }

    /**
     *读取并解析csv，返回解析后的数组
     */
    protected function handle_file()
    {
        $list=array();//结果存储位置
        try{
            $file=fopen($this->file_name,'r') or die('文件打开失败！');
            while($v=fgetcsv($file))
            {
                $list[]=$v;
            }
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }

        return $list;
    }
}
//$demo=new csv_analysis('../assert/test.csv');
//$re=$demo->run();


