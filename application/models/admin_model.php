<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/4
 * Time: 10:02
 */
class Admin_model extends CI_Model{
    const TBL   =   "admin";
    /*
     * @access public
     * return array 查询结果
     * */
    public function get_admin($name){
        $query  =    $this->db->get_where(self::TBL, array('admin_name' => $name));
        return  $query->result_array();
    }
}
