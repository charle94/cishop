<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/2
 * Time: 18:52
 */
class MY_Loader extends  CI_Loader{
    protected $_themes  =  'default/';
    public function switch_themes_on(){
        $this->_ci_view_paths = array(THEMES_DIR.$this->_themes	=> TRUE);
    }
    public function switch_themes_off(){
        //不做更改
    }
}