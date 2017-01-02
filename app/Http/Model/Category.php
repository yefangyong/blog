<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

    class Category extends Model {
        protected $table='category';
        protected $primaryKey='cate_id';
        public $timestamps = false;
        //用create方法，需要指明不能插入的字段明
        protected $guarded = [];

    ////第一种方法，写成静态方法，直接调用
    //public static function tree() {
    //    $category = Category::all();
    //    return (new Category())->gettree($category,'cate_name','cate_id','cate_pid');
    //}
    //第二种方法，不写成静态方法
    public function tree() {
        $category = $this->orderBy('cate_order','asc')->get();
        return $this->gettree($category,'cate_name','cate_id','cate_pid');
    }


    //处理数据，二级分类，pid,id,递归方法,通过传参，构造方法。封装,移植性较好
    public function gettree($data,$file_name,$file_id,$file_pid,$pid=0)
    {
        $arr = array();
        foreach ($data as $k => $v) {
            if ($v->$file_pid == $pid) {
                $data[$k]['_'.$file_name] = $data[$k][$file_name];
                $arr[] = $data[$k];
                foreach ($data as $m => $n) {
                    if($n->$file_pid == $v->$file_id){
                        $data[$m]['_'.$file_name] = '├─ ' . $data[$m][$file_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}