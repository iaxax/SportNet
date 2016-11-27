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

    private $conn;

    private $login_sql;

    public function __construct() {
        $this->conn = Connection::getConnection();
        $this->login_sql = $this->conn->prepare("
            select * from user
            where name = ? and password = ?
        ");
    }

    /**
     * 处理用户登录请求
     *
     * @param LoginVO $vo 登录参数，参见LoginVO的定义
     * @return ResultVO
     */
    public function login(LoginVO $vo) {
        $name = $vo->getName();
        $pw = $vo->getPassword();
        $result = $this->conn->query(
            "select count(*) from user " .
            "where user.name = '$name' and user.password = '$pw';"
        );
        if($result == null) {
            return new ResultVO(false, "ha");
        }
//        $this->login_sql->execute(array($name, $pw));
//
//        if($rows[0] == 1) {
//            new ResultVO(true, "登录成功");
//        }

        return new ResultVO(false, "账号与密码不匹配");

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