<?php

require __DIR__ . "/../model/FriendModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 7:46
 *
 * 处理有关用户好友信息的请求
 */
class FriendController extends Controller {

    private $model;

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->model = new FriendModel();
    }

    /**
     * 获取当前用户的好友列表
     *
     * @return string 好友列表的json格式
     */
    public function getFriends() {
        $user = $_SESSION['LoginUser'];
        $list = $this->model->getFriends($user);
        return json_encode($list);
    }

    /**
     * 模糊搜索与用户输入用户名匹配的用户,不包括用户本人
     *
     * @return string 用户列表的json格式
     */
    public function findUserByName() {
        $name = $this->request->getParam('name');
        $list = $this->model->findUserByName($name);
        return json_encode($list);
    }

    /**
     * 为当前用户添加好友
     *
     * @return string 添加结果的json格式
     */
    public function addFriend() {
        $user = $_SESSION['LoginUser'];
        $friend = $this->request->getParam('name');
        return $this->model->addFriend($user, $friend)->toJson();
    }
}