<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/28
 * Time: 13:38
 */
class Attribute_model extends CI_Model{

    const TBL_ATTR = 'attribute';

    public function add_attrs($data){
        return $this->db->insert(self::TBL_ATTR,$data);
    }
}