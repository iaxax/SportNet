<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 10:23
 *
 * 账户模型，实现登录、注册的逻辑处理和数据存取
 */
class AccountModel {

    //数据库连接
    private $conn;

    //查询系统中是否存在该账号
    private $loginSql;

    //查询待注册账号是否已经存在
    private $registerQuery;

    public function __construct() {
        $this->conn = Connection::getConnection();

        $this->loginSql = $this->conn->prepare(
            "SELECT count(*) FROM user " .
            "WHERE name = :name AND password = :pw ;"
        );

        $this->registerQuery = $this->conn->prepare(
            "SELECT count(*) FROM user " .
            "WHERE name = :name ;"
        );
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
        $this->loginSql->execute(
            array(':name' => $name, ':pw' => $pw)
        );
        $rows = $this->loginSql->fetch(PDO::FETCH_NUM);

        if($rows[0] == 1) {
            $_SESSION['LoginUser'] = $name;
            return new ResultVO(true, "登录成功");
        }
        else {
            return new ResultVO(false, "账号与密码不匹配");
        }
    }

    /**
     * 处理用户注册请求
     *
     * @param RegisterVO $vo 注册参数，参见RegisterVO的定义
     * @return ResultVO
     */
    public function register(RegisterVO $vo) {
        //查询系统中是否已经存在该账号
        $name = $vo->getName();
        $this->registerQuery->execute(
            array(':name' => $name)
        );
        if ($this->registerQuery->fetchColumn()) {
            return new ResultVO(false, "该账户已经存在");
        }

        $nickname = $vo->getNickname();
        $email = $vo->getEmail();
        $password = $vo->getPassword();
        //新建账号
        $count = $this->conn->exec(
            "INSERT INTO user VALUES " .
            "('$name', '$nickname', '$email', '$password');"
        );
        if($count == 1) {
            return new ResultVO(true, "注册账号成功");
        }
        else {
            return new ResultVO(false, "注册账号失败");
        }
    }
}