<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 21:28
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    //指定表名
    protected $table = 'student';
    //指定主键
    protected $primarykey = 'id';

    //获取时间戳，开启
    public $timestamps = true;

    //批量增加字段数据
    protected $fillable = ['name','age'];

    protected function getDateFormat() {
        return time();
    }

    protected function asDateTime($value)
    {
       return $value;
    }
}