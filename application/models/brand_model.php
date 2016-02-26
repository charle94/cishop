<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/26
 * Time: 20:10
 */
class Brand_model extends CI_Model{
    const TBL_BRAND = 'brand';
    //添加商品品牌
    public  function add_brand($data){
        return $this->db->insert(self::TBL_BRAND,$data);
    }
    //获取商品品牌
    public  function list_brand(){
        $query = $this->db->get(self::TBL_BRAND);
        return $query->result_array();
    }
}