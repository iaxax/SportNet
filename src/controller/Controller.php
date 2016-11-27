<?php

/**
 * Created by PhpStorm.
 * User: Y481L
 * Date: 2016/11/27
 * Time: 9:53
 *
 * 用户请求拦截器基类
 */
abstract class Controller {

    protected $request;

    protected $response;

    public function __construct(
        \Slim\Http\Request $request,
        \Slim\Http\Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}