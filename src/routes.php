<?php
// Routes

// Home page
$app->get('/[{name}]', function ($request, $response, $args) {
    return $this->renderer->render($response, 'login.html', $args);
});

// 加载所有控制器类
require "requires.php";

// 拦截用户请求并处理
$app->post('/controller/{controller}/{method}',
    function (\Slim\Http\Request $request, $response, $args) {
        $cls = new ReflectionClass($args['controller']);
        $method = $cls->getMethod($args['method']);
        $ctrl = $cls->newInstance($request, $response);
        return $method->invoke($ctrl);
    }
);

