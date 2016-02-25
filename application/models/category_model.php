<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/4
 * Time: 17:16
 * 商品类别模型
 */
class Category_model extends CI_Model{
    const  TBL_CATE  = "category";
    /*
     * @access public
     * @param $pid 节点id
     * @return array 返回该节点所有后代节点
     */
    public function list_cate($pid = 0){
        //获取所有记录
        $query = $this->db->get(self::TBL_CATE);
        $cates = $query->result_array();
        //对类别重组 并返回
        return $this->_tree($cates,$pid);


    }
    /*
     * @access public
     * @param $data array 传入数组
     * @return bool TRUE或者flase
     * */
    public function insert_cate($data){
        return $this->db->insert(self::TBL_CATE, $data);
    }

    /*
     * @access private
     * @param $arr 要遍历的数组
     * @param $pid 节点pid 默认为零
     * @return arr 排好序的后代节点
     * */
    private function  _tree($arr,$pid=0,$level=0){
        static  $tree = array();//注意使用静态数组
        foreach($arr as $v){
            if($v['parent_id']==$pid){
                //说明找到子节点
                $v['level'] = $level;
                $tree[] = $v;
                //以该节点为父节点找其后代节点
                $this->_tree($arr,$v['cat_id'],$level+1);
            }
        }
        return $tree;
    }
//---------------------------------------------END-------------------------------------------------------------

//---------------------------------------------BEGIN-----------------------------------------------------------
    /*
     * @access public
     * @param $cat_id
     * @return array二维数组
     * */
    public  function get_cate($cat_id){
        $query = $this->db->get_where(self::TBL_CATE, array('cat_id' => $cat_id));
        return $query->result_array();

    }
    /*
     *
     * */
    public function update_cate($id,$data){
        $this->db->where('cat_id', $id);
        return  $this->db->update(self::TBL_CATE, $data);

    }
//--------------------------------------------END---------------------------------------------------------------
/*
 * access public
 * @param $cat_id
 * @return bool
 * */
    public function delete_cate($cat_id){
        return $this->db->delete(self::TBL_CATE,array('cat_id' => $cat_id));
    }



}