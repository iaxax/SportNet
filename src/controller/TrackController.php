<?php

require __DIR__ . "/../model/TrackModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/29
 * Time: 22:22
 *
 * 处理用户有关动态信息的请求
 */
class TrackController extends Controller {

    private $model;

    public function __construct($request, $response) {
        parent::__construct($request, $response);
        $this->model = new TrackModel();
    }

    /**
     * 获得当前登录用户今天的动态
     */
    public function getTodayTracks() {
        $user = $_SESSION['LoginUser'];
        $list =$this->model->getTodayTracks($user);
        return $this->toJson($list);
    }

    /**
     * 获得一周内所有动态内容
     */
    public function getAllTracks() {
        $list = $this->model->getAllTracks();
        return $this->toJson($list);
    }

    /**
     * 获得当前登录用户的历史动态
     */
    public function getHistoryTracks() {
        $user = $_SESSION['LoginUser'];
        $list = $this->model->getHistoryTracks($user);
        return $this->toJson($list);
    }

    /**
     * 当前用户发表一条动态
     */
    public function createTrack() {
        $result = $this->model->createTrack(
            $_SESSION['LoginUser'],
            $this->request->getParam('content')
        );

        if($result->getMessage() instanceof TrackVO) {
            $vo = $result->getMessage();
            return urldecode(json_encode(array(
                "success" => $result->getSuccess(),
                "message" => $vo->toMap()
            )));
        }
        else {
            return $result->toJson();
        }
    }

    private function toJson($arr) {
        $list = array();

        foreach ($arr as $item) {
            if($item instanceof TrackVO) {
                array_push($list, $item->toMap());
            }
        }

        return urldecode(json_encode($list));
    }
}