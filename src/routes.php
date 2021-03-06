<?php
// Routes

// 加载所有控制器类
require "requires.php";

// 加载HTML请求
$app->get('/html/{name}', function ($request, $response, $args) {
    return $this->renderer->render($response, $args['name'], $args);
});

// 拦截用户请求并处理
$app->map(['GET', 'POST'], '/controller/{controller}/{method}',
    function (\Slim\Http\Request $request, $response, $args) {
        $cls = new ReflectionClass($args['controller']);
        $method = $cls->getMethod($args['method']);
        $ctrl = $cls->newInstance($request, $response);
        return $method->invoke($ctrl);
    }
);

// 运动信息注入
$app->post('/data/{user}',
    function ($request, $response, $args) {
        $controller = new ExerciseController($request, $response);
        $controller->createExerciseInfo($args['user']);
        return "success";
});

// 拦截其他请求
$app->map(['GET', 'POST'], '[/{params:.*}]', function ($request, $response, $args) {
    return $this->renderer->render($response, 'login.html', $args);
});