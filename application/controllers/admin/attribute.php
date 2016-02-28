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
        $data['attrs'] = $this->attribute_model->list_attrs();
        $this->load->view('attribute_list.html',$data);
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
            $data['attr_type'] = $this->input->post('attr_type',true);
            $data['attr_input_type'] = $this->input->post('attr_input_type',true);
            $data['sort_order'] = $this->input->post('sort_order',true);
            $data['attr_value'] = $this->input->post('attr_values',true);
            if($this->attribute_model->add_attrs($data)){
                //ok
                $data['message'] = "插入成功";
                $data['url'] = site_url('admin/attribute/index');
                $data['wait'] = 3;
                $this->load->view('message.html',$data);
            }else{
                //失败
                $data['message'] = "插入失败";
                $data['url'] = site_url('admin/attribute/add');
                $data['wait'] = 3;
                $this->load->view('message.html',$data);
            }
        }

    }
}