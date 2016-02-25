<?php    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/2
 * Time: 19:00
 */
class Home_Controller extends  CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->switch_themes_on();
    }

}
//---------admin控制器
class Admin_Controller extends  CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->switch_themes_off();
        //权限验证
        if(!$this->session->userdata('admin')){
            redirect('admin/privilege/login');
        }
    }
}