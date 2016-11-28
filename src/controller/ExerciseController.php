<?php

require __DIR__ . "/../model/ExerciseModel.php";

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/28
 * Time: 18:42
 *
 * 获取当前用户运动信息
 */
class ExerciseController extends Controller {

    /**
     * 获取当前用户的运动统计信息
     */
    public function getExerciseStatInfo() {
        $user = $_SESSION['LoginUser'];
        $model = new ExerciseModel();
        return $model->getExerciseStatInfo($user)->toJson();
    }

}