<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 0:58
 *
 * 用户登录所需信息
 */
class LoginVO {

    private $name;

    private $password;

    public function __construct($name, $password) {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }
}