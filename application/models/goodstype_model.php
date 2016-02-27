<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/27
 * Time: 10:28
 */
class Goodstype_model extends CI_Model{
    const TBL_GT = 'goods_type';

    //插入商品类型
    public  function add_goodstype($data){
        return $this->db->insert(self::TBL_GT,$data);
    }
    //获取商品类型
    public function list_goodstype($limit,$offset){
        //获取分页数据
        $query = $this->db->limit($limit,$offset)->get(self::TBL_GT);
        //第一个为记录数第二个参数为偏移量
        return $query->result_array();
    }
    //统计商品类型总数
    public function count_goodstype(){
        return $this->db->count_all(self::TBL_GT);
    }
}