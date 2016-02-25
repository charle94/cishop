<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/4
 * Time: 11:16
 * 商品类别控制器
 */
class Category extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        //载入表单验证类
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

    }

    //---------------------------显示分类列表
    public function index()
    {
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_list.html', $data);
    }
    //---------------------------显示分类列表END

    //---------------------------显示添加表单BEGIN
    public function add()
    {
        $data['cates'] = $this->category_model->list_cate();
        $this->load->view('cat_add.html', $data);
    }
    //--------------------------显示添加表单END

    //--------------------------显示编辑表单BEGIN
    public function edit($cat_id)
    {   $data['cates'] = $this->category_model->list_cate();
        $data['current'] = $this->category_model->get_cate($cat_id);
        $this->load->view('cat_edit.html',$data);
    }
    //--------------------------显示编辑表单END

    //-------------------------更新分类操作BEGIN
    public function update(){
        //表单验证
        $this->form_validation->set_rules('cat_name', '分类名称', 'required');
        $this->form_validation->set_rules('parent_id', '', 'required');
        if ($this->form_validation->run() == FALSE) {
            //表单验证失败
            $data['message'] = validation_errors();
            $data['url'] = site_url('admin/category/edit').'/'.$this->input->post('cat_id',true);
            $data['wait'] = 3;
            $this->load->view('message.html', $data);
        }else{
            //表单验证成功，判断是否将其更新到子节点下
            $cat_id = $this->input->post('cat_id',true);
            $parent_id = $this->input->post('parent_id',true);
            $sub_cates = $this->category_model->list_cate($cat_id);
            //获取后代分类的cat_id
            $sub_ids = array();
            foreach($sub_cates as $cate){
                $sub_ids[] = $cate['cat_id'];
            }
            if( $parent_id == $cat_id || in_array($parent_id,$sub_ids)){
                //存在更新到子分类错误
                $data['message'] = "不能将该分类更新到子分类下";
                $data['url'] = site_url('admin/category/edit').'/'.$this->input->post('cat_id',true);
                $data['wait'] = 3;
                $this->load->view('message.html', $data);
            }else{
              //进行更新操作
                $data['cat_name'] = $this->input->post('cat_name', true);
                $data['parent_id'] = $this->input->post('parent_id', true);
                $data['unit'] = $this->input->post('unit', true);
                $data['sort_order'] = $this->input->post('sort_order', true);
                $data['cat_desc'] = $this->input->post('cat_desc', true);
                $data['is_show'] = $this->input->post('is_show', true);
            //调用模型
               if($this->category_model->update_cate($cat_id,$data)) {
                   $data['message'] = "更新成功";
                   $data['url'] = site_url('admin/category/index');
                   $data['wait'] = 3;
                   $this->load->view('message.html', $data);
               }else{
                   $data['message'] = "更新失败";
                   $data['url'] = site_url('admin/category/edit').'/'.$cat_id;
                   $data['wait'] = 3;
                   $this->load->view('message.html', $data);
               }

            }


        }

    }
    //------------------------------更新分类END

    //------------------------------执行插入分类操作BEGIN
    public function insert()
    {
        $this->form_validation->set_rules('cat_name', '分类名称', 'required');
        $this->form_validation->set_rules('parent_id', '', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['message'] = validation_errors();
            $data['url'] = site_url('admin/category/add');
            $data['wait'] = 3;
            $this->load->view('message.html', $data);
        } else {
            $data['cat_name'] = $this->input->post('cat_name', true);
            $data['parent_id'] = $this->input->post('parent_id', true);
            $data['unit'] = $this->input->post('unit', true);
            $data['sort_order'] = $this->input->post('sort_order', true);
            $data['cat_desc'] = $this->input->post('cat_desc', true);
            $data['is_show'] = $this->input->post('is_show', true);
            if($this->category_model->insert_cate($data)){
                redirect(site_url('admin/category/index'));
            }else{
                $data['message'] = "插入失败";
                $data['url'] = site_url('admin/category/add');
                $data['wait'] = 3;
                $this->load->view('message.html', $data);
            }

        }
    }
    //------------------------------执行插入分类操作END

    //-----------------------------执行删除分类操作
    public function delete($cat_id){
        if($this->category_model->delete_cate($cat_id)){
            $data['message'] = "删除成功";
            $data['url'] = site_url('admin/category/index');
            $data['wait'] = 3;
            $this->load->view('message.html', $data);
        }else{
            $data['message'] = "删除失败";
            $data['url'] = site_url('admin/category/index');
            $data['wait'] = 3;
            $this->load->view('message.html', $data);
        }
    }
}
