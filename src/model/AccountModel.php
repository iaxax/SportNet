<?php

require __DIR__ . "/../db/Connection.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 10:23
 *
 * 账户模型，实现登录、注册的逻辑处理和数据存取
 */
class AccountModel {

    /**
     * 处理用户登录请求
     *
     * @param LoginVO $vo 登录参数，参见LoginVO的定义
     * @return ResultVO
     */
    public function login(LoginVO $vo) {
        // TODO: Implement login() method.
        $name = $vo->getName();
        $pw = $vo->getPassword();
        Connection::getConnection();
        return new ResultVO(true, "$name->$pw");
    }

    /**
     * 处理用户注册请求
     *
     * @param RegisterVO $vo 注册参数，参见RegisterVO的定义
     * @return ResultVO
     */
    public function register(RegisterVO $vo)
    {
        // TODO: Implement register() method.
        $name = $vo->getName();
        $pw = $vo->getPassword();
        return new ResultVO(true, "$name->$pw");
    }
}