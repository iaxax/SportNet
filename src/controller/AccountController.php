<?php

require __DIR__ . "/../vo/LoginVO.php";
require __DIR__ . "/../vo/RegisterVO.php";
require __DIR__ . "/../vo/ResultVO.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/26
 * Time: 23:37
 *
 * 账号处理控制器，处理登录、注册请求
 */
class AccountController {

    /**
     * 用户登录
     *
     * @param LoginVO $vo 登录所需信息，参见LoginVO的定义
     * @return ResultVO 登录结果，参见ResultVO的定义
     */
    function login(LoginVO $vo) {
        return new ResultVO(true, "success");
    }

    /**
     * 用户注册
     *
     * @param RegisterVO $vo 注册所需信息，参见LoginVO的定义
     * @return ResultVO 注册结果，参见ResultVO的定义
     */
    function register(RegisterVO $vo) {
        return new ResultVO(true, "success");
    }

}