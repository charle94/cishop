<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/2
 * Time: 20:34
 */
//----------权限控制器
class Privilege extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
    }
    //随机获取字符串函数
    function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }
    public function login(){
        /* $vals  =  array(
             'img_path'  =>  './data/captcha',
             'img_url'   =>  base_url('data/captcha'),
             'word'=>$this->getRandChar(rand(6,10))
             );
         $data = create_captcha($vals);*/
        $this->load->view('login.html');
    }
    public function code(){
        //调用函数
        $arr  =  array(
            'word'=>$this->getRandChar(rand(4,9))
        );
        //-------验证码保存到session
        $this->session->set_userdata('code',$arr['word']);
        create_captcha($arr);

    }
    //处理登陆
    public  function signin(){
        //设置验证规则
        $this->form_validation->set_rules('username','','required');
        $this->form_validation->set_rules('password','','required');
        //获取表单数据
        $captcha    =  strtolower( $this->input->post('captcha'));
        //获取session中验证码
        $code   = strtolower( $this->session->userdata('code')) ;
        if($captcha === $code){
            if($this->form_validation->run() == false){
                $data['message']    =   validation_errors();
                $data['url']         =  site_url('admin/privilege/login');
                $data['wait']        =  3;
                $this->load->view('message.html',$data);
            }
            else{
                //验证码正确 需要验证用户名 和 密码
                $username   = $this->input->post('username');
                $password   = $this->input->post('password');
                //载入数据库模块并调用 获取数据
                $this->load->model('admin_model');
                $arr    =   $this->admin_model->get_admin($username);
                foreach ($arr as $row)
                {
                    $admin['name']    =   $row ['admin_name'];
                    $admin['password']=   $row['password'];
                }
                if(!empty($arr)&&$username == $admin['name']&&  $password ==  $admin['password']   ) {
                    //用户名密码正确并且数据库查询不为空ok保存session信息 ，然后跳转到后台首页
                    $this->session->set_userdata('admin',$username);
                    redirect('admin/main/index');
                }
                else{
                    //用户名密码错误error
                    $data['url']   =  site_url('admin/privilege/login');
                    $data['message']    =  "用户名或密码错误";
                    $data['wait']   =   3;
                    $this->load->view('message.html',$data);
                }
            }


        }else{
            //验证码 不正确给出相应提示页面 然后返回
            $data['url']   =  site_url('admin/privilege/login');
            $data['message']    =  "验证码错误";
            $data['wait']   =   3;
            $this->load->view('message.html',$data);
        }
    }
    public function logout(){
        //清除session
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        redirect(site_url('admin/privilege/login'));


    }
}