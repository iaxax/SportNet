<?php

require __DIR__ . "/../model/UserModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:34
 *
 * 获取当前用户信息
 */
class UserController extends Controller {

    private $model;

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->model = new UserModel();
    }

    /**
     * 获取当前登录用户信息
     *
     * @return string 当前用户信息的json格式
     */
    public function getCurrentUser() {
        return $this->model->getCurrentUser()->toJson();
    }
}