<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/25
 * Time: 21:43
 */
class Brand extends Admin_Controller{
    //显示品牌信息
    public function index(){
        $this->load->view('brand_list.html');
    }
    //显示添加品牌页面
    public function add(){
        $this->load->view('brand_add.html');
    }
    //显示编辑品牌页面
    public  function  edit(){
        $this->load->view('brand_edit.html');
    }
}