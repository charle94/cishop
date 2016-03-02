<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/29
 * Time: 11:03
 */
class Goods extends Admin_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('goodstype_model');
        $this->load->model('attribute_model');
        $this->load->model('category_model');
        $this->load->model('brand_model');

    }
    public function index(){
        $this->load->view('goods_list.html');
    }
    public function add(){
        //获取商品类型
        $data['goodstypes'] = $this->goodstype_model->get_goodstype();
        //获取分类信息
        $data['cates'] = $this->category_model->list_cate();
        //获取品牌信息
        $data['brands'] =$this->brand_model->list_brand();
        $this->load->view('goods_add.html',$data);
    }
    public function edit(){
        $this->load->view('goods_edit.html');
    }
    //创建商品属性页面
    public function create_attrs_html(){
        $type_id = $this->input->get('type_id',true);
        //print_r($type_id);
        //获取指定商品类型的属性
        $attrs = $this->attribute_model->get_attrs($type_id);
        //print_r( $attrs);
        //构造html字符串
        $html = '';
        foreach($attrs as $v){
            $html.= "<tr>";
            $html.= "<td class='label'>".$v['attr_name']."</td>";
            $html.= "<td>";
            $html.= '<input type="hidden" name="attr_id_list[]" value='.$v["attr_id"].'>';
            switch($v['attr_input_type']){
                case 0:
                    //文本框
                    $html.= '<input name="attr_value_list[]" type="text" value="" size="40">';
                    break;
                case 1:
                    //下拉列表
                    $arr = explode(PHP_EOL,$v['attr_value']);//php换行符适应不同操作系统
                    $html.= '<select name="attrs_value_list[]">';
                    $html.= '<option value="">请选择</option>';
                    foreach($arr as $arr_value){
                        $html.= '<option value="'.$arr_value.'">'.$arr_value.'</option>';
                    }
                    $html.= '</select>';
                    break;
                case 2:
                    //文本域
                    break;
                default:
                    break;
            }


            $html.= "</td>";
            $html.= "</tr>";
        }
        echo $html;
    }
}