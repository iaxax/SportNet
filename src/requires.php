<?php
/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 9:51
 *
 * 加载需要的类到routes.php
 */

require __DIR__ . "/controller/Controller.php";
require __DIR__ . "/controller/AccountController.php";
require __DIR__ . "/controller/UserController.php";
require __DIR__ . "/controller/ExerciseController.php";
require __DIR__ . "/controller/FriendController.php";
require __DIR__ . "/controller/ActivityController.php";
require __DIR__ . "/controller/TrackController.php";

require __DIR__ . "/db/Connection.php";

require __DIR__ . "/vo/UserInfoVO.php";
require __DIR__ . "/vo/ResultVO.php";
require __DIR__ . "/vo/LoginVO.php";
require __DIR__ . "/vo/RegisterVO.php";
require __DIR__ . "/vo/ExerciseStat.php";
require __DIR__ . "/vo/ActivityVO.php";
require __DIR__ . "/vo/TrackVO.php";
require __DIR__ . "/vo/ExerciseTypeStat.php";
require __DIR__ . "/vo/ExerciseTimeStat.php";

