<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/25
 * Time: 21:43
 */
class Brand extends Admin_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('brand_model');
        $this->load->library('upload');
    }
    //显示品牌信息
    public function index(){
        //获取品牌信息
        $data['brands'] = $this->brand_model->list_brand();
        $this->load->view('brand_list.html',$data);
    }
    //显示添加品牌页面
    public function add(){
        $this->load->view('brand_add.html');
    }
    //显示编辑品牌页面
    public  function  edit(){
        $this->load->view('brand_edit.html');
    }
    //添加品牌
    public function insert(){
        //设置验证规则
        $this->form_validation->set_rules('brand_name','品牌名称','required');
        if($this->form_validation->run() == false){
        //验证未通过
            $data['message'] = validation_errors();
            $data['url'] = site_url('admin/brand/add');
            $data['wait'] = 3;
            $this->load->view('message.html',$data);
        }else{
            //验证通过，处理图片上传
            /*//配置上传参数
            $config['upload_path'] = './webroot/images/upload';
            //$config['upload_path'] =base_url('webroot/images/upload/');
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100;*/


            if($this->upload->do_upload('brand_logo')){
                //上传成功 获取文件名
                $fileinfo= $this->upload->data();
                $data['logo'] = $fileinfo['file_name'];
                //获取表单提交数据
                $data ['brand_name'] = $this->input->post('brand_name');
                $data ['url'] = $this->input->post('site_url');
                $data ['brand_desc'] = $this->input->post('brand_desc');
                $data['sort_order'] = $this->input->post('sort_order');
                $data['is_show'] = $this->input->post('is_show');
                //调用模型完成插入动作
                if($this->brand_model->add_brand($data)){
                    $data['message'] = '添加品牌成功';
                    $data['url'] = site_url('admin/brand/index');
                    $data['wait'] = 3;
                    $this->load->view('message.html',$data);
                }else{
                    $data['message'] = '添加品牌失败';
                    $data['url'] = site_url('admin/brand/add');
                    $data['wait'] = 3;
                    $this->load->view('message.html',$data);
                }
            }else{
                //上传失败
                $data['message'] = $this->upload->display_errors();
                $data['url'] = site_url('admin/brand/add');
                $data['wait'] = 3;
                $this->load->view('message.html',$data);
            }
        }
    }














}