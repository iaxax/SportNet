<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 0:54
 *
 * 用户注册所需信息
 */
class RegisterVO {

    private $name;

    private $nickname;

    private $email;

    private $password;

    public function __construct($name, $nickname, $email, $password) {
        $this->name = $name;
        $this->nickname = $nickname;
        $this->email = $email;
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
    public function getNickname() {
        return $this->nickname;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }
}