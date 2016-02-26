<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/26
 * Time: 21:09
 */
//配置上传参数
$config['upload_path'] = './webroot/images/upload';
//$config['upload_path'] =base_url('webroot/images/upload/');
$config['allowed_types'] = 'gif|jpg|png';
$config['max_size'] = 100;
