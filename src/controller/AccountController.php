<?php

require __DIR__ . "/../vo/ResultVO.php";
require __DIR__ . "/../vo/LoginVO.php";
require __DIR__ . "/../vo/RegisterVO.php";
require __DIR__ . "/Controller.php";
require __DIR__ . "/../model/AccountModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/26
 * Time: 23:37
 *
 * 账号处理控制器，处理登录、注册请求
 */
class AccountController extends Controller {

    /**
     * 用户登录
     * @return string 登录结果
     */
    function login() {
        $name = $this->request->getParam('name');
        $pw = $this->request->getParam('pw');
        $model = new AccountModel();
        $vo = new LoginVO($name, $pw);
        $result = $model->login($vo);
        return $result->toJson();
    }

    /*
     * 用户注册
     *
     * @return ResultVO 注册结果，参见ResultVO的定义
     */
    function register() {
        $model = new AccountModel();
        $result = $model->register(new RegisterVO(
            $this->request->getParam('name'),
            $this->request->getParam('nickname'),
            $this->request->getParam('email'),
            $this->request->getParam('pw')
        ));
        return $result->toJson();
    }

}