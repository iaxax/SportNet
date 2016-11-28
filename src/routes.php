<?php
// Routes

// 加载所有控制器类
require "requires.php";

// 加载HTML请求
$app->get('/html/{name}', function ($request, $response, $args) {
    return $this->renderer->render($response, $args['name'], $args);
});

// 拦截用户请求并处理
$app->post('/controller/{controller}/{method}',
    function (\Slim\Http\Request $request, $response, $args) {
        $cls = new ReflectionClass($args['controller']);
        $method = $cls->getMethod($args['method']);
        $ctrl = $cls->newInstance($request, $response);
        return $method->invoke($ctrl);
    }
);

// 拦截其他请求
$app->get('[/{params:.*}]', function ($request, $response, $args) {
    return $this->renderer->render($response, 'login.html', $args);
});