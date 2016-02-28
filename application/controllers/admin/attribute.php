<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/28
 * Time: 11:53
 */
class Attribute extends Admin_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
        $this->load->library('form_validation');
    }
    const TBL_ATTR = 'attribute';
    public function index(){
        $this->load->view('attribute_list.html');
    }
    public function add(){
        //获取商品类型
        $goodstypes = $this->goodstype_model-> get_goodstype();
        $data['goodstypes'] = $goodstypes;
        $this->load->view('attribute_add.html',$data);
    }
    public function edit(){
        $this->load->view('attribute_edit.html');
    }
    public function insert(){
        //设置表单验证规则
        $this->form_validation->set_rules('attr_name','商品属性名称','required');
        $this->form_validation->set_rules('type_id','商品类型','required');
        if($this->form_validation->run() == false){
            //验证规则未通过
            $data['message'] = validation_errors();
            $data['url'] = site_url('admin/attribute/add');
            $data['wait'] = 3;
            $this->load->view('message.html',$data);
        }else{
            //表单验证规则通过
            $data['attr_name'] = $this->input->post('attr_name',true);
            $data['type_id'] = $this->input->post('type_id',true);
        }

    }
}