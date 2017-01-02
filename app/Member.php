<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/20
 * Time: 22:22
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    public static function getMember() {
        return 'name is yfy';
    }
}