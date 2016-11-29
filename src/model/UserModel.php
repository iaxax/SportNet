<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 11:11
 *
 * 当前用户信息的处理
 */
class UserModel {

    /**
     * 获取当前登录用户信息
     */
    public function getCurrentUser() {
        return new UserInfoVO($_SESSION['LoginUser']);
    }
}